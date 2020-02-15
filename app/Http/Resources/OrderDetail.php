<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetail extends JsonResource
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
            'detail' => $this->id,
            'food' => [
                'id' => $this->food_id,
                'name' => $this->food->name,
                'price' => $this->food->price,
                'image' => $this->food->getFirstMedia('images')->getFullUrl()
            ],
            'quantity' => $this->quantity,
            'subtotal' => $this->quantity * $this->food->price
        ];
    }
}
