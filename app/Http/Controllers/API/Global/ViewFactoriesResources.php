<?php

namespace App\Http\Controllers\API\Global;

use App\Exceptions\CategoryNotFoundException;
use App\Http\Resources\Factoryresource;
use App\Models\Category;
use App\Models\Factory;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ViewFactoriesResources extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allfactories()
    {
        return Factoryresource::collection(Factory::select(['id','owner_id','factory_name','logo','address'])->paginate(20));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allcategries(Factory $factory)
    {
        return Factoryresource::collection($factory->categories->makeHidden(['created_at', 'updated_at']));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allproducts(Factory $factory)
    {
        query:{
//            $products = Product::select('id','product_name','product_picture','availability')->whereIn('category_id', $categories_ids)->with('under_category:id,factory_id,category_name')->orderBy('id')->paginate(6);
        $products =DB::table('products as p') ->select(
            'p.id','p.category_id','c.factory_id',
            'p.product_name', DB::raw('CONCAT(\''.asset('storage').'/'.'\',p.product_picture) AS product_picture'),'p.product_description','p.price','c.category_name')
            ->join('categories as c', function ($join) use ($factory) {
                $join->on('p.category_id', '=', 'c.id')
                    ->where('c.factory_id','=',$factory->id )
                    ->where('p.availability','=',1);
            })->orderBy('p.id')
            ->paginate(10);
    }
        return $this->returnData($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function showfactory(Factory $factory)
    {
        return new Factoryresource($factory);
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
        query:{
//            $products = Product::select('id','product_name','product_picture','availability')->whereIn('category_id', $categories_ids)->with('under_category:id,factory_id,category_name')->orderBy('id')->paginate(6);
        $products =DB::table('products as p') ->select(
            'p.id','p.category_id','c.factory_id',
            'p.product_name','p.product_picture','p.product_picture','p.product_description','p.price','c.category_name')
            ->join('categories as c', function ($join) use ($factory,$category) {
                $join->on('p.category_id', '=', 'c.id')
                    ->where('p.category_id','=',$category->id)
                    ->where('c.factory_id','=',$factory->id )
                    ->where('p.availability','=',1);
                ;
            })->orderBy('p.id')
            ->paginate(10);
    }
        return  response()->json( $products);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    /*public function allproductswithoutoffers(Factory $factory)
    {
        return Factoryresource::collection(
            Product::whereIn('category_id', $factory->categories->pluck('id'))->doesntHave('offer')->orderBy('id')->paginate(6)->
        each(function ($model) use ($factory){
                $model->makeHidden(['created_at', 'updated_at']);
            $model->factory_id=$factory->id;
        }));
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    /* public function allproductswithoffers(Factory $factory)
     {
         $products= Product::whereIn('category_id', $factory->categories->pluck('id'))
             ->has('offer')
             ->orderBy('id')
             ->paginate(10);
         foreach ($products as $product){
             $product->factory_id=$factory->id;
         }
         return Factoryresource::collection($products);
     }*/
}
