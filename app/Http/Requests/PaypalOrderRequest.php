<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaypalOrderRequest extends FormRequest
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
            'full_name' => 'required|min:5',
            'province_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'ward_id' => 'required|numeric',
            'address' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => __('full_name_required'),
            'email.required' => __('email_required'),
            //'province_id.required' => __('province_required'),
            'district_id.required' => __('district_required'),
            'ward_id.required' => __('ward_required'),
            'address.required' => __('address_required'),
            'phone.required' => __('phone_required'),
            'phone.numeric' => __('phone_numeric'),
            'province_id.numeric' => __('province_required'),
            'district_id.numeric' => __('district_numeric'),
            'ward_id.numeric' => __('ward_numeric'),
            'email.email' => __('email_format'),
            'full_name.min' => __('full_name_min'),
        ];
    }
}
