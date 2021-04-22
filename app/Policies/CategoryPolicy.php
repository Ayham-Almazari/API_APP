<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\Category;
use App\Models\Factory;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function view(Buyer $buyer, Category $category)
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
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function update(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function delete(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function restore(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function forceDelete(Buyer $buyer, Category $category)
    {
        //
    }

    /**
     * Determine whether the owner can work the model.
     *
     * @param  \App\Models\Buyer
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function AuthorizeCategoryForOwner($owner,Factory $factory, Category $category)
    {
        return $factory->id===$category->factory_id;
    }
}
