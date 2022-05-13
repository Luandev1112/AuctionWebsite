<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Product";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::orderBy('id', 'DESC')->with('user', 'category', 'subCategory', 'brand')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys'));
    }

    public function detail($id)
    {
        $pageTitle = "Manage product detail";
        $product = Product::where('id',$id)->with('productSpecification.specification')->firstOrFail();
        return view('admin.product.detail', compact('pageTitle', 'product'));
    }

    public function pending()
    {
        $pageTitle = "All pending products";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::where('status', 0)->with('user', 'category', 'subCategory', 'brand')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys'));
    }

    public function approved()
    {
        $pageTitle = "All approved products";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::where('status', 1)->with('user', 'category', 'subCategory', 'brand')->whereDate('time_duration','>', Carbon::now()->toDateTimeString())->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys'));
    }

    public function cancel()
    {
        $pageTitle = "All cancel products";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::where('status', 2)->with('user', 'category', 'subCategory', 'brand')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys'));
    }

    public function expired()
    {
        $pageTitle = "All expired products";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::whereDate('time_duration','<=', Carbon::now()->toDateTimeString())->with('user', 'category', 'subCategory', 'brand')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys'));
    }

    public function approvBy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = 1;
        $product->save();
        $notify[] = ['success', 'Product has been approved'];
        return back()->withNotify($notify);
    }

    public function cancelBy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = 2;
        $product->save();
        $notify[] = ['success', 'Product has been cancel'];
        return back()->withNotify($notify);
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $products = Product::whereHas('user',function($q) use ($search){
            $q->where('username', 'like', "%$search%");
        })->orWhere('title', 'like', "%$search%");
        $pageTitle = '';
        if($scope == 'pending'){
            $products = $products->where('status', 0);
        }elseif($scope == 'approved'){
            $products = $products->where('status', 1)->whereDate('time_duration','>', Carbon::now()->toDateTimeString());
        }elseif($scope == 'cancel'){
            $products = $products->where('status', 2);
        }elseif($scope == 'expired'){
            $products = $products->whereDate('time_duration','<=', Carbon::now()->toDateTimeString());
        }
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = $products->with('user', 'category', 'subCategory', 'brand')->orderBy('id', 'DESC')->paginate(getPaginate());
        $pageTitle = 'Product Search - ' . $search;
        $emptyMessage = 'No data found';
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys', 'search'));
    }

    public function productCategorySearch(Request $request, $scope)
    {
        $category = Category::where('status', 1)->where('id', $request->category_id)->firstOrFail();
        $categoryId = $category->id;
        $pageTitle =  $category->name .' '.$scope.' products list';
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get(); 
        $products = Product::where('category_id', $category->id);
        if($scope == 'pending'){
            $products = $products->where('status', 0);
        }elseif($scope == 'approved'){
            $products = $products->where('status', 1)->whereDate('time_duration','>', Carbon::now()->toDateTimeString());;
        }elseif($scope == 'cancel'){
            $products = $products->where('status', 2);
        }elseif($scope == 'expired'){
            $products = $products->whereDate('time_duration','<=', Carbon::now()->toDateTimeString());
        }
        $products = $products->with('user', 'category', 'subCategory', 'brand')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'emptyMessage', 'products', 'categorys', 'categoryId'));
    }
    

    public function featuredInclude(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        $product->featured = 1;
        $product->save();
        $notify[] = ['success', 'Include this product featured list'];
        return back()->withNotify($notify);
    }

    public function featuredNotInclude(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        $product->featured = 0;
        $product->save();
        $notify[] = ['success', 'Remove this product featured list'];
        return back()->withNotify($notify);
    }


    public function productReport()
    {
        $pageTitle = "Product Report List";
        $emptyMessage = "No data found";
        $reports = ProductReport::whereHas('product', function($q){
            $q->where('status', 1)->whereDate('time_duration','>', Carbon::now()->toDateTimeString());
        })->latest()->with('user', 'product')->paginate(getPaginate());
        return view('admin.product.report', compact('pageTitle', 'emptyMessage', 'reports'));
    }
}
