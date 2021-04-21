<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'roles';

    public function users(){
        return $this
            ->belongsToMany(User::class, 'user_role','role_id', 'user_id')
            ->withTimestamps();
    }

    public function permissions(){
        return $this
            ->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')
            ->withTimestamps();
    }

    public function filterRole($data)
    {
        $query = Role::select('id', 'name', 'display_name');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }

        $sortData = [
            'name'       => 'name',
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
