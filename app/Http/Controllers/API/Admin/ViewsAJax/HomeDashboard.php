<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Cart;
use App\Models\Factory;
use App\Models\Order;
use App\Models\Owner;
use App\Models\Product;

class HomeDashboard extends Controller
{
    public $factories;
    public $admins;
    public $buyers;
    public $owners;
    public $orders;
    public $carts;
    public $payment;
    public $products;
    public $buyers_percentage;
    public $factories_percentage;
    public $cart_percentage;
    public $product_percentage;
    public function __construct()
    {
            $this->factories=Factory::count();
                $this->admins=Admin::count();
            $this->buyers=Buyer::count();
            $this->owners=Owner::count();
            $this->orders=Order::where('status','Shipped')->count();
            $this->carts=Buyer::has('Cart')->get()->count();
            $this->payment=Order::all()->sum(function ($order) {
                return  $order->total_amount;
            });
            $this->products=Product::count();
            //(number_of_buyers/number_of_users)*100
            $this->buyers_percentage=round((Buyer::has('OrderWithFactories')->get()->count()/$this->buyers)*100,2);
            $this->factories_percentage=round((Factory::has('BuyersOrderedFromMyFactory')->get()->count()/$this->factories)*100,2);
            $this->cart_percentage=round((Buyer::has('Cart')->get()->count()/$this->buyers)*100,2);
            $this->product_percentage=round((Product::has('Me_In_Orders_Details')->get()->count()/$this->products)*100,2);
    }

    public function index()
    {
        return view('pages.admin_home')->with([
            'factories'=>$this->factories,
            'admins'=>$this->admins,
            'buyers'=>$this->buyers,
            'owners'=>$this->owners,
            'orders'=>$this->orders,
            'carts' =>$this->carts,
            'payment'=>$this->payment,
            'products'=>$this->products,
            'buyers_percentage'=>$this->buyers_percentage,
            'factories_percentage'=>$this->factories_percentage,
            'cart_percentage'=>$this->cart_percentage,
            'product_percentage'=>$this->product_percentage,
        ]);
    }
}
