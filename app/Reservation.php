<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'status', 'seats', 'date', 'comments'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
