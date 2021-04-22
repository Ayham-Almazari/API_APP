<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner_Factories_CMS\CreateOfferRequest;
use App\Http\Resources\Factoryresource;
use App\Http\Resources\ProductResource;
use App\Models\Factory;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class FactoryOffers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Factory $factory)
    {
        $this->authorize('authorize-owner-factory',  $factory);
        declare__:{
        //categories
        $categories=$factory->categories()->get();
        $categories_count=$categories->count();
        $categories_ids=$categories->pluck('id');
        //products
        $products = Product::whereIn('category_id', $categories_ids)->has('offer')->orderBy('id')->with('offer')->paginate(6)
            ->
            each(function ($model) use ($factory){
                $model->factory_id=$factory->id;
            });
        $products_count=$products->count();
        $products_ids=$products->pluck('id');
    }
        return ProductResource::collection($products)->additional([
            'categories_count'=> $categories_count==0?'No Categories Yet .':$categories_count,
            'categories_ids'=>$categories_ids,
            'products_count'=> $products_count==0?'No Products Yet .':$products_count,
            'products_ids'=>$products_ids
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOfferRequest $request , Factory $factory , Product $product)
    {
        //discount = 100 * (original_price - discounted_price) / original_price
        $this->authorize('authorize-owner-factory',  $factory);
        $this->authorize('authorize-owner-product',[$factory,$product]);
        if ($product->offer) {
            return $this->returnErrorMessage('The product already has an offer .');
        }
        create_offer:{
        $offer=$product->offer()->create($request->validated());
          }
        return (new Factoryresource($offer))->additional([
            'status'=>true,
            'msg'=>"{$offer->title} Offer Created Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Factory $factory,Product $product,Offer $offer)
    {
        $this->authorize('authorize-owner-factory',  $factory);
        $this->authorize('authorize-owner-product',[$factory,$product]);
        $this->authorize('authorize-owner-offer',[$product,$offer]);
        return new Factoryresource($offer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOfferRequest $request,Factory $factory,Product $product,Offer $offer)
    {
        $this->authorize('authorize-owner-factory',  $factory);
        $this->authorize('authorize-owner-product',[$factory,$product]);
        $this->authorize('authorize-owner-offer',[$product,$offer]);
        $offer->update($request->validated());
        return (new Factoryresource($offer))->additional([
        'status'=>true,
        'msg'=>"{$offer->title} Offer Updated Successfully"
    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory,Product $product,Offer $offer)
    {
        $this->authorize('authorize-owner-factory',  $factory);
        $this->authorize('authorize-owner-product',[$factory,$product]);
        $this->authorize('authorize-owner-offer',[$product,$offer]);
        $offer->delete();
        return $this->returnSuccessMessage("{$offer->title} Offer deleted Successfully");
    }
}
