<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Http\Resources\PricingOverallResource;
use App\Price;
use App\PremiumSubscriptionType;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function index(Request $request)
    {
        $prices = Price::where(function($query)use($request){
            if($request->subscription_type) $query->where('subscription_type',$request->subscription_type);
            if($request->currency) $query->where('currency',$request->currency);
            if($request->currency_symbol) $query->where('currency_symbol',$request->currency_symbol);
        })->get();

        $premium_subscription = PremiumSubscriptionType::all();

        return PricingOverallResource::collection($premium_subscription);
    }
}
