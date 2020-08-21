<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'item_code',
        'items',
        'no_of_stocks',
        'end_cycle_date',
        'duration',
        'product_cost',
    ];
}
