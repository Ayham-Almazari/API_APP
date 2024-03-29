<?php

namespace App\Http\Controllers\API\buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private  $factory = null;
    private  $buyer ;
    private  $cart ;
    private $RelationalCart;
    public function __construct()
    {
       if ($this->buyer=auth()->user()) {
           $this->cart=$this->buyer->Cart;
           $this->RelationalCart=$this->buyer->Cart();
           if ($this->cart->count() >= 1) {
               $this->factory=$this->cart[0]->under_category->factory__;
           }
       }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
       return  CartResource::collection($this->cart)->additional([
           'factory'=>[
               'factory_id'  =>$this->factory ? $this->factory->id:null,
               'factory_name'=>$this->factory ? $this->factory->factory_name:null,
               'logo'        =>$this->factory ? $this->factory->logo:null
           ]]);
    }
    /**
     * show quantity of the product.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product){
        $cart=$this->RelationalCart->findOrFail($product->id);
        return response()->json(['quantity' => $cart->cart->quantity]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request ,Product $product)
    {
        $request->validate(['quantity'=>'numeric|required']);
        $response=\Gate::inspect('AuthorizeProductForCart',[Product::class,$this->factory,$product]);
        if ($response->denied())
            return $this->returnErrorMessage($response->message());
        if ($request->quantity > $product->warehouse_quantity) {
        return $this->returnError(['quantity'=>["The quantity ordered exceeds the quantity in the warehouse ". ( $this->factory->factory_name ?? "of this" ) . " factory "]]);
        }
        if ( $this->cart->find($product->id)) {
            $this->RelationalCart->updateExistingPivot($product->id,$request->only('quantity'));
            return $this->returnSuccessMessage('Updated Successfully .',201);
        }else{
            $this->RelationalCart->attach($product->id,$request->only('quantity'));
            return $this->returnSuccessMessage('Added Successfully .',201);
        }
        //if you need to return refreshed model

        //return auth()->user()->Cart()->where('product_id',$product->id)->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if ($this->RelationalCart->detach($product))
          return  $this->returnSuccessMessage('Removed Successfully .');
        else
          return  $this->returnErrorMessage('Something Error Or Already Deleted .');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function empty()
    {
        // Detach all roles from the user...
        (new OrderController)->EmptyOrder();

        if ($this->RelationalCart->detach()) {
                return $this->returnSuccessMessage('Emptied Successfully .');
            }else
                return   $this->returnErrorMessage('Something Error Or Already Emptied .');
    }
}
