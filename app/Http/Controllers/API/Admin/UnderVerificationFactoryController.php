<?php

namespace App\Http\Controllers\API\Admin;

use App\Exceptions\FactoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\FactoryCollection;
use App\Http\Resources\Factoryresource;
use App\Models\Factory;
use App\Notifications\ForceDeleteFactory;
use App\Notifications\FactoryCanceled;
use App\Notifications\FactoryConfirm;
use App\Notifications\RestoreFactory;
use Illuminate\Http\Request;

class UnderVerificationFactoryController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($deleteAction=false)
    {
        //factories created and waiting to verify or canceled
         $Trashedwithrelation= Factory::onlyTrashed()->where('deleted_at',$deleteAction?'<>':'=','1998-12-30 23:00:00')->with('owner.profile')->paginate(15);
            return new FactoryCollection($Trashedwithrelation->makeVisible('property_file'));
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
     * @param int $id
     * @return Factoryresource
     * @throws FactoryNotFoundException
     */
    /*public function show($id)
    {
        $factory= Factory::onlyTrashed()->where('deleted_at','1998-12-30 23:00:00')->with('owner.profile')->find($id);
        if ($factory) {
            return new Factoryresource($factory);
        } else
            throw new FactoryNotFoundException('Factory Not Found .');
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$restoreAction=false)
    {
        $factory=  Factory::onlyTrashed()->where('deleted_at',$restoreAction?'<>':'=','1998-12-30 23:00:00')->get()->find($id);
        if ($factory) {
            $factory->restore();
            if ($restoreAction):
                $factory->owner->notify(new RestoreFactory($factory));
                return $this->returnSuccessMessage($factory->owner->profile->first_name." ".$factory->owner->profile->last_name. ' restored successfully');
            else:
                $factory->owner->notify(new FactoryConfirm($factory));
                return $this->returnSuccessMessage($factory->owner->profile->first_name." ".$factory->owner->profile->last_name. ' confirmed successfully');
            endif;
        }else
            throw new FactoryNotFoundException('Factory Not Found .');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$deleteAction=false)
    {
        $factory=  Factory::onlyTrashed()->where('deleted_at',$deleteAction?'<>':'=','1998-12-30 23:00:00')->get()->find($id);
        if ($factory) {
            $message_info=[
                'factory_name'=>$factory->factory_name,
                'name'=>$factory->owner->profile->first_name . ' ' .$factory->owner->profile->last_name
            ];
            if ($deleteAction)
                $factory->owner->notify(new ForceDeleteFactory($message_info));
            else
            $factory->owner->notify(new FactoryCanceled($message_info));
            $factory->forceDelete();
            return $this->returnSuccessMessage("MR . ".$message_info['name']." factory '{$message_info['factory_name']}' canceled successfully");
        }else
            throw new FactoryNotFoundException('Factory Not Found .');

    }


}
