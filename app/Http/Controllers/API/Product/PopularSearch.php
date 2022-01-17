<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\PopularSearch as PopularSearchModel;
use App\Http\Resources\PopularSearchResource;

use Illuminate\Http\Request;

class PopularSearch extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $PopularSearch  = PopularSearchModel::active()->popular()->limit(50)->get();

        return PopularSearchResource::collection($PopularSearch);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PopularSearch  $popularSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PopularSearch $popularSearch)
    {
        //
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
    }
}
