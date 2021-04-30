<?php

namespace App\Observers;


use App\Models\Buyer;
use App\Models\BuyerOrder;



class BuyerObserver
{

    /**
     * Handle the Buyer "created" event.
     *
     * @param \App\Models\Buyer $buyer
     * @return void
     */
    public function created(Buyer $buyer)
    {
        $data=\request()->only(['first_name','last_name']);
        $buyer->profile()->create($data);
    }

    /**
     * Handle the Buyer "updated" event.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return void
     */
    public function updated(Buyer $buyer)
    {//TODO if set it to null
        BuyerOrder::where('buyer_id',$buyer->id)->update([//when update the profile of the user call update([])
            'phone'        =>$buyer->phone??$order->phone,
            'username'     =>$buyer->username??$order->username,
            'address'      =>$buyer->profile->address,
            'facebook'     =>$buyer->profile->facebook,
            'instagram'    =>$buyer->profile->instagram,
            'first_name'   =>$buyer->profile->first_name,
            'last_name'    =>$buyer->profile->last_name,
            'picture'      =>$buyer->profile->picture
        ]);
    }

    /**
     * Handle the Buyer "deleted" event.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return void
     */
    public function deleted(Buyer $buyer)
    {
        //
    }

    /**
     * Handle the Buyer "restored" event.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return void
     */
    public function restored(Buyer $buyer)
    {
        //
    }

    /**
     * Handle the Buyer "force deleted" event.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return void
     */
    public function forceDeleted(Buyer $buyer)
    {
        //
    }
}
