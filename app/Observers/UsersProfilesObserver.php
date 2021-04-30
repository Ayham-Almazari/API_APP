<?php

namespace App\Observers;

use App\Models\BuyerOrder;
use App\Models\OwnerOrder;
use App\Models\UsersProfiles;

class UsersProfilesObserver
{
    /**
     * Handle the UsersProfiles "created" event.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return void
     */
    public function created(UsersProfiles $usersProfiles)
    {
        //
    }

    /**
     * Handle the UsersProfiles "updated" event.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return void
     */
    public function updated(UsersProfiles $usersProfiles)
    {
        if($usersProfiles->buyer){
            BuyerOrder::where('buyer_id',$usersProfiles->buyer->id)->update([
                'address'      =>$usersProfiles->address,
                'facebook'     =>$usersProfiles->facebook,
                'instagram'    =>$usersProfiles->instagram,
                'first_name'   =>$usersProfiles->first_name,
                'last_name'    =>$usersProfiles->last_name,
                'picture'    =>$usersProfiles->picture
            ]);
        }elseif ($usersProfiles->owner){
            OwnerOrder::where('owner_id',$usersProfiles->owner->id)->update([
                'address'      =>$usersProfiles->address,
                'facebook'     =>$usersProfiles->facebook,
                'instagram'    =>$usersProfiles->instagram,
                'first_name'   =>$usersProfiles->first_name,
                'last_name'    =>$usersProfiles->last_name,
                'picture'    =>$usersProfiles->picture
            ]);
        }

    }

    /**
     * Handle the UsersProfiles "deleted" event.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return void
     */
    public function deleted(UsersProfiles $usersProfiles)
    {
        //
    }

    /**
     * Handle the UsersProfiles "restored" event.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return void
     */
    public function restored(UsersProfiles $usersProfiles)
    {
        //
    }

    /**
     * Handle the UsersProfiles "force deleted" event.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return void
     */
    public function forceDeleted(UsersProfiles $usersProfiles)
    {
        //
    }
}
