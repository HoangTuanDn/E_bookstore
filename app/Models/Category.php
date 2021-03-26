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
    

}
