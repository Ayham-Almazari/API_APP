<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\Factory;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function viewAny($owner)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Owner  $owner
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function view($owner,Factory $factory, Product $product)
    {
        return $factory->id===$product->under_category->factory_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function create($owner)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function update($owner,Factory $factory, Product $product)
    {
        return $factory->id===$product->under_category->factory_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function delete($owner,Factory $factory, Product $product)
    {
        return $factory->id===$product->under_category->factory_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function restore(Buyer $buyer, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function forceDelete(Buyer $buyer, Product $product)
    {
        //
    }

    /**
     * Determine whether the owner can work the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function AuthorizeProductForOwner($owner,Factory $factory, Product $product)
    {
        return $factory->id===$product->under_category->factory_id;
    }

    /**
     * Determine whether the owner can work the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function AuthorizeProductForCart($owner,$factory, Product $product)
    {
        //if cart is empty authorized
        if (is_null($factory)) {
            return Response::allow();
        }elseif ($factory->id !== $product->under_category->factory__->id) {
            //if the buyer tried to add product from another factory then unauthorized
            return Response::deny("There are items in your cart from {$factory->factory_name} . Clear your cart Or Order items in your cart to add items from another factory .");
        }
        return Response::allow();
    }
}
