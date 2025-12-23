<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ChatController;

// ==============================
// 1️⃣ Halaman utama (welcome)
// ==============================
Route::get('/', function () {
    return view('welcome');
});

// ==============================
// 2️⃣ Routes untuk autentikasi
// ==============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// ✅ Logout pakai GET agar tidak error MethodNotAllowedHttpException
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==============================
// 3️⃣ Routes CRUD Produk (hanya untuk yang login)
// ==============================
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});

// ==============================
// 4️⃣ Dashboard berdasarkan role
// ==============================

// 🔹 ADMIN Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});

// 🔹 SELLER Dashboard pakai Controller biar bisa kirim data
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

    Route::get('/seller/chat', [ChatController::class, 'sellerChatList'])->name('seller.chat.list');

    Route::get('/seller/chat/{buyerId}', [ChatController::class, 'sellerChatDetail'])
        ->name('seller.chat.detail');
});

// 🔹 BUYER Dashboard
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/buyer/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    Route::get('/buyer/orders', [BuyerOrderController::class, 'index'])->name('buyer.orders');
    Route::get('/buyer/products', [BuyerController::class, 'products'])->name('buyer.products');
    Route::get('/buyer/products/{id}', [BuyerController::class, 'productDetail'])->name('buyer.product.detail');
    Route::get('/buyer/chat', [ChatController::class, 'buyerChatList'])->name('buyer.chat.list');
    Route::get('/buyer/chat/{sellerId}', [ChatController::class, 'buyerChat'])->name('buyer.chat');
    Route::get('/buyer/cart', [BuyerController::class, 'cart'])->name('buyer.cart');
    Route::get('/buyer/cart/add/{productId}',[BuyerController::class, 'addToCart'])->name('buyer.cart.add');
    Route::post('/buyer/cart/update/{id}', [BuyerController::class, 'updateQty'])->name('buyer.cart.update');
    Route::delete('/buyer/cart/{id}', [BuyerController::class, 'deleteItem'])->name('buyer.cart.delete');
    Route::post('/buyer/checkout', [BuyerController::class, 'checkout'])->name('buyer.checkout');
    Route::post('/buyer/checkout/process', [BuyerController::class, 'processCheckout'])->name('buyer.checkout.process');

});
/*
|--------------------------------------------------------------------------
| 7️⃣ CHAT SEND (GLOBAL - BUYER & SELLER)
|--------------------------------------------------------------------------
| Route INI YANG MENGATASI ERROR 403
*/
Route::middleware('auth')->post('/chat/send', [ChatController::class, 'sendMessage'])
    ->name('chat.send');
