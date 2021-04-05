<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'coupons';

}
