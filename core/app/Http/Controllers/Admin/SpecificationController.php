<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecificationController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Specification";
        $emptyMessage = "No data found";
        $categorys = Category::where('status', 1)->select('id', 'name')->get();
        $specifications = Specification::latest()->with('category')->paginate(getPaginate());
        return view('admin.specification.index', compact('pageTitle', 'emptyMessage', 'categorys', 'specifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'category_id' => 'required|exists:categories,id'
        ]);
        $specification = new Specification();
        $specification->name = $request->name;
        $specification->slug = Str::slug($request->name);
        $specification->category_id = $request->category_id;
        $specification->save();
        $notify[] = ['success', 'Specification has been created'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required|exists:specifications,id',
            'category_id'=>'required|exists:categories,id',
            'name'=>'required|max:120',
        ]);
        $specification = Specification::findOrFail($request->id);
        $specification->name = $request->name;
        $specification->slug = Str::slug($request->name);
        $specification->category_id = $request->category_id;
        $specification->save();
        $notify[] = ['success', 'Specification has been updated'];
        return back()->withNotify($notify);
    }
}
