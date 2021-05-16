<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use App\Models\Product;

class ManageFactories extends Controller
{
    public function index()
    {
/*        try {*/
            return view('pages.Manage_Factories.index')->withFactories(Factory::all());
       /* }catch (\ErrorException $e){
            return $e->getMessage();
        }*/
    }
    public function products(Factory $factory){
        $products = Product::whereIn('category_id', $factory->categories->pluck('id'))->with('under_category')->get();
        $response="";
        foreach ($products as $product):
           $availability= $product->availability?"<span style='color: darkgreen'>Available</span>":"<span style='color: darkred'>Unavailable</span>";
           $category=$product->under_category->category_name;
           $price=$product->price;
            $response.=<<<HTML
  <div class="col">
    <div class="card">
      <img src="$product->product_picture" class="card-img-top" alt="...">
      <div class="card-body">
        <h4 class="card-title">$product->product_name</h4>
        <h5 class="card-title"> $availability </h5>
        <h5 class="card-title"> Price : $price </h5>
        <h5 class="card-title">  Category : $category </h5>
        <p class="card-text">
        <!-- Vertically centered modal -->
        <div class="modal fade" id="productsdescription$product->id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Product Descriptione</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             <div class="modal-body">
              $product->product_description
             </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
        </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productsdescription$product->id">Description
        </button>
        </p>
      </div>
    </div>
  </div>
HTML;
        endforeach;
        return response($response);
    }
}
