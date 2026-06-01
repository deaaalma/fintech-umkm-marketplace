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

        Route::get('/services/create', \App\Livewire\AdminUmkm\Product\Create::class)->name('services.create');
        Route::get('/services/{id}/edit', \App\Livewire\AdminUmkm\Product\Edit::class)->name('services.edit');
        Route::get('/services', \App\Livewire\AdminUmkm\Product\Index::class)->name('services');

        Route::get('/verification', \App\Livewire\AdminUmkm\Verification::class)->name('verification');
        Route::get('/staff', \App\Livewire\AdminUmkm\Staff\Index::class)->name('staff');

       
    });

});