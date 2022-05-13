<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'stars' => 'required|integer|max:5|min:1',
            'product_id' => 'required|exists:products,id',
            'review' => 'required|max:500'
        ]);
        $user = Auth::user();
        $product = Product::where('status', 1)->firstOrFail();
        $review = new Review();
        $review->user_id = $user->id;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->starts = $request->stars;
        $review->save();
        $notify[] = ['success', 'Thanks for putting your review.'];
        return back()->withNotify($notify);
    }
}
