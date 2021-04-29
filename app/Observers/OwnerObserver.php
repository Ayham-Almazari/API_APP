<?php

namespace App\Observers;

use App\Models\Owner;
use App\Models\OwnerOrder;

class OwnerObserver
{
    /**
     * Handle the Owner "created" event.
     *
     * @param  \App\Models\Owner  $owner
     * @return void
     */
    public function created(Owner $owner)
    {
        $data=\request()->only(['first_name','last_name']);
        $owner->profile()->create($data);
    }

    /**
     * Handle the Owner "updated" event.
     *
     * @param  \App\Models\Owner  $owner
     * @return void
     */
    public function updated(Owner $owner)
    {
        OwnerOrder::where('owner_id',$owner->id)->update([//when update the profile of the user call update([])
            'phone'        =>$owner->phone,
            'username'     =>$owner->username,
        ]);
    }

    /**
     * Handle the Owner "deleted" event.
     *
     * @param  \App\Models\Owner  $owner
     * @return void
     */
    public function deleted(Owner $owner)
    {
        //
    }

    /**
     * Handle the Owner "restored" event.
     *
     * @param  \App\Models\Owner  $owner
     * @return void
     */
    public function restored(Owner $owner)
    {
        //
    }

    /**
     * Handle the Owner "force deleted" event.
     *
     * @param  \App\Models\Owner  $owner
     * @return void
     */
    public function forceDeleted(Owner $owner)
    {
        //
    }
}
