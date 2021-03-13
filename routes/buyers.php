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
    Route::post('sendPasswordResetLink', [BuyerController::class,'sendEmail'])->middleware("throttle:5,1");
    Route::post('resetPassword', [BuyerController::class,'passwordResetProcess'])->middleware("throttle:5,1");
    Route::middleware(['auth:buyer','jwt.verify:buyer'])->group(function () {
        Route::post('logout'   , [BuyerController::class,'logout']    );
        Route::post( 'user'    ,    [BuyerController::class,'user']   );
        Route::post('refresh'    , [BuyerController::class,'refresh'] );
    });
    Route::middleware('Logged:buyer')->group(function (){
        Route::get('email/verify', [BuyerController::class,'verify'])->name('verification.verify');
        Route::get('email/resend', [BuyerController::class,'resend'])->name('verification.resend');
    });
});



