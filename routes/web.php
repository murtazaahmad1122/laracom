<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product-details');

// Route::get('/', function () {
//     return view('index');
// });

Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add-to-cart');

Route::get('/term', function () {
    return view('term');
});
Route::get('/privacy', function () {
    return view('privacy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/index', function () {
        return view('index');
    })->name('index');
    Route::get('/products', function () {
        return view('products');
    })->name('products');
    Route::get('/product-details', function () {
        return view('product-details');
    })->name('product-details');
   

});


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);