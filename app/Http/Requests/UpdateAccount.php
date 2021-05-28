<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccount extends FormRequest
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
            'full_name' => 'min:5',
            'province_id' => 'numeric',
            'district_id' => 'numeric',
            'ward_id' => 'numeric',
            'phone' => 'numeric',
            'email' => 'email',
        ];
    }

    public function messages()
    {
        return [
            'province_id.numeric' => __('province_required'),
            'district_id.numeric' => __('district_numeric'),
            'ward_id.numeric' => __('ward_numeric'),
            'phone.numeric' => __('phone_numeric'),
            'email.email' => __('email_format'),
            'full_name.min' => __('full_name_min'),
        ];
    }
}
