<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\Factory;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function viewAny(Buyer $buyer)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function view(Buyer $buyer, Offer $offer)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function create(Buyer $buyer)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function update(Buyer $buyer, Offer $offer)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function delete(Buyer $buyer, Offer $offer)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function restore(Buyer $buyer, Offer $offer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Offer  $offer
     * @return mixed
     */
    public function forceDelete(Buyer $buyer, Offer $offer)
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
    public function AuthorizeOfferForOwner($owner,Product $product ,Offer $offer)
    {
        return $product->id===$offer->product_id;
    }
}
