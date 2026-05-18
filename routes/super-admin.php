<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\SuperAdmin\Index::class)->name('dashboard');
        Route::get('/dashboard/users', \App\Livewire\SuperAdmin\User\Index::class)->name('dashboard.users');
        Route::get('/dashboard/transactions', \App\Livewire\SuperAdmin\Transaction\Index::class)->name('dashboard.transactions');

        

        

    });

});