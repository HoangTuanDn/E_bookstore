<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255|min:5',
            'price' =>'required|numeric',
            'category_id' => 'required',
            'featured_img' => 'dimensions:min_width=270,min_height=340',
            'image_detail[]' => 'image',
            'contents' => 'required',
            'title' => 'required'
        ];
    }
}
