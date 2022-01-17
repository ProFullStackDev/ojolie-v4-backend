<?php

namespace App\Http\Controllers;

use App\PopularSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class PopularSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $popular_searches = PopularSearch::orderBy('id','desc')->get();

        return view('popular-searches.index', compact('popular_searches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('popular-searches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
           'keyword' => 'required|string|max:512|unique:popular_searches,keyword',
           'is_new' => 'required|integer',
           'seq' => 'required|integer',
           'count' => 'required|integer',
           'status' => 'required|integer',
       ]);
        
       if ($validator->fails()) {
           // Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput()->withErrors($validator->messages());
       }

       try{
            $popularSearch = new PopularSearch();

            $popularSearch->keyword = $request->keyword;
            $popularSearch->is_new = $request->is_new;
            $popularSearch->count = $request->count;
            $popularSearch->seq = $request->seq;
            $popularSearch->status = $request->status;
            $popularSearch->save();

            \Session::flash('message', 'Record has been created!'); 
            \Session::flash('alert-class', 'alert-success'); 
            return redirect('/popular-searches');        
        }catch(\Exceptions $e){
            \Session::flash('message', 'We are facing some issue while update!'); 
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/popular-searches');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PopularSearch  $popularSearch
     * @return \Illuminate\Http\Response
     */
    public function show(PopularSearch $popularSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PopularSearch  $popularSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(PopularSearch $popularSearch)
    {
        //
        return view('popular-searches.edit', compact('popularSearch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PopularSearch  $popularSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PopularSearch $popularSearch)
    {
        //

        $validator = Validator::make($request->all(), [
           'keyword' =>"required|string|max:512|unique:popular_searches,keyword,{$popularSearch->id}",
           'is_new' => 'required|integer',
           'seq' => 'required|integer',
           'count' => 'required|integer',
           'status' => 'required|integer',
       ]);
        
       if ($validator->fails()) {
           // Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput()->withErrors($validator->messages());
       }

       try{
            
            $popularSearch->keyword = $request->keyword;
            $popularSearch->is_new = $request->is_new;
            $popularSearch->count = $request->count;
            $popularSearch->seq = $request->seq;
            $popularSearch->status = $request->status;
            $popularSearch->save();

            \Session::flash('message', 'Record has been updated!'); 
            \Session::flash('alert-class', 'alert-success'); 
            return redirect('/popular-searches');        
        }catch(\Exceptions $e){
            \Session::flash('message', 'We are facing some issue while update!'); 
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/popular-searches');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PopularSearch  $popularSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(PopularSearch $popularSearch)
    {
        //
        try{
            PopularSearch::destroy($popularSearch->id);
            \Session::flash('message', 'Record has been deleted!'); 
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/popular-searches');
        }catch(\Exceptions $e){
            \Session::flash('message', 'We are facing some issue while deleting!'); 
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/popular-searches');

        }
    }
}
