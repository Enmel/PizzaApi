<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SegurityQuestion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', "question", "answer"
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id'); //el segundo parametro es el campo de este modelo que se usa como llave foranea
    }
}
