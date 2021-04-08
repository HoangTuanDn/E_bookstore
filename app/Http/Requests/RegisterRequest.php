<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:2',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6|',
            're_password' => 'required|min:6|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('name_required'),
            'email.required' => __('email_required'),
            'email.email' => __('email_format'),
            'email.unique' => __('email_unique'),
            'password.required' => __('password_required'),
            'password.min' => __('password_min'),
            're_password.required' => __('password_confirmation_required'),
            're_password.same' => __('password_confirmation_same'),
        ];
    }
}
