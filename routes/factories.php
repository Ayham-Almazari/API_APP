<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\FactoryController;
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
    'prefix' => 'auth/factory',
],function (){
    //rout without restricted access auth
    Route::post('login'      ,      [FactoryController::class,'login']    );
    Route::post('register'   ,      [FactoryController::class,'register'] );
    Route::middleware('auth:factory')->group(function () {
        Route::post('logout'   ,    [FactoryController::class,'logout']   );
        Route::post( 'user'    ,    [FactoryController::class,'user']     );
        Route::post('refresh'    ,  [FactoryController::class,'refresh']  );
    });
});



