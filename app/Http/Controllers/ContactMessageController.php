<?php

namespace App\Http\Controllers;

use App\ContactMessage;

use App\Http\Requests\ContactMessageRequest;

class ContactMessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contact_messages = ContactMessage::all();

        return

            view('contact-messages.index', compact('contact_messages'));
    }

    public function create()
    {
        return view('contact-messages.create');
    
    }

    public function add(ContactMessageRequest $request)
    {
        ContactMessage::create($request->all());

        return redirect('/contact-messages/create')->with('success', 'Your message was sent successfully.');
    }

    public function show($id)
    {
        //
        $contact_message = ContactMessage::findOrFail($id);
        return view('contact-messages.detail', compact('contact_message'));
    }

    public function edit($id)
    {
        //
        $contact_message = ContactMessage::findOrFail($id);
        return view('contact-messages.edit', compact('contact_message'));
    }

    public function update(ContactMessageRequest $request, $id)
    {
        //
        ContactMessage::whereId($id)->first()->update($request->all());

        return back()->with('success', 'mail was updated successfully.');
    }

    public function destroy($id)
    {
        ContactMessage::whereId($id)->delete(); 

        return redirect('/contact-messages');

    }
}
