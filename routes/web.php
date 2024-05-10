<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\CartController;
use App\Http\Controllers\web\HomeController;
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



Route::get('/',[HomeController::class,'index'])->name('home');
Route::any('/login',[AuthController::class,'login'])->name('login');
Route::any('/register',[AuthController::class,'register'])->name('register');
Route::middleware(['auth'])->group(function () {
    //  user routes

Route::get('/get-cart',[CartController::class,'index'])->name('get-cart');
Route::get('/add-cart',[CartController::class,'addCart'])->name('add-cart');
Route::get('/get-qty-total',[CartController::class,'getQtyTotal'])->name('get-qty-total');
Route::get('/delete-cart-item',[CartController::class,'deleteCartItem'])->name('delete-cart-item');
Route::get('/update-cart-item',[CartController::class,'updateCartItem'])->name('update-cart-item');

    
    Route::delete('logout',[AuthController::class,'logout'])->name('logout');
});

