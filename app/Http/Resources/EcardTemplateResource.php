<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EcardTemplateResource extends JsonResource
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
            'template_name' => $this->template_name,
            'template_title' => $this->template_title,
            'template_content' => $this->template_content,
            'mb_template_title' => $this->mb_template_title,
            'mb_template_content' => $this->mb_template_content,
        ];
    }
}
