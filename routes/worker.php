<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('worker')->name('worker.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\Worker\Index::class)->name('dashboard');

        

    });

});