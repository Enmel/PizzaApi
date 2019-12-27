<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailCollection;


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
        return [
            'order' => $this->id,
            'user' => $this->user->name,
            'details' => new OrderDetailCollection($this->details),
            'status' => $this->status,
            'paidout' => $this->paidout,
            'created_at' => $this->created_at,
            'total' => $this->details->sum('total')
        ];
    }
}
