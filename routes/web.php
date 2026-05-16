<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/customer/dashboard/preview', function () {
    return view('templates.customer.dashboard');
})->name('customer.dashboard.preview');

Route::get('/customer/orders/preview', function () {
    return view('templates.customer.orders');
})->name('customer.orders.preview');

Route::get('/customer/partners/preview', function () {
    return view('templates.customer.partners');
})->name('customer.partners.preview');

Route::get('/customer/order-details/preview', function () {
    return view('templates.customer.order-details');
})->name('customer.order-details.preview');

Route::get('/customer/notifications/preview', function () {
    return view('templates.customer.notifications');
})->name('customer.notifications.preview');

Route::get('/customer/chat/preview', function () {
    return view('templates.customer.chat');
})->name('customer.chat.preview');

Route::get('/superadmin/dashboard/preview', function () {
    return view('templates.superadmin.dashboard');
})->name('superadmin.dashboard.preview');

Route::get('/superadmin/users/preview', function () {
    return view('templates.superadmin.users');
})->name('superadmin.users.preview');

Route::get('/superadmin/transactions/preview', function () {
    return view('templates.superadmin.transactions');
})->name('superadmin.transactions.preview');

Route::get('/superadmin/reports/preview', function () {
    return view('templates.superadmin.reports');
})->name('superadmin.reports.preview');

Route::get('/superadmin/settings/preview', function () {
    return view('templates.superadmin.settings');
})->name('superadmin.settings.preview');

Route::view('templates.dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('templates.profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard untuk Customer (Default)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Dashboard Super Admin
    Route::get('/admin/dashboard', function () {
        return view('livewire.superadmin.index'); // Pastikan view ini ada
    })->name('admin.dashboard');

    // 3. Dashboard UMKM
    Route::get('/dashboard', function () {
        return view('livewire.customer.index'); // Tampilan default customer/pembeli
    })->name('dashboard');

    Route::get('/onboarding', \App\Livewire\Umkm\Onboarding::class)->name('onboarding');

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

require __DIR__ . '/auth.php';
