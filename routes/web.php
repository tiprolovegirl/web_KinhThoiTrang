<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::controller(CartController::class)->group(function(){
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::get('/cart','index')->name('cart.index');
    Route::post('/cart/remove/{id}', 'removeItem')->name('cart.remove');
    Route::get('/cart/count', 'getCartCount')->name('cart.count');
    Route::post('/cart/update/{id}', 'update')->name('cart.update');

});

Route::controller(FavoriteController::class)->group(function(){
    Route::post('/favorites/{productId}', 'addFavorite')->name('favorite.add');
    Route::get('/favorites','index')->name('favorite.index');
    Route::delete('/favorites/{productId}','removeFavorite')->name('favorite.remove');
    Route::get('/favorites/count', 'getFavoriteCount')->name('favorite.count');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/products/search', 'search')->name('product.search');
    Route::get('/products/{id}', 'detail')->name('product.detail');
});

Route::controller(CheckoutController::class)->group(function(){
    Route::get('/checkout-payment', 'checkoutPayment')->name('checkout.payment');
    Route::get('/payment-complete', 'paymentComplete')->name('checkout.paymentComplete');
});


Route::resource('posts', PostController::class);
