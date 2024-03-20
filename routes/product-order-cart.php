<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/**
 * Routes for cart operations
 */
Route::middleware(['guest.authenticate'])->group(function (){
    Route::get('{userId}/cart-items', [CartController::class, 'index'])->name('cart-items');
    Route::post('add-to-cart', [CartController::class, 'store'])->name('add-to-cart');
    Route::put('cart-quantity-change', [CartController::class, 'update'])->name('change-cart-item-quantity');
    Route::post('remove-from-cart', [CartController::class, 'destroy'])->name('remove-from-cart');
});


/**
 * Routes for checkout operations
 */
Route::middleware(['guest.authenticate'])->group(function (){
    Route::post('items-checkout', [CheckoutController::class, 'index'])->name('checkout-page');
});
