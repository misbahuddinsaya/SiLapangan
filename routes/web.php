<?php

use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/pemesanan-gor', [PemesananController::class, 'Gor'])->name('pemesanan-gor');
Route::get('/pemesanan-lapangan', [PemesananController::class, 'Lapangan'])->name('pemesanan-lapangan');

// Pemesanan
Route::post('/pemesanan-lapangan', [PemesananController::class, 'simpanPemesanan'])->name('simpan');