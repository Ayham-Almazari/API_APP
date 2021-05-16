<?php

use App\Http\Controllers\API\Admin\UnderVerificationDeleteOwnerFactoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('api/v1/dashboard')->middleware(['auth:admin'])->group(function (){
    Route::apiResource('owners/underverificationownrs',UnderVerificationOwnerController::class);
    Route::apiResource('factories/underverificationfactories',UnderVerificationFactoryController::class);
    Route::get('factories/underverificationfactoriesfordlete',[UnderVerificationDeleteOwnerFactoryController::class,'index']);
    Route::get('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'RestoreFactory']);
    Route::delete('factories/underverificationfactoriesfordlete/{id}',[UnderVerificationDeleteOwnerFactoryController::class,'DeleteFactory']);
    Route::get('search', [\App\Http\Controllers\API\Admin\ViewsAJax\UsersViews::class,"search"])->name('search.forRegisterBuyerAsAdmin');
    Route::put('update/permissions/factory/{factory}', [\App\Http\Controllers\API\Admin\ManageFactories::class,"UpdateFactoryPermissions"])->name('search.forRegisterBuyerAsAdmin');
});
//

Route::prefix('tallybills/admins/dashboard')->name('view.')->group(function () {
    Route::view('login', 'pages.ajax-login')->name("admin.login");
        Route::view('home', 'pages.admin_home')->name("admin.home");
        Route::get('unverified-factories', [\App\Http\Controllers\API\Admin\ViewsAJax\UnderVerificationFactoryViews::class,"index"]);
        Route::get('unverified-deleted-factories', [\App\Http\Controllers\API\Admin\ViewsAJax\UnderVerificationDeletedFactoryViews::class,"index"]);
        Route::get('unverified-owners', [\App\Http\Controllers\API\Admin\ViewsAJax\UnderVerificationOwnersViews::class,"index"]);
        Route::get('unverified-owners', [\App\Http\Controllers\API\Admin\ViewsAJax\UnderVerificationOwnersViews::class,"index"]);
        Route::get('users', [\App\Http\Controllers\API\Admin\ViewsAJax\UsersViews::class,"index"]);
        Route::get('manage-factories', [\App\Http\Controllers\API\Admin\ViewsAJax\ManageFactories::class,"index"]);
        Route::get('manage-factories/{factory}/products', [\App\Http\Controllers\API\Admin\ViewsAJax\ManageFactories::class,"products"]);
});
