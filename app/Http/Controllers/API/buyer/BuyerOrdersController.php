<?php

namespace App\Http\Controllers\API\buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndexBuyerOrders;
use App\Http\Resources\OrderResource;
use App\Models\Factory;
use App\Models\Order;

class BuyerOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders =Order::where('status', 'Shipped')
            ->where('buyer_id', auth()->user()->getJWTIdentifier())->get();
        return   IndexBuyerOrders::collection($orders);
    }

    public function show(Order $order){
        /*  $orders =Order::where('status', 'Shipped')
              ->where('buyer_id', auth()->user()->getJWTIdentifier())->get();*/
        return new OrderResource($order);
    }
}
