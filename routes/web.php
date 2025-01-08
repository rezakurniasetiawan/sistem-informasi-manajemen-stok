<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InboundItemsController;
use App\Http\Controllers\OutboundItemsController;

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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');

Route::middleware('auth:sanctum')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================== Master Route ==============================
    // Kategori Route
    Route::prefix('kategori')->group(function () {
        Route::get('/', [MasterController::class, 'indexCategory'])->name('indexCategory');
        Route::get('/add', [MasterController::class, 'createCategory'])->name('createCategory');
        Route::post('/store', [MasterController::class, 'storeCategory'])->name('storeCategory');
        Route::get('/edit/{id}', [MasterController::class, 'editCategory'])->name('editCategory');
        Route::post('/update/{id}', [MasterController::class, 'updateCategory'])->name('updateCategory');
        Route::get('/delete/{id}', [MasterController::class, 'deleteCategory'])->name('deleteCategory');
        Route::get('/pdf', [MasterController::class, 'pdfCategory'])->name('pdfCategory');
    });
    
    // Satuan Route
    Route::prefix('satuan')->group(function () {
        Route::get('/', [MasterController::class, 'indexUnit'])->name('indexUnit');
        Route::get('/add', [MasterController::class, 'createUnit'])->name('createUnit');
        Route::post('/store', [MasterController::class, 'storeUnit'])->name('storeUnit');
        Route::get('/edit/{id}', [MasterController::class, 'editUnit'])->name('editUnit');
        Route::post('/update/{id}', [MasterController::class, 'updateUnit'])->name('updateUnit');
        Route::get('/delete/{id}', [MasterController::class, 'deleteUnit'])->name('deleteUnit');
        Route::get('/pdf', [MasterController::class, 'pdfUnit'])->name('pdfUnit');
    });

    // Supplier Route
    Route::prefix('supplier')->group(function () {
        Route::get('/', [MasterController::class, 'indexSupplier'])->name('indexSupplier');
        Route::get('/add', [MasterController::class, 'createSupplier'])->name('createSupplier');
        Route::post('/store', [MasterController::class, 'storeSupplier'])->name('storeSupplier');
        Route::get('/edit/{id}', [MasterController::class, 'editSupplier'])->name('editSupplier');
        Route::post('/update/{id}', [MasterController::class, 'updateSupplier'])->name('updateSupplier');
        Route::get('/delete/{id}', [MasterController::class, 'deleteSupplier'])->name('deleteSupplier');
        Route::get('/pdf', [MasterController::class, 'pdfSupplier'])->name('pdfSupplier');
    });

    // User Route
    Route::prefix('user')->group(function () {
        Route::get('/', [MasterController::class, 'indexUser'])->name('indexUser');
        Route::get('/add', [MasterController::class, 'createUser'])->name('createUser');
        Route::post('/store', [MasterController::class, 'storeUser'])->name('storeUser');
        Route::get('/edit/{id}', [MasterController::class, 'editUser'])->name('editUser');
        Route::post('/update/{id}', [MasterController::class, 'updateUser'])->name('updateUser');
        Route::get('/delete/{id}', [MasterController::class, 'deleteUser'])->name('deleteUser');
        Route::get('/pdf', [MasterController::class, 'pdfUser'])->name('pdfUser');
    });

    // Barang Route
    Route::prefix('barang')->group(function () {
        Route::get('/', [MasterController::class, 'indexGoods'])->name('indexGoods');
        Route::get('/add', [MasterController::class, 'createGoods'])->name('createGoods');
        Route::post('/store', [MasterController::class, 'storeGoods'])->name('storeGoods');
        Route::get('/edit/{id}', [MasterController::class, 'editGoods'])->name('editGoods');
        Route::post('/update/{id}', [MasterController::class, 'updateGoods'])->name('updateGoods');
        Route::get('/delete/{id}', [MasterController::class, 'deleteGoods'])->name('deleteGoods');
        Route::get('/pdf', [MasterController::class, 'pdfGoods'])->name('pdfGoods');
    });

    // Barang Masuk Route
    Route::prefix('barang-masuk')->group(function () {
        Route::get('/', [InboundItemsController::class, 'indexInboundItems'])->name('indexInboundItems');
        Route::get('/add', [InboundItemsController::class, 'createInboundItems'])->name('createInboundItems');
        Route::post('/store', [InboundItemsController::class, 'storeInboundItems'])->name('storeInboundItems');
        Route::get('/edit/{id}', [InboundItemsController::class, 'editInboundItems'])->name('editInboundItems');
        Route::post('/update/{id}', [InboundItemsController::class, 'updateInboundItems'])->name('updateInboundItems');
        Route::get('/delete/{id}', [InboundItemsController::class, 'deleteInboundItems'])->name('deleteInboundItems');
        Route::get('/pdf', [InboundItemsController::class, 'pdfInboundItems'])->name('pdfInboundItems');
    });

    Route::prefix('barang-keluar')->group(function () {
        Route::get('/', [OutboundItemsController::class, 'indexOutboundItems'])->name('indexOutboundItems');
        // Route::get('/add', [OutboundItemsController::class, 'createOutboundItems'])->name('createOutboundItems');
        // Route::post('/store', [OutboundItemsController::class, 'storeOutboundItems'])->name('storeOutboundItems');
        // Route::get('/edit/{id}', [OutboundItemsController::class, 'editOutboundItems'])->name('editOutboundItems');
        // Route::post('/update/{id}', [OutboundItemsController::class, 'updateOutboundItems'])->name('updateOutboundItems');
        // Route::get('/delete/{id}', [OutboundItemsController::class, 'deleteOutboundItems'])->name('deleteOutboundItems');
    });

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
