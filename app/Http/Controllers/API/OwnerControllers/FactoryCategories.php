<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Exceptions\CategoryNotFoundException;
use App\Exceptions\FactoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner_Factories_CMS\CreateCategoryRequest;
use App\Http\Requests\Owner_Factories_CMS\UpdateCategoryRequest;
use App\Http\Resources\Factoryresource;
use App\Models\Category;
use App\Models\Factory;
use App\Rules\UniqueCategoryName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function auth;

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
        auth()->shouldUse('owner');
        $this->owner = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($factory)
    {
        return  Factoryresource::collection($this->factory($factory)->categories);
    }

    /**
     * @throws FactoryNotFoundException
     */
    private function factory($id)
    {
        $factory = $this->owner->factories()->where('id', $id)->first(['id', 'factory_name']);
        if (!$factory) {
            throw new FactoryNotFoundException('factory not found or inaccessible');
        }
        return $factory;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Factory $factory
     * @return Response
     */
    public function store(CreateCategoryRequest $request, $factory)
    {
        $category = $request->factory->categories()->create($request->validated());
        return $this->returnSuccessMessage("Category '{$category->category_name}' for '{$request->factory->factory_name}' factory created successfully .", \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Factoryresource
     * @throws CategoryNotFoundException
     */
    public function show($factory, $category)
    {
        return new Factoryresource($this->category($this->factory($factory), $category));
    }

    /**
     * @throws FactoryNotFoundException
     */
    private function category($factory, $category)
    {
        $category = $factory->categories()->find($category);
        if (empty($category))
            throw new CategoryNotFoundException('category not found');
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public
    function update($factory, $category, UpdateCategoryRequest $request)
    {
        update_category:{
        $request->category->update(
            $request->validated()
        );
    }
        return (new Factoryresource($request->category))->additional(['msg'=>'Category updated successfully .','status'=>true]);
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
        $category = $this->category($factory, $category);
    }
        $category->delete();
        return $this->returnSuccessMessage('Category deleted successfully .');
    }
}
