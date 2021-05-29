<?php

namespace App\Http\Controllers\API\buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    private $factory = null;
    private $buyer;
    private $cart;
    private $RelationalCart;
    private $neworder = null;
    private $RelationalOrder;
    private $Orders;

    public function __construct()
    {
        if ($this->buyer = auth()->user()) {
            $this->cart = $this->buyer->Cart;
            $this->RelationalCart = $this->buyer->Cart();
            $this->orders = $this->buyer->OrderWithFactories;
            $this->RelationalOrder = $this->buyer->OrderWithFactories();
            if ($this->cart->count() >= 1) {
                $this->factory = $this->cart[0]->under_category->factory__;
            }
        }
    }

    public function index()
    {
        return new OrderResource(Order::where('buyer_id', $this->buyer->id));
    }
    /**
     *if the buyer already made an order delete the order and make another to consist the data with the current
     * cart of the buyer to ensure that card === order
     *
     * **/
    public function EmptyOrder()
    {
        //Buyer::find(1)->Orders()->where('orders.id',5)->detach()//dont user any detach in orders the relation just for relate the buyer an the factory of the specific order
        return  Order::where('status', 'In Process')->where('buyer_id', $this->buyer->id)->delete();
    }

    public function MakeOrder()
    {
        //TODO ADD TAX
        //comment and status of order are added later
        if (is_null($this->factory)) return $this->returnErrorMessage('Your Cart Is Empty , No Items To Order .');
        //if the buyer already made an order delete the order and make another to consist the data with the current cart of the buyer to ensure that card === order
        self::EmptyOrder();
        $total_amount = $this->cart->sum(function ($product) {
            return $product->cart->quantity * $product->price ;
        });
        create_order:{//when create an order the order observer will triggered to empty the cart and fill it in order_details and the other data to backup
        $order_info = [
            'buyer_id' => $this->buyer->id,
            'factory_id' => $this->factory->id,
            'total_amount' => $total_amount,
            'orderDate' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 'In Process'
        ];
        \request()->buyer=$this->buyer;
        \request()->factory=$this->factory;
        $neworder = Order::create($order_info);
    }
//      return $neworder->with('Details.product')->get(); inconsistent data
//       return [$this->RelationalOrder->where('orders.id',$this->neworder->id)->get(),$this->neworder->with('Details.product')s->get()];
        return new OrderResource($neworder);
    }


    public function PlaceOrder(Request $request,$order)
    {
        $order = Order::findOrFail($order);
        if ($order->status === "Shipped") {
            return $this->returnErrorMessage('This order has already been Shipped .');
        }$request->validate(['comment' => 'string|nullable|max:966']);
        $order->update(array_merge(
            $request->only( 'comment'),
            ['shippedDate' => Carbon::now()->format('Y-m-d H:i:s'),
                'status' => 'Shipped'
            ]));

        $this->cart->each(function ($product){
            $product->warehouse_quantity=$product->warehouse_quantity-$product->cart->quantity;
            $product->save();
        });
        $this->RelationalCart->detach();
        return new OrderResource($order);
    }


   /* public function DeleteItem($order,OrderDetails $item) {
        $order = Order::findOrFail($order);
        if(($order->id !== $item->order_id ) || ($order->status === 'Shipped') ){
            throw new AuthorizationException('This action is unauthorized .');
        }
        $item->delete();
        return $this->returnSuccessMessage('The Item deleted successfully .');
    }*/

}
