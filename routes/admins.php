<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\AdminController;
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
    'prefix' => 'auth/admin',
],function (){
    //rout without restricted access auth
    Route::post('login'      , [AdminController::class,'login']   );
    Route::post('register'   , [AdminController::class,'register']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('logout'   , [AdminController::class,'logout']);
        Route::post( 'user'    ,    [AdminController::class,'user']  );
        Route::post('refresh'    , [AdminController::class,'refresh'] );
    });
});



