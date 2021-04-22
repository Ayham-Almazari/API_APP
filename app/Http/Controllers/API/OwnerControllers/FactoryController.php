<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Requests\Owner_Factories_CMS\CreateFactoryRequest;
use App\Http\Resources\Factoryresource;
use App\Models\Factory;
use App\Notifications\DeleteFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    }


    public function index()
    {
        $owner_factories = auth()->user()->factories()->get(['id','factory_name','address','logo']);
        return (Factoryresource::collection($owner_factories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFactoryRequest $request)
    {
        Upload_property_file:{
            $img = $this->upload_base64_image('factories/property-files',base64: $request->property_file);
        }
        Create_factory_and_trash_it_for_confirmed:{
        $created_factory =  auth() -> user() -> factories() -> create(array_merge($request->validated(),['property_file'=>$img->uploaded_image]));
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
        $this->authorize('authorize-owner-factory', $factory);
        return (new Factoryresource($factory->load('categories.products')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function update(CreateFactoryRequest $request, Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $data=$request->validated();
        updated_images:{
        $update_image=$this->update_image($factory->logo,'factories/logos',$request->logo);
        $data['logo']= $update_image ? $update_image->uploaded_image :null;
        $update_image=$this->update_image($factory->cover_photo,'factories/cover_photos',$request->cover_photo);
        $data['cover_photo']= $update_image ? $update_image->uploaded_image :null;
         }
        $factory->update($data);
        return (new Factoryresource($factory))->additional([
            'status'=>true,
            'msg'=>"{$factory->factory_name} Updated Successfully ."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $messageInfo=[
            "owner"=>$factory->owner->profile->first_name.' '.$factory->owner->profile->last_name,
            "factory_name"=>$factory->factory_name
        ];
        $factory->owner->notify(new DeleteFactory($messageInfo));
        $factory->delete();
       return $this->returnSuccessMessage("{$messageInfo['owner']} your factory {$messageInfo['factory_name']} under deleting . It will be deleted after a week during this period. You can contact us if you have decided to return to deleting your factory .",Response::HTTP_OK);
    }
}
