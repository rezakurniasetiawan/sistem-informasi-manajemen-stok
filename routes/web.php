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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/kategori', [MasterController::class, 'indexCategory'])->name('indexCategory');
    Route::get('/add-kategori', [MasterController::class, 'createCategory'])->name('createCategory');
    Route::post('/store-kategori', [MasterController::class, 'storeCategory'])->name('storeCategory');
    Route::get('/edit-kategori/{id}', [MasterController::class, 'editCategory'])->name('editCategory');
    Route::post('/update-kategori/{id}', [MasterController::class, 'updateCategory'])->name('updateCategory');
    Route::get('/delete-kategori/{id}', [MasterController::class, 'deleteCategory'])->name('deleteCategory');
    Route::get('/category/pdf', [MasterController::class, 'pdfCategory'])->name('pdfCategory');


    Route::get('/satuan', [MasterController::class, 'indexUnit'])->name('indexUnit');
    Route::get('/add-satuan', [MasterController::class, 'createUnit'])->name('createUnit');
    Route::post('/store-satuan', [MasterController::class, 'storeUnit'])->name('storeUnit');
    Route::get('/edit-satuan/{id}', [MasterController::class, 'editUnit'])->name('editUnit');
    Route::post('/update-satuan/{id}', [MasterController::class, 'updateUnit'])->name('updateUnit');
    Route::get('/delete-satuan/{id}', [MasterController::class, 'deleteUnit'])->name('deleteUnit');
    Route::get('/unit/pdf', [MasterController::class, 'pdfUnit'])->name('pdfUnit');


    Route::get('/supplier', [MasterController::class, 'indexSupplier'])->name('indexSupplier');
    Route::get('/add-supplier', [MasterController::class, 'createSupplier'])->name('createSupplier');
    Route::post('/store-supplier', [MasterController::class, 'storeSupplier'])->name('storeSupplier');
    Route::get('/edit-supplier/{id}', [MasterController::class, 'editSupplier'])->name('editSupplier');
    Route::post('/update-supplier/{id}', [MasterController::class, 'updateSupplier'])->name('updateSupplier');
    Route::get('/delete-supplier/{id}', [MasterController::class, 'deleteSupplier'])->name('deleteSupplier');
    Route::get('/supplier/pdf', [MasterController::class, 'pdfSupplier'])->name('pdfSupplier');


    Route::get('/user', [MasterController::class, 'indexUser'])->name('indexUser');
    Route::get('/add-user', [MasterController::class, 'createUser'])->name('createUser');
    Route::post('/store-user', [MasterController::class, 'storeUser'])->name('storeUser');
    Route::get('/edit-user/{id}', [MasterController::class, 'editUser'])->name('editUser');
    Route::post('/update-user/{id}', [MasterController::class, 'updateUser'])->name('updateUser');
    Route::get('/delete-user/{id}', [MasterController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/user/pdf', [MasterController::class, 'pdfUser'])->name('pdfUser');

    Route::get('/barang', [MasterController::class, 'indexGoods'])->name('indexGoods');
    Route::get('/add-barang', [MasterController::class, 'createGoods'])->name('createGoods');
    Route::post('/store-barang', [MasterController::class, 'storeGoods'])->name('storeGoods');
    Route::get('/edit-barang/{id}', [MasterController::class, 'editGoods'])->name('editGoods');
    Route::post('/update-barang/{id}', [MasterController::class, 'updateGoods'])->name('updateGoods');
    Route::get('/delete-barang/{id}', [MasterController::class, 'deleteGoods'])->name('deleteGoods');
    Route::get('/goods/pdf', [MasterController::class, 'pdfGoods'])->name('pdfGoods');


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
