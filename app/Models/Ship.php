<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $table = 'ships';

    protected $guarded = ['id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function filterShip($data)
    {
        $query = Ship::leftJoin('provinces', 'ships.province_id', '=', 'provinces.id')
            ->leftJoin('districts', 'ships.district_id', '=', 'districts.id')
            ->leftJoin('wards', 'ships.ward_id', '=', 'wards.id')
            ->select('ships.*');

        if (!empty($data['province_name'])) {
            $query->where('provinces.name', 'like', "%{$data['province_name']}%");
        }

        if (!empty($data['district_name'])) {
            $query->where('districts.name', 'like', "%{$data['district_name']}%");
        }

        if (!empty($data['ward_name'])) {
            $query->where('wards.name', 'like', "%{$data['ward_name']}%");
        }


        $sortData = [
            'province_name' => 'provinces.name',
            'district_name' => 'districts.name',
            'ward_name'     => 'wards.name',
            'price'         => 'price',
            'created_at'    => 'created_at'
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

        return $query
            ->with(['province', 'district', 'ward'])
            ->paginate($data['limit'], ['*'], 'page', $data['page']);
    }
}
