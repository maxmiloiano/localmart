<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:seller'])->get('/seller/dashboard', function () {
    return view('dashboard.seller');
})->name('seller.dashboard');

Route::middleware(['auth', 'role:buyer'])->get('/buyer/dashboard', function () {
    return view('dashboard.buyer');
})->name('buyer.dashboard');
