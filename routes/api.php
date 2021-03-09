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


Route::get('email/verify', [\App\Http\Controllers\API\auth\VerificationController::class,'verify'])->name('verification.verify');
Route::get('email/resend', [\App\Http\Controllers\API\auth\VerificationController::class,'resend'])->name('verification.resend');

Route::apiResource('posts',PostController::class);

Route::apiResource('manufactor',ManufactorsController::class);



