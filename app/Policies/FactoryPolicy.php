<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\Factory;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactoryPolicy
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
        return false ;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function view(Buyer $buyer, Factory $factory)
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
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function update(Buyer $buyer, Factory $factory)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function delete(Buyer $buyer, Factory $factory)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function restore(Buyer $buyer, Factory $factory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function forceDelete(Buyer $buyer, Factory $factory)
    {
        //
    }
}