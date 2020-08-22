<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'mode_of_payment',
    ];

    public function products() {
        return $this->hasMany('App\CartProduct', 'cart_id', 'id');
    }

    public function getIsPaidAttribute()
    {
        return $this->attributes['is_paid'] == 1;
    }
}
