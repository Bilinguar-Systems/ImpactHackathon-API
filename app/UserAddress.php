<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'users_address';

    protected $fillable = [
        'user_id',
        'lot_no',
        'street',
        'barangay',
        'municipality',
        'city',
        'zip_code',
    ];
}
