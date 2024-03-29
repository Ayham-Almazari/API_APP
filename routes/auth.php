<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\{VerificationController as Email,
                                    BuyerAuth ,
                                    OwnerAuth ,
                                    AdminAuth};
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
        Route::post('email/verify', [Email::class,'verify'])->name('verification.verify');
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
        Route::middleware(['auth:buyer'])->group(function () {
            //refresh token , logout , refresh
            Route::post('logout'   , [BuyerAuth::class,'logout']    );
            Route::get('refresh'    , [BuyerAuth::class,'refresh'] );
            //get current authenticated user
            Route::get( 'user'    ,    [BuyerAuth::class,'user']);
        });
        //buyer reset password routes
        //throttle
//        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetCode', [BuyerAuth::class,'sendEmail']);
            Route::post('resetPassword', [BuyerAuth::class,'passwordResetProcess']);
//        });
    });

    // ADMIN AUTH ROUTES
    Route::group([
        'prefix' => 'admin',
    ],function (){
        //rout without restricted access auth
        Route::post('login'      , [AdminAuth::class,'login']   )->name('admin.login');
        Route::get('register/{buyer:username}'   , [AdminAuth::class,'register'])
            ->missing(function (){
                return response()->json(['Undefined User Or Already has been defined as Admin .'],\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
            });
        //routes must have valid access token and user must logged in
        Route::middleware(['auth:admin'])->group(function () {
            //refresh token , logout , refresh
            Route::get('logout'   , [AdminAuth::class,'logout']);
            Route::get('refresh'    , [AdminAuth::class,'refresh'] );
            //get current authotocated user
            Route::get( 'user'    ,    [AdminAuth::class,'user']);
            Route::delete('remove/{admin}', [\App\Http\Controllers\API\Admin\ViewsAJax\UsersViews::class,"deleteadmin"])->name('search.removeAdmin');
        });
        //admin reset password routes
        //throttle
        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetLink', [AdminAuth::class,'sendEmail']);
            Route::post('resetPassword', [AdminAuth::class,'passwordResetProcess']);
        });
    });


    // Owner AUTH ROUTES
    Route::group([
        'prefix' => 'owner',
    ],function (){
        //rout without restricted access auth
        Route::post('login'      ,      [OwnerAuth::class,'login']    );
        Route::post('register'   ,      [OwnerAuth::class,'register'] );
        //routes must have valid access token and user must logged in
        Route::middleware(['auth:owner'])->group(function () {
            Route::post('logout'   ,    [OwnerAuth::class,'logout']   );
            Route::get( 'user'    ,    [OwnerAuth::class,'user']     );
            Route::get('refresh'    ,  [OwnerAuth::class,'refresh']  );
        });
        //Owner reset password routes
        //throttle
        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetLink', [OwnerAuth::class,'sendEmail']);
            Route::post('resetPassword', [OwnerAuth::class,'passwordResetProcess']);
        });
    });


});



