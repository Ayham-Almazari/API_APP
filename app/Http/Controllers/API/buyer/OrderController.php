<?php

namespace App\Http\Controllers\API\buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    private  $factory = null ;
    private  $buyer ;
    private  $cart ;
    private  $RelationalCart ;
    private $neworder=null;
    private $RelationalOrder;
    private $Orders;

    public function __construct()
    {
        if ($this->buyer=auth()->user()) {
            $this->cart = $this->buyer->Cart;
            $this->RelationalCart = $this->buyer->Cart();
            $this->orders = $this->buyer->OrderFromFactories;
            $this->RelationalOrder = $this->buyer->OrderFromFactories();
            if ($this->cart->count() >= 1) {
                $this->factory = $this->cart[0]->under_category->factory__;
            }
        }
    }

    public function index()
    {
        return new OrderResource(Order::where('buyer_id',$this->buyer->id));
    }

   public function MakeOrder()
   {
       //TODO when delete the factory or buyer associated with this order your must determine how access them
       //TODO ADD TAX
       //comment and status of order are added later
        if (is_null($this->factory)) return $this->returnErrorMessage('Your Cart Is Empty , No Items To Order .') ;
        //if the buyer already made an order delete the order and make another to consist the data with the current cart of the buyer to ensure that card === order
        //Buyer::find(1)->Orders()->where('orders.id',5)->detach()//dont user any detach in orders the relation just for relate the buyer an the factory of the specific order
        Order::where('status','In Process')->where('buyer_id',$this->buyer->id)->where('factory_id',$this->factory->id)->delete();

        $total_amount= $this->cart->sum(function ($product) {
            return $product->cart->quantity * $product->price ;
         });
       create_order:{//when create an order the order observer will triggered to empty the cart and fill it in order
       $order_info=[
           'buyer_id'=>$this->buyer->id,
           'factory_id'=>$this->factory->id,
           'total_amount'=>$total_amount,
           'orderdate'=>Carbon::now()->format('Y-m-d H:i:s'),
           'status' =>'In Process'
       ];
       $neworder=Order::create($order_info);
      }
//      return $neworder->with('Details.product')->get(); inconsistent data

        return new OrderResource($neworder);
//       return [$this->RelationalOrder->where('orders.id',$this->neworder->id)->get(),$this->neworder->with('Details.product')s->get()];
   }


    public function PlaceOrder(Request $request, $order)
   {
       $order= Order::findOrFail($order);
       $request->validate(['comment'=>'string|nullable|max:966','requiredDate'=>'date_format:Y:m:d H:i|after_or_equal:'.date('Y:m:d H:i')]);
       $order->update(array_merge(
           $request->only('requiredDate','comment'),
           ['shippedDate'=>Carbon::now()->format('Y-m-d H:i:s'),
             'status'=>'Shipped'
           ]));
       $this->RelationalCart->detach();
        return $order;
   }


}
