<?php

namespace App\Http\Controllers\fontend;


use App\Http\Requests\EmailContactRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\EmailContact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    private $product;
    private $category;
    private $emailContact;
    private $blog;


    /**
     * HomeController constructor.
     * @param $product
     * @param $category
     * @param $emailContact
     * @param $blog
     */
    public function __construct(Product $product, Category $category, EmailContact $emailContact, Blog $blog)
    {
        $this->product = $product;
        $this->category = $category;
        $this->emailContact = $emailContact;
        $this->blog = $blog;
    }

    public function index(Request $request){

        $dbProduct = $this->product
            ->get(['id', 'slug','author', 'title', 'name', 'price', 'featured_img', 'discount', 'quantity', 'quantity_sold', 'type', 'publish_date', 'created_at']);

        $newProduct = $dbProduct->sortByDesc('publish_date')->slice(0, 6);

        $allProducts = $dbProduct->chunk(2);

        $biographicProducts = $this->category->proudctsByCatagorySlug(__('biographic_slug'));

        $adventureProducts = $this->category->proudctsByCatagorySlug(__('adventure_slug'));
        $humorProducts = $this->category->proudctsByCatagorySlug(__('humor_slug'));

        $cookProducts = $this->category->proudctsByCatagorySlug(__('cook_slug'));

        $bestSellProducts = $dbProduct->sortByDesc('quantity_sold')->slice(0, 8);

        $ourBlogs = $this->blog->latest()->limit(3)->get(['name', 'slug','view', 'title', 'created_at']);

        $isHomePage = true;

        return view('fontend.home', compact('isHomePage','newProduct', 'allProducts', 'bestSellProducts','biographicProducts','adventureProducts', 'humorProducts', 'cookProducts', 'ourBlogs'));

    }

}
