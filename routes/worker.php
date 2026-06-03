<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('worker')->name('worker.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\Worker\Index::class)->name('dashboard');
        
        // SOP & Panduan
        Route::get('/sop', \App\Livewire\Worker\Sop\Index::class)->name('sop');

        // Tugas Saya
        Route::get('/tasks', \App\Livewire\Worker\Tasks::class)->name('tasks');

        // Profil
        Route::get('/profile', \App\Livewire\Worker\Profile::class)->name('profile');
        // Notifikasi
        Route::get('/notifications', \App\Livewire\Worker\Notifications::class)->name('notifications');

    });

});