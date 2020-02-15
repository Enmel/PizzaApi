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
                'size' => $this->food->categorydata->{"$this->size"."_label"},
                'image' => $this->food->getFirstMedia('images')->getFullUrl(),
                'price' =>  $this->food->{"$this->size"."_price"}
            ],
            'quantity' => $this->quantity,
            'subtotal' => $this->quantity * $this->food->{"$this->size"."_price"}
        ];
    }
}
