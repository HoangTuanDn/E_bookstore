<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function loginForm() {
        if (auth()->guard('admin')->check()){
            return redirect()->to('admin');
        }
        return view('admin.auth.login');
    }

    public function loginAction(Request $request){
        $remember = $request->has('remember_me') ? true: false;

        if (
            auth()->guard('admin')
                  ->attempt($request->only('email', 'password'),
            $remember
        )){
            return redirect()->to('admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
