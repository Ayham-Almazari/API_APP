<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'factory'=>[
                'factory_id'     =>$this->factory_->factory_id,
                'factory_name'     =>$this->factory_->factory_name,
                'factory_phone'    =>$this->factory_->phone,
                'factory_address'  =>$this->factory_->address,
                'factory_facebook' =>$this->factory_->facebook,
                'factory_instagram'=>$this->factory_->instagram,
                'factory_email'    =>$this->factory_->email,
                'logo'             =>$this->factory_->logo
            ],
            'order'=>[
                'order_id'        =>$this->id,
                'status'          =>$this->status,
                'total_amount'    =>$this->total_amount,
                'comment'         =>$this->comment,
                'orderDate'       =>$this->orderDate,
                'requiredDate'    =>$this->requiredDate,
                'shippedDate'     =>$this->shippedDate
            ],
                'details'         =>$this->Details->map(fn($detail)=>[
                'item_id'    =>  $detail->id,
                'product_name'    =>$detail->product_name,
                'product_picture' =>$detail->product_picture,
                'quantity_ordered'=>$detail->quantity_ordered,
                'price_each'      =>$detail->price_each,
                'total_amount'    =>$detail->total_amount,
                'category'        =>$detail->category
            ])
            ,
            'buyer' => [
                'buyer_id'     =>$this->buyer_->buyer_id,
                'buyer_phone'    => $this->buyer_->phone,
               'buyer_username' => $this->buyer_->username,
               'buyer_name'     => $this->buyer_->first_name .  $this->buyer_->last_name ,
               'buyer_picture'  => $this->buyer_->picture,
               'buyer_address'  => $this->buyer_->address,
               'buyer_facebook'  => $this->buyer_->facebook,
               'buyer_instagram'  => $this->buyer_->instagram
            ],
            'owner' => [
                'owner_id'     =>$this->owner_->owner_id,
                'owner_phone'   => $this->owner_->phone,
                'owner_username'=> $this->owner_->username,
                'owner_name'    => $this->owner_->first_name .  $this->owner_->last_name ,
                'owner_picture' => $this->owner_->picture,
                'owner_address' => $this->owner_->address,
                'owner_facebook' => $this->owner_->facebook,
                'owner_instagram' => $this->owner_->instagram
                ]
        ];
    }
}
