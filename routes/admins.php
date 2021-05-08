<?php

use App\Http\Controllers\API\Admin\UnderVerificationDeleteOwnerFactoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('api/v1/dashboard')->middleware(['auth:admin'])->group(function (){
    Route::apiResource('owners/underverificationownrs',UnderVerificationOwnerController::class);
    Route::apiResource('factories/underverificationfactories',UnderVerificationFactoryController::class);
    Route::get('factories/underverificationfactoriesfordlete',[UnderVerificationDeleteOwnerFactoryController::class,'index']);
    Route::get('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'RestoreFactory']);
    Route::delete('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'DeleteFactory']);
});

Route::prefix('tallybills/admins/dashboard')->name('view.')->group(function () {
    Route::view('login', 'pages.ajax-login')->name("admin.login");
    Route::view('home', 'pages.admin_home')->name("admin.home");
    Route::view('unverified-factories', 'pages.unverified-factories')->name("admin.home");
});
