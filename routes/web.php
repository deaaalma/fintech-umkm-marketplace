<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/customer/dashboard/preview', function () {
    return view('customer.dashboard');
})->name('customer.dashboard.preview');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard untuk Customer (Default)
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // 2. Dashboard Super Admin
    Route::get('/admin/dashboard', function () {
        return view('livewire.admin.index'); // Pastikan view ini ada
    })->name('admin.dashboard');

    // 3. Dashboard UMKM
    Route::get('/umkm/dashboard', function () {
        return view('livewire.umkm.index'); // Pastikan view ini ada
    })->name('umkm.dashboard');

    // 4. Dashboard Worker
    Route::get('/worker/dashboard', function () {
        return view('livewire.worker.index'); // Pastikan view ini ada
    })->name('worker.dashboard');

    // 5. Dashboard Customer
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';
