<?php

namespace App\Http\Controllers\API\Extra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EcardCategory;
use App\Ecard;

class AutoSuggestController extends Controller
{
    public function categories(Request $request)
    {
        $ecard_categories = EcardCategory::whereNotNull('parent_id')->where('name','LIKE','%'.$request->search.'%')->pluck('name','id');
        return response()->json(['data'=>$ecard_categories]);
    }

    public function cards(Request $request)
    {
        $ecards = Ecard::where('caption','LIKE','%'.$request->search.'%')->pluck('caption','id');
        return response()->json(['data'=>$ecards]);
    }
}
