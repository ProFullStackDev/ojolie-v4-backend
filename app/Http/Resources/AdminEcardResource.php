<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminEcardResource extends JsonResource
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
            'active' => $this->active,
            'private' => $this->private,
            'popular_card' => $this->popular_card,
            'recommended_card' => $this->recommended_card,
            'filename' => asset(Storage::url('img/ecards/'.$this->filename)),
            'thumbnail' => asset(Storage::url('img/ecards/'.$this->thumbnail)),
            'caption' => $this->caption,
            'detail' => $this->detail,
            'video' => $this->video
        ];
    }
}
