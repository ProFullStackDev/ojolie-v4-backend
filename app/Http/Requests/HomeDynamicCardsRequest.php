<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeDynamicCardsRequest extends FormRequest
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
            'name' => 'required',
            'card_title' => 'required',
            'card_content' => 'required',
            'card_img' => 'required|image|max:1000',
            'card_link' => 'required|numeric',
            'bg_color' => 'required',
            'category_id' => 'required|numeric'
        ];
    }
}
