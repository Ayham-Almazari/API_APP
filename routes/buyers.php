<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\BuyerController;
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


Route::group([
    'prefix' => 'auth/buyer',
],function (){
    //rout without restricted access auth
    Route::post('login'      , [BuyerController::class,'login']       );
    Route::post('register'   , [BuyerController::class,'register']    );

    Route::middleware(['auth:buyer','jwt.verify:buyer'])->group(function () {
        Route::post('logout'   , [BuyerController::class,'logout']    );
        Route::post( 'user'    ,    [BuyerController::class,'user']   );
        Route::post('refresh'    , [BuyerController::class,'refresh'] );
    });
});



