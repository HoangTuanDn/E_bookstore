<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}
