<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'permissions';

    public function permissions(){
        return $this
            ->hasMany(Permission::class, 'parent_id');
    }

    public function roles(){
        return $this
            ->belongsToMany(Permission::class, 'permission_role', 'permission_id','role_id')
            ->withTimestamps();
    }
}
