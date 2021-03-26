<?php

namespace App\Http\Controllers\fontend;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WishListController extends Controller
{
    public function index()
    {
        return view('fontend.wish_list');
    }
}
