<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailCollection;
use App\Http\Resources\OrderVoucherCollection;


class Order extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $paidout = 0;

        if($this->vouchers->where('paidout', '=', 1)->sum('amount') > $this->details->sum('total')){
            $paidout = 1;
        }

        return [
            'order' => $this->id,
            'user' => $this->user->name,
            'details' => new OrderDetailCollection($this->details),
            'vouchers' => new OrderVoucherCollection($this->vouchers),
            'status' => $this->status,
            'paidout' => $paidout,
            'created_at' => $this->created_at,
            'total' => $this->details->sum('total')
        ];
    }
}
