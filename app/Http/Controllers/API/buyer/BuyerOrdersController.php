<?php

namespace App\Http\Controllers\API\buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Factory;
use App\Models\Order;
use Illuminate\Http\Request;

class BuyerOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $orders =Order::where('status', 'Shipped')
            ->where('buyer_id', auth()->user()->getJWTIdentifier())->get();
        return  OrderResource::collection($orders);
    }
}
