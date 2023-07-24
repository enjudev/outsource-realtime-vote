<?php

namespace App\Http\Requests\Admin\LangCustom;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $data = [
            'lang.*.key' => 'nullable',
            'lang.*.en' => 'nullable',
            'lang.*.vi' => 'nullable',
        ];
        return $data;
    }
}
