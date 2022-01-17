<?php

namespace App\Http\Controllers;

use App\Price;

use Illuminate\Http\Request;

use App\Http\Requests\PriceRequest;

class PricesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pricing_lists = Price::all();

        return

            view('pricing-list.index', compact('pricing_lists'));
    }

    public function create()
    {
        return view('pricing-list.create');
    
    }

    public function add(PriceRequest $request)
    {
        Price::create($request->all());

        return redirect('/pricing-list/create')->with('success', 'Your pricing was successfully created.');
    }

    public function edit($id)
    {
        //
        $pricing_list = Price::findOrFail($id);
        
        return view('pricing-list.edit', compact('pricing_list'));
    }

    public function update(Request $request, $id)
    {
        //
        Price::whereId($id)->first()->update($request->all());

        return back()->with('success', 'Pricing was updated successfully.');
    }

    public function destroy($id)
    {
        Price::whereId($id)->delete(); 

        return redirect('/pricing-list');

    }
}
