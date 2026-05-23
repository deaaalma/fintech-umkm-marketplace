<?php

namespace App\Livewire\Customer\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Index extends Component
{
    use WithPagination;

    public $activeTab = 'semua';
    public $search = '';
    public $statusFilter = '';
    public $dateRange = [];

    protected $queryString = ['activeTab', 'search', 'statusFilter'];

    public function updatedSearch() { $this->resetPage(); }
    public function updatedActiveTab() { $this->resetPage(); }

    public function render()
    {
        $userId = auth()->id();
        $query = Order::where('customer_id', $userId)->with('umkm')->latest();

        // Search Logic
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%'.$this->search.'%')
                  ->orWhereHas('umkm', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
            });
        }

        // Tab Logic
        if ($this->activeTab === 'menunggu') {
            $query->whereIn('status', ['pending_valuation', 'waiting_payment']);
        } elseif ($this->activeTab === 'proses') {
            $query->whereIn('status', ['paid', 'processing']);
        } elseif ($this->activeTab === 'selesai') {
            $query->where('status', 'completed');
        }

        // Dropdown Status Filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Date Range Filter
        if (count($this->dateRange) === 2) {
            $query->whereBetween('created_at', [$this->dateRange[0], $this->dateRange[1]]);
        }

        $ordersRaw = $query->paginate(6);

        // Map Data for UI
        $orders = collect($ordersRaw->items())->map(function($o) {
            return [
                'id' => $o->id,
                'invoice' => $o->invoice_number ?? 'INV-'.$o->id,
                'service_name' => 'Layanan JOS', // Bisa ganti dengan product name jika ada relasi
                'status' => $o->status,
                'date' => $o->created_at->format('d M Y'),
                'booking_date' => $o->booking_date ? $o->booking_date->format('d M Y') : '-',
                'booking_time' => $o->booking_time ?? '-',
                'location' => $o->service_address ?? 'Denpasar, Bali',
                'provider' => $o->umkm->name ?? 'Partner JOS',
            ];
        });

        $tabs = [
            ['id' => 'semua', 'label' => 'Semua', 'count' => Order::where('customer_id', $userId)->count()],
            ['id' => 'menunggu', 'label' => 'Menunggu', 'count' => Order::where('customer_id', $userId)->whereIn('status', ['pending_valuation', 'waiting_payment'])->count()],
            ['id' => 'proses', 'label' => 'Proses', 'count' => Order::where('customer_id', $userId)->whereIn('status', ['paid', 'processing'])->count()],
            ['id' => 'selesai', 'label' => 'Selesai', 'count' => Order::where('customer_id', $userId)->where('status', 'completed')->count()],
        ];

        return view('livewire.customer.order.index', [
            'orders' => $orders,
            'orders_pagination' => $ordersRaw,
            'tabs' => $tabs
        ]);
    }
}