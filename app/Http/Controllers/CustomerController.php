<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\stringContains;

class CustomerController extends Controller
{
    private $customer;

    /**
     * CustomerController constructor.
     * @param $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    {
        return view('fontend.customer.account');
    }

    public function login(LoginRequest $request, $language)
    {

        $remember = $request->has('remember_me');
        $request_field = filterEmailOrUsername($request, 'username_or_email');

        $credentials = changeKeyCheck($request->only('username_or_email', 'password'), $request_field);

        if (auth()->guard('customer')
            ->attempt($credentials, $remember)) {
            $json = [
                'success' => true,
                'data'    => [
                    'url_redirect' => route('home', ['language' => app()->getLocale()]),
                    'type'         => 'success',
                    'message'      => __('login_success'),
                ],
                'code'    => Response::HTTP_CREATED
            ];
        } else {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('user_or_name_password_error')]
                ],
                'code'    => Response::HTTP_UNAUTHORIZED
            ];
        }

        return response()->json($json, $json['code']);
    }


    public function register(RegisterRequest $request, $language)
    {

        $dataInsert = $request->only([
            'name',
            'email',
            'password',
            'phone',
            'province_id',
            'district_id',
            'ward_id',
            'address',
            'address',
            'full_name',
        ]);

        $dataInsert['password'] = Hash::make($dataInsert['password']);

        try {
            $isCreated = true;
            $this->customer->create($dataInsert);

        } catch (\Exception $e) {
            $isCreated = false;
            Log::error('message: ' . $e->getMessage() . '--file : ' . $e->getFile() . '--Line : ' . $e->getLine());
        }

        if ($isCreated) {
            $json = [
                'success' => true,
                'data'    => [
                    'type'    => 'success',
                    'message' => __('register_success'),
                ],
                'code'    => Response::HTTP_CREATED
            ];
        } else {
            $json = [
                'success' => false,
                'errors'  => [
                    [__('error_message')]
                ],
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
        return response()->json($json, $json['code']);

    }

    public function logout(Request $request, $language)
    {
        $name = auth()->guard('customer')->user()->name;
        auth()->guard('customer')->logout();
        $json = [
            'success' => true,
            'data'    => [
                'type'    => 'success',
                'message' => __('logout_success', ['name' => $name]),
                'url_redirect' => route('account.my', ['language' => app()->getLocale()]),
            ],
            'code'    => Response::HTTP_OK
        ];
        return response()->json($json, $json['code']);
    }
}
