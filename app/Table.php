<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder as Builder;

class Table extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'chairs', 'description'
    ];

    public function scopeHasSeats(Builder $query, $chairs): Builder
	{
	    return $query->where('chairs', '>=', $chairs);
	}
}
