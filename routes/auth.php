<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\{VerificationController as Email,BuyerController as BuyerAuth,OwnerController,AdminController};
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
    'prefix' => 'auth'
],function (){

    //email verification routes
    Route::middleware(['Logged',"throttle:5,2"])->group(function (){
        Route::get('email/verify', [Email::class,'verify'])->name('verification.verify');
        Route::get('email/resend', [Email::class,'resend'])->name('verification.resend');
    });
    //if not verified
    Route::get('email/notice', [Email::class,'notice'])->name('verification.notice');


    //buyer auth routes
    Route::group([
        'prefix' => 'buyer',
    ],function (){
        //routes without restricted access auth
        Route::post('login'      , [BuyerAuth::class,'login']       );
        Route::post('register'   , [BuyerAuth::class,'register']    );
        //routes must have valid access token and user must logged in
        Route::middleware(['jwt.verify:buyer','auth:buyer'])->group(function () {
            //refresh token , logout , refresh
            Route::post('logout'   , [BuyerAuth::class,'logout']    );
            Route::post( 'user'    ,    [BuyerAuth::class,'user']   );
            Route::post('refresh'    , [BuyerAuth::class,'refresh'] );
        });
        //buyer reset password routes
        //throttle
        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetCode', [BuyerAuth::class,'sendEmail']);
            Route::post('resetPassword', [BuyerAuth::class,'passwordResetProcess']);
        });

    });









});



