<?php

namespace App\Http\Controllers\API\Global;

use App\Http\Resources\Factoryresource;
use App\Models\Factory;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function allproductswithoutoffers(Factory $factory)
    {
        return Factoryresource::collection(
            Product::whereIn('category_id', $factory->categories->pluck('id'))->doesntHave('offer')->orderBy('id')->paginate(6)->
        each(function ($model) use ($factory){
                $model->makeHidden(['created_at', 'updated_at']);
            $model->factory_id=$factory->id;
        }));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function allproductswithoffers(Factory $factory)
    {
        return Factoryresource::collection(
            Product::makeHidden(['created_at', 'updated_at'])->whereIn('category_id', $factory->categories->pluck('id'))->has('offer')->orderBy('id')->paginate(6)->
            each(function ($model) use ($factory){
                $model->factory_id=$factory->id;
            }));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function edit(Factory $factory)
    {
        //
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
        //
    }
}
