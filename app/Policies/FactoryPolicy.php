<?php

namespace App\Policies;

use App\Models\Buyer;
use App\Models\Factory;
use App\Models\Owner;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactoryPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\buyer|owner|admin  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before( $user ){

    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function viewAny($owner,$factory)
    {
        return $owner->id==$factory->owner_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function view(Owner $owner, Factory $factory)
    {
        return $owner->id===$factory->owner_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function create($owner,$factory)
    {
        return $owner->id==$factory->owner_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function update($owner, Factory $factory)
    {
        return $owner->id==$factory->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Buyer  $buyer
     * @param  \App\Models\Factory  $factory
     * @return mixed
     */
    public function delete($owner, Factory $factory)
    {
        return $owner->id==$factory->owner_id;
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

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return mixed
     */
    public function OwnerOwnFactory($owner,$factory)
    {
        return $owner->id==$factory->owner_id;
    }
}
