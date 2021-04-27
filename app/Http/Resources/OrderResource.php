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
        return [//TODO Add email to factory
            'factory'=>[
                'factory_id'       =>$this->factory_->id,
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
                'orderDate'       =>$this->orderdate,
                'requiredDate'    =>$this->requiredDate,
                'shippedDate'     =>$this->shippedDate
            ],
                'details'         =>$this->Details->map(fn($detail)=>[
                'product_id'      =>$detail->product_id,
                'product_name'    =>$detail->product->product_name,
                'product_picture' =>$detail->product->product_picture,
                'quantity_ordered'=>$detail->quantity_ordered,
                'price_each'      =>$detail->price_each,
                'total_amount'    =>$detail->total_amount,
                'category'        =>$detail->product->under_category->category_name
            ])
            ,
            'buyer' => [
               'buyer_id'       => $this->buyer_id,
               'buyer_phone'    => $this->buyer_->phone,
               'buyer_username' => $this->buyer_->username,
               'buyer_name'     => $this->buyer_->profile->first_name .  $this->buyer_->profile->last_name ,
               'buyer_picture'  => $this->buyer_->profile->picture,
               'buyer_address'  => $this->buyer_->profile->address,
               'buyer_facebook'  => $this->buyer_->profile->facebook,
               'buyer_instagram'  => $this->buyer_->profile->instagram
            ],
            'owner' => [
                'owner_id'      => $this->factory_->owner_id,
                'owner_phone'   => $this->factory_->owner->phone,
                'owner_username'=> $this->factory_->owner->username,
                'owner_name'    => $this->factory_->owner->profile->first_name .  $this->factory_->owner->profile->last_name ,
                'owner_picture' => $this->factory_->owner->profile->picture,
                'owner_address' => $this->factory_->owner->profile->address,
                'owner_facebook' => $this->factory_->owner->profile->facebook,
                'owner_instagram' => $this->factory_->owner->profile->instagram
                ]
        ];
    }
}
