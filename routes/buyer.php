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

Route::middleware(['auth:buyer'])->prefix('buyer')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function (){
        Route::get('',[\App\Http\Controllers\API\buyer\CartController::class,'index'])->name('index');
        Route::post('add/{product}',[\App\Http\Controllers\API\buyer\CartController::class,'store'])->name('store');
        Route::delete('delete/{product}',[\App\Http\Controllers\API\buyer\CartController::class,'destroy'])->name('delete');
        Route::delete('empty',[\App\Http\Controllers\API\buyer\CartController::class,'empty'])->name('empty');
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('make',[\App\Http\Controllers\API\buyer\OrderController::class,'MakeOrder'])->name('make');
        Route::post('{oder}/place',[\App\Http\Controllers\API\buyer\OrderController::class,'PlaceOrder'])->name('place');
        Route::delete('{oder}/item/{item}/delete',[\App\Http\Controllers\API\buyer\OrderController::class,'DeleteItem'])->name('delete');
        Route::delete('cancel',[\App\Http\Controllers\API\buyer\OrderController::class,'EmptyOrder'])->name('delete');
    });
    Route::get('orders',  BuyerOrdersController::class);
});

