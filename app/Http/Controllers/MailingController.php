<?php

namespace App\Http\Controllers;

use App\Mailing;

use App\Http\Requests\MailingRequest;

class MailingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mailing_lists = Mailing::all();

        return

            view('mailing-list.index', compact('mailing_lists'));
    }



    public function create()
    {
        return view('mailing-list.create');
    
    }

    public function add(MailingRequest $request)
    {
        Mailing::create($request->all());

        return redirect('/mailing-list/create')->with('success', 'Your email was sent successfully.');
    }

    public function edit($id)
    {
        //
        $mailing_list = Mailing::findOrFail($id);
        return view('mailing-list.edit', compact('mailing_list'));
    }

    public function update(MailingRequest $request, $id)
    {
        //
        Mailing::whereId($id)->first()->update($request->all());

        return back()->with('success', 'mail was updated successfully.');
    }

    public function destroy($id)
    {
        Mailing::whereId($id)->delete(); 

        return redirect('/mailing-list');

    }
}
