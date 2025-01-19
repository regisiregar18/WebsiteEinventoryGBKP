<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DonasiJemaatController;
use App\Http\Controllers\InventarisasiController;
use App\Http\Controllers\DanaPersembahanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman UMUM / User non-login
Route::get('/', [PagesController::class, 'index'])->name('index');

// Data user Handle
Route::resource('users', UserController::class);

Route::middleware('guest')->group(function () {
    // Halaman jika belum login
    Route::get('/login', [PagesController::class, 'login'])->name('login');
    Route::get('/register', [PagesController::class, 'register'])->name('register');

    // Method
    Route::post('/login-process', [AuthController::class, 'loginProcess']);
});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [PagesController::class, 'dashboard'])->name('dashboard');
        Route::get('/data-barang', [PagesController::class, 'dataBarang'])->name('dataBarang');
        Route::get('/barang-kembali', [PagesController::class, 'barangKembali'])->name('barangKembali');
        Route::get('/barang-pinjam', [PagesController::class, 'barangPinjam'])->name('barangPinjam');
        Route::get('/edit-barang-pinjam/{id}', [BarangController::class, 'showBarangPinjam'])->name('showBarangPinjam');
        Route::get('/dana-masuk', [PagesController::class, 'danaMasuk'])->name('danaMasuk');
        Route::get('/inventarisasi', [PagesController::class, 'inventarisasi'])->name('inventarisasi');
        Route::get('/my-profile', [PagesController::class, 'profile'])->name('profile');
        Route::get('/setting-profile', [PagesController::class, 'settings'])->name('settings');
        Route::get('/data-barang', [BarangController::class, 'index'])->name('dataBarang');
    });

    Route::resource('barangs', BarangController::class);
    Route::resource('danas', DanaPersembahanController::class);
    Route::resource('donasis', DonasiJemaatController::class);
    Route::resource('inventarisasis', InventarisasiController::class);
    Route::post('/upload-bukti-pembayaran', [DonasiJemaatController::class, 'storeBuktiPembayaran'])->name('upload.bukti.pembayaran');

    Route::get('/printBarangKembali', [BarangController::class, 'printBarangKembali']);
    Route::get('/printBarangPinjam', [BarangController::class, 'printBarangPinjam']);
    Route::get('/printDanaMasuk', [BarangController::class, 'printDanaMasuk']);
    Route::get('/printDataBarang', [BarangController::class, 'printDataBarang']);
    Route::get('/peminjaman/filter', [PagesController::class, 'filterPeminjaman'])->name('filterPeminjaman');
    Route::get('/data-barang/filter', [BarangController::class, 'filter'])->name('data-barang.filter');

    Route::get('/logout-process', [AuthController::class, 'logoutProcess']);
});
