<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\SuperAdmin\Index::class)->name('dashboard');
        Route::get('/dashboard/users', \App\Livewire\SuperAdmin\UserManagement::class)->name('dashboard.users');
        Route::get('/dashboard/umkm', \App\Livewire\SuperAdmin\UmkmManagement::class)->name('dashboard.umkm');
        Route::get('/dashboard/umkm/{umkm:slug}', \App\Livewire\SuperAdmin\UmkmDetail::class)->name('dashboard.umkm.detail');
        Route::get('/dashboard/transactions', \App\Livewire\SuperAdmin\Transaction\Index::class)->name('dashboard.transactions');
        Route::get('/dashboard/reports', \App\Livewire\SuperAdmin\Report\Index::class)->name('dashboard.reports');
        Route::get('/dashboard/settings', \App\Livewire\SuperAdmin\Setting\Index::class)->name('dashboard.settings');

        

        

    });

});