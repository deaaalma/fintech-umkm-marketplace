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
        $activeOrdersCount = Order::where('customer_id', $userId)
            ->whereIn('status', ['pending_valuation', 'waiting_payment', 'paid', 'processing'])
            ->count();

        // 2. Hitung Pesanan Sukses
        $successOrdersCount = Order::where('customer_id', $userId)
            ->where('status', 'completed')
            ->count();

        // 3. Ambil Pesanan Terbaru (Maksimal 5, beserta data UMKM & Produk)
        $recentOrder = Order::with(['umkm', 'product'])
            ->where('customer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get()
            ->first();

        // 4. Rekomendasi Partner (Ambil 4 UMKM aktif secara acak)
        $partners = Umkm::where('status', 'active')
            ->where('is_verified', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 5. Jumlah Notifikasi
        $notifications = auth()->user()->userNotifications()->take(5)->get()->map(function($n) {
            return [
                'message' => $n->title, // atau combine dengan message
                'time' => $n->created_at->diffForHumans(),
                'is_read' => $n->read_at !== null,
                'link' => $n->link
            ];
        });

        $notifCount = auth()->user()->userNotifications()->whereNull('read_at')->count();

        return view('livewire.customer.index', [
            'activeOrdersCount'  => $activeOrdersCount,
            'successOrdersCount' => $successOrdersCount,
            'recentOrder'       => $recentOrder,
            'partners'           => $partners,
            'notifCount'         => $notifCount,
            'notifications'      => $notifications,
        ]);
    }
}
