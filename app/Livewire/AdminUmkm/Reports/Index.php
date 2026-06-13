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
        $totalRevenue = (clone $ordersQuery)->whereIn('status', ['paid', 'completed'])->sum('agreed_price');
        $aov = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Status Counts
        $statusCounts = (clone $ordersQuery)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $activeCount = ($statusCounts['pending_valuation'] ?? 0) + ($statusCounts['negotiation'] ?? 0) + ($statusCounts['waiting_worker'] ?? 0) + ($statusCounts['processing'] ?? 0) + ($statusCounts['waiting_payment'] ?? 0);
        $completedCount = ($statusCounts['paid'] ?? 0) + ($statusCounts['completed'] ?? 0);
        $cancelledCount = $statusCounts['cancelled'] ?? 0;

        // Chart Data (Daily Revenue & Orders)
        $chartDataRaw = (clone $ordersQuery)
            ->selectRaw('DATE(created_at) as date, SUM(CASE WHEN status IN ("paid", "completed") THEN agreed_price ELSE 0 END) as revenue, COUNT(*) as orders_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $chartDates = [];
        $chartRevenues = [];
        $chartOrders = [];
        
        foreach ($chartDataRaw as $data) {
            $chartDates[] = Carbon::parse($data->date)->format('d M');
            $chartRevenues[] = $data->revenue;
            $chartOrders[] = $data->orders_count;
        }

        // Top Services
        $topServices = (clone $ordersQuery)
            ->selectRaw('product_id, COUNT(*) as count')
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->limit(5)
            ->with('product')
            ->get();

        // Customer Demographics (New vs Returning within this umkm)
        // Simplified: just group by customer_id count
        $customerCounts = (clone $ordersQuery)
            ->selectRaw('customer_id, COUNT(*) as count')
            ->groupBy('customer_id')
            ->get();
            
        $totalCustomers = $customerCounts->count();
        $returningCustomers = $customerCounts->where('count', '>', 1)->count();
        $newCustomers = $totalCustomers - $returningCustomers;
        
        $returningPercentage = $totalCustomers > 0 ? round(($returningCustomers / $totalCustomers) * 100) : 0;
        $newPercentage = $totalCustomers > 0 ? round(($newCustomers / $totalCustomers) * 100) : 0;

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
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
            'chartDates' => $chartDates,
            'chartRevenues' => $chartRevenues,
            'chartOrders' => $chartOrders,
            'topServices' => $topServices,
            'totalCustomers' => $totalCustomers,
            'newPercentage' => $newPercentage,
            'returningPercentage' => $returningPercentage,
            'orders' => $orders
        ]);
    }
}
