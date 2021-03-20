<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [
        'id',
        'remember_token',
        'email_verified_at',

    ];

    protected $attributes = [
        'email_verified_at' => '',
        'remember_token'    => '',
        'image_path'    => '',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public function products()
    {
        return $this
            ->hasMany(Product::class, 'user_id');
    }

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->withTimestamps();
    }

}
