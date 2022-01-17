<?php

namespace App\Http\Controllers;

use App\HomeDynamicCards;

use App\Http\Requests\HomeDynamicCardsRequest;

use App\EcardCategory;

use App\Http\Requests\HomeDynamicCardsUpdateRequest;

class HomeDynamicCardsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dynamic_cards = HomeDynamicCards::all();

        return

            view('home-dynamic-cards.index', compact('dynamic_cards'));
    }

    public function create()
    {

        $categories = EcardCategory::where('parent_id', '!=', null)->get();
        return view('home-dynamic-cards.create', compact('categories'));

    }

    public function add(HomeDynamicCardsRequest $request)
    {
        $input = $request->all();

        if ($file = $request->file('card_img')) {
            $name  = time() . $file->getClientoriginalName();
            $file->move('img/dynamic-data', $name);
            $input['card_img'] = $name;
        }

        HomeDynamicCards::create($input);

        return redirect('/home-dynamic-cards/create')->with('success', 'your card was created successfully.');
    }

    public function edit($id)
    {
        //
        $dynamic_card = HomeDynamicCards::findOrFail($id);
        $categories = EcardCategory::where('id', '!=', $dynamic_card->category_id)->where('parent_id', '!=', null)->get();
        $dyanmic_card_category = EcardCategory::find($dynamic_card->category_id);
        return view('home-dynamic-cards.edit', compact('dynamic_card', 'categories', 'dyanmic_card_category'));
    }

    public function update(HomeDynamicCardsUpdateRequest $request, $id)
    {
        //
        $input = $request->all();

        if ($file = $request->file('card_img')) {
            $name  = time() . $file->getClientoriginalName();
            $file->move('img/dynamic-data', $name);
            $input['card_img'] = $name;
        }

        HomeDynamicCards::whereId($id)->first()->update($input);

        return back()->with('success', 'your card was updated successfully.');
    }

    public function destroy($id)
    {
        HomeDynamicCards::whereId($id)->delete();

        return redirect('/home-dynamic-cards');

    }
}
