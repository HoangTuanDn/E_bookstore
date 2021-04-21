<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['name', 'parent_id', 'slug', 'updated_at', 'created_at','deleted_at'];

    protected $table = 'categories';

    public function products()
    {
        return $this
            ->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')
            ->withTimestamps();
    }
    public function proudctsByCatagorySlug($categorySlug){
        $category = Category::select('id')->where('slug', $categorySlug)->first();
        $products = Category::find($category->id)->products->chunk(2);

        return $products;
    }

    public function filterCategory($data)
    {
        $query = Category::select('id', 'name', 'created_at');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }


        $sortData = [
            'name'       => 'name',
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
