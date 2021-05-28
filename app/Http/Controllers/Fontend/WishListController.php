<?php

namespace App\Http\Controllers\fontend;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WishListController extends Controller
{
    private $product;

    /**
     * WishListController constructor.
     * @param $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $allProducts = $this->product->where('quantity' , '!=', 0)->get(['id'])->toArray();
        $allProducts = array_column($allProducts,'id');
        $allProducts = implode(',', $allProducts);

        return view('fontend.wish_list', compact('allProducts'));
    }
}
