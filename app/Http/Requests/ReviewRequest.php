<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'id' => 'required|numeric',
            'quality_rate' => 'required|numeric|digits_between:1,5',
            'price_rate' => 'required|numeric|digits_between:1,5',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('user_or_name_required'),
            'id.numeric' => __('id_numeric'),
            'quality_rate.required' => __('rate_required'),
            'quality_rate.numeric' => __('rate_numeric'),
            'quality_rate.digits_between' => __('rate_numeric'),
            'price_rate.required' => __('rate_required'),
            'price_rate.numeric' => __('rate_numeric'),
            'price_rate.digits_between' => __('rate_numeric'),
        ];
    }
}
