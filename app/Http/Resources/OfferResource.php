<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Offer */
class OfferResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'offer_value' => $this->offer_value,
            'offer_price' => $this->offer_price,
            'offer_description' => $this->offer_description,
            'offer_title' => $this->offer_title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'for_product' => $this->for_product,
            'product_id' => $this->product_id,
        ];
    }
}
