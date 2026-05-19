<?php

namespace App\Livewire\AdminUmkm\Order;

use App\Models\Order;
use App\Models\Umkm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
   use WithPagination;

    public $search = '';
    public $category = 'All';
    public $status = 'All';
    public $showFilters = false;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategory() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'status']);
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        $query = Order::where('umkm_id', $umkmId)->with('customer')->latest();

        // Filter Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($c) {
                      $c->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filter Category (Tabs)
        if ($this->category == 'Active') {
            $query->whereIn('status', ['pending_valuation', 'waiting_payment', 'paid', 'processing']);
        } elseif ($this->category == 'History') {
            $query->whereIn('status', ['completed', 'cancelled']);
        }

        // Filter Status Dropdown
        if ($this->status != 'All') {
            $query->where('status', $this->status);
        }

        $ordersRaw = $query->paginate(10);

        // Mapping Data untuk UI
        $orders = collect($ordersRaw->items())->map(function($order) {
            $statusMap = [
                'pending_valuation' => ['color' => 'amber', 'label' => 'Pending'],
                'waiting_payment'   => ['color' => 'orange', 'label' => 'Waiting'],
                'paid'              => ['color' => 'teal',   'label' => 'Paid'],
                'processing'        => ['color' => 'blue',   'label' => 'Active'],
                'completed'         => ['color' => 'green',  'label' => 'Done'],
                'cancelled'         => ['color' => 'red',    'label' => 'Canceled'],
            ];

            $info = $statusMap[$order->status] ?? ['color' => 'slate', 'label' => $order->status];

            return [
                'id'     => $order->invoice_number ?? 'INV-'.$order->id,
                'client' => $order->customer->name ?? 'Guest',
                'price'  => 'Rp ' . number_format($order->agreed_price, 0, ',', '.'),
                'status' => $info['label'],
                'color'  => $info['color'],
                'time'   => $order->created_at->format('H:i A'),
            ];
        });

        return view('livewire.admin-umkm.order.index', [
            'orders' => $orders,
            'orders_pagination' => $ordersRaw
        ]);
    }
}
