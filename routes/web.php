<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Product\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Halaman awal otomatis diarahkan ke login atau daftar produk
Route::get('/', function () {
    return redirect()->route('products.index');
})->name('home');

// Route khusus untuk pengguna yang BELUM login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route yang wajib LOGIN (Auth) dan disaring kembali menggunakan RBAC
Route::middleware('auth')->group(function () {
    
    // Aksi Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Akses khusus tingkat tinggi (Admin & Formulator)
    Route::middleware('role:admin,formulator')->group(function () {
        Route::get('/register', [ProductController::class, 'create'])->name('products.create');
        Route::post('/register', [ProductController::class, 'store'])->name('products.store');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Akses membaca untuk semua role terdaftar
    Route::middleware('role:admin,formulator,teknisi,manajer r&d,qa')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product:batch_code}', [ProductController::class, 'show'])->name('products.show');
    });
});