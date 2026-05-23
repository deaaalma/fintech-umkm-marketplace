<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class TransactionManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $startDate = '';
    public $endDate = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function clearDates()
    {
        $this->reset(['startDate', 'endDate']);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'startDate', 'endDate']);
        $this->statusFilter = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::with(['umkm', 'customer'])
            ->latest();

        // --- APPLY FILTERS ---
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('umkm', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->statusFilter !== 'all' && $this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // --- CALCULATE REACTIVE STATS ---
        // Copy the query used for the table, but with its own cloned instance for stats
        $statsQuery = clone $query;
        $allStatsQuery = clone $query;

        $stats = [
            'total_volume' => (clone $statsQuery)->whereIn('status', ['paid', 'completed', 'processing'])->sum('agreed_price'),
            'total_orders' => (clone $statsQuery)->count(),
            'pending_payouts' => (clone $statsQuery)->whereIn('status', ['paid', 'processing'])->sum('agreed_price'),
            'success_rate' => (clone $statsQuery)->where('status', '!=', 'cancelled')->count() > 0 
                ? ((clone $statsQuery)->where('status', 'completed')->count() / (clone $statsQuery)->where('status', '!=', 'cancelled')->count()) * 100 
                : 0
        ];

        return view('livewire.super-admin.transaction-management', [
            'orders' => $query->paginate(10),
            'stats' => $stats
        ])->layout('layouts.superadmin', ['title' => 'Manajemen Transaksi']);
    }
}
