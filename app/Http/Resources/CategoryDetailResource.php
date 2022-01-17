<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
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
            'slug' => $this->slug,
            'header_image' => $this->header_image,
            'header_color' => $this->header_color,
            'header_descripion' => $this->header_description,
            'page_title' => $this->page_title,
            'page_description' => $this->page_description,
            'meta_keyword' => $this->meta_keyword,
        ];
    }
}
