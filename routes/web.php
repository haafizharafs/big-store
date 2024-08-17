<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\JualController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HistoriPenjualanController;


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
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('logout', [LoginController::class, 'actionlogout'])->name('logout')->middleware('auth');

Route::get('/barang', [BarangController::class,'index'])->name('indexBarang')->middleware('auth');
Route::get('/barang/tambah-barang', [BarangController::class,'formTambahBarang'])->name('formTambahBarang')->middleware('auth');
Route::post('/barang/simpan-barang', [BarangController::class,'simpan'])->name('simpanBarang')->middleware('auth');
Route::post('/barang/update-barang/{id}', [BarangController::class,'update'])->name('updateBarang')->middleware('auth');
Route::post('/barang/delete-barang/{id}', [BarangController::class,'delete'])->name('deleteBarang')->middleware('auth');

Route::get('/gudang', [GudangController::class,'index'])->name('indexGudang')->middleware('auth');

Route::get('/kategori', [KategoriController::class,'index'])->name('indexKategori')->middleware('auth');
Route::post('/kategori/simpan-kategori', [KategoriController::class,'simpan'])->name('simpanKategori')->middleware('auth');
Route::post('/kategori/update-kategori/{id}', [KategoriController::class,'update'])->name('updateKategori')->middleware('auth');
Route::post('/kategori/delete-kategori/{id}', [KategoriController::class,'delete'])->name('deleteKategori')->middleware('auth');

Route::get('/satuan', [SatuanController::class,'index'])->name('indexSatuan')->middleware('auth');
Route::post('/satuan/simpan-satuan', [SatuanController::class,'simpan'])->name('simpanSatuan')->middleware('auth');
Route::post('/satuan/update-satuan/{id}', [SatuanController::class,'update'])->name('updateSatuan')->middleware('auth');
Route::post('/satuan/delete-satuan/{id}', [SatuanController::class,'delete'])->name('deleteSatuan')->middleware('auth');

Route::get('/mutasi', [MutasiController::class,'index'])->name('indexMutasi')->middleware('auth');

// Route::post('/mutasi/masuk/simpan',[MutasiController::class,'simpanMasuk'])->name('simpanMasuk')->middleware('auth');
Route::post('/mutasi/masuk/delete-masuk/{id}',[MutasiController::class,'deleteMasuk'])->name('deleteMasuk')->middleware('auth');

Route::post('/mutasi/keluar/simpan',[MutasiController::class, 'simpanKeluar'])->name('simpanKeluar')->middleware('auth');
Route::post('/mutasi/keluar/delete-keluar/{id}',[MutasiController::class, 'deleteKeluar'])->name('deleteKeluar')->middleware('auth');

Route::post('/mutasi/kembali/simpan',[MutasiController::class, 'simpanKembali'])->name('simpanKembali')->middleware('auth');
Route::post('/mutasi/kembali/delete-kembali/{id}',[MutasiController::class, 'deleteKembali'])->name('deleteKembali')->middleware('auth');

Route::get('/scan', [ScanController::class,'index'])->name('indexScan')->middleware('auth');

Route::get('/jual', [JualController::class, 'index'])->name('indexJual')->middleware('auth');
Route::post('/jual/simpan-jual', [PenjualanController::class, 'simpan'])->name('simpanPenjualan')->middleware('auth');

Route::get('/histori', [HistoriPenjualanController::class, 'index'])->name('indexHistori')->middleware('auth');
Route::get('/histori/{id}', [HistoriPenjualanController::class, 'detail'])->name('detailHistori')->middleware('auth');
Route::post('/histori/delete-penjualan-tunggu/{id}', [HistoriPenjualanController::class,'deletePenjualanTunggu'])->name('deletePenjualanTunggu')->middleware('auth');
Route::post('/histori/selesai-penjualan-tunggu/{id}', [HistoriPenjualanController::class,'selesaiPenjualanTunggu'])->name('selesaiPenjualanTunggu')->middleware('auth');
