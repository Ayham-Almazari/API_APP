<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Notifications\OwnerCanceled;
use App\Notifications\OwnerConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OwnerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:admin','jwt.verify:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Trashedwithrelation= Owner::with('profile')->onlyTrashed()->get();
       return $this->returnData($Trashedwithrelation,'data','All Trashed owners');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($owner)
    {
        return $this->returnData($owner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($owner){
        $owner->restore();
        $owner->account_verification='confirmed';
        $owner->save();
        $owner->notify(new OwnerConfirmed($owner));
        return $this->returnSuccessMessage($owner->profile->first_name." ".$owner->profile->last_name. ' confirmed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($owner)
    {
        $owner->notify(new OwnerCanceled($owner));
         $owner->forceDelete();
        return $this->returnSuccessMessage($owner->profile->first_name." ".$owner->profile->last_name. ' Removed successfully');
    }
}
