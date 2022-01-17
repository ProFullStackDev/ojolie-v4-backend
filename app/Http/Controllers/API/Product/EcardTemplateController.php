<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\EcardTemplate;
use App\Http\Resources\EcardTemplateResource;

class EcardTemplateController extends Controller
{
    public function index()
    {

        $dynamic_cards = EcardTemplate::orderBy('id')->get();

        return EcardTemplateResource::collection($dynamic_cards);
    }

    public function show($id)
    {
        return new EcardTemplateResource(EcardTemplate::find($id));
    }
}
