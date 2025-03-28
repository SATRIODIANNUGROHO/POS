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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);            // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);        // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);     // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);           // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);         // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);    // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);       // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);   // menghapus data user
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