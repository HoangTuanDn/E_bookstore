<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailContact extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'email_contact';
}
