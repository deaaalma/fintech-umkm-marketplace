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
        Route::get('/orders/{order}/invoice', [\App\Http\Controllers\Customer\InvoiceController::class, 'show'])->name('order-invoice');
        Route::get('/orders/{order}/invoice/download', [\App\Http\Controllers\Customer\InvoiceController::class, 'download'])->name('order-invoice-download');
        Route::get('/orders/{order}/review', \App\Livewire\Customer\Order\Review::class)->name('order-review');
        Route::get('/partners', \App\Livewire\Customer\Partner\Index::class)->name('partners');
        Route::get('/partners/{partner}', \App\Livewire\Customer\Partner\Show::class)->name('partner-detail');
        Route::get('/notifications', \App\Livewire\Customer\Notifications::class)->name('notifications');
        Route::get('/profile', \App\Livewire\Customer\Profile::class)->name('profile');
       
    });

});