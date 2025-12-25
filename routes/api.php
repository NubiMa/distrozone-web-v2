<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Api\Admin\AdminProductController;
use App\Http\Controllers\Api\Admin\AdminOrderController;
use App\Http\Controllers\Api\Admin\AdminReportController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Cashier\CashierOrderController;
use App\Http\Controllers\Api\Cashier\CashierPaymentController;
use App\Http\Controllers\Api\ShippingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (Guest access)
Route::prefix('v1')->group(function () {
    
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Public product browsing
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/products/{id}/variants', [ProductController::class, 'variants']);
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
    
    // Shipping information
    Route::get('/shipping/destinations', [ShippingController::class, 'destinations']);
    Route::post('/shipping/calculate', [ShippingController::class, 'calculate']);
    
    // Bank accounts (public - needed for payment)
    Route::get('/bank-accounts', [PaymentController::class, 'bankAccounts']);
});

// Protected routes (Authenticated users)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Customer routes
    Route::middleware('role:customer')->prefix('customer')->group(function () {
        
        // Profile
        Route::get('/profile', [CustomerController::class, 'profile']);
        Route::put('/profile', [CustomerController::class, 'updateProfile']);
        
        // Addresses
        Route::get('/addresses', [CustomerController::class, 'addresses']);
        Route::post('/addresses', [CustomerController::class, 'createAddress']);
        Route::put('/addresses/{id}', [CustomerController::class, 'updateAddress']);
        Route::delete('/addresses/{id}', [CustomerController::class, 'deleteAddress']);
        Route::post('/addresses/{id}/set-default', [CustomerController::class, 'setDefaultAddress']);
        
        // Cart
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/add', [CartController::class, 'add']);
        Route::put('/cart/items/{id}', [CartController::class, 'updateQuantity']);
        Route::delete('/cart/items/{id}', [CartController::class, 'removeItem']);
        Route::delete('/cart/clear', [CartController::class, 'clear']);
        Route::get('/cart/summary', [CartController::class, 'summary']);
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'create']);
        Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
        Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel']);
        
        // Payments
        Route::post('/orders/{orderNumber}/payment/upload', [PaymentController::class, 'uploadProof']);
        Route::get('/orders/{orderNumber}/payment', [PaymentController::class, 'show']);
    });
    
    // Cashier routes
    Route::middleware('role:cashier,admin')->prefix('cashier')->group(function () {
        
        // Order management
        Route::get('/orders', [CashierOrderController::class, 'index']);
        Route::get('/orders/pending', [CashierOrderController::class, 'pending']);
        Route::get('/orders/{orderNumber}', [CashierOrderController::class, 'show']);
        Route::put('/orders/{orderNumber}/status', [CashierOrderController::class, 'updateStatus']);
        
        // Payment verification
        Route::get('/payments/pending', [CashierPaymentController::class, 'pending']);
        Route::post('/payments/{id}/verify', [CashierPaymentController::class, 'verify']);
        Route::post('/payments/{id}/reject', [CashierPaymentController::class, 'reject']);
        
        // Quick stats
        Route::get('/dashboard/stats', [CashierOrderController::class, 'stats']);
    });
    
    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // User management
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::post('/users', [AdminUserController::class, 'create']);
        Route::put('/users/{id}', [AdminUserController::class, 'update']);
        Route::delete('/users/{id}', [AdminUserController::class, 'delete']);
        Route::post('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive']);
        
        // Product management
        Route::get('/products', [AdminProductController::class, 'index']);
        Route::post('/products', [AdminProductController::class, 'create']);
        Route::get('/products/{id}', [AdminProductController::class, 'show']);
        Route::put('/products/{id}', [AdminProductController::class, 'update']);
        Route::delete('/products/{id}', [AdminProductController::class, 'delete']);
        Route::post('/products/{id}/toggle-active', [AdminProductController::class, 'toggleActive']);
        
        // Product variants
        Route::post('/products/{id}/variants', [AdminProductController::class, 'addVariant']);
        Route::put('/products/{id}/variants/{variantId}', [AdminProductController::class, 'updateVariant']);
        Route::delete('/products/{id}/variants/{variantId}', [AdminProductController::class, 'deleteVariant']);
        
        // Product images
        Route::post('/products/{id}/images', [AdminProductController::class, 'uploadImage']);
        Route::delete('/products/{id}/images/{imageId}', [AdminProductController::class, 'deleteImage']);
        Route::post('/products/{id}/images/{imageId}/set-primary', [AdminProductController::class, 'setPrimaryImage']);
        
        // Categories
        Route::post('/categories', [CategoryController::class, 'create']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'delete']);
        
        // Order management (all orders)
        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show']);
        Route::put('/orders/{orderNumber}', [AdminOrderController::class, 'update']);
        Route::post('/orders/{orderNumber}/notes', [AdminOrderController::class, 'addNotes']);
        
        // Reports
        Route::get('/reports/sales', [AdminReportController::class, 'sales']);
        Route::get('/reports/revenue', [AdminReportController::class, 'revenue']);
        Route::get('/reports/profit', [AdminReportController::class, 'profit']);
        Route::get('/reports/products/best-selling', [AdminReportController::class, 'bestSellingProducts']);
        Route::get('/reports/products/low-stock', [AdminReportController::class, 'lowStock']);
        Route::get('/reports/export/sales', [AdminReportController::class, 'exportSales']);
        
        // Settings
        Route::get('/settings', [AdminUserController::class, 'getSettings']);
        Route::put('/settings', [AdminUserController::class, 'updateSettings']);
        
        // Dashboard
        Route::get('/dashboard/stats', [AdminOrderController::class, 'dashboardStats']);
    });
});