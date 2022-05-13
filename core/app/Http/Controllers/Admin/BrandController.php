<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Brand";
        $emptyMessage = "No data found";
        $brands = Brand::latest()->paginate(getPaginate());
        return view('admin.brand.index', compact('pageTitle', 'emptyMessage', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:80']);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status ? 1: 0;
        $brand->save();
        $notify[] = ['success', 'Brand has been created'];
        return back()->withNotify($notify);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:brands,id',
            'name' => 'required|max:80',
        ]);
        $brand = Brand::findOrFail($request->id);
        $brand->name = $request->name;
        $brand->status = $request->status ? 1: 0;
        $brand->save();
        $notify[] = ['success', 'Brand has been updated'];
        return back()->withNotify($notify);
    }
}
