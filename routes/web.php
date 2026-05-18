<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Landing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Template Preview Routes (Hanya untuk keperluan Design/Development)
|--------------------------------------------------------------------------
*/
Route::prefix('templates')->group(function () {
    // 1. Customer Previews
    Route::view('customer/dashboard', 'templates.customer.dashboard')->name('customer.dashboard.preview');
    Route::view('customer/orders', 'templates.customer.orders')->name('customer.orders.preview');
    Route::view('customer/order-details', 'templates.customer.order-details')->name('customer.order-details.preview');
    Route::view('customer/partners', 'templates.customer.partners')->name('customer.partners.preview');
    Route::view('customer/notifications', 'templates.customer.notifications')->name('customer.notifications.preview');
    Route::view('customer/chat', 'templates.customer.chat')->name('customer.chat.preview');

    // 2. Superadmin Previews
    Route::view('superadmin/dashboard', 'templates.superadmin.dashboard')->name('superadmin.dashboard.preview');
    Route::view('superadmin/users', 'templates.superadmin.users')->name('superadmin.users.preview');
    Route::view('superadmin/transactions', 'templates.superadmin.transactions')->name('superadmin.transactions.preview');
    Route::view('superadmin/reports', 'templates.superadmin.reports')->name('superadmin.reports.preview');
    Route::view('superadmin/settings', 'templates.superadmin.settings')->name('superadmin.settings.preview');

    // 3. UMKM Previews
    Route::get('umkm/dashboard', \App\Livewire\AdminUmkm\Index::class)->name('umkm.dashboard.preview');
    Route::get('umkm/orders', \App\Livewire\AdminUmkm\Orders::class)->name('umkm.orders.preview');

    Route::view('/welcome', 'templates.welcome')->name('welcome');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|*/
Route::get('/', \App\Livewire\Landing::class)->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 1. Global Dashboard Redirector ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'superadmin' => redirect()->route('admin.dashboard'),
            'admin_umkm'  => redirect()->route('umkm.dashboard'),
            'worker'      => redirect()->route('worker.dashboard'),
            'customer'    => redirect()->route('customer.dashboard'),
            default       => redirect('/'),
        };
    })->name('dashboard');

    // --- 2. UMKM Setup Wizard (Owner Only) ---
    Volt::route('umkm/setup', 'pages.auth.umkm-setup')->name('umkm.setup');

    // --- 6. Customer Space ---
    Route::prefix('customer')->name('customer.')->group(function () {
         Route::get('/dashboard', \App\Livewire\Customer\Index::class)->name('dashboard');
    });

    // --- 7. Common Auth Routes ---
    Route::view('/profile', 'profile')->name('profile');
});

/*
|--------------------------------------------------------------------------
| Authentication Actions
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/umkm.php';
require __DIR__ . '/worker.php';