<?php

use App\Http\Controllers\V1\CategoryContoller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ShopController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryContoller::class);
Route::resource('products', ProductController::class);
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');