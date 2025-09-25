<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Kelola Data
    Route::get('stok-pupuk', [\App\Http\Controllers\Master\StokPupukController::class, 'index'])->name('stok-pupuk.index');
    Route::get('pemasok', [\App\Http\Controllers\Master\PemasokController::class, 'index'])->name('pemasok.index');

    // Transaksi
    Route::get('penjualan', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('pembelian', [\App\Http\Controllers\Transaksi\PembelianController::class, 'index'])->name('pembelian.index');

    // Laporan
    Route::get('laporan', [\App\Http\Controllers\Laporan\LaporanController::class, 'index'])->name('laporan.index');

    // Users
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Pengaturan
    Route::get('settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
