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
    

}
