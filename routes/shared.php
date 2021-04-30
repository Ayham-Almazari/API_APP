<?php

use App\Http\Controllers\API\SharedUsers\UsersProfilesController;
use Illuminate\Support\Facades\Route;
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

Route::prefix('user')->group(function () {
    Route::get('profile',[UsersProfilesController::class,'show']);
    Route::put('profile',[UsersProfilesController::class,'update']);
    Route::delete('profile',[UsersProfilesController::class,'destroy']);
});
