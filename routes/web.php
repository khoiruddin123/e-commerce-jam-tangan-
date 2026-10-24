<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.katalog');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

// --- Rute Autentikasi ---
use App\Http\Controllers\AuthController;

// --- Rute Autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
