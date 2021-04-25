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
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        return  Factoryresource::collection(
        $factory->categories->each(function ($category) use ($factory) {
            $category->makeHidden(['category_description']);
        }));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Factory $factory
     * @return Response
     */
    public function store(CreateCategoryRequest $request,Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $category = $factory->categories()->create($request->validated());
        return $this->returnSuccessMessage("Category '{$category->category_name}' for '{$request->factory->factory_name}' factory created successfully .", \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Factoryresource
     * @throws CategoryNotFoundException
     */
    public function show(Factory $factory,Category $category)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $this->authorize('authorize-owner-category', [$factory,$category]);
        return new Factoryresource( $category->makeVisible(['created_at','updated_at']));
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Factoryresource
     * @throws CategoryNotFoundException
     */
    public function ShowCategoryProducts(Factory $factory,Category $category)
    {
        // TODO filter products by category
        // TODO filter products by availability
        $this->authorize('authorize-owner-factory', $factory);
        $this->authorize('authorize-owner-category', [$factory,$category]);
        query:{
//            $products = Product::select('id','product_name','product_picture','availability')->whereIn('category_id', $categories_ids)->with('under_category:id,factory_id,category_name')->orderBy('id')->paginate(6);
        $products =DB::table('products as p') ->select(
            'p.id','p.category_id','c.factory_id',
            'p.product_name','p.product_picture','p.product_picture','p.availability','c.category_name')
            ->join('categories as c', function ($join) use ($factory,$category) {
                $join->on('p.category_id', '=', 'c.id')
                    ->where('p.category_id','=',$category->id)
                    ->where('c.factory_id','=',$factory->id );
            })->orderBy('p.id')
            ->paginate(10);
    }
        return  response()->json( $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public
    function update(Factory $factory,Category $category, CreateCategoryRequest $request)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $this->authorize('authorize-owner-category', [$factory,$category]);
        update_category:{
        $category->update(
            $request->validated()
        );
    }
        return (new Factoryresource($category))->additional(['msg'=>'Category updated successfully .','status'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public
    function destroy(Factory $factory,Category $category)
    {
        $this->authorize('authorize-owner-factory', $factory);
        $this->authorize('authorize-owner-category', [$factory,$category]);
        $category->delete();
        return $this->returnSuccessMessage('Category deleted successfully .');
    }
}
