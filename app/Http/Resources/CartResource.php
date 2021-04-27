<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Cart */
class CartResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id'     => $this -> id,
            'product_name'   => $this -> product_name,
            'price'   => $this -> price,
            'product_picture' => $this ->product_picture,
            'quantity' => $this ->cart->quantity
        ];
    }

}
