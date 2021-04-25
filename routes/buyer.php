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

Route::middleware(['auth:buyer'])->prefix('buyer/cart')->name('cart.')->group(function () {
    Route::get('',[\App\Http\Controllers\API\buyer\CartController::class,'index'])->name('index');
    Route::post('add/{product}',[\App\Http\Controllers\API\buyer\CartController::class,'store'])->name('store');
    Route::delete('delete/{product}',[\App\Http\Controllers\API\buyer\CartController::class,'destroy'])->name('delete');
    Route::delete('empty',[\App\Http\Controllers\API\buyer\CartController::class,'empty'])->name('empty');
});

