<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseProductController extends Controller
{

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index()
    {
        $user = Auth::user();
        $pageTitle = "Purchase list";
        $emptyMessage = "No data found";
        $purchaseProducts = Order::where('status', '!=', 0)->where('user_id', $user->id)->with('product')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.purchase.index', compact('pageTitle', 'emptyMessage', 'purchaseProducts'));
    }


    public function dispute(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'report' => 'required|min:30|max:500'
        ]);
        $user = Auth::user();
        $order = Order::where('order_number', $request->order_number)->where('user_id', $user->id)->firstOrFail();
        $order->status = 5;
        $order->dispute = $request->report;
        $order->save();
        $notify[] = ['success', 'Order disputed'];
        return back()->withNotify($notify);
    }

    public function complated(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number'
        ]);
        $user = Auth::user();
        $order = Order::where('order_number', $request->order_number)->where('user_id', $user->id)->firstOrFail();
        $order->status = 2;
        $order->save();
        $notify[] = ['success', 'Order complete'];
        return back()->withNotify($notify);
    }

}
