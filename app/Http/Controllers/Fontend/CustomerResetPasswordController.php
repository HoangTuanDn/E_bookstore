<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Customer;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerResetPasswordController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function reset(Request $request)
    {

        $request->validate($this->rules(), $this->validationErrorMessages());

        $email = $request->input('email');
        $customer = $this->customer->where('email', $email)->first();

        if ($customer){

            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
            );

            if ( $response == Password::PASSWORD_RESET){
                $json = [
                    'success' => true,
                    'data'    => [
                        'url_redirect' => route('account.my', ['language' => app()->getLocale()]),
                        'type'         => 'success',
                        'message'      => __('reset_password_success'),
                    ],
                    'code'    => Response::HTTP_OK
                ];

            }else{
                $json = [
                    'success' => false,
                    'errors'  => [
                        [__('reset_password_warning')]
                    ],
                    'code'    => Response::HTTP_NOT_ACCEPTABLE
                ];
            }

        }else {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('customer_not_found')]
                ],
                'code'    => Response::HTTP_NOT_FOUND
            ];
        }

        return response()->json($json, $json['code']);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }


    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }


    public function broker()
    {
        return Password::broker('customers');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
}
