<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'type' => $this->type,
            'timezone' => $this->timezone,
            'expires' => $this->expires_at,
            'notice_expires' => $this->notice_expires,
            'notify_pickup' => $this->notify_pickup,
            'notify_sent' => $this->notify_sent,
            'notify_reply' => $this->notify_reply,
            'newsletter_subscribed' => $this->newsletter_subscribed,
            'fb_id' => $this->fb_id
        ];
    }
}
