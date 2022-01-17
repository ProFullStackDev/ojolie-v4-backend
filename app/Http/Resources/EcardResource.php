<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\EcardTemplate;
use App\Http\Resources\EcardTemplateResource;

class EcardResource extends JsonResource
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
            'active' => $this->active,
            'private' => $this->private,
            'thumbnail' => asset(Storage::url('img/ecards/' . $this->filename.'.jpg')),
            'caption' => $this->caption,
            'detail' => $this->detail,
            'video' => $this->video
        ];

        if ($this->img_suffix != null) {
            $arrayData['filename'] = asset(Storage::url('img/ecards/' . $this->filename . 'P_' . $this->img_suffix . '.jpg'));
        } elseif ($this->img_suffix == null) {
            $arrayData['filename'] = asset(Storage::url('img/ecards/' . $this->filename . 'P.jpg'));
        }

        if ($this->template_id != null) {
            $arrayData['template_detail'] = new EcardTemplateResource(EcardTemplate::find($this->template_id));
        } elseif ($this->template_id == null) {
            $arrayData['template_detail'] = new EcardTemplateResource(EcardTemplate::where('default', '=', 1)->first());
        }

        return $arrayData;
    }
}
