<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:admin','jwt.verify:admin'])->group(function (){
    Route::apiResource('owners/underverificationownrs',UnderVerificationOwnerController::class);
    Route::apiResource('factories/underverificationfactories',UnderVerificationFactoryController::class);
});
