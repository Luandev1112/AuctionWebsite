<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function send()
    {
        $pageTitle = "Messages list";
        $emptyMessage = "No data found";
        $user = Auth::user();
        $sends = Contact::where('sender_id', $user->id)->with('sender', 'receiver')->orderBy('id', 'DESC')->paginate(getPaginate());
        $receiveds = Contact::where('receiver_id', $user->id)->with('sender', 'receiver')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate. 'user.message.index', compact('pageTitle', 'emptyMessage', 'sends', 'receiveds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|max:250',
            'message' => 'required',
        ]);
        $user = Auth::user();
        $contact = new Contact();
        $contact->sender_id = $user->id;
        $contact->receiver_id = $request->receiver_id;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        $notify[] = ['success', 'Messages submitted'];
        return back()->withNotify($notify);
    }

    public function reply(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'message' => 'required'
        ]);
        $contactReply = new ContactReply();
        $contactReply->contact_id = $request->contact_id;
        $contactReply->message = $request->message;
        $contactReply->save();
        $notify[] =['success', 'Reply submitted'];
        return back()->withNotify($notify);
    }

    public function read($id)
    {
        $pageTitle = "Read Messages";
        $emptyMessage = "No data found";
        $reads = ContactReply::where('contact_id', decrypt($id))->orderBy('id', 'DESC')->get();
        return view($this->activeTemplate. 'user.message.read', compact('pageTitle', 'emptyMessage', 'reads'));
    }
}
