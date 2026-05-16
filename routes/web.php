<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome');

/*
|--------------------------------------------------------------------------
| Template Preview Routes (Hanya untuk keperluan Design/Development)
|--------------------------------------------------------------------------
*/
Route::prefix('templates')->name('templates.')->group(function () {
    // Customer Previews
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::view('/dashboard', 'templates.customer.dashboard')->name('dashboard');
        Route::view('/orders', 'templates.customer.orders')->name('orders');
        Route::view('/order-details', 'templates.customer.order-details')->name('order-details');
        Route::view('/partners', 'templates.customer.partners')->name('partners');
        Route::view('/notifications', 'templates.customer.notifications')->name('notifications');
        Route::view('/chat', 'templates.customer.chat')->name('chat');
    });

    // Superadmin Previews
    Route::prefix('superadmin')->name('superadmin.')->group(function () {
        Route::view('/dashboard', 'templates.superadmin.dashboard')->name('dashboard');
        Route::view('/users', 'templates.superadmin.users')->name('users');
        Route::view('/transactions', 'templates.superadmin.transactions')->name('transactions');
        Route::view('/reports', 'templates.superadmin.reports')->name('reports');
        Route::view('/settings', 'templates.superadmin.settings')->name('settings');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 1. Global Dashboard Redirector ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'admin_umkm'  => redirect()->route('umkm.dashboard'),
            'worker'      => redirect()->route('worker.dashboard'),
            'customer'    => redirect()->route('customer.dashboard'),
            default       => redirect('/'),
        };
    })->name('dashboard');

    // --- 2. UMKM Setup Wizard (Owner Only) ---
    Volt::route('umkm/setup', 'pages.auth.umkm-setup')->name('umkm.setup');

    // --- 3. Super Admin Space ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\SuperAdmin\Index::class)->name('dashboard');
    });

    // --- 4. UMKM Owner Space ---
    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/dashboard', function () {
            return view('livewire.umkm.index');
        })->name('dashboard');
        Route::get('/onboarding', \App\Livewire\Umkm\Onboarding::class)->name('onboarding');
    });

    // --- 5. Worker Space ---
    Route::prefix('worker')->name('worker.')->group(function () {
        Route::get('/dashboard', function () {
            return view('livewire.worker.index');
        })->name('dashboard');
    });

    // --- 6. Customer Space ---
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('livewire.customer.index');
        })->name('dashboard');
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