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

    public function filterCoupon($data)
    {
        $query = Coupon::select('id', 'name','number', 'count', 'condition', 'code', 'is_publish');

        if (!empty($data['name'])) {
            $query->where('name', 'like', "%{$data['name']}%");
        }

        if (!empty($data['code'])) {
            $query->where('code', 'like', "%{$data['code']}%");
        }

        $sortData = [
            'code'       => 'code',
            'number'       => 'number_apply',
            'condition'       => 'condition',
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
