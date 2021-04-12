<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Resources\FactoryCollection;
use App\Http\Resources\Factoryresource;
use App\Models\Factory;
use App\Models\Owner;
use App\Notifications\DeleteFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth:owner','jwt.verify:owner']);
        Auth::shouldUse('owner');
    }

    public function index()
    {
        $owner_factories= auth()->user()->factories()->get(['id','factory_name','address','logo']);
        return (Factoryresource::collection($owner_factories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Data_FOR_VALIDATE_STORE:{
        $data=$request->only('factory_name','property_file');
        }
        Validate_request:{
        $v =  Validator::make($data,[
            "factory_name"=>'required|min:3|string',
            'property_file'=> 'required|file|max:5120|mimes:jpg,bmp,png,jpeg,pdf,pptx,doc,docx,rar,zip'
        ]);
        if ($v->fails()) {
            return $this->returnError($v->errors());
        }
        }
        Uoload_property_file:{
        if ($request->hasFile('property_file'))
            if ($request->file('property_file')->isValid())
                $data['property_file'] = $request->file('property_file')->store('property_files/factories');
            else
                $this->returnError(['property_file'=>'Invalid file'],'The file uploaded invalid',Response::HTTP_BAD_REQUEST);
        }
        Create_factory_and_trash_it_for_confirmed:{
        $created_factory =  auth() -> user() -> factories() -> create($data);
        $created_factory -> delete();
        }
        return $this->returnSuccessMessage('please wait to confirm your new factory '. $created_factory->factory_name ,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Factory $factory)
    {
      $factory=  auth()->user()->factories()->where('id',$factory->id)->first(['id','factory_name','address','logo']) ;
       if (!$factory) {
           return $this->returnErrorMessage('The factory not found oe inaccessible');
       }
        return (new Factoryresource($factory->load('categories.products')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factory $factory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory)
    {
        $messageInfo=[
            "owner"=>$factory->owner->profile->first_name.' '.$factory->owner->profile->last_name,
            "factory_name"=>$factory->factory_name,
        ];
        $factory->owner->notify(new DeleteFactory($messageInfo));
        $factory->delete();
       return $this->returnSuccessMessage("{$messageInfo['owner']} your factory {$messageInfo['factory_name']} under deleting . It will be deleted after a week during this period. You can contact us if you have decided to return to deleting your factory .",Response::HTTP_OK);
    }
}
