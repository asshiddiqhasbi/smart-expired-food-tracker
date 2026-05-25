<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile (semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Produk — admin, petugas_gudang, petugas_qc
    Route::resource('products', ProductController::class)
         ->middleware('role:admin,petugas_gudang,petugas_qc');

    // CRUD Kategori — admin, petugas_qc
    Route::resource('categories', CategoryController::class)
        ->middleware('role:admin,petugas_qc');

    // CRUD Lokasi — admin, petugas_gudang
    Route::resource('locations', LocationController::class)
        ->middleware('role:admin,petugas_gudang');

    // Stok Masuk — admin, petugas_gudang, supplier
    Route::resource('stock-ins', StockInController::class)
        ->middleware('role:admin,petugas_gudang,supplier')
        ->only(['index', 'create', 'store', 'show', 'destroy']);

    // Stok Masuk per Produk
    Route::get('products/{product}/stock-ins', [StockInController::class, 'byProduct'])
        ->middleware('role:admin,petugas_gudang,supplier,petugas_qc')
        ->name('products.stock-ins');

    // Stok Keluar — admin, petugas_gudang
    Route::resource('stock-outs', StockOutController::class)
        ->middleware('role:admin,petugas_gudang')
        ->only(['index', 'create', 'store', 'show', 'destroy']);

    // Notifikasi — admin, petugas_gudang, petugas_qc
    Route::middleware('role:admin,petugas_gudang,petugas_qc')->group(function () {
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    // Laporan — admin, manajer
    Route::get('laporan', [LaporanController::class, 'index'])
        ->middleware('role:admin,manajer')
        ->name('laporan.index');

    // Audit Trail — admin, manajer
    Route::get('activity-logs', [ActivityLogController::class, 'index'])
        ->middleware('role:admin,manajer')
        ->name('activity-logs.index');

    // Barcode lookup
    Route::get('barcode/lookup', [App\Http\Controllers\BarcodeController::class, 'lookup'])
        ->middleware('role:admin,petugas_gudang,supplier')
        ->name('barcode.lookup');
});

require __DIR__.'/auth.php';