<?php

namespace App\Observers;

use App\Http\Controllers\API\auth\BuyerAuth;
use App\Http\Requests\auth\Login_buyer;
use App\Http\Requests\auth\Register_request;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Psy\Exception\TypeErrorException;
use Symfony\Component\HttpFoundation\Response;


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
    {
        //
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