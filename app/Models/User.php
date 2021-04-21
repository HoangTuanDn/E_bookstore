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

    public function checkPermissionAccess($permissionCheck){

        $roles = auth()->guard('admin')->user()->roles;

        foreach ($roles as $role){
            if ($role->permissions->contains('key_code', $permissionCheck)) {
                return true;
            };
        };

        return false;
    }

    public function filterUser($data)
    {
        $query = User::select('id', 'name', 'email', 'image_path');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }


        $sortData = [
            'name'       => 'username',
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
