<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        $pageTitle = "All order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', '!=', 0)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    
    public function pending()
    {
        $pageTitle = "Pending order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 1)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    public function complated()
    {
        $pageTitle = "Complated order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 2)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    public function inProcess()
    {
        $pageTitle = "In process order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 3)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    public function shipped()
    {
        $pageTitle = "Shipped order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 4)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    public function onHold()
    {
        $pageTitle = "On hold order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 5)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }
    public function disputed()
    {
        $pageTitle = "Disputed order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 6)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }

    public function cancelled()
    {
        $pageTitle = "Cancelled order";
        $emptyMessage = "No data found";
        $orders = Order::where('status', 7)->with('user', 'product', 'product.user')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }


    public function refund(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id'
        ]);
        $general = GeneralSetting::first();

        $order = Order::where('id', $request->id)->firstOrFail();
        $order->status = 7;
        $order->save();

        $amount = ($order->amount - $order->charge);
        $productUser = User::findOrFail($order->product->user_id);
        $productUser->balance -= $amount;
        $productUser->save();

        $transaction = new Transaction();
        $transaction->user_id = $productUser->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $productUser->balance;
        $transaction->trx_type = '-';
        $transaction->details = 'Subtract Balance for '. $order->order_number . ' number';
        $transaction->trx = getTrx();
        $transaction->save();

        notify($productUser, 'ORDER_BAL_SUB', [
            'trx' => $transaction->trx,
            'order_number' => $order->order_number,
            'amount' => showAmount($amount),
            'currency' => $general->cur_text,
            'post_balance' => showAmount($productUser->balance),
        ]);

        $user = User::findOrFail($order->user_id);
        $user->balance += $order->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount =  $order->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '+';
        $transaction->details = 'Refund for '. $order->order_number . ' number';
        $transaction->trx = getTrx();
        $transaction->save();

        notify($user, 'ORDER_REFUND', [
            'trx' => $transaction->trx,
            'order_number' => $order->order_number,
            'amount' => showAmount($order->amount),
            'currency' => $general->cur_text,
            'post_balance' => showAmount($user->balance),
        ]);
        $notify[] = ['success', 'Refund completed'];
        return back()->withNotify($notify);
    }


    public function resolved(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id'
        ]);
        $order = Order::where('id', $request->id)->firstOrFail();
        $order->status = 2;
        $order->save();
        $notify[] = ['success', 'order completed'];
        return back()->withNotify($notify);
    }


    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|exists:orders,order_number'
        ]);
        $search = $request->search;
        $pageTitle = $search . ' Order Number';
        $emptyMessage = "No data found";
        $orders = Order::where('status', '!=', 0)->where('order_number', $search)->with('user', 'product', 'product.user')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders', 'search'));
    }
}
