<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// auth routes

Route::post('register',[AuthController::class,'register'])->name('register');
Route::post('login',[AuthController::class,'login'])->name('login');


// product routes 
Route::get('product-listing',[ProductController::class,'index'])->name('product-listing');
Route::get('get-product-details',[ProductController::class,'getProductDetils'])->name('get-product-details');
Route::get('seach-product',[ProductController::class,'seachProduct'])->name('seach-product');



Route::middleware(['auth:sanctum'])->group(function () {
    //  user routes
    Route::get('get-profile',[AuthController::class,'getProfile'])->name('get-profile');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
});
