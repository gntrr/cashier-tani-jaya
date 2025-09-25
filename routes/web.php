<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\DashboardController::class,'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Kelola Data
    // Transaksi yang boleh diakses kasir & admin
    // Penjualan
    Route::get('penjualan', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('penjualan/create', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('penjualan', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan/{penjualan}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('penjualan/{penjualan}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    // Pembelian
    Route::get('pembelian', [\App\Http\Controllers\Transaksi\PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('pembelian/create', [\App\Http\Controllers\Transaksi\PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('pembelian', [\App\Http\Controllers\Transaksi\PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('pembelian/{pembelian}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'show'])->name('pembelian.show');
    Route::delete('pembelian/{pembelian}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'destroy'])->name('pembelian.destroy');

    // Group khusus admin
    Route::middleware('admin')->group(function () {
        // Kelola Data
        // Pupuk CRUD
        Route::get('stok-pupuk', [\App\Http\Controllers\Master\StokPupukController::class, 'index'])->name('stok-pupuk.index');
        Route::get('stok-pupuk/create', [\App\Http\Controllers\Master\StokPupukController::class, 'create'])->name('stok-pupuk.create');
        Route::post('stok-pupuk', [\App\Http\Controllers\Master\StokPupukController::class, 'store'])->name('stok-pupuk.store');
        Route::get('stok-pupuk/{pupuk}/edit', [\App\Http\Controllers\Master\StokPupukController::class, 'edit'])->name('stok-pupuk.edit');
        Route::put('stok-pupuk/{pupuk}', [\App\Http\Controllers\Master\StokPupukController::class, 'update'])->name('stok-pupuk.update');
        Route::delete('stok-pupuk/{pupuk}', [\App\Http\Controllers\Master\StokPupukController::class, 'destroy'])->name('stok-pupuk.destroy');

        // Pemasok CRUD
        Route::get('pemasok', [\App\Http\Controllers\Master\PemasokController::class, 'index'])->name('pemasok.index');
        Route::get('pemasok/create', [\App\Http\Controllers\Master\PemasokController::class, 'create'])->name('pemasok.create');
        Route::post('pemasok', [\App\Http\Controllers\Master\PemasokController::class, 'store'])->name('pemasok.store');
        Route::get('pemasok/{pemasok}/edit', [\App\Http\Controllers\Master\PemasokController::class, 'edit'])->name('pemasok.edit');
        Route::put('pemasok/{pemasok}', [\App\Http\Controllers\Master\PemasokController::class, 'update'])->name('pemasok.update');
        Route::delete('pemasok/{pemasok}', [\App\Http\Controllers\Master\PemasokController::class, 'destroy'])->name('pemasok.destroy');

        // Laporan
        Route::get('laporan', [\App\Http\Controllers\Laporan\LaporanController::class, 'index'])->name('laporan.index');

        // Users
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

        // Pengaturan
        Route::get('settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    });
});

require __DIR__.'/auth.php';
