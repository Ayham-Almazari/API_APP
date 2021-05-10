<?php


namespace App\Http\Controllers\API\OwnerControllers;


use App\Http\Resources\IndexBuyerOrders;
use App\Http\Resources\OrderResource;
use App\Models\Factory;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class FactoryOrdersController
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Factory $factory)
    {
        $orders =Order::where('status', 'Shipped')
                ->where('factory_id', $factory->id )->get();
        return  IndexBuyerOrders::collection($orders);
    }


    public function show(Order $order){
        /*  $orders =Order::where('status', 'Shipped')
              ->where('buyer_id', auth()->user()->getJWTIdentifier())->get();*/
        return new OrderResource($order);
    }

}
