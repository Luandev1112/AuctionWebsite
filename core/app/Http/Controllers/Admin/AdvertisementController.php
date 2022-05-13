<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    
    public function index(Request $request)
    {
        $pageTitle = "All Advertisements";
        $emptyMessage = "No data found";
        $ads = Advertisement::latest()->paginate(getPaginate());
        return view('admin.ads.index',compact('pageTitle','ads','emptyMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60',
            'type' => 'required|in:1,2',
            'size' => 'required|in:540x984,779x80,300x250',
            'redirect_url' => ['required_if:type,1', $request->redirect_url ? 'url':''],
            'adimage' => ['required_if:type,1','image',new FileTypeValidate(['jpg','jpeg','png','gif'])],
            'script' =>  ['required_if:type,2', $request->script ? 'required':''],
        ]);
        
        $advr = new Advertisement();
        $advr->name = $request->name;
        $advr->type = $request->type;
        $advr->script = $request->script ? $request->script : null;
        $advr->redirect_url = $request->redirect_url ? $request->redirect_url : null;
        $advr->size = $request->size;
        $path = imagePath()['advertisement']['path'];
        if($request->adimage){
            list($width, $height) = getimagesize($request->adimage);
            $size = $width.'x'.$height;
            if($request->size != $size){
                $notify[]=['error','Sorry image size has to be '.$request->size];
                return back()->withNotify($notify);
            }
            try {
                $advr->image = uploadImage($request->adimage, $path);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $advr->status = $request->status ? 1:2;
        $advr->save();
        $notify[]=['success','Advertisement has been added'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = "Advertisement Update";
        $ads = Advertisement::findOrFail($id);
        return view('admin.ads.edit', compact('pageTitle', 'ads'));
    }

    public function update(Request $request, $id)
    {
        $advr = Advertisement::findOrFail($id);
        $request->validate([
            'name' => 'required|max:40',
            'size' => 'required|in:540x984,779x80,300x250',
        ]);
        if($advr->type == 1){
            $request->validate([
                'redirect_url' => 'required|url',
                'adimage' => 'required|image|mimes:jpg,jpeg,png,PNG',
            ]);
        }
        elseif($advr->type == 2){
            $request->validate(['script' => 'required']);
        }
        $advr->name = $request->name;
        $advr->type = $advr->type;
        $advr->script = $request->script ? $request->script : null;
        $advr->redirect_url = $request->redirect_url ? $request->redirect_url : null;
        $advr->size = $request->size;
        $path = imagePath()['advertisement']['path'];
        if($request->adimage){
            list($width, $height) = getimagesize($request->adimage);
            $size = $width.'x'.$height;
            if($request->size != $size){
                $notify[]=['error','Sorry image size has to be '.$request->size];
                return back()->withNotify($notify);
            }
            try {
                $advr->image = uploadImage($request->adimage,$path,null,$advr->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $advr->status = $request->status?1:2;
        $advr->save();
        $notify[]=['success','Advertisement has been updated'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:advertisements,id'
        ]);
        $ads =  Advertisement::findOrFail($request->id);
        $ads->delete();
        $notify[] = ['success','Advertisement has been deleted'];
        return back()->withNotify($notify);
    }
}
