<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Factoryresource;
use App\Models\Category;
use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FactoryCategories extends Controller
{
    private $owner;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware(['auth:owner']);
        Auth::shouldUse('owner');
        $this->owner = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($factory)
    {
        $factory_categories = $this->factory($factory);
        if (!$factory_categories)
            return $this->returnErrorMessage('factory not found or inaccessible', 404);
        return new Factoryresource($factory_categories->load('categories'));
    }

    private function factory($id)
    {
        $factory = $this->owner->factories()->where('id', $id)->first(['id', 'factory_name']);
        return $factory;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Factory $factory
     * @return Response
     */
    public function store(Request $request, $factory)
    {
        if_owner_of_this_factory:{
        $factory = $this->factory($factory);
        if (!$factory)
            return $this->returnErrorMessage('factory not found or inaccessible', 404);
    }
        Validation_Request:{
        $v = Validator::make($request->only(['category_name', 'category_description']), [
            'category_name' => 'string|max:255|required',
            'category_description' => 'string|max:255|required'
        ]);
        if ($v->fails()) {
            return $this->returnError($v->errors());
        }
    }
        if_category_exists_returnError_or_create:{
        if (array_search($request->category_name, $factory->categories()->pluck('category_name')->toArray()) !== false) :
            return $this->returnError([
                'category_name' => ['category_name has already been taken .']
            ]);
        else :
            $category = $factory->categories()->create($v->validated());
            return $this->returnSuccessMessage("Category '{$category->category_name}' for $factory->factory_name factory created successfully .", \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
        endif;
    }

    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Category
     */
    public function show($factory, $category)
    {
        $factory = $this->factory($factory);
        if (!$factory)
            return $this->returnErrorMessage('factory not found or inaccessible', 404);
        $category = $factory->categories->only($category)->toArray();
        if (empty($category))
            return $this->returnErrorMessage('category not found', 404);

        return new Factoryresource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function update( $factory, $category , Request $request)
    {
        if_unauthorized:{
        $factory = $this->factory($factory);
        if (!$factory)
            return $this->returnErrorMessage('factory not found or inaccessible', 404);
        $category = $factory->categories()->where('id', $category)->first();
        if (empty($category))
            return $this->returnErrorMessage('category not found', 404);
    }

        Validation_Request:{
        $v = Validator::make($request->only(['category_name', 'category_description']), [
            'category_name' => 'string|min:3|max:255|required|alpha_dash',
            'category_description' => 'string|max:1000'
        ]);
        if ($v->fails()) {
            return $this->returnError($v->errors());
        }
    }
        duplicate_entry_category_exists:{
        if (array_search($request->category_name, $factory->categories()->pluck('category_name')->toArray()) !== false) :
            return $this->returnError([
                'category_name' => ['category_name has already been taken .']
            ]);
        else :
            update_category:{
            $category->update(
                $v->validated()
            );
        }
        endif;
    }
        return $this->returnData( $category , 'data', 'Category updated successfully .' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public
    function destroy($factory, $category)
    {
        if_unauthorized:{
        $factory = $this->factory($factory);
        if (!$factory)
            return $this->returnErrorMessage('Factory not found or inaccessible', 404);
        $category = $factory->categories()->where('id', $category)->first();
        if (empty($category))
            return $this->returnErrorMessage('Category not found', 404);
    }
        $category->delete();
        return $this->returnSuccessMessage('Category deleted successfully .');
    }
}
