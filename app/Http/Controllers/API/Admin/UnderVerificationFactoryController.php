<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FactoryCollection;
use App\Http\Resources\Factoryresource;
use App\Models\Factory;
use App\Notifications\FactoryCanceled;
use App\Notifications\FactoryConfirm;
use Illuminate\Http\Request;

class UnderVerificationFactoryController extends Controller
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
         $Trashedwithrelation= Factory::onlyTrashed()->with('owner.profile')->paginate(15);
            return new FactoryCollection($Trashedwithrelation);
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
    public function show($id)
    {
        $factory= Factory::onlyTrashed()->with('owner.profile')->find($id);
        if ($factory) {
            return new Factoryresource($factory);
        }else
            return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $factory=  Factory::onlyTrashed()->get()->find($id);
        if ($factory) {
            $factory->restore();
            $factory->owner->notify(new FactoryConfirm($factory));
            return $this->returnSuccessMessage($factory->owner->profile->first_name." ".$factory->owner->profile->last_name. ' confirmed successfully');
        }else
            return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factory=  Factory::onlyTrashed()->get()->find($id);
        if ($factory) {
            $message_info=[
                'factory_name'=>$factory->factory_name,
                'name'=>$factory->owner->profile->first_name . ' ' .$factory->owner->profile->last_name
            ];
            $factory->owner->notify(new FactoryCanceled($message_info));
            $factory->forceDelete();
            return $this->returnSuccessMessage("MR . ".$message_info['name']." factory '{$message_info['factory_name']}' canceled successfully");
        }else
            return abort(404);
    }
}
