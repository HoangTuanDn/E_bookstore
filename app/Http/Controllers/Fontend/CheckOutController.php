<?php

namespace App\Http\Controllers\fontend;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CheckOutController extends Controller
{
    public function index(){
        return view('fontend.checkout');
    }
}
