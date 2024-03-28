<?php

use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

use Illuminate\Support\Facades\Route;


/**
 * Guest route protection for seller user
 */
Route::middleware(['guest.authenticate'])->group(function () {
    Route::get('product-dashboard', [SellerProductController::class, 'index'])->name('my-product-ads');
    Route::get('product-ad', [SellerProductController::class, 'create'])->name('product-ad-form');
    Route::post('product-ad', [SellerProductController::class, 'store'])->name('product-ad-post');
    Route::get('product/{productId}/edit', [SellerProductController::class, 'edit'])->name('product-edit');
    Route::put('product/{productId}/update', [SellerProductController::class, 'update'])->name('product-update');
    Route::get('product/{productId}/destroy', [SellerProductController::class, 'destroy'])->name('product-destroy');

    Route::get('get-parent-category', [CategoryController::class, 'getPaginatedCategory'])->name('paginated-category');
    Route::get('get-child-option/{parentId}', [CategoryController::class, 'displayChildCategory'])->name('get-child-option');

    Route::post('post-comment', [CommentController::class, 'store'])->name('post-comment');


});



/**
 * Product related routes
 */
Route::get('/', [ProductController::class, 'index'])->name('user-home');
Route::get('/{categoryId}/products', [ProductController::class, 'categoryProductList'])->name('product-listing');
Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product-display');
