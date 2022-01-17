<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'order_id' => $this->order_id,
            'subscription_type'=> $this->order->subscription_type,
            'pay_via' => $this->pay_via,
            'pay_via_type' => $this->pay_via_type,
            'pay_currency' => $this->pay_currency,
            'pay_amount' => $this->pay_amount,
            'pay_date' => $this->pay_date,
            'pay_status' => $this->pay_status,
            'pay_name' => $this->pay_name,
            'pay_email' => $this->pay_email,
            'transaction_id' => $this->transaction_id,
        ];
    }
}
