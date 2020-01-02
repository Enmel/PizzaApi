<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FoodCategory;

class Food extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->getFirstMedia('images')->getFullUrl(),
            'description' => $this->description,
            'price' => $this->price,
            'size' => $this->size,
            'category' => new FoodCategory($this->categorydata)
        ];
    }
}
