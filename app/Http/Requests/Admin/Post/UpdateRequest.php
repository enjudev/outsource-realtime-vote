<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return [
            'title' => 'required',
            'summary' => 'required',
            'parent_id' => 'required',
            'published' => 'required',
            'label' => 'required',
            'slug' => 'required',
            'linkColor' => 'required',
            'enableComment' => 'nullable',
            'displayPriority' => 'nullable',
            'description' => 'required',
            'thumbnail' => 'required',
            'schema' => 'nullable|json',
            'meta_robot	' => 'nullable',
            'seo_title' => 'nullable',   
            'seo_description' => 'nullable',
            'seo_keyword' => 'nullable',
            'seo_canonical' => 'nullable',
        ];
    }
}
