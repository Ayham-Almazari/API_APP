<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Global\ViewFactoriesResources;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('factories',[ViewFactoriesResources::class,'allfactories']);
Route::get('factories/{factory}',[ViewFactoriesResources::class,'showfactory']);
Route::get('factories/{factory}/categories',[ViewFactoriesResources::class,'allcategries']);
Route::get('factories/{factory}/products',[ViewFactoriesResources::class,'allproducts']);
Route::get('factory/{factory}/category/{category}/products',[ViewFactoriesResources::class,'ShowCategoryProducts']);


