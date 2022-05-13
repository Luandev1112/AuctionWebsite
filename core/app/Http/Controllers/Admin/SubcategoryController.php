<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    
    public function index()
    {
        $pageTitle = "Manage Sub Category";
        $emptyMessage = "No data found";
        $subCategorys = Subcategory::latest()->with('category')->paginate(getPaginate());
        $categorys = Category::where('status', 1)->select('id', 'name')->get();
        return view('admin.sub_category.index', compact('pageTitle', 'emptyMessage', 'categorys', 'subCategorys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subCategory = new Subcategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        $notify[] = ['success', 'Sub Category has been created'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subcategories,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:120',
        ]);
        $subCategory = Subcategory::findOrFail($request->id);
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        $notify[] = ['success', 'Sub Category has been updated'];
        return back()->withNotify($notify);
    }
}
