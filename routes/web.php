<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.katalog');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');