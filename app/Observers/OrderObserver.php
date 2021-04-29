<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $BuyerCart=auth()->user()->Cart;
        $cart=$BuyerCart->map(function ($item) use ($order){
            return [
                'order_id'=>$order->id,
                'product_id'=>$item->id,
                'price_each'=>$item->price,
                'product_name'=>$item->product_name,
                'product_picture'=>$item->product_picture,
                'category'=>$item->under_category->category_name,
                'quantity_ordered'=>$item->cart->quantity,
                'total_amount'=>$item->price * $item->cart->quantity
            ];
        });
        $order->Details()->createMany($cart);
        $order->factory_()->create([
            'factory_id'       =>\request()->factory->id,
            'factory_name'     =>\request()->factory->factory_name,
            'phone'            =>\request()->factory->phone,
            'address'          =>\request()->factory->address,
            'facebook'         =>\request()->factory->facebook,
            'instagram'        =>\request()->factory->instagram,
            'email'            =>\request()->factory->email,
            'logo'             =>\request()->factory->logo
        ]);
        $order->owner_()->create([
            'owner_id'       =>\request()->factory->owner->id,
            'phone'          =>\request()->factory->owner->phone,
            'address'        =>\request()->factory->owner->profile->address,
            'facebook'       =>\request()->factory->owner->profile->facebook,
            'instagram'      =>\request()->factory->owner->profile->instagram,
            'first_name'     =>\request()->factory->owner->profile->first_name,
            'last_name'      =>\request()->factory->owner->profile->last_name,
            'username'       =>\request()->factory->owner->username,
            'picture'        =>\request()->factory->owner->profile->picture
        ]);
        $order->buyer_()->create([
            'buyer_id'     =>\request()->buyer->id,
            'phone'        =>\request()->buyer->phone,
            'address'      =>\request()->buyer->profile->address,
            'facebook'     =>\request()->buyer->profile->facebook,
            'instagram'    =>\request()->buyer->profile->instagram,
            'first_name'   =>\request()->buyer->profile->first_name,
            'last_name'    =>\request()->buyer->profile->last_name,
            'username'     =>\request()->buyer->username,
            'picture'      =>\request()->buyer->profile->picture
        ]);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
