<?php

namespace App\Livewire\AdminUmkm;

use App\Models\Order;
use App\Models\Umkm;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    public $search = '';

    public function render()
    {
        // Pastikan user punya umkm_id, jika tidak ada set 0 agar tidak error
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id') ?? 0;

        // 1. Query Orders Terbaru
        $ordersQuery = Order::where('umkm_id', $umkmId)
            ->with(['customer', 'product'])
            ->latest();

        if ($this->search) {
            $ordersQuery->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($query) {
                      $query->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $recentOrders = $ordersQuery->where('status', 'pending_valuation')->limit(4)->get();

        // 2. Statistik Riil (Gunakan umkm_net_income untuk balance)
        $stats = [
            'new_orders'     => Order::where('umkm_id', $umkmId)->where('status', 'pending_valuation')->count(),
            'total_balance'  => Order::where('umkm_id', $umkmId)->whereIn('status', ['paid', 'processing', 'completed'])->sum('agreed_price'),
            'active_orders'  => Order::where('umkm_id', $umkmId)->whereIn('status', ['paid', 'processing'])->count(),
        ];

        // 4. Live Pipeline (Berdasarkan enum aslimu)
        $pipeline = [
            'New'        => Order::where('umkm_id', $umkmId)->where('status', 'pending_valuation')->count(),
            'Waiting'    => Order::where('umkm_id', $umkmId)->where('status', 'waiting_payment')->count(),
            'Paid'       => Order::where('umkm_id', $umkmId)->where('status', 'paid')->count(),
            'Processing' => Order::where('umkm_id', $umkmId)->where('status', 'processing')->count(),
            'Completed'  => Order::where('umkm_id', $umkmId)->where('status', 'completed')->count(),
            'Cancelled'  => Order::where('umkm_id', $umkmId)->where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin-umkm.index', [
            'recentOrders' => $recentOrders,
            'stats'        => $stats,
            'pipeline'     => $pipeline
        ]);
    }
}