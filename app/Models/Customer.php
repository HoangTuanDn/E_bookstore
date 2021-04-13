<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use HasFactory;

    use HasFactory;
    use SoftDeletes;


    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'customers';

    public function productReviews(){
        return $this
            ->belongsToMany(Product::class, 'customer_review', 'customer_id', 'product_id')
            ->withPivot('nickname', 'quality_rate', 'price_rate', 'content')
            ->withTimestamps();
    }
}
