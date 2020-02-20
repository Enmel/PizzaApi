<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $prices = [];
        $labels = [];

        if ($this->very_small_price > 0) {
            $prices['very_small'] = $this->very_small_price;
            $labels['very_small'] = $this->categorydata->very_small_label;
        }

        if ($this->small_price > 0) {
            $prices['small'] = $this->small_price;
            $labels['small'] = $this->categorydata->small_label;
        }

        if ($this->medium_price > 0) {
            $prices['medium'] = $this->medium_price;
            $labels['medium'] = $this->categorydata->medium_label;
        }

        if ($this->large_price > 0) {
            $prices['large'] = $this->large_price;
            $labels['large'] = $this->categorydata->large_label;
        }

        if ($this->very_large_price > 0) {
            $prices['very_large'] = $this->very_large_price;
            $labels['very_large'] = $this->categorydata->very_large_label;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->getFirstMedia('images')->getFullUrl(),
            'description' => $this->description,
            'prices' => $prices,
            'labels' => $labels,
            'category' => [
                'id' => $this->categorydata->id,
                'name' => $this->categorydata->name,
                'image' => $this->categorydata->getFirstMedia('images')->getFullUrl()
            ],
        ];
    }
}
