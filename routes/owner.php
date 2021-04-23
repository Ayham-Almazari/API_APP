<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\OwnerAuth;
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

Route::middleware(['auth:owner'])->prefix('owner_cms')->group(function () {
    Route::apiResources([
        'factories'           =>FactoryController::class,
        'factories.categories'=>FactoryCategories::class,
        'factories.products'  =>FactoryProducts::class,
    ]);
    Route::get('factories/{factory}/offers',[\App\Http\Controllers\API\OwnerControllers\FactoryOffers::class,'index'])->name('factories.products.Offers.index');
    Route::apiResource('factories.products.offers'  ,FactoryOffers::class)->except(['index']);
});

