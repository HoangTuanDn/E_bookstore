<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';

    public function districts(){
        return $this->hasMany(District::class, 'province_id');
    }
}
