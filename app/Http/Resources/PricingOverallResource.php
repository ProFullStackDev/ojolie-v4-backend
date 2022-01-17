<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Price;

use App\Http\Resources\PriceResource;

class PricingOverallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [

            'id' => $this->id,
            'subscription_type' => $this->subscription_type,
            'pricing_data' => PriceResource::collection( Price::where('subscription_type',$this->subscription_type)->get())

        ];
    }
}
