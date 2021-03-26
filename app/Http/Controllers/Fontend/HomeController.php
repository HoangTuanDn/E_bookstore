<?php

namespace App\Http\Controllers\fontend;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    private $product;
    private $category;

    /**
     * HomeController constructor.
     * @param $product
     * @param $category
     */
    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index(Request $request){

        $dbProduct = $this->product
            ->get(['id', 'slug', 'name', 'price', 'featured_img', 'discount', 'quantity', 'quantity_sold', 'type', 'publish_date', 'created_at']);

        $newProduct = $dbProduct->sortByDesc('publish_date')->slice(0, 6);

        $allProducts = $dbProduct->chunk(2);

        $biographicProducts = $this->category->proudctsByCatagorySlug(__('biographic_slug'));

        $adventureProducts = $this->category->proudctsByCatagorySlug(__('adventure_slug'));
        $humorProducts = $this->category->proudctsByCatagorySlug(__('humor_slug'));

        $cookProducts = $this->category->proudctsByCatagorySlug(__('cook_slug'));

        $bestSellProducts = $dbProduct->sortByDesc('quantity_sold')->slice(0, 8);

        return view('fontend.home', compact('newProduct', 'allProducts', 'bestSellProducts','biographicProducts','adventureProducts', 'humorProducts', 'cookProducts'));
    }
}
