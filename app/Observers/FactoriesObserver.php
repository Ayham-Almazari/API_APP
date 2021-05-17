<?php

namespace App\Observers;

use App\Models\Factory;
use App\Models\FactoryOrder;
use App\Models\OrderDetails;

class FactoriesObserver
{
    /**
     * Handle the Factory "created" event.
     *
     * @param  \App\Models\Factory  $factory
     * @return void
     */
    public function created(Factory $factory)
    {
        $factory->F_permissions()->create(['factory_id'=>$factory->id]);
    }

    /**
     * Handle the Factory "updated" event.
     *
     * @param  \App\Models\Factory  $factory
     * @return void
     */
    public function updated(Factory $factory)
    {
        FactoryOrder::where('factory_id',$factory->id)->update([
            'factory_name'     =>$factory->factory_name,
            'phone'            =>$factory->phone,
            'address'          =>$factory->address,
            'facebook'         =>$factory->facebook,
            'instagram'        =>$factory->instagram,
            'email'            =>$factory->email,
        ]);
    }

    /**
     * Handle the Factory "deleted" event.
     *
     * @param  \App\Models\Factory  $factory
     * @return void
     */
    public function deleted(Factory $factory)
    {
        //
    }

    /**
     * Handle the Factory "restored" event.
     *
     * @param  \App\Models\Factory  $factory
     * @return void
     */
    public function restored(Factory $factory)
    {
        //
    }

    /**
     * Handle the Factory "force deleted" event.
     *
     * @param  \App\Models\Factory  $factory
     * @return void
     */
    public function forceDeleted(Factory $factory)
    {
        //
    }
}
