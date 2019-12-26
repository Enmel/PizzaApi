<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'order_id', 'food_id', 'quantity', 'total'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function food()
    {
    	return $this->belongsTo('App\Food');
    }
}
