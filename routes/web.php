<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [\App\Http\Controllers\DashboardController::class,'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::get('/api/chart-data', [\App\Http\Controllers\DashboardController::class,'chartData'])
    ->middleware(['auth','verified'])
    ->name('dashboard.chart-data');

Route::middleware('auth')->group(function () {
    // Profile: sekarang kasir juga boleh edit & update profil sendiri (hapus pembatasan sebelumnya)
    Route::get('/profile', function(){
        $user = request()->user();
        if(\App\Helpers\RoleHelper::isKasir($user)){
            return view('profile.kasir_edit', ['user'=>$user]);
        }
        return app(ProfileController::class)->edit(request());
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Hapus akun tetap dibatasi admin untuk keamanan
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('admin')->name('profile.destroy');
    // AJAX util untuk kasir
    Route::get('ajax/pupuk/search', [\App\Http\Controllers\DashboardController::class,'searchPupuk'])
        ->name('ajax.pupuk.search');
    Route::post('ajax/penjualan/quick-store', [\App\Http\Controllers\DashboardController::class,'quickStorePenjualan'])
        ->name('ajax.penjualan.quick-store');
    // Kelola Data
    // Transaksi yang boleh diakses kasir & admin
    // Penjualan
    Route::get('penjualan', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('penjualan/create', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('penjualan', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan/{penjualan}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('penjualan/{penjualan}/struk', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'receipt'])->name('penjualan.receipt');
    Route::delete('penjualan/{penjualan}', [\App\Http\Controllers\Transaksi\PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    // Pembelian
    Route::get('pembelian', [\App\Http\Controllers\Transaksi\PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('pembelian/create', [\App\Http\Controllers\Transaksi\PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('pembelian', [\App\Http\Controllers\Transaksi\PembelianController::class, 'store'])->name('pembelian.store');
    // Tambahan edit/update harus didefinisikan sebelum show agar tidak tertangkap oleh {pembelian}
    Route::get('pembelian/{pembelian}/edit', [\App\Http\Controllers\Transaksi\PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('pembelian/{pembelian}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'update'])->name('pembelian.update');
    Route::get('pembelian/{pembelian}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'show'])->name('pembelian.show');
    Route::delete('pembelian/{pembelian}', [\App\Http\Controllers\Transaksi\PembelianController::class, 'destroy'])->name('pembelian.destroy');

    // Riwayat Kasir (read-only penjualan)
    Route::get('riwayat', [\App\Http\Controllers\Kasir\RiwayatController::class,'index'])->name('kasir.riwayat.index');
    Route::get('riwayat/{penjualan}', [\App\Http\Controllers\Kasir\RiwayatController::class,'show'])->name('kasir.riwayat.show');

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
    Route::get('laporan/penjualan.pdf', [\App\Http\Controllers\Laporan\LaporanController::class, 'penjualanPdf'])->name('laporan.penjualan.pdf');
    Route::get('laporan/pembelian.pdf', [\App\Http\Controllers\Laporan\LaporanController::class, 'pembelianPdf'])->name('laporan.pembelian.pdf');

        // Users
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        // Pengaturan
        Route::get('/settings', function () {
            $user = Auth::user();
            return redirect()->route('users.edit', $user);
        })->name('settings.index')->middleware('auth');
    });
});

require __DIR__.'/auth.php';
