<?php

use App\Http\Controllers\V1\CategoryContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('categories', CategoryContoller::class);
