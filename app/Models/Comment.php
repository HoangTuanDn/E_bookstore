<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'blog_customer';

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }


}
