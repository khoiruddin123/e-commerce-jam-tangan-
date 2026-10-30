<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MerekController;
use App\Http\Controllers\Admin\VarianController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Pelanggan\UlasanController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfilController;


// --- Rute Publik / Beranda & Katalog ---
Route::get('/', [ProdukController::class, 'beranda'])->name('produk.index');
Route::get('/beranda', [ProdukController::class, 'beranda'])->name('beranda');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.katalog');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

// --- Rute Autentikasi (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Halaman Khusus Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk & Galeri Foto Horologi
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
    Route::post('/produk/{id}/foto', [AdminProdukController::class, 'uploadFoto'])->name('produk.uploadFoto');
    Route::delete('/produk/foto/{fotoId}', [AdminProdukController::class, 'hapusFoto'])->name('produk.hapusFoto');
    Route::patch('/produk/foto/{fotoId}/utama', [AdminProdukController::class, 'setFotoUtama'])->name('produk.setFotoUtama');

    // Manajemen Pesanan & Pengiriman
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::post('/pesanan/{id}/resi', [PesananController::class, 'updateResi'])->name('pesanan.updateResi');

    // Laporan Omzet Bulanan
    Route::get('/laporan-omzet', [LaporanController::class, 'index'])->name('laporan.omzet');
    Route::get('/laporan-omzet/cetak', [LaporanController::class, 'cetak'])->name('laporan.omzet.cetak');

    // Manajemen Kategori Produk
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Manajemen Merek Jam Tangan
    Route::get('/merek', [MerekController::class, 'index'])->name('merek.index');
    Route::post('/merek', [MerekController::class, 'store'])->name('merek.store');
    Route::put('/merek/{id}', [MerekController::class, 'update'])->name('merek.update');
    Route::delete('/merek/{id}', [MerekController::class, 'destroy'])->name('merek.destroy');

    // Manajemen Varian, Harga & Stok
    Route::get('/varian', [VarianController::class, 'index'])->name('varian.index');
    Route::post('/varian', [VarianController::class, 'store'])->name('varian.store');
    Route::put('/varian/{id}', [VarianController::class, 'update'])->name('varian.update');
    Route::patch('/varian/{id}/stok-harga', [VarianController::class, 'updateStokHarga'])->name('varian.updateStokHarga');
    Route::delete('/varian/{id}', [VarianController::class, 'destroy'])->name('varian.destroy');
});

// --- Halaman Khusus Pelanggan ---
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/beranda', [PelangganController::class, 'index'])->name('beranda');
    Route::get('/pesanan', [PelangganController::class, 'index'])->name('pesanan');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

// --- Rute Profil Pelanggan ---
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// --- Rute Keranjang Belanja (F8 Part 1) ---
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
});

// --- Rute Checkout & Pengiriman (F8 Part 2) ---
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');
});

// --- Rute Konfirmasi Pembayaran Simulasi (F9) ---
Route::middleware('auth')->group(function () {
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
    Route::post('/pembayaran/{id}/batal', [PembayaranController::class, 'batal'])->name('pembayaran.batal');
    Route::get('/pembayaran/{id}/sukses', [PembayaranController::class, 'sukses'])->name('pembayaran.sukses');
});
