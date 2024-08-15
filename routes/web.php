<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product-details');

// Route::get('/', function () {
//     return view('index');
// });
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('add-to-cart');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

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