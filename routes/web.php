<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

// --- Rute Publik / Katalog (Dari Temen Loe) ---
Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.katalog');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

// --- Rute Autentikasi (Dari Loe) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); 
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Halaman Khusus Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// --- Halaman Khusus Pelanggan ---
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/beranda', function () {
        return view('pelanggan.beranda');
    })->name('beranda');
});