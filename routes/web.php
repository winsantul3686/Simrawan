<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfilController;

// Beranda publik
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Auth
Route::get('/login',    [AuthController::class,   'showLogin'])->name('login');
Route::post('/login',   [AuthController::class,   'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class,'showRegister'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('register.post');

// Protected Routes
Route::middleware('auth.custom')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Stok
    Route::get('/stok',         [StokController::class, 'index'])->name('stok.index');
    Route::post('/stok',        [StokController::class, 'store'])->name('stok.store');
    Route::put('/stok/{id}',    [StokController::class, 'update'])->name('stok.update');
    Route::delete('/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');

    // Katalog Produk
    Route::get('/katalog',         [KatalogController::class, 'index'])->name('katalog.index');
    Route::post('/katalog',        [KatalogController::class, 'store'])->name('katalog.store');
    Route::put('/katalog/{id}',    [KatalogController::class, 'update'])->name('katalog.update');
    Route::delete('/katalog/{id}', [KatalogController::class, 'destroy'])->name('katalog.destroy');

    // Transaksi
    Route::get('/transaksi',        [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::put('/transaksi/{id}',   [TransaksiController::class, 'update'])->name('transaksi.update');

    // Wishlist
    Route::get('/wishlist',       [WishlistController::class, 'index'])->name('wishlist.index');
    Route::put('/wishlist/{id}',  [WishlistController::class, 'update'])->name('wishlist.update');

    // Customer
    Route::get('/customer',         [CustomerController::class, 'index'])->name('customer.index');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    // Laporan Keuangan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

    // Profil Admin
    Route::get('/profil',                  [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil',                  [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/reset-password',  [ProfilController::class, 'resetPassword'])->name('profil.reset-password');
});