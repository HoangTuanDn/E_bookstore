<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'comment' => 'required',
            'parent_id' => 'required|numeric',
            'blog_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => __('comment_required'),
            'parent_id.required' => __('comment_format'),
            'blog_id.required' => __('comment_format'),
            'parent_id.numeric' => __('comment_format'),
            'blog_id.numeric' => __('comment_format'),
        ];
    }
}
