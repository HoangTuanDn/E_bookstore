<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class CustomerForgotPasswordController extends Controller
{

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function showLinkRequestForm()
    {
        return view('fontend.customer.forgot_password');
    }



    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $email = $request->input('email');
        $customer = $this->customer->where('email', $email)->first();
        if ($customer){

            $status = $this->broker()->sendResetLink(
                $this->credentials($request)
            );


            if ($status == Password::RESET_LINK_SENT){
                $json = [
                    'success' => true,
                    'data'    => [
                        'type'         => 'success',
                        'message'      => __('send_email_reset_success'),
                    ],
                    'code'    => Response::HTTP_OK
                ];

            }else{
                $json = [
                    'success' => true,
                    'data'    => [
                        'type'         => 'warning',
                        'message'      => __('send_email_reset_warning'),
                    ],
                    'code'    => Response::HTTP_OK,
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

       /* return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);*/
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }


    public function broker()
    {
        return Password::broker('customers');
    }
}
