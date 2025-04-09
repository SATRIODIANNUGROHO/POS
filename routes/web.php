<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FnBController;
use App\Http\Controllers\BnHController;
use App\Http\Controllers\HCController;
use App\Http\Controllers\BKController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\LevelUserController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiPenjualanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);            // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);        // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);     // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);           // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);         // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);    // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);       // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']);   // menghapus data user
});

// Route untuk Level User
Route::group(['prefix' => 'level-user'], function () {
    Route::get('/', [LevelUserController::class, 'index']);
    Route::post('/list', [LevelUserController::class, 'list']);
    Route::get('/create', [LevelUserController::class, 'create']);
    Route::post('/', [LevelUserController::class, 'store']);
    Route::get('/create_ajax', [LevelUserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [LevelUserController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [LevelUserController::class, 'show']);
    Route::get('/{id}/edit', [LevelUserController::class, 'edit']);
    Route::put('/{id}', [LevelUserController::class, 'update']);
    Route::get('/{id}/edit_ajax', [LevelUserController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [LevelUserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [LevelUserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [LevelUserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [LevelUserController::class, 'destroy']);
});

// Route untuk Kategori Barang
Route::group(['prefix' => 'kategori-barang'], function () {
    Route::get('/', [KategoriBarangController::class, 'index']);
    Route::post('/list', [KategoriBarangController::class, 'list']);
    Route::get('/create', [KategoriBarangController::class, 'create']);
    Route::post('/', [KategoriBarangController::class, 'store']);
    Route::get('/create_ajax', [KategoriBarangController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [KategoriBarangController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [KategoriBarangController::class, 'show']);
    Route::get('/{id}/edit', [KategoriBarangController::class, 'edit']);
    Route::put('/{id}', [KategoriBarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [KategoriBarangController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [KategoriBarangController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [KategoriBarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [KategoriBarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [KategoriBarangController::class, 'destroy']);
});

// Route untuk Data Barang
Route::group(['prefix' => 'data-barang'], function () {
    Route::get('/', [DataBarangController::class, 'index']);
    Route::post('/list', [DataBarangController::class, 'list']);
    Route::get('/create', [DataBarangController::class, 'create']);
    Route::post('/', [DataBarangController::class, 'store']);
    Route::get('/create_ajax', [DataBarangController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [DataBarangController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [DataBarangController::class, 'show']);
    Route::get('/{id}/edit', [DataBarangController::class, 'edit']);
    Route::put('/{id}', [DataBarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [DataBarangController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [DataBarangController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [DataBarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [DataBarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [DataBarangController::class, 'destroy']);
});

// Route untuk Stok Barang
Route::group(['prefix' => 'stok-barang'], function () {
    Route::get('/', [StokBarangController::class, 'index']);
    Route::post('/list', [StokBarangController::class, 'list']);
    Route::get('/create', [StokBarangController::class, 'create']);
    Route::post('/', [StokBarangController::class, 'store']);
    Route::get('/create_ajax', [StokBarangController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [StokBarangController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [StokBarangController::class, 'show']);
    Route::get('/{id}/edit', [StokBarangController::class, 'edit']);
    Route::put('/{id}', [StokBarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [StokBarangController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [StokBarangController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [StokBarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [StokBarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [StokBarangController::class, 'destroy']);
});

// Route untuk Transaksi Penjualan
Route::group(['prefix' => 'transaksi-penjualan'], function () {
    Route::get('/', [TransaksiPenjualanController::class, 'index']);
    Route::post('/list', [TransaksiPenjualanController::class, 'list']);
    Route::get('/create', [TransaksiPenjualanController::class, 'create']);
    Route::post('/', [TransaksiPenjualanController::class, 'store']);
    Route::get('/create_ajax', [TransaksiPenjualanController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [TransaksiPenjualanController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [TransaksiPenjualanController::class, 'show']);
    Route::get('/{id}/edit', [TransaksiPenjualanController::class, 'edit']);
    Route::put('/{id}', [TransaksiPenjualanController::class, 'update']);
    Route::get('/{id}/edit_ajax', [TransaksiPenjualanController::class, 'edit_ajax']);    // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [TransaksiPenjualanController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [TransaksiPenjualanController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [TransaksiPenjualanController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    Route::delete('/{id}', [TransaksiPenjualanController::class, 'destroy']);
});

Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);

Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

Route::get('/user/hapus/{id}', [UserController:: class, 'hapus']);

Route::get('/level', [LevelController::class, 'index']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/kategori/create', [KategoriController::class, 'create']);

Route::post('/kategori', [KategoriController::class, 'store']);

Route::get('/user', [UserController::class, 'index']);

Route::get('/transaction', [TransactionController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/foodAndBeverage', [FnBController::class, 'index']);

Route::get('/beautyHealth', [BnHController::class, 'index']);

Route::get('/homeCare', [HCController::class, 'index']);

Route::get('/babyKid', [BKController::class, 'index']);

Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit']);

Route::put('/kategori/{id}', [KategoriController::class, 'update']);

Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);