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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Customer\ProdukController;
use App\Http\Controllers\Customer\PesananController;
use App\Http\Controllers\Customer\WishlistCustomerController;
use App\Http\Controllers\Customer\ProfilCustomerController;
use App\Http\Controllers\Customer\NotifikasiCustomerController;

// Beranda publik
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Auth
Route::get('/login',    [AuthController::class,    'showLogin'])->name('login');
Route::post('/login',   [AuthController::class,    'login'])->name('login.post');
Route::post('/logout',  [AuthController::class,    'logout'])->name('logout');
Route::get('/register', [RegisterController::class,'showRegister'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('register.post');

// =====================
// ADMIN ROUTES
// =====================
Route::middleware('auth.custom:admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/stok',         [StokController::class, 'index'])->name('stok.index');
    Route::post('/stok',        [StokController::class, 'store'])->name('stok.store');
    Route::put('/stok/{id}',    [StokController::class, 'update'])->name('stok.update');
    Route::delete('/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');

    Route::get('/katalog',         [KatalogController::class, 'index'])->name('katalog.index');
    Route::post('/katalog',        [KatalogController::class, 'store'])->name('katalog.store');
    Route::put('/katalog/{id}',    [KatalogController::class, 'update'])->name('katalog.update');
    Route::delete('/katalog/{id}', [KatalogController::class, 'destroy'])->name('katalog.destroy');

    Route::get('/transaksi',      [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');

    Route::get('/wishlist',      [WishlistController::class, 'index'])->name('wishlist.index');
    Route::put('/wishlist/{id}', [WishlistController::class, 'update'])->name('wishlist.update');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/pengeluaran', [LaporanController::class, 'store'])->name('laporan.pengeluaran.store');
    Route::delete('/laporan/pengeluaran/{id}', [LaporanController::class, 'destroy'])->name('laporan.pengeluaran.destroy');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

    Route::get('/profil',                 [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil',                 [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/reset-password', [ProfilController::class, 'resetPassword'])->name('profil.reset-password');
});

// =====================
// CUSTOMER ROUTES
// =====================
Route::middleware('auth.custom:customer')->prefix('customer')->group(function () {

    Route::get('/produk',                    [ProdukController::class, 'index'])->name('customer.produk');
    Route::post('/pesanan',                  [PesananController::class, 'store'])->name('customer.pesanan.store');
    Route::get('/pesanan/konfirmasi/{id}',   [PesananController::class, 'konfirmasi'])->name('customer.pesanan.konfirmasi');
    Route::post('/pesanan/upload/{id}',      [PesananController::class, 'uploadBukti'])->name('customer.pesanan.upload');
    Route::get('/riwayat',                   [PesananController::class, 'riwayat'])->name('customer.riwayat');
    Route::post('/pesanan/batalkan/{id}',    [PesananController::class, 'batalkan'])->name('customer.pesanan.batalkan');

    Route::get('/wishlist',                  [WishlistCustomerController::class, 'index'])->name('customer.wishlist');
    Route::post('/wishlist',                 [WishlistCustomerController::class, 'store'])->name('customer.wishlist.store');
    Route::delete('/wishlist/{id}',          [WishlistCustomerController::class, 'destroy'])->name('customer.wishlist.destroy');

    // Pengaturan Akun Customer (Sesuai mockup Gambar 4 & 29)
    Route::get('/profil',                    [ProfilCustomerController::class, 'index'])->name('customer.profil');
    Route::put('/profil',                    [ProfilCustomerController::class, 'update'])->name('customer.profil.update');
    Route::post('/profil/reset-password',    [ProfilCustomerController::class, 'resetPassword'])->name('customer.profil.reset-password');

    Route::get('/notifikasi',                [NotifikasiCustomerController::class, 'index'])->name('customer.notifikasi');
    Route::get('/notifikasi/detail/{type}/{id}', [NotifikasiCustomerController::class, 'show'])->name('customer.notifikasi.show');
    Route::post('/notifikasi/baca/{id}',     [NotifikasiCustomerController::class, 'baca'])->name('customer.notifikasi.baca');

    // Integrasi Form Pemesanan / Modal Checkout dari Poin 3
    Route::post('/produk/pesan', [ProdukController::class, 'storeOrder'])->name('produk.storeOrder');
});