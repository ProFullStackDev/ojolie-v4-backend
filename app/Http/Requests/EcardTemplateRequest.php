<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcardTemplateRequest extends FormRequest
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
            'template_name' => 'required',
            'template_title' => 'required',
            'template_content' => 'required',
            'mb_template_title' => 'required',
            'mb_template_content' => 'required',
            'default' => 'required',

        ];
    }
}
