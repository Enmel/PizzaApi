<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodCategory extends JsonResource
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
            'labels' => [
                'very_small' => $this->very_small_label,
                'small' => $this->small_label,
                'medium' => $this->medium_label,
                'large' => $this->large_label,
                'very_large' => $this->very_large_label,
            ],
        ];
    }
}
