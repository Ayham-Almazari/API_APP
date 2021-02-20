<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
],function (){
   //rout without restricted access auth
    Route::post('login'      , [AuthController::class,'login']);
    Route::post('register'   , [AuthController::class,'register'] );
    Route::post('refresh'    , [AuthController::class,'refresh']);

    Route::middleware('auth:api')->group(function ($router) {
        Route::post('logout'   , [AuthController::class,'logout']);
        Route::post( 'user' ,  [AuthController::class,'user']);
    });
});
Route::group([
    'prefix' => 'auth/admin',
],function (){
    //rout without restricted access auth
    Route::post('login'      , [AuthController::class,'login']);
    Route::post('register'   , [AuthController::class,'register'] );
    Route::post('refresh'    , [AuthController::class,'refresh']);

    Route::middleware('auth:admin')->group(function ($router) {
        Route::post('logout'   , [AuthController::class,'logout']);
        Route::post( 'user' ,  [AuthController::class,'user']);
    });
});

Route::apiResource('posts',PostController::class);

Route::apiResource('manufactor',ManufactorsController::class);


