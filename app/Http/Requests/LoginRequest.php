<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username_or_email' => 'required',
            'password' =>'required',
        ];
    }
    public function messages()
    {
        return [
            'username_or_email.required' => __('user_or_name_required'),
            'password.required' => __('password_required'),
        ];
    }

}
