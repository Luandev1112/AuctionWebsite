<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Specification;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $pageTitle = "Manage Category";
        $emptyMessage = "No data found";
        $categorys = Category::latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categorys'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:80']);
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status ? 1: 0;
        $category->save();
        $notify[] = ['success', 'Category has been created'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|max:80',
        ]);
        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->status = $request->status ? 1: 0;
        $category->save();
        $notify[] = ['success', 'Category has been updated'];
        return back()->withNotify($notify);
    }

    public function specification($id)
    {
        $emptyMessage = 'No data found';
        $category = Category::findOrFail($id);
        $pageTitle = $category->name . ' category specification list';
        $categorys = Category::where('status', 1)->select('id', 'name')->get();
        $specifications = Specification::where('category_id', $category->id)->with('category')->paginate(getPaginate());
        return view('admin.specification.index', compact('pageTitle', 'emptyMessage', 'categorys', 'specifications'));
    }

    public function subcategory($id)
    {
        $category = Category::findOrFail($id);
        $emptyMessage = "No data found";
        $pageTitle = ucfirst($category->name) . ' subcategory list';
        $subCategorys = Subcategory::where('category_id', $category->id)->latest()->with('category')->paginate(getPaginate());
        $categorys = Category::where('status', 1)->select('id', 'name')->get();
        return view('admin.sub_category.index', compact('pageTitle', 'emptyMessage', 'categorys', 'subCategorys'));
    }
}
