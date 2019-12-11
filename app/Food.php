<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'size',
        'price',
        'description',
        'category'
    ];

    public function category()
    {
        return $this->hasOne('App\FoodCategory');
    }
}
