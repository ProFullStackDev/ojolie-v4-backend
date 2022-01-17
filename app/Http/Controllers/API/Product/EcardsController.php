<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ecard;
use App\EcardCategory;
use App\Http\Resources\EcardResource;
use App\PopularSearch;

class EcardsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ecard_category_slug)
        {
            $card_category = EcardCategory::where('slug', '=', $request->ecard_category_slug)->first();
            $ecards = Ecard::select('ecards.*')
            ->join('ecard_to_category','ecards.id','=','ecard_to_category.ecard_id')
            ->where('ecard_to_category.ecard_category_id', $card_category->id)->orderBy('type', 'ASC')->orderBy('ecard_to_category.sort')->paginate(18);
        }
        elseif($request->ecard_category_id)
        {
            $ecards = Ecard::select('ecards.*')
            ->join('ecard_to_category','ecards.id','=','ecard_to_category.ecard_id')
            ->where(function($query)use($request){
                $query->where('ecard_to_category.ecard_category_id',$request->ecard_category_id);
                if($request->type)
                    $query->where('ecard_to_category.type',$request->type);
                if($request->free)
                    $query->where('ecards.private',0);
                if($request->private)
                    $query->where('ecards.private',1);
                if($request->search)
                    $query->where('ecards.caption','LIKE','%'.$request->search.'%')
                        ->orWhere('ecards.detail','LIKE','%'.$request->search.'%');

            })
            ->orderBy('type', 'ASC')->orderBy('ecard_to_category.sort')
            ->paginate(18);
        }
        else
        {
            $ecards = Ecard::where('active', 1)->orderBy('id', 'DESC')->paginate(18);
        }

        return EcardResource::collection($ecards);
    }

    public function search(Request $request)
    {

        PopularSearch::saveKeyWord($request->search_data);

        $ecards = Ecard::where('caption', 'LIKE', '%' . $request->search_data . '%')
        ->orWhere('detail', 'LIKE', '%' . $request->search_data . '%')
        ->orWhere('filename', 'LIKE', '%' . $request->search_data . '%')->get();
        return EcardResource::collection($ecards);
    }

    public function show($id)
    {
        return new EcardResource(Ecard::find($id));
    }

    public function free_cards()
    {
        $ecards = Ecard::where('active',1)->where('private',0)->orderBy('id','DESC')->paginate(18);
        return EcardResource::collection($ecards);
    }

    public function private_cards()
    {
        $ecards = Ecard::where('active',1)->where('private',1)->orderBy('id','DESC')->paginate(18);
        return EcardResource::collection($ecards);
    }

    public function latest()
    {
        $ecards = Ecard::where('active',1)->orderBy('id','DESC')->paginate(18);
        return EcardResource::collection($ecards);
    }

    public function popular()
    {
        $ecards = Ecard::where('active',1)->whereHas('ecardsentitems')->withCount('ecardsentitems')->orderBy('type', 'ASC')->orderBy('ecardsentitems_count','DESC')->paginate(10);
        return EcardResource::collection($ecards);
    }

    public function popular_slideshow()
    {
        $card_category = EcardCategory::where('slug', '=', 'popular-ecards')->first();
        $ecards = Ecard::select('ecards.*')
        ->join('ecard_to_category','ecards.id','=','ecard_to_category.ecard_id')
        ->where('ecard_to_category.ecard_category_id', $card_category->id)->orderBy('type', 'ASC')->orderBy('ecard_to_category.sort')->paginate(18);
        return EcardResource::collection($ecards);
    }

    public function recommended()
    {
        $ecards = Ecard::where('recommended_card',1)->orderBy('id','DESC')->paginate(3);
        return EcardResource::collection($ecards);
    }

}
