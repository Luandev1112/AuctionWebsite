<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'qty' => 'required|gt:0|integer',
            'payment_type' => 'required|in:1,2',
            'product_id' => 'required|exists:products,id',
        ]);
        $user = Auth::user();
        $general = GeneralSetting::first();
        $product = Product::where('status', 1)->where('id', $request->product_id)->whereDate('time_duration','>', Carbon::now()->toDateTimeString())->firstOrFail();

        if($product->user_id == $user->id){
            $notify[] = ["error","You can not be order your self-product"];
            return back()->withNotify($notify);
        }
        $amount = 0;
        $charge = 0;
        if($product->featured == 1){
            $amount = (($product->amount + $general->featured_price) * $request->qty);
        }else{
            $amount = ($product->amount * $request->qty);
        }
        if($general->charge_status == 1){
            $charge = ($general->fixed_charge + (($amount / 100) * $general->charge));
        }
        if($request->payment_type == 1){
            $order = new Order();
            $order->user_id = $user->id;
            $order->qty = $request->qty;
            $order->amount = $amount;
            $order->charge = $charge;
            $order->product_id = $product->id;
            $order->order_number = getTrx();
            $order->save();
            session()->put('order_number',$order->order_number);
            return redirect()->route('user.order.payment');
        }

        if($request->payment_type == 2){
            $amount = (($product->amount * $request->qty));
            if($amount > $user->balance){
                $notify[] = ['error', 'Insufficient balance to pay the order.'];
                return back()->withNotify($notify);
            }
            $order = new Order();
            $order->user_id = $user->id;
            $order->qty = $request->qty;
            $order->amount = $amount;
            $order->charge = $charge;
            $order->product_id = $product->id;
            $order->order_number = getTrx();
            $order->status = 1;
            $order->save();

            $user->balance -= $amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type = '-';
            $transaction->details = 'Payment via '. $general->sitename . ' wallet';
            $transaction->trx = $order->order_number;
            $transaction->save();

            $productUser = $order->product->user;
            $productUser->balance += ($order->amount - $order->charge);
            $productUser->save();

            $trans = new Transaction();
            $trans->user_id = $productUser->id;
            $trans->amount = ($order->amount - $order->charge);
            $trans->post_balance = $productUser->balance;
            $trans->charge = $charge;
            $trans->trx_type = '+';
            $trans->details = 'Payment for ' . $order->order_number . ' number';
            $trans->trx = $order->order_number;
            $trans->save();

            notify($productUser, 'PAYMENT_USER', [
                'trx' => $trans->trx,
                'order_number' => $order->order_number,
                'amount' => showAmount($order->amount - $order->charge),
                'charge' => showAmount($order->charge),
                'currency' => $general->cur_text,
                'post_balance' => showAmount($productUser->balance),
            ]);
            
            notify($user, 'PRODUCT_PAYMENT_WALLET', [
                'trx' => $transaction->trx,
                'amount' => showAmount($order->amount),
                'currency' => $general->cur_text,
                'post_balance' => showAmount($user->balance),
            ]);

            $notify[] = ['success', 'Payment Complate'];
            return back()->withNotify($notify);
        }
    }

    public function payment()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment', compact('gatewayCurrency', 'pageTitle'));
    }

    public function paymentInsert(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'method_code' => 'required',
            'currency' => 'required',
        ]);
        
        $user = Auth::user();
        $order = Order::where('status', 0)->where('order_number', $request->order_number)->where('user_id', $user->id)->first();
        if(!$order){
            $notify[] = ['error', 'Invalid order'];
            return back()->withNotify($notify);
        }
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $order->amount || $gate->max_amount < $order->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($order->amount * $gate->percent_charge / 100);
        $payable = $order->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->order_id = $order->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $order->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = $order->order_number;
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data->trx);
        return redirect()->route('user.deposit.preview');
    }
}
