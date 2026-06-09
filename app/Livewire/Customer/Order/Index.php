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

    public $search = '';
    public $statusFilter = '';
    public $dateRange = [];

    protected $queryString = ['search', 'statusFilter'];

    public function updatedSearch() { $this->resetPage(); }
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

        // Dropdown Status Filter
        if ($this->statusFilter) {
            if ($this->statusFilter === 'pending_valuation_negotiation') {
                $query->where('status', 'pending_valuation')->whereNotNull('agreed_price');
            } elseif ($this->statusFilter === 'pending_valuation') {
                $query->where('status', 'pending_valuation')->whereNull('agreed_price');
            } else {
                $query->where('status', $this->statusFilter);
            }
        }

        // Date Range Filter
        if (is_array($this->dateRange) && count($this->dateRange) === 2) {
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

        return view('livewire.customer.order.index', [
            'orders' => $orders,
            'orders_pagination' => $ordersRaw
        ]);
    }
}