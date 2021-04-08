<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'orders';

    public function products(){
        return $this
            ->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function ship(){
        return $this
            ->belongsTo(Ship::class, 'ship_id');
    }

    public function coupon(){
        return $this
            ->belongsTo(Coupon::class, 'coupon_id');
    }

    public function payment(){
        return $this
            ->belongsTo(Payment::class, 'payment_id');
    }
}
