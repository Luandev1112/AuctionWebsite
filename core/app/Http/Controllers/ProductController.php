<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Specification;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    
    public function index()
    {
        $user = Auth::user();
        $pageTitle = "Manage Product";
        $emptyMessage = "No data found";
        $products = Product::where('user_id', $user->id)->latest()->with('category', 'productSpecification')->paginate(getPaginate());
        return view($this->activeTemplate. 'user.product.index', compact('pageTitle', 'emptyMessage', 'products'));
    }

    public function create()
    {
        $pageTitle = "Create Product";
        $brands = Brand::where('status', 1)->select('id', 'name')->get();
        return view($this->activeTemplate . 'user.product.create', compact('pageTitle', 'brands'));   
    }

    public function store(Request $request)
    {
        $request->validate([
            'featured'=> 'nullable|in:1',
            'title'=> 'required|max:255',
            'sub_title'=> 'required|max:255',
            'amount'=> 'required|numeric|gt:0',
            'keywords' => 'required|array|min:3|max:15',
            'time_duration'=> 'required|after_or_equal:today',
            'category_id'=> 'required|exists:categories,id',
            'sub_category'=> 'required|exists:subcategories,id',
            'brand'=> 'required|exists:brands,id',
            'image'=>  ['required','image',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'description' => 'required'
        ]);
        $category = Category::where('id', $request->category_id)->where('status', 1)->firstOrFail();
        $brand = Brand::where('id', $request->brand)->where('status', 1)->firstOrFail();

        $user = Auth::user();
        $product = new Product();
        $product->user_id = $user->id;
        $product->title = $request->title;
        $product->sub_title = $request->sub_title;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->amount = $request->amount;
        $product->time_duration = $request->time_duration;
        $product->description = $request->description;
        $product->featured = $request->featured ? $request->featured : null;
        if ($request->hasFile('image')) {
            $path = imagePath()['product']['path'];
            $size = imagePath()['product']['size'];
            try {
                $filename = uploadImage($request->image, $path, $size);
                $product->image = $filename;
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $product->keyword = $request->keywords;
        $product->save();
        $notify[] = ['success', 'Product has been created'];
        return redirect()->route('user.product.index')->withNotify($notify);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $pageTitle = "Product Update";
        $emptyMessage = "No data found";
        $brands = Brand::where('status', 1)->select('id', 'name')->get();
        $product = Product::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        return view($this->activeTemplate . 'user.product.edit', compact('pageTitle', 'emptyMessage','product','brands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keywords' => 'required|array|min:3|max:15',
            'title'=> 'required|max:255',
            'sub_title'=> 'required|max:255',
            'amount'=> 'required|numeric|gt:0',
            'time_duration'=> 'required|date',
            'category_id'=> 'required|exists:categories,id',
            'sub_category'=> 'required|exists:subcategories,id',
            'brand'=> 'required|exists:brands,id',
            'image'=>  ['nullable','image',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'description' => 'required'
        ]);
        $category = Category::where('id', $request->category_id)->where('status', 1)->firstOrFail();
        $brand = Brand::where('id', $request->brand)->where('status', 1)->firstOrFail();

        $user = Auth::user();
        $product = Product::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        if($product->status == 1){
            $notify[] = ['error', "Can't update approved product"];
            return back()->withNotify($notify);
        }
        $product->user_id = $user->id;
        $product->title = $request->title;
        $product->sub_title = $request->sub_title;
        $product->category_id = $request->category_id;
        $product->amount = $request->amount;
        $product->time_duration = $request->time_duration;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $path = imagePath()['product']['path'];
            $size = imagePath()['product']['size'];
            try {
                $filename = uploadImage($request->image, $path, $size, $product->image);
                $product->image = $filename;
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $product->keyword = $request->keywords;
        $product->save();
        $notify[] = ['success', 'Product has been updated'];
        return back()->withNotify($notify);
    }

    public function addSpecification($id)
    {
        $user = Auth::user();
        $pageTitle = "Specification";
        $emptyMessage = "No data found";
        $product = Product::where('id',$id)->where('user_id', $user->id)->firstOrFail();
        $specifications = Specification::where('category_id', $product->category_id)->with('productSpecification')->get();
        return view($this->activeTemplate . 'user.product.specification', compact('pageTitle', 'emptyMessage', 'product', 'specifications'));
    }

    public function storeSpecification(Request $request, $id)
    {
        $i=0;$j=0;
        $user = Auth::user();
        $product = Product::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        if($product->status == 1){
            $notify[] = ['error', "Can't update approved product"];
            return back()->withNotify($notify);
        }
        $specifications = Specification::where('category_id', $product->category_id)->pluck('slug',)->toArray();
        $specificationId = Specification::where('category_id', $product->category_id)->pluck('id',)->toArray();
        $requestData = $request->except('_token');
        foreach($requestData as $value){
            $request->validate([
                $specifications[$i] => 'required|max:120'
            ]);
            $i++;
        }
        $productSpecificationDelete = ProductSpecification::where('product_id', $product->id)->delete();
        foreach($requestData as $value){
            $productSpecification = new ProductSpecification();
            $productSpecification->product_id = $product->id;
            $productSpecification->specification_id = $specificationId[$j];
            $productSpecification->value = $value;
            $productSpecification->save();
            $j++;
        }
        $notify[] = ['success', 'Product specification has been created'];
        return back()->withNotify($notify);
    }
}
