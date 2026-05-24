<?php

namespace App\Livewire\AdminUmkm;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.blank')]
class Orders extends Component
{
    public $search = '';
    public $category = 'All'; // All, Active, History
    public $service = 'All';
    public $timeRange = 'All'; // Today, This Week, Month
    public $status = 'All';
    public $showFilters = false;

    public function toggleFilters()
    {
        // If it's about to close, reset everything
        if ($this->showFilters) {
            $this->resetAllProps();
        }
        $this->showFilters = !$this->showFilters;
    }

    public function resetFilters()
    {
        // Just reset props, keep showFilters as is (open)
        $this->resetAllProps();
    }

    private function resetAllProps()
    {
        $this->service = 'All';
        $this->status = 'All';
        $this->search = '';
    }

    public function render()
    {
        $allOrders = [
            ['id' => 'ORD-12345', 'client' => 'Ahmad S.', 'item' => 'Deep Cleaning', 'status' => 'Pending', 'color' => 'amber', 'time' => '10:30 AM', 'date' => now()->format('Y-m-d')],
            ['id' => 'ORD-12344', 'client' => 'Budi T.', 'item' => 'Office Clean', 'status' => 'In Process', 'color' => 'blue', 'time' => '10:15 AM', 'date' => now()->format('Y-m-d')],
            ['id' => 'ORD-12343', 'client' => 'Siti N.', 'item' => 'Regular Clean', 'status' => 'Pending', 'color' => 'amber', 'time' => '09:45 AM', 'date' => now()->subDays(1)->format('Y-m-d')],
            ['id' => 'ORD-12342', 'client' => 'Joko W.', 'item' => 'Deep Cleaning', 'status' => 'Completed', 'color' => 'teal', 'time' => '09:20 AM', 'date' => now()->subDays(3)->format('Y-m-d')],
            ['id' => 'ORD-12341', 'client' => 'Ani P.', 'item' => 'Office Clean', 'status' => 'In Process', 'color' => 'blue', 'time' => '08:50 AM', 'date' => now()->subDays(7)->format('Y-m-d')],
            ['id' => 'ORD-12339', 'client' => 'Dimas K.', 'item' => 'Vehicle Clean', 'status' => 'Cancelled', 'color' => 'red', 'time' => '02:30 PM', 'date' => now()->subDays(10)->format('Y-m-d')],
        ];

        $orders = collect($allOrders)->filter(function($order) {
            // Search filter
            if (!empty($this->search)) {
                $matchSearch = str_contains(strtolower($order['id']), strtolower($this->search)) || 
                               str_contains(strtolower($order['client']), strtolower($this->search));
                if (!$matchSearch) return false;
            }

            // Category filter (Active vs History)
            if ($this->category == 'Active' && !in_array($order['status'], ['Pending', 'In Process'])) return false;
            if ($this->category == 'History' && !in_array($order['status'], ['Completed', 'Cancelled'])) return false;

            // Service filter
            if ($this->service != 'All' && $order['item'] != $this->service) return false;

            // Status filter
            if ($this->status != 'All' && $order['status'] != $this->status) return false;

            // Time range filter
            if ($this->timeRange != 'All') {
                $orderDate = \Carbon\Carbon::parse($order['date']);
                if ($this->timeRange == 'Today' && !$orderDate->isToday()) return false;
                if ($this->timeRange == 'This Week' && !$orderDate->isCurrentWeek()) return false;
                if ($this->timeRange == 'This Month' && !$orderDate->isCurrentMonth()) return false;
            }

            return true;
        });

        return view('livewire.admin-umkm.orders', [
            'orders' => $orders
        ]);
    }

    public function setCategory($cat) { $this->category = $cat; }
    public function setService($svc) { $this->service = $svc; }
    public function setTimeRange($tr) { $this->timeRange = $tr; }
    public function setStatus($st) { $this->status = $st; }
}
