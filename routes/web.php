<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

Route::view('templates.profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {

        // 1. Wizard Setup UMKM
        Volt::route('umkm/setup', 'pages.auth.umkm-setup')
            ->name('umkm.setup');

        // 2. Default Dashboard (Pintu Masuk Utama)
        // Route ini biasanya digunakan untuk redirect general
        Route::get('/dashboard', function () {
            $role = auth()->user()->role;

            return match($role) {
                'super_admin' => redirect()->route('admin.dashboard'),
                'admin_umkm'  => redirect()->route('umkm.dashboard'), // Ubah ke route dashboard UMKM
                'worker'      => redirect()->route('worker.dashboard'),
                default       => view('livewire.customer.index'), // Dashboard Customer
            };
        })->name('dashboard');

        // 3. Dashboard Super Admin
        Route::get('/admin/dashboard', function () {
            return view('livewire.superadmin.index');
        })->name('admin.dashboard');

        // 4. Dashboard UMKM (Owner)
        Route::get('/umkm/dashboard', function () {
            return view('livewire.umkm.index'); // Buat view khusus Dashboard Owner UMKM
        })->name('umkm.dashboard');

        // 5. Dashboard Worker
        Route::get('/worker/dashboard', function () {
            return view('livewire.worker.index');
        })->name('worker.dashboard');

        // 6. Dashboard Customer (Spesifik)
        Route::get('/customer/dashboard', function () {
            return view('livewire.customer.index');
        })->name('customer.dashboard');

        Route::get('/onboarding', \App\Livewire\Umkm\Onboarding::class)->name('onboarding');
    });

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
