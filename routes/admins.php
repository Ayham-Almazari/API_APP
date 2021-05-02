<?php

use App\Http\Controllers\API\Admin\UnderVerificationDeleteOwnerFactoryController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:admin'])->group(function (){
    Route::apiResource('owners/underverificationownrs',UnderVerificationOwnerController::class);
    Route::apiResource('factories/underverificationfactories',UnderVerificationFactoryController::class);
    Route::get('factories/underverificationfactoriesfordlete',[UnderVerificationDeleteOwnerFactoryController::class,'index']);
    Route::get('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'RestoreFactory']);
    Route::delete('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'DeleteFactory']);
});
