<?php

namespace App\Http\Controllers\API\Dynamic;

use App\Http\Controllers\Controller;
use App\HomeDynamicCards;
use App\Http\Resources\HomeDynamicCardsResource;

class HomeDynamicCardsController extends Controller
{
    public function index()
    {

        $dynamic_cards = HomeDynamicCards::orderBy('id')->limit(3)->get();

        return HomeDynamicCardsResource::collection($dynamic_cards);
    }

    public function show($id)
    {
        return new HomeDynamicCardsResource(HomeDynamicCards::find($id));
    }
}
