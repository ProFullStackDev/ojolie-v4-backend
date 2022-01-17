<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EcardResource;
use App\Http\Resources\EcardsentRecipientResource;

class EcardsentItemResource extends JsonResource
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
            'ecard' => new EcardResource($this->ecard),
            'greeting' => $this->greeting,
            'message' => $this->message,
            'email_message' => $this->email_message,
            'timezone' => $this->timezone,
            'scheduled_date' => $this->scheduled_date,
            'draft' => $this->draft,
            'pickup_noti' => $this->pickup_noti,
            'created_at' => $this->created_at,
            'total_sent' => $this->ecardsentrecipients()->count(),
            'recipents' => EcardsentRecipientResource::collection($this->whenLoaded('ecardsentrecipients')),
            'share_url' => 'https://staging-ojolie-frontend-pfylq.ondigitalocean.app/card-pickup/'.encrypt('s_'.$this->id)
        ];
    }
}
