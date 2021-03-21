<?php

namespace App\Observers;

use App\Models\Owner;

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
        //
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