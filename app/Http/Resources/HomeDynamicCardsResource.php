<?php

namespace App\Http\Resources;

use App\EcardCategory;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EcardCategoryResource;

class HomeDynamicCardsResource extends JsonResource
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
            'card_title' => $this->card_title,
            'card_content' => $this->card_content,
            'card_img' => 'https://staging-ojolie.dingerpay.org/img/dynamic-data/'.$this->card_img,
            'card_link' => $this->card_link,
            'bg_color' => $this->bg_color,
            'category' => new EcardCategoryResource(EcardCategory::find($this->category_id))
        ];
    }
}
