<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $attributes = [
        'author'        => '',
        'title'         => '',
        'quantity'      => '',
        'quantity_sold' => '',
        'discount'      => '',
        'type'          => '',
        'publisher'     => '',
        'publish_date'  => '1/1/1970',
        'page'          => '',
        'dimensions'    => '',
    ];

    protected $table = 'products';

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this
            ->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this
            ->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id')
            ->withTimestamps();
    }

    public function customerReviews()
    {
        return $this
            ->belongsToMany(Customer::class, 'customer_review', 'product_id', 'customer_id')
            ->withPivot('nickname', 'quality_rate', 'price_rate', 'content')
            ->withTimestamps();

    }

    public function upsellProducts()
    {
        $products = Product::select('id', 'slug', 'name', 'title', 'author', 'price', 'featured_img', 'discount', 'quantity', 'quantity_sold', 'type', 'publish_date', 'created_at')
            ->orderByRaw('price - discount DESC')->limit(config('custom.limit'))->get();

        return $products;
    }

    public function getRate($productIs)
    {
        $product = Product::find($productIs);
        $productsToCustomer = $product->customerReviews;
        $avgRate = 0;
        $totalRate = 0;
        $numberReview = 1;

        if (!$productsToCustomer){
            return $avgRate;
        }

        foreach ($productsToCustomer as $review) {
            $numberReview += 1;
            $totalRate += ($review->pivot->quality_rate + $review->pivot->price_rate)/2;
        }

        $numberReview = $numberReview > 1 ? $numberReview - 1 : 1;
        $avgRate = $totalRate / $numberReview;
        return $avgRate;
    }

    public function filterProduct($data)
    {
        $query = Product::select('id', 'slug', 'name', 'title', 'author', 'price', 'featured_img', 'discount', 'quantity', 'quantity_sold', 'type', 'publish_date', 'created_at');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }

        if (!empty($data['category'])) {

            $categories = Category::join('category_product as cp', 'categories.id', '=', 'cp.category_id')
                ->where('categories.slug', $data['category'])
                ->get(['cp.product_id']);

            $productIds = [];
            $categories->each(function ($item, $key) use (&$productIds) {
                $productIds [] = $item->product_id;
            });

            $query->whereIn('id', $productIds);

        }

        if (!empty($data['tag'])) {

            $tags = Tag::join('product_tag as pt', 'tags.id', '=', 'pt.tag_id')
                ->where('tags.slug', $data['tag'])
                ->get(['pt.product_id']);

            $productIds = [];
            $tags->each(function ($item, $key) use (&$productIds) {
                $productIds [] = $item->product_id;
            });

            $query->whereIn('id', $productIds);

        }

        if (!empty($data['price_min']) && !empty($data['price_max'])) {
            $query->whereBetween('discount', [$data['price_min'], $data['price_max'],]);
        }

        $sortData = [
            'name'       => 'name',
            'date'       => 'publish_date',
            'price'      => 'discount',
            'created_at' => 'created_at'
        ];

        if (isset($data['sort']) && array_key_exists($data['sort'], $sortData)) {
            $sort = $sortData[$data['sort']];
        } else {
            $sort = $sortData['created_at'];
        }

        if (isset($data['order']) && (utf8_strtolower($data['order']) == 'desc')) {
            $order = "desc";
        } else {
            $order = "asc";
        }

        $query->orderBy($sort, $order);

        if (isset($data['limit'])) {
            if ($data['limit'] < 1) {
                $data['limit'] = config('custom.limit');
            }
        } else {
            $data['limit'] = config('custom.limit');
        }

        if (!isset($data['page'])) {
            $data['page'] = 1;
        }

        return $query->paginate($data['limit'], ['*'], 'page', $data['page']);
    }


}
