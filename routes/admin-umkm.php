<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified', 'role:admin_umkm'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('umkm')->name('umkm.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\AdminUmkm\Index::class)->name('dashboard');

        Route::get('/orders', \App\Livewire\AdminUmkm\Order\Index::class)->name('orders');

    });

});