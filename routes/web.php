<?php

use App\Models\Factory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//-------------------admin
Route::get('/', function () {
    return redirect()->route("view.admin.login");
});

//Route::resource('/upload',csvController::class);
