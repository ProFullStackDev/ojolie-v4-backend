<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MemberResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->orders()->exists())
        {
            $pending_order_id = $this->orders()->doesntHave('payment')->first() ? $this->orders()->doesntHave('payment')->first()->id : null;
        }
        else
        {
            $pending_order_id = null;
        }

        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'language' => $this->language,
            'active' => $this->active,
            'details'=> $this->member()->exists() ? new MemberResource($this->member) : null,
            'pending_order_id'=> $pending_order_id
        ];
    }
}
