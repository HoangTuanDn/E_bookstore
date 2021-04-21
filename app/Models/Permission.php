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

    public function filterPermission($data)
    {
        $query = Permission::select('id', 'name', 'display_name', 'parent_id', 'key_code');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }


        $sortData = [
            'key_code'       => 'code',
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
