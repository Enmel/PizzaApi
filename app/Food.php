<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Food extends Model implements HasMedia
{
    use HasMediaTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'size',
        'price',
        'description',
        'category'
    ];

    public function categorydata()
    {
        return $this->belongsTo('App\FoodCategory', 'category'); //el segundo parametro es el campo de este modelo que se usa como llave foranea
    }
}
