<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\RegisterController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/index',[UserController::class,'indexuser']);



Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/admin',[AdminController::class,'index'])->name('admin')->middleware('admin');

Route::get('/indexproduk', [ProdukController::class, 'index'])->name('indexproduk')->middleware('admin');
Route::get('/createproduk', [ProdukController::class, 'create'])->name('createproduk')->middleware('admin');
Route::post('/storeproduk', [ProdukController::class, 'store'])->middleware('admin');

Route::get('/editproduk/{produk}', [ProdukController::class, 'edit'])->name('editproduk')->middleware('admin');
Route::post('/updateproduk', [ProdukController::class, 'update'])->name('updateproduk')->middleware('admin');
Route::post('/deleteproduk/{id}',[ProdukController::class,'destroy'])->name('deleteproduk')->middleware('admin');

Route::post('/approvepengguna/{id}',[PenggunaController::class,'approve'])->middleware('admin');
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna')->middleware('admin');
Route::post('/approvepengguna', [PenggunaController::class, 'approve'])->name('approvepengguna');



