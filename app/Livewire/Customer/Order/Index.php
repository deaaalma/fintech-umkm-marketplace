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
    public function updatedStatusFilter() { $this->resetPage(); }
    public function updatedDateRange() { $this->resetPage(); }

    public function render()
    {
        $userId = auth()->id();
        $query = Order::where('customer_id', $userId)->with(['umkm', 'product'])->latest();

        // Search Logic
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%'.$this->search.'%')
                  ->orWhereHas('umkm', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'))
                  ->orWhereHas('product', fn($p) => $p->where('name', 'like', '%'.$this->search.'%'));
            });
        }

        // Tab Logic (Mockup categories)
        if ($this->activeTab === 'menunggu_review') {
            $query->where('status', 'pending_valuation')->whereNull('agreed_price');
        } elseif ($this->activeTab === 'negosiasi') {
            $query->where('status', 'pending_valuation')->whereNotNull('agreed_price');
        } elseif ($this->activeTab === 'payment') {
            $query->where('status', 'waiting_payment');
        } elseif ($this->activeTab === 'in_progress') {
            $query->whereIn('status', ['paid', 'processing']);
        } elseif ($this->activeTab === 'completed') {
            $query->where('status', 'completed');
        } elseif ($this->activeTab === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        // Dropdown Status Filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Date Range Filter
        if (count($this->dateRange) === 2) {
            $query->whereBetween('created_at', [$this->dateRange[0] . ' 00:00:00', $this->dateRange[1] . ' 23:59:59']);
        }

        $ordersRaw = $query->paginate(6);

        // Map Data for UI
        $orders = collect($ordersRaw->items())->map(function($o) {
            return [
                'id' => $o->id,
                'invoice' => $o->invoice_number ?? 'INV-'.$o->id,
                'service_name' => $o->product->name ?? 'Layanan Tidak Diketahui',
                'status' => $o->status,
                'price' => $o->agreed_price ?? 0,
                'agreed_price' => $o->agreed_price,
                'date' => $o->created_at->translatedFormat('d F Y'),
                'time' => $o->created_at->format('H:i'),
                'booking_date' => $o->booking_date ? \Carbon\Carbon::parse($o->booking_date)->translatedFormat('d F Y') : '-',
                'booking_time' => $o->booking_time ?? '-',
                'location' => $o->service_address ?? 'Alamat tidak tersedia',
                'provider' => $o->umkm->name ?? 'Partner JOS',
                'cancel_reason' => $o->cancellation_reason ?? 'Dibatalkan oleh sistem atau pengguna.',
            ];
        });

        // Generate Counts for Tabs
        $baseQuery = Order::where('customer_id', $userId);
        
        $tabs = [
            ['id' => 'semua', 'label' => 'All', 'count' => (clone $baseQuery)->count()],
            ['id' => 'menunggu_review', 'label' => 'Menunggu Review', 'count' => (clone $baseQuery)->where('status', 'pending_valuation')->whereNull('agreed_price')->count()],
            ['id' => 'negosiasi', 'label' => 'Negosiasi', 'count' => (clone $baseQuery)->where('status', 'pending_valuation')->whereNotNull('agreed_price')->count()],
            ['id' => 'payment', 'label' => 'Payment', 'count' => (clone $baseQuery)->where('status', 'waiting_payment')->count()],
            ['id' => 'in_progress', 'label' => 'In Progress', 'count' => (clone $baseQuery)->whereIn('status', ['paid', 'processing'])->count()],
            ['id' => 'completed', 'label' => 'Completed', 'count' => (clone $baseQuery)->where('status', 'completed')->count()],
            ['id' => 'cancelled', 'label' => 'Cancelled', 'count' => (clone $baseQuery)->where('status', 'cancelled')->count()],
        ];

        return view('livewire.customer.order.index', [
            'orders' => $orders,
            'orders_pagination' => $ordersRaw,
            'tabs' => $tabs
        ]);
    }
}