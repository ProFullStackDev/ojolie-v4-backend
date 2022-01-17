<?php

namespace App\Http\Controllers;

use App\BlackList;

use App\Http\Requests\BlackListRequest;

class BlackListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $black_lists = BlackList::all();

        return

            view('blacklist.index', compact('black_lists'));
    }

    public function create()
    {
        return view('blacklist.create');
    }

    public function add(BlackListRequest $request)
    {
        BlackList::create($request->all());

        return redirect('blacklist/create')->with('success', 'Blacklist email was successfully added.');
    }

    public function edit($id)
    {
        //
        $black_list = BlackList::findOrFail($id);
        return view('blacklist.edit', compact('black_list'));
    }

    public function update(BlackListRequest $request, $id)
    {
        //

        BlackList::whereId($id)->first()->update($request->all());

        return back()->with('success', 'Updated blacklist email successfully');
    }

    public function destroy($id)
    {
        BlackList::whereId($id)->delete();

        return redirect('/blacklist');

    }
}
