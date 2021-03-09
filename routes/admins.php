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
    Route::post('sendPasswordResetLink', [AdminController::class,'sendEmail']);
    Route::post('resetPassword', [AdminController::class,'passwordResetProcess']);
    Route::middleware(['auth:admin','jwt.verify:admin'])->group(function () {
        Route::post('logout'   , [AdminController::class,'logout']);
        Route::get( 'user'    ,    [AdminController::class,'user']  );
        Route::post('refresh'    , [AdminController::class,'refresh'] );
    });
    Route::get('email/verify', [AdminController::class,'verify'])->name('verification.verify');
    Route::get('email/resend', [AdminController::class,'resend'])->name('verification.resend');
});



