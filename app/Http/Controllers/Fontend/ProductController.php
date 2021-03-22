<?php

namespace App\Http\Controllers\fontend;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function index(){
        return view('fontend.shop');
    }

    public function show(Request $request){
        return view('fontend.single_product');
    }
}
