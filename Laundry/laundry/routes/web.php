<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;

use App\Models\Layanan;

Route::get('/', function () {
    $layanans = Layanan::all();
    return view('home', compact('layanans'));
});

Route::resource('pelanggan', PelangganController::class);
Route::resource('layanan', LayananController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('pengeluaran', PengeluaranController::class);
Route::resource('laporan', LaporanController::class);
Route::get('my-orders', [PelangganController::class, 'myOrders'])->name('my.orders')->middleware('auth');
Route::get('laporan-export-csv', [LaporanController::class, 'exportCSV'])->name('laporan.export.csv');
Route::get('laporan-export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export.pdf');

Route::get('login', [PelangganController::class, 'showLogin'])->name('login');
Route::post('login', [PelangganController::class, 'authenticate']);
Route::get('logout', [PelangganController::class, 'logout'])->name('logout');

Route::get('register', [PelangganController::class, 'showRegister'])->name('register');
Route::post('register', [PelangganController::class, 'storeUser']);

Route::get('dashboard', [PelangganController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('pos', [TransaksiController::class, 'create'])->name('pos')->middleware('auth');

// DOKU QRIS Routes
Route::get('doku/qris/{id}', [\App\Http\Controllers\DokuController::class, 'showQris'])->name('doku.qris')->middleware('auth');
Route::post('doku/simulate/{id}', [\App\Http\Controllers\DokuController::class, 'simulateSuccess'])->name('doku.simulate');
Route::post('doku/callback', [\App\Http\Controllers\DokuController::class, 'callback'])->name('doku.callback');
