<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kategori', [MasterController::class, 'kategori'])->name('kategori');
    Route::get('/satuan', [MasterController::class, 'unit'])->name('satuan');
    Route::get('/barang', [MasterController::class, 'goods'])->name('barang');
    Route::get('/supplier', [MasterController::class, 'supplier'])->name('supplier');
    Route::get('/user', [MasterController::class, 'user'])->name('user');
    Route::get('/barang-masuk', [DashboardController::class, 'index'])->name('barangMasuk');
    Route::get('/barang-keluar', [DashboardController::class, 'index'])->name('barangKeluar');
    Route::get('/laporan-barang-masuk', [DashboardController::class, 'index'])->name('laporanBarangMasuk');
    Route::get('/laporan-barang-keluar', [DashboardController::class, 'index'])->name('laporanBarangKeluar');
    Route::get('/sync-stok-fifo', [DashboardController::class, 'index'])->name('syncStokFifo');
    Route::get('/setting', [DashboardController::class, 'index'])->name('setting');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
// Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
// Route::get('/barang', [BarangController::class, 'index'])->name('barang');
// Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
// Route::get('/user', [UserController::class, 'index'])->name('user');
// Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barangMasuk');
// Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barangKeluar');
// Route::get('/laporan-barang-masuk', [LaporanBarangMasukController::class, 'index'])->name('laporanBarangMasuk');
// Route::get('/laporan-barang-keluar', [LaporanBarangKeluarController::class, 'index'])->name('laporanBarangKeluar');
// Route::get('/sync-stok-fifo', [SyncStokFifoController::class, 'index'])->name('syncStokFifo');
// Route::get('/setting', [SettingController::class, 'index'])->name('setting');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
