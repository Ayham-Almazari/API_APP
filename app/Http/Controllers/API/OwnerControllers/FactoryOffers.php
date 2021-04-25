<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner_Factories_CMS\CreateOfferRequest;
use App\Http\Resources\Factoryresource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Models\Factory;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\FactoryCollection;
class FactoryOffers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Factory $factory)
    {
        $this->authorize('authorize-owner-factory',  $factory);
//        $products = Product::whereIn('category_id', $categories_ids)->has('offer')->orderBy('id')->with('offer')->paginate(6)

        query:{
//            $products = Product::select('id','product_name','product_picture','availability')->whereIn('category_id', $categories_ids)->with('under_category:id,factory_id,category_name')->orderBy('id')->paginate(6);
        $products =DB::table('products as p') ->select(
            'p.id','p.category_id','c.factory_id','o.id as offer_id',
            'p.product_name','p.product_picture','p.product_picture','p.availability','c.category_name','o.')
            ->join('categories as c', function ($join) use ($factory) {
                $join->on('p.category_id', '=', 'c.id')
                    ->where('c.factory_id','=',$factory->id );
            })->Join('offers as o', function ($join) use ($factory) {
                $join->on('p.id', '=', 'o.product_id');
            })->orderBy('p.id')
            ->paginate(10);
         }
//        return  OfferResource::collection($products);
        return response()->json($products);
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
