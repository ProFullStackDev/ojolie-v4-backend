<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EcardsentReplyResource;

class EcardsentRecipientResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'sent_date' => $this->sent_date,
            'resent_date' =>  $this->resent_date,
            'pickup_date' => $this->pickup_date,
            'count_view' => $this->count_view,
            'reply' => new EcardsentReplyResource($this->ecardsentreply)
        ];
    }
}
