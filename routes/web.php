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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);

Route::get('/transaction', [TransactionController::class, 'index']);

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/foodAndBeverage', [FnBController::class, 'index']);

Route::get('/beautyHealth', [BnHController::class, 'index']);

Route::get('/homeCare', [HCController::class, 'index']);

Route::get('/babyKid', [BKController::class, 'index']);