<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderVoucher extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $paidout = 'Pendiente';

        if($this->paidout == 1){
            $paidout = 'Confirmado';
        }

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'bank' => $this->bank,
            'reference' => $this->reference,
            'comments' => $this->comments ?? "",
            'paidout' => $paidout
        ];
    }
}
