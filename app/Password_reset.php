<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'token', 'email', 'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
