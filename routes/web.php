<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\CatalogController;
use App\Http\Controllers\Guest\ProductController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Public Access)
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Catalog
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');

// About Page
Route::get('/tentang', function () {
    return view('guest.about');
})->name('about');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    
    // Register
    Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register'])->name('register.post');
});

// Logout (Authenticated Only)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Customer Routes (Authenticated)
|--------------------------------------------------------------------------
| These will be implemented in PHASE 2
*/

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    // Will be implemented in Phase 2
    // Dashboard, Cart, Checkout, Orders, etc.
});

/*
|--------------------------------------------------------------------------
| Cashier Routes (Authenticated)
|--------------------------------------------------------------------------
| These will be implemented in PHASE 3
*/

Route::middleware(['auth', 'role:cashier,admin'])->prefix('kasir')->name('cashier.')->group(function () {
    // Will be implemented in Phase 3
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated)
|--------------------------------------------------------------------------
| These will be implemented in PHASE 4
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Will be implemented in Phase 4
});