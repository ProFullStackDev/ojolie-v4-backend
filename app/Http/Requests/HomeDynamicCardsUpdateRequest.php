<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeDynamicCardsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => '',
            'card_title' => '',
            'card_content' => '',
            'card_img' => 'image|max:1000',
            'card_link' => 'numeric',
            'bg_color' => '',
            'category_id' => 'numeric'
        ];
    }
}
