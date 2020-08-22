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
    ];

    public function products() {
        return $this->hasMany('App\CartProduct', 'cart_id', 'id');
    }
}
