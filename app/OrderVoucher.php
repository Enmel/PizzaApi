<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderVoucher extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'order_id', 'amount', 'bank', 'reference', 'comments'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
