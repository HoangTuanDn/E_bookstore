<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'name_vn' => 'required|max:255|min:5',
            'name_en' => 'required|max:255|min:5',
            'category_id' => 'required',
            'featured_img' => 'dimensions:min_width=880,min_height=460',
            'content_vn' => 'required',
            'content_en' => 'required',
            'title_vn' => 'required',
            'title_en' => 'required'
        ];
    }
}
