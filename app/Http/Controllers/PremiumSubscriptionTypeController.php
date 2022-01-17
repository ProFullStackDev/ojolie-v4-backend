<?php

namespace App\Http\Controllers;

use App\PremiumSubscriptionType;

use Illuminate\Http\Request;

use App\Http\Requests\PremiumSubscriptionTypeRequest;

class PremiumSubscriptionTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pricing_lists = PremiumSubscriptionType::all();

        return

            view('premium-subscription-type.index', compact('pricing_lists'));
    }

    public function create()
    {
        return view('premium-subscription-type.create');

    }

    public function add(PremiumSubscriptionTypeRequest $request)
    {
        PremiumSubscriptionType::create($request->all());

        return redirect('/premium-subscription-type/create')->with('success', 'Your pricing was successfully created.');
    }

    public function edit($id)
    {
        //
        $pricing_list = PremiumSubscriptionType::findOrFail($id);

        return view('premium-subscription-type.edit', compact('pricing_list'));
    }

    public function update(PremiumSubscriptionTypeRequest $request, $id)
    {
        //
        PremiumSubscriptionType::whereId($id)->first()->update($request->all());

        return back()->with('success', 'Pricing was updated successfully.');
    }

    public function destroy($id)
    {
        PremiumSubscriptionType::whereId($id)->delete();

        return redirect('/premium-subscription-type');

    }
}
