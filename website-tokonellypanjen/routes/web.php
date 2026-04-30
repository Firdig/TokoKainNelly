<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductFrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutFrontController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductImageServeController;

// ═══════════════════════════════════════════════════════════════
// PUBLIC ROUTES (No Auth Required)
// ═══════════════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog');
Route::get('/produk/{id}', [ProductFrontController::class, 'show'])->name('product.show');
Route::view('/tentang-kami', 'about')->name('about');
Route::view('/hubungi-kami', 'contact')->name('contact');

// Product Images from Database
Route::get('/product-image/variant/{variant}', [ProductImageServeController::class, 'variant'])->name('image.variant');
Route::get('/product-image/gallery/{image}', [ProductImageServeController::class, 'gallery'])->name('image.gallery');

// Session-based Cart (accessible without login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ═══════════════════════════════════════════════════════════════
// AUTHENTICATION ROUTES (Rate Limited)
// ═══════════════════════════════════════════════════════════════

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ═══════════════════════════════════════════════════════════════
// CUSTOMER ROUTES (Authenticated Customers)
// ═══════════════════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {
    // E-Commerce Checkout (Rate Limited)
    Route::get('/checkout', [CheckoutFrontController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutFrontController::class, 'process'])
        ->middleware('throttle:checkout')
        ->name('checkout.process');
    Route::get('/invoice/{id}', [CheckoutFrontController::class, 'success'])->name('checkout.success');

    // Customer Order Tracking
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');
});

// ═══════════════════════════════════════════════════════════════
// POS & REPORT ROUTES (Staff/Admin Only)
// ═══════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/kasir', [WebController::class, 'pos'])->name('pos');
    Route::get('/kasir/receipt/{id}', [WebController::class, 'receipt'])->name('pos.receipt');
    Route::get('/laporan', [WebController::class, 'laporan'])->name('laporan');
    Route::post('/checkout', [TransactionController::class, 'store'])->name('pos.checkout');
});

// ═══════════════════════════════════════════════════════════════
// ADMIN ROUTES (Admin/Staff with is_admin middleware)
// ═══════════════════════════════════════════════════════════════

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); // alias

    // Product Management (CRUD)
    Route::resource('products', ProductController::class);

    // Stock Opname (Physical Audit)
    Route::get('stock-opname', [\App\Http\Controllers\Admin\StockOpnameController::class, 'index'])->name('stock-opname.index');
    Route::post('stock-opname', [\App\Http\Controllers\Admin\StockOpnameController::class, 'store'])->name('stock-opname.store');

    // Order Management
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'store', 'destroy']);

    // Laporan Stok (Stock Movement Log)
    Route::get('stock-report', [StockReportController::class, 'index'])->name('admin.stock-report.index');
});
