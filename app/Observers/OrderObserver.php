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
        $BuyerCart=auth()->user()->Cart();
        $cart=$BuyerCart->select('product_id','price')->get()->map(function ($item) use ($order){
            return [
                'order_id'=>$item->id,
                'product_id'=>$item->product_id,
                'price_each'=>$item->price,
                'quantity_ordered'=>$item->cart->quantity,
                'total_amount'=>$item->price * $item->cart->quantity
            ];
        });
        $order->Details()->createMany($cart);
//        $BuyerCart->detach();
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
