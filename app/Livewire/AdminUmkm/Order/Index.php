<?php

namespace App\Livewire\AdminUmkm\Order;

use App\Models\Order;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Product;
use App\Models\UmkmWorker;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
   use WithPagination;

    public $search = '';
    #[Url]
    public $category = 'All';
    public $status = 'All';
    public $showFilters = false;
    public $selected = [];

    public $service_type = '';
    public $staff_id = '';
    public $date_start = '';
    public $date_end = '';
    public $amount_min = '';
    public $amount_max = '';
    public $customer_type = 'All'; // All, New, Returning

    public function selectAll($orderIds)
    {
        if (count($this->selected) === count($orderIds)) {
            $this->selected = [];
        } else {
            $this->selected = $orderIds;
        }
    }


    public function setDateRange($range)
    {
        if ($range === 'today') {
            $this->date_start = now()->toDateString();
            $this->date_end = now()->toDateString();
        } elseif ($range === 'week') {
            $this->date_start = now()->startOfWeek()->toDateString();
            $this->date_end = now()->endOfWeek()->toDateString();
        } elseif ($range === 'month') {
            $this->date_start = now()->startOfMonth()->toDateString();
            $this->date_end = now()->endOfMonth()->toDateString();
        }
        $this->resetPage();
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategory() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingServiceType() { $this->resetPage(); }
    public function updatingStaffId() { $this->resetPage(); }
    public function updatingDateStart() { $this->resetPage(); }
    public function updatingDateEnd() { $this->resetPage(); }
    public function updatingAmountMin() { $this->resetPage(); }
    public function updatingAmountMax() { $this->resetPage(); }
    public function updatingCustomerType() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'status', 'service_type', 'staff_id', 'date_start', 'date_end', 'amount_min', 'amount_max', 'customer_type']);
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        // Get Service Types
        $serviceTypes = Product::where('umkm_id', $umkmId)
                               ->select('type')
                               ->distinct()
                               ->pluck('type');

        // Get Staffs (Workers) for this UMKM
        // As per request: "staff assignment get from user table role worker"
        // Better to get workers that belong to this UMKM
        $workerIds = UmkmWorker::where('umkm_id', $umkmId)->pluck('user_id');
        $staffs = User::whereIn('id', $workerIds)->where('role', 'worker')->get();
        // If the umkm_workers table is not populated, we fallback to all workers
        if ($staffs->isEmpty()) {
             $staffs = User::where('role', 'worker')->get();
        }

        $query = Order::where('umkm_id', $umkmId)
                      ->with(['customer', 'product', 'orderAssignment.worker']);

        // Filter Search (Invoice, Customer Name, Phone, Product Name, Product Type)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($c) {
                      $c->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('product', function($p) {
                      $p->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('type', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filter Category (Tabs)
        if ($this->category == 'Pending Review') {
            $query->where('status', 'pending_valuation');
        } elseif ($this->category == 'Negotiating') {
            $query->where('status', 'pending_valuation'); // Assuming Negotiating is part of Pending Review
        } elseif ($this->category == 'Awaiting Payment') {
            $query->where('status', 'waiting_payment');
        } elseif ($this->category == 'Paid') {
            $query->where('status', 'paid');
        } elseif ($this->category == 'In Process') {
            $query->where('status', 'processing');
        } elseif ($this->category == 'Active') {
            $query->whereIn('status', ['paid', 'processing']);
        } elseif ($this->category == 'Completed') {
            $query->where('status', 'completed');
        } elseif ($this->category == 'Cancelled') {
            $query->where('status', 'cancelled');
        }

        // Filter Status Dropdown
        if ($this->status != 'All') {
            $query->where('status', $this->status);
        }

        // Filter Service Type
        if ($this->service_type) {
            $query->whereHas('product', function($q) {
                $q->where('type', $this->service_type);
            });
        }

        // Filter Staff
        if ($this->staff_id) {
             $query->whereIn('id', \App\Models\OrderAssignment::where('worker_id', $this->staff_id)->pluck('order_id'));
        }

        // Filter Date Range
        if ($this->date_start) {
            $query->whereDate('booking_date', '>=', $this->date_start);
        }
        if ($this->date_end) {
            $query->whereDate('booking_date', '<=', $this->date_end);
        }

        // Filter Amount Range
        if ($this->amount_min) {
            $query->where('agreed_price', '>=', $this->amount_min);
        }
        if ($this->amount_max) {
            $query->where('agreed_price', '<=', $this->amount_max);
        }

        // Filter Customer Type
        if ($this->customer_type === 'New') {
            $query->whereHas('customer', function($q) use($umkmId) {
                // Customer has only 1 order in this UMKM
                $q->whereHas('orders', function($oq) use($umkmId) {
                    $oq->where('umkm_id', $umkmId);
                }, '=', 1);
            });
        } elseif ($this->customer_type === 'Returning') {
            $query->whereHas('customer', function($q) use($umkmId) {
                // Customer has > 1 orders in this UMKM
                $q->whereHas('orders', function($oq) use($umkmId) {
                    $oq->where('umkm_id', $umkmId);
                }, '>', 1);
            });
        }

        $ordersRaw = $query->latest()->paginate(10);

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

            // Try to get staff name
            $staffName = '-';
            $assignment = $order->orderAssignment;
            if ($assignment && $assignment->worker) {
                 $staffName = $assignment->worker->name;
            }

            return [
                'id_raw' => $order->id,
                'id'     => $order->invoice_number ?? 'ORDER-'.$order->id,
                'client' => $order->customer->name ?? 'Guest',
                'service'=> $order->product->name ?? 'Unknown',
                'price'  => 'Rp ' . number_format($order->agreed_price, 0, ',', '.'),
                'status' => $info['label'],
                'color'  => $info['color'],
                'time'   => $order->created_at->format('H:i A'),
                'booking'=> $order->booking_date ? $order->booking_date->format('d M, H:i') : '-',
                'staff'  => $staffName,
            ];
        });

        return view('livewire.admin-umkm.order.index', [
            'orders' => $orders,
            'orders_pagination' => $ordersRaw,
            'serviceTypes' => $serviceTypes,
            'staffs' => $staffs,
        ]);
    }
}

