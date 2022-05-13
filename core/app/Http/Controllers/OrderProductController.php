<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderProductController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function orderList()
    {
        $user = Auth::user();
        $pageTitle = "Product order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', '!=', 0)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function pending()
    {
        $user = Auth::user();
        $pageTitle = "Pending order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 1)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function complete()
    {
        $user = Auth::user();
        $pageTitle = "Complete order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 2)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function process()
    {
        $user = Auth::user();
        $pageTitle = "In process order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 3)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function ship()
    {
        $user = Auth::user();
        $pageTitle = "Shipped order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 4)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function dispute()
    {
        $user = Auth::user();
        $pageTitle = "Disputed order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 5)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function cancel()
    {
        $user = Auth::user();
        $pageTitle = "Cancel order list";
        $emptyMessage = "No data found";
        $orderLists = Order::where('status', 6)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user', 'product')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.index', compact('pageTitle', 'emptyMessage', 'orderLists'));
    }

    public function detail($id)
    {
        $pageTitle = "Purchase product detail";
        $emptyMessage = "No data found";
        $product = Product::where('status', '!=', 0)->where('id', $id)->with('productSpecification.specification', 'review.user')->firstOrFail();
        $user = $product->user;
        $userReview = Review::whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->with('user')->avg('starts');
        return view($this->activeTemplate . 'user.order.detail', compact('pageTitle', 'emptyMessage', 'product', 'userReview'));
    }


    public function inProcess(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number'
        ]);
        $user = Auth::user();
        $order = Order::where('order_number', $request->order_number)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->firstOrFail();
        $order->status = 3;
        $order->save();
        $notify[] = ['success', 'Order in process'];
        return back()->withNotify($notify);
    }

    public function shipped(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'shpping_date' => 'required|after_or_equal:today',
        ]);
        $user = Auth::user(); 
        $order = Order::where('order_number', $request->order_number)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->firstOrFail();
        $order->status = 4;
        $order->shipped_date = $request->shpping_date;
        $order->save();
        $notify[] = ['success', 'Shipped this order'];
        return back()->withNotify($notify);
    }

    public function cancelled(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number'
        ]);
        $general = GeneralSetting::first();

        $user = Auth::user(); 
        $order = Order::where('order_number', $request->order_number)->whereHas('product', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->firstOrFail();

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
        $notify[] = ['success', 'Order Canceled'];
        return back()->withNotify($notify);
    }




}
