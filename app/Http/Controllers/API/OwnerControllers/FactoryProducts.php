<?php

namespace App\Http\Controllers\API\OwnerControllers;

use App\Exceptions\CategoryNotFoundException;
use App\Exceptions\FactoryNoCategoriesYet;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner_Factories_CMS\CreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\UpdateProductsOrdersJob;
use App\Models\Factory;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Exception\NotSupportedException;
use Intervention\Image\Exception\NotWritableException;

class FactoryProducts extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Factory $factory)
    {
        $this->authorize('authorize-owner-factory', $factory);
        query:{
//            $products = Product::select('id','product_name','product_picture','availability')->whereIn('category_id', $categories_ids)->with('under_category:id,factory_id,category_name')->orderBy('id')->paginate(6);
        $products = DB::table('products as p')->select(
            'p.id', 'p.category_id', 'c.factory_id',
            'p.product_name', 'p.product_picture', 'p.product_picture', 'p.availability', 'c.category_name', 'p.price')
            ->join('categories as c', function ($join) use ($factory) {
                $join->on('p.category_id', '=', 'c.id')
                    ->where('c.factory_id', '=', $factory->id);
            })->orderBy('p.id')
            ->paginate(10);
    }
        return response()->json($products);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws CategoryNotFoundException
     */
    public function store(CreateProductRequest $request, Factory $factory)
    {
        try {
            authorize_and_ifcategory_not_found:{
                $this->authorize('authorize-owner-factory', $factory);
                $factory->categories()->count() === 0 ? throw new FactoryNoCategoriesYet($factory->factory_name . ' does not has any category yet') : null;
                $category = $factory->categories->find($request->category_id) ??
                    throw new CategoryNotFoundException ('Not found Or Unauthorized Category .');
            }
            upload_image:{
                $img = $this->upload_base64_image('factories/product-images', base64: $request->product_picture);
            }
            create_product:{
                $data = $request->validated();
                $data['product_picture'] = $img->uploaded_image;
                $product = $category->products()->create($data);
            }
        } catch (NotReadableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotReadable}"]]);
        } catch (NotWritableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotWritable}"]]);
        } catch (NotSupportedException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotSupported}"]]);
        }
        response:{
        return (new ProductResource($product))->additional(['status' => true, 'msg' => "{$factory->factory_name} / {$category->category_name} / {$product->product_name} created successfully ."]);
    }
    }

    /**
     * Display the specified resource.
     *only if the product belong to the factory
     * @param Product $product
     * @return Response
     */
    public function show(Factory $factory, Product $product)
    {
        $this->authorize('authorize-owner-product', [$factory, $product]);
        return new ProductResource($product->makeHidden(['category_id'])->makeVisible(['created_at', 'updated_at']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function update(CreateProductRequest $request, Factory $factory, Product $product)
    {
        try {
            authorize_and_if_category_not_found:
            $this->authorize('authorize-owner-product', [$factory, $product]);
            $factory->categories()->count() === 0 ? throw new FactoryNoCategoriesYet($factory->factory_name . ' does not has any category yet') : null;
            $category = $factory->categories->find($request->category_id) ??
                throw new CategoryNotFoundException ('Not found Or Unauthorized Category .');
            $data = $request->validated();

            update_upload_image:
            $update_image = $this->update_image($product->product_picture, 'factories/product-images', $request->product_picture);
            $data['product_picture'] = $update_image ? $update_image->uploaded_image : null;

            update_product:
            $product->update($data);
            update_upload_image_for_orders:
            UpdateProductsOrdersJob::dispatch($product, $data, $request->product_picture)->delay(Carbon::now()->addSeconds(15));

        } catch (NotReadableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotReadable}"]]);
        } catch (NotWritableException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotWritable}"]]);
        } catch (NotSupportedException $e) {
            return $this->returnError(['product_picture' => [$e->getMessage() . " {NotSupported}"]]);
        }
        response:
        return (new ProductResource($product))->additional(['status' => true, 'msg' => "{$factory->factory_name} / {$product->under_category->category_name} / {$product->product_name} updated successfully ."]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Response
     */
    public function destroy(Factory $factory, Product $product)
    {
        $this->authorize('authorize-owner-product', [$factory, $product]);
        $this->delete_image($product->product_picture);
        $product->delete();
        return $this->returnSuccessMessage($product->product_name . " deleted successfully .");
    }

}
