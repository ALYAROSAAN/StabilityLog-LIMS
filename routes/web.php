<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Product\Controllers\ProductController;

Route::get('/', [ProductController::class, 'create'])->name('home');
Route::get('/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/register', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');