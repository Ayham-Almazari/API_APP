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


Route::group([
    'prefix' => 'auth/owner',
],function (){
    //rout without restricted access auth
    Route::post('login'      ,      [OwnerAuth::class,'login']    );
    Route::post('register'   ,      [OwnerAuth::class,'register'] );
    Route::post('sendPasswordResetLink', [OwnerAuth::class,'sendEmail']);
    Route::post('resetPassword', [OwnerAuth::class,'passwordResetProcess']);
    Route::middleware(['auth:owner','jwt.verify:owner'])->group(function () {
        Route::post('logout'   ,    [OwnerAuth::class,'logout']   );
        Route::post( 'user'    ,    [OwnerAuth::class,'user']     );
        Route::post('refresh'    ,  [OwnerAuth::class,'refresh']  );
    });
});



