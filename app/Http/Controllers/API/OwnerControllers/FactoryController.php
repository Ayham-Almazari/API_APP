<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Requests\Owner_Factories_CMS\CreateFactoryRequest;
use App\Http\Resources\Factoryresource;
use App\Jobs\UpdateFactoryOrdersJob;
use App\Models\Factory;
use App\Models\FactoryOrder;
use App\Models\OrderDetails;
use App\Notifications\DeleteFactory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Exception\NotSupportedException;
use Intervention\Image\Exception\NotWritableException;
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
        $owner_factories = auth()->user()->factories()->get(['id', 'factory_name', 'address', 'logo']);
        return (Factoryresource::collection($owner_factories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFactoryRequest $request)
    {
        try {
            Upload_property_file:{
                $img = $this->upload_base64_image('factories/property-files', base64: $request->property_file);
            }
            Create_factory_and_trash_it_for_confirmed:{
                $created_factory = auth()->user()->factories()->create(array_merge($request->validated(), ['property_file' => $img->uploaded_image]));
                $created_factory->update(['deleted_at' => '1998-12-30 23:00:00']);
            }
        } catch (NotReadableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotReadable}"]]);
        } catch (NotWritableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotWritable}"]]);
        } catch (NotSupportedException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotSupported}"]]);
        }
        return $this->returnSuccessMessage('please wait to confirm your new factory ' . $created_factory->factory_name, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Factory $factory
     * @return JsonResponse
     */
    public function show(Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        return (new Factoryresource($factory->load('categories.products')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Factory $factory
     * @return Factoryresource
     */
    public function update(CreateFactoryRequest $request, Factory $factory)
    {
        try {
            $this->authorize('authorize-owner-factory', $factory);
            $data = $request->validated();
            updated_images:{
                $update_image = $this->update_image($factory->logo, 'factories/logos', $request->logo);
                $data['logo'] = $update_image ? $update_image->uploaded_image : null;
                $update_image = $this->update_image($factory->cover_photo, 'factories/cover_photos', $request->cover_photo);
                $data['cover_photo'] = $update_image ? $update_image->uploaded_image : null;
            }
            update_factory:
            $factory->update($data);
            update_factory_logo_orders:
            UpdateFactoryOrdersJob::dispatch($factory->id, $request->logo)->delay(Carbon::now()->addSeconds(15));
        } catch (NotReadableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotReadable}"]]);
        } catch (NotWritableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotWritable}"]]);
        } catch (NotSupportedException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotSupported}"]]);
        }
        Response:
        return (new Factoryresource($factory))->additional([
            'status' => true,
            'msg' => "{$factory->factory_name} Updated Successfully ."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Factory $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory)
    {//TODO DELETE FACTORY LOGO AND COVER PHOTO IN ADMIN
        $this->authorize('authorize-owner-factory', $factory);
        $messageInfo = [
            "owner" => $factory->owner->profile->first_name . ' ' . $factory->owner->profile->last_name,
            "factory_name" => $factory->factory_name
        ];
        $factory->owner->notify(new DeleteFactory($messageInfo));
        $factory->delete();
        return $this->returnSuccessMessage("{$messageInfo['owner']} your factory {$messageInfo['factory_name']} under deleting . It will be deleted after a week during this period. You can contact us if you have decided to return to deleting your factory .", Response::HTTP_OK);
    }
}
