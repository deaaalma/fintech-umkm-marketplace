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
    public $search = '';

    public function render()
    {
        $userId = Auth::id();

        // 1. Hitung Pesanan Aktif (Belum selesai atau dibatalkan)
        $query = Order::with(['umkm', 'product'])
            ->where('customer_id', $userId)
            ->whereIn('status', ['pending_valuation', 'waiting_payment', 'paid', 'processing']);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->whereHas('product', function($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('umkm', function($q3) {
                      $q3->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $activeOrders = $query->orderBy('created_at', 'desc')->get();

        $activeOrdersCount = $activeOrders->count();

        // 2. Hitung Pesanan Sukses
        $successOrdersCount = Order::where('customer_id', $userId)
            ->where('status', 'completed')
            ->count();

        // 3. Hitung Pesanan Dibatalkan
        $cancelledOrdersCount = Order::where('customer_id', $userId)
            ->where('status', 'cancelled')
            ->count();

        // 4. Hitung Pesanan Perlu Tindakan
        // Kriteria: current_step in [3, 4] ATAU status 'waiting_payment' ATAU (status 'pending_valuation' dan agreed_price tidak null)
        $needsActionCount = $activeOrders->filter(function($order) {
            return in_array($order->current_step, [3, 4]) || 
                   $order->status === 'waiting_payment' || 
                   ($order->status === 'pending_valuation' && !is_null($order->agreed_price));
        })->count();

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
            'activeOrders'         => $activeOrders,
            'activeOrdersCount'    => $activeOrdersCount,
            'successOrdersCount'   => $successOrdersCount,
            'cancelledOrdersCount' => $cancelledOrdersCount,
            'needsActionCount'     => $needsActionCount,
            'partners'             => $partners,
            'notifCount'           => $notifCount,
            'notifications'        => $notifications,
        ]);
    }
}
