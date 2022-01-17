<?php

namespace App\Http\Resources;

use App\Price;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $arrayData = [
            'id' => $this->id,
            'subscription_type' => $this->subscription_type,
            'currency' => $this->currency,
            'currency_symbol' => $this->currency_symbol,
            'amount' => $this->amount,
        ];

        if ($this->subscription_type == "1") {

            $arrayData['discount'] = null;

        } elseif ($this->subscription_type == "2") {

            $prices = Price::where('subscription_type', '1')->where('currency', $this->currency)->first();

            $price2 = $prices->amount * 2;

            $percent = $price2 - $this->amount;

            $decimal_value = $percent / $price2;

            $discount = $decimal_value * 100;

            $arrayData['discount'] = floor($discount)."%";

        }

        return $arrayData;
    }
}
