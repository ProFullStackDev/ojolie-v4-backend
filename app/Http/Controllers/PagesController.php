<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pages'] = Page::all();
        return view('pages.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
        ];

        $request->validate($rules);

        $page = new Page;
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->keywords = $request->keywords;
        $page->save();

        return redirect()->route('pages.index')->with('success','Pages added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page'] = Page::find($id);
        return view('pages.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page'] = Page::find($id);
        return view('pages.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
        ];

        $request->validate($rules);

        $page = Page::find($id);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->keywords = $request->keywords;
        $page->save();

        return redirect()->route('pages.index')->with('success','Pages updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            Page::find($id)->delete();
        } 
        catch (\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()->with('error',$e->errorInfo[2]);
        }
        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
