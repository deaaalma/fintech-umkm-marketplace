<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {

    // --- 3. Super Admin Space ---
    // Tambahkan middleware 'role:super_admin' (pastikan nama role sesuai database)
    Route::prefix('customer')->name('customer.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', \App\Livewire\Customer\Index::class)->name('dashboard');
        Route::get('/orders', \App\Livewire\Customer\Order\Index::class)->name('orders');
        Route::get('/orders/{order}', \App\Livewire\Customer\Order\Show::class)->name('order-details');
        Route::get('/partners', \App\Livewire\Customer\Partner\Index::class)->name('partners');
       
    });

});