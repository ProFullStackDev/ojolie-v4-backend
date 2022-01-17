<?php

namespace App\Http\Controllers\API\Extra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use App\Http\Resources\PageResource;
use App\Mail\ContactusMail;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function index($name)
    {
        $page = Page::where('name','LIKE',$name)->first();
        return new PageResource($page);
    }

    public function contactus(Request $request)
    {
        $rules = [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'message'=>'required'
        ];

        $request->validate($rules);

        $query = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        Mail::to('saintkabyo@gmail.com')
        ->queue(new ContactusMail($query));

        return response()->json(['message'=>'Message sent successfully!'],200);
    }
}
