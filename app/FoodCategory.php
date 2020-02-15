<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class FoodCategory extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'name', 'very_small_label', 'small_label', 'medium_label', 'large_label', 'very_large_label'
    ];
}
