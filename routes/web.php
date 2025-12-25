<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\CatalogController;
use App\Http\Controllers\Guest\ProductController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Customer\CustomerHomeController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\CustomerCatalogController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\AddressController;

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
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
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
    // Home, Catalog, Product (reuse guest routes with customer navbar)
    Route::get('/', [CustomerHomeController::class, 'index'])->name('home');
    Route::get('/katalog', [CustomerCatalogController::class, 'index'])->name('catalog');
    Route::get('/tentang', function () {
        return view('customer.about');
    })->name('about');
    Route::get('/produk/{slug}', [CustomerProductController::class, 'show'])->name('product.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/items/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/items/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    
    // Checkout
    // Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    // Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Payment
    Route::post('/orders/{orderNumber}/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.upload');
    
    // // Wishlist
    // Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    // Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    // // Profile
    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    
    // // Addresses
    // Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    // Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    // Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    // Route::delete('/addresses/{id}', [AddressController::class, 'delete'])->name('addresses.delete');
    // Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
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