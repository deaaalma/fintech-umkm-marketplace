<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.customer-layout')]
class Index extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // 1. Hitung Pesanan Aktif (Belum selesai atau dibatalkan)
        $activeOrders = Order::with(['umkm', 'product'])
            ->where('customer_id', $userId)
            ->whereIn('status', ['pending_valuation', 'waiting_payment', 'paid', 'processing'])
            ->orderBy('created_at', 'desc')
            ->get();

        $activeOrdersCount = $activeOrders->count();

        // 2. Hitung Pesanan Sukses
        $successOrdersCount = Order::where('customer_id', $userId)
            ->where('status', 'completed')
            ->count();

        // 3. Hitung Pesanan Perlu Tindakan (Step 3: Negotiation atau Step 4: Payment)
        $needsActionCount = $activeOrders->whereIn('current_step', [3, 4])->count();

        // 4. Rekomendasi Partner (Ambil 4 UMKM aktif secara acak)
        $partners = Umkm::where('status', 'active')
            ->where('is_verified', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 5. Jumlah Notifikasi
        $notifications = auth()->user()->userNotifications()->take(5)->get();
        $notifCount = auth()->user()->userNotifications()->whereNull('read_at')->count();

        return view('livewire.customer.index', [
            'activeOrders'       => $activeOrders,
            'activeOrdersCount'  => $activeOrdersCount,
            'successOrdersCount' => $successOrdersCount,
            'needsActionCount'   => $needsActionCount,
            'partners'           => $partners,
            'notifCount'         => $notifCount,
            'notifications'      => $notifications,
        ]);
    }
}
