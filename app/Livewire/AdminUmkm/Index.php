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

        // 1. Query Orders Terbaru (Sesuaikan invoice_number & status enum)
        $ordersQuery = Order::where('umkm_id', $umkmId)
            ->with(['customer']) // Pastikan di model Order ada method customer()
            ->latest();

        if ($this->search) {
            $ordersQuery->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($query) {
                      $query->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $recentOrdersRaw = $ordersQuery->limit(5)->get();

        // 2. Mapping Data ke UI (Sesuaikan dengan enum tabel kamu)
        $recentOrders = $recentOrdersRaw->map(function($order) {
            $statusMap = [
                'pending_valuation' => ['color' => 'amber', 'label' => 'Pending'],
                'waiting_payment'   => ['color' => 'orange', 'label' => 'Waiting'],
                'paid'              => ['color' => 'teal',   'label' => 'Paid'],
                'processing'        => ['color' => 'blue',   'label' => 'Active'],
                'completed'         => ['color' => 'green',  'label' => 'Done'],
                'cancelled'         => ['color' => 'red',    'label' => 'Canceled'],
            ];

            $statusInfo = $statusMap[$order->status] ?? ['color' => 'slate', 'label' => $order->status];

            return [
                'id_raw' => $order->id,
                'id'     => $order->invoice_number ?? 'ORDER-'.$order->id,
                'client' => $order->customer->name ?? 'Guest',
                'status' => $statusInfo['label'],
                'color'  => $statusInfo['color'],
                'time'   => $order->created_at->format('H:i'),
            ];
        });

        // 3. Statistik Riil (Gunakan umkm_net_income untuk balance)
        $stats = [
            'new_orders'     => Order::where('umkm_id', $umkmId)->where('status', 'waiting_payment')->count(),
            'total_balance'  => Order::where('umkm_id', $umkmId)->where('status', 'paid')->sum('umkm_net_income'),
            'active_orders'  => Order::where('umkm_id', $umkmId)->where('status', 'processing')->count(),
        ];

        // 4. Live Pipeline (Berdasarkan enum aslimu)
        $pipeline = [
            'Waiting'    => Order::where('umkm_id', $umkmId)->where('status', 'waiting_payment')->count(),
            'Paid'       => Order::where('umkm_id', $umkmId)->where('status', 'paid')->count(),
            'Processing' => Order::where('umkm_id', $umkmId)->where('status', 'processing')->count(),
            'Completed'  => Order::where('umkm_id', $umkmId)->where('status', 'completed')->count(),
        ];

        return view('livewire.admin-umkm.index', [
            'recentOrders' => $recentOrders,
            'stats'        => $stats,
            'pipeline'     => $pipeline
        ]);
    }
}