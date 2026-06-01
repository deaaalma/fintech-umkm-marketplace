<?php

namespace App\Livewire\AdminUmkm\Reports;

use App\Models\Order;
use App\Models\Umkm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    use WithPagination;

    public $dateRange = 'this_month';
    public $startDate;
    public $endDate;
    public $search = '';

    public function mount()
    {
        $this->setDateRange('this_month');
    }

    public function setDateRange($range)
    {
        $this->dateRange = $range;
        
        switch ($range) {
            case 'today':
                $this->startDate = Carbon::today()->format('Y-m-d');
                $this->endDate = Carbon::today()->format('Y-m-d');
                break;
            case 'last_7_days':
                $this->startDate = Carbon::today()->subDays(6)->format('Y-m-d');
                $this->endDate = Carbon::today()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = Carbon::today()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::today()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = Carbon::today()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::today()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
        }
    }

    public function applyFilter()
    {
        $this->dateRange = 'custom';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        // Fetch basic stats (in a real app, these would be complex queries based on date range)
        $ordersQuery = Order::where('umkm_id', $umkmId);
        
        if ($this->startDate && $this->endDate) {
            $ordersQuery->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        }

        $totalOrders = (clone $ordersQuery)->count();
        $totalRevenue = (clone $ordersQuery)->where('status', 'completed')->sum('agreed_price');
        $aov = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Fetch paginated orders for the table
        $orders = (clone $ordersQuery)
            ->with(['customer', 'product'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function ($q2) {
                          $q2->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-umkm.reports.index', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'aov' => $aov,
            'orders' => $orders
        ]);
    }
}
