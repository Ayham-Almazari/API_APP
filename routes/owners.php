<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\OwnerController;
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
    'prefix' => 'auth/owner',
],function (){
    //rout without restricted access auth
    Route::post('login'      ,      [OwnerController::class,'login']    );
    Route::post('register'   ,      [OwnerController::class,'register'] );
    Route::post('sendPasswordResetLink', [OwnerController::class,'sendEmail']);
    Route::post('resetPassword', [OwnerController::class,'passwordResetProcess']);
    Route::middleware(['auth:owner','jwt.verify:owner'])->group(function () {
        Route::post('logout'   ,    [OwnerController::class,'logout']   );
        Route::post( 'user'    ,    [OwnerController::class,'user']     );
        Route::post('refresh'    ,  [OwnerController::class,'refresh']  );
    });
});



