<?php

namespace App\Livewire\Customer\Order;

use App\Models\Order;
use App\Models\OrderLog;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Show extends Component
{
    public Order $order;
    public $showAcceptModal = false;
    
    // Dynamic data containers
    public $staffTeam = [];
    public $workScope = [];
    public $workProgress = [];
    public $paymentDetails = [];
    public $verificationData = [];

    // Use order photos if available, otherwise mock
    public function getWorkResultsProperty()
    {
        $photos = $this->order->photos;
        
        // If it's a string, it means casting didn't happen or failed
        if (is_string($photos)) {
            $photos = json_decode($photos, true);
        }

        // Final fallback to raw original if still empty/null
        if (!$photos) {
            $raw = $this->order->getRawOriginal('photos');
            $photos = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        if ($photos && is_array($photos) && count($photos) > 0) {
            return collect($photos)->map(fn($path) => asset('storage/' . $path))->toArray();
        }
        
        return [
            'https://images.unsplash.com/photo-1581578731548-c64695cc6958?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1527515545081-5db817172677?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=500&auto=format&fit=crop',
        ];
    }


    public function toggleAcceptModal()
    {
        $this->showAcceptModal = !$this->showAcceptModal;
    }

    public function mount(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->order = $order->load(['umkm', 'product', 'orderAssignment.worker']);

        // 1. Dynamic Staff Team
        if ($this->order->orderAssignment && $this->order->orderAssignment->worker) {
            $worker = $this->order->orderAssignment->worker;
            $this->staffTeam = [
                [
                    'name' => $worker->name, 
                    'role' => 'Assigned Specialist', 
                    'experience' => 'Certified Staff @ ' . $this->order->umkm->name, 
                    'initials' => strtoupper(substr($worker->name, 0, 1))
                ]
            ];
        } else {
            $this->staffTeam = [
                ['name' => 'Pending Assignment', 'role' => 'Awaiting Admin', 'experience' => '-', 'initials' => '?']
            ];
        }

        // 2. Dynamic Work Scope
        $this->workScope = [
            'Layanan: ' . $this->order->product->name,
            'Lokasi: ' . ($this->order->service_address ?? 'Alamat terdaftar'),
            'Catatan: ' . ($this->order->notes ?? 'Prosedur standar'),
        ];

        // 3. Dynamic Work Progress (Based on Status)
        if ($this->order->status === 'processing') {
            $this->workProgress = [
                ['task' => 'Persiapan Alat & Bahan', 'status' => 'completed', 'time' => $this->order->updated_at->format('H:i')],
                ['task' => 'Pengerjaan Layanan: ' . $this->order->product->name, 'status' => 'in_progress', 'time' => 'Sedang dikerjakan...'],
                ['task' => 'Pembersihan & Finishing', 'status' => 'pending', 'time' => ''],
                ['task' => 'Verifikasi Hasil', 'status' => 'pending', 'time' => ''],
            ];
        } elseif (in_array($this->order->status, ['waiting_payment', 'paid', 'completed'])) {
            $this->workProgress = [
                ['task' => 'Persiapan Alat & Bahan', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Pengerjaan Layanan', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Pembersihan & Finishing', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Verifikasi Hasil', 'status' => 'completed', 'time' => '-'],
            ];
        } else {
            $this->workProgress = [
                ['task' => 'Menunggu Penugasan', 'status' => 'pending', 'time' => ''],
            ];
        }

        // 4. Dynamic Payment Details
        $this->paymentDetails = [
            'base_services' => [
                ['name' => $this->order->product->name, 'price' => $this->order->agreed_price ?? 0],
            ],
            'additional_services' => [],
            'discounts' => [],
            'fees' => [
                ['name' => 'Biaya Layanan', 'amount' => $this->order->platform_fee ?? 0],
            ],
            'final_total' => $this->order->agreed_price ?? 0
        ];

        // 5. Dynamic Verification Data
        if ($this->order->status === 'completed' || $this->order->status === 'paid') {
            $this->verificationData = [
                'completed_at' => $this->order->updated_at->format('d M Y, H:i'),
                'transaction_id' => $this->order->invoice_number ?? ('TRX-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT)),
                'method' => 'Saldo / Transfer',
            ];
        }
    }

    public function cancelOrder()
    {
        if (in_array($this->order->status, ['pending_valuation', 'negotiation', 'waiting_payment'])) {
            $this->order->update(['status' => 'cancelled']);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Order Cancelled',
                'reason' => 'Customer cancelled the order via detail page.',
            ]);

            session()->flash('message', 'Pesanan berhasil dibatalkan.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function acceptPrice()
    {
        if ($this->order->status === 'pending_valuation' && $this->order->agreed_price !== null) {
            $this->order->update([
                'status' => 'processing', // Move to processing after price agreement
                'current_step' => 4 // Move to Service Process step
            ]);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Customer Accepted Price',
                'reason' => 'Customer agreed to the negotiated price (Rp ' . number_format($this->order->agreed_price, 0, ',', '.') . ') and proceeded to payment.',
            ]);

            session()->flash('message', 'Harga disetujui. Silakan lanjutkan ke pembayaran.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function rejectPrice()
    {
        if ($this->order->status === 'pending_valuation' && $this->order->agreed_price !== null) {
            $this->order->update([
                'status' => 'cancelled', 
                'cancellation_reason' => 'Customer rejected the proposed price.'
            ]);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Price Rejected',
                'reason' => 'Customer rejected the price proposal and cancelled the order.',
            ]);

            session()->flash('message', 'Pesanan dibatalkan karena penolakan harga.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function render()
    {
        $logs = OrderLog::where('order_id', $this->order->id)
            ->latest()
            ->get();
            
        return view('livewire.customer.order.show', [
            'logs' => $logs
        ]);
    }
}
