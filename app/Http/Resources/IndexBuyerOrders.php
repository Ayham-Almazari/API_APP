<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexBuyerOrders extends JsonResource
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
            'factory'=>[
                'factory_name'     =>$this->factory_->factory_name,
                'logo'             =>$this->factory_->logo
            ],
            'order'=>[
                'order_id'        =>$this->id,
                'status'          =>$this->status,
                'total_amount'    =>$this->total_amount,
                'shippedDate'     =>$this->shippedDate
            ]
        ];
    }
}
