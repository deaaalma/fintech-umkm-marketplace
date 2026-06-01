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
    
    // Mock data for Service Process (Step 4)
    public $staffTeam = [
        ['name' => 'Ahmad Syarif', 'role' => 'Team Lead', 'experience' => '5 years experience', 'initials' => 'AS'],
        ['name' => 'Budi Santoso', 'role' => 'Member', 'experience' => '2 years experience', 'initials' => 'BS'],
    ];

    public $workScope = [
        'Deep cleaning 50m² living area',
        'Extra 2 bathrooms deep cleaning',
        'Balcony 10m² cleaning',
    ];

    public $workProgress = [
        ['task' => 'Living room', 'status' => 'completed', 'time' => '10:00'],
        ['task' => 'Bedroom 1', 'status' => 'completed', 'time' => '10:20'],
        ['task' => 'Bathroom 1', 'status' => 'in_progress', 'time' => 'Currently working...'],
        ['task' => 'Bathroom 2', 'status' => 'pending', 'time' => ''],
        ['task' => 'Kitchen', 'status' => 'pending', 'time' => ''],
        ['task' => 'Balcony', 'status' => 'pending', 'time' => ''],
    ];

    // Mock data for Payment (Step 5)
    public $paymentDetails = [
        'base_services' => [
            ['name' => 'Deep cleaning 50m²', 'price' => 2210000],
            ['name' => 'Extra 2 Bathrooms', 'price' => 390000],
            ['name' => 'Balcony 20m²', 'price' => 187200],
        ],
        'additional_services' => [
            ['name' => 'Window Cleaning (3 windows)', 'price' => 117000],
            ['name' => 'AC Filter Cleaning (1 unit)', 'price' => 150000],
        ],
        'discounts' => [
            ['name' => 'Loyalty Discount', 'amount' => 30000],
        ],
        'fees' => [
            ['name' => 'Admin Fee', 'amount' => 4600],
        ],
        'final_total' => 2728800
    ];

    // Mock data for Completed (Step 6)
    public $workResults = [
        'https://images.unsplash.com/photo-1581578731548-c64695cc6958?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1527515545081-5db817172677?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=500&auto=format&fit=crop',
    ];

    public $verificationData = [
        'completed_at' => '14 Jan 2024, 11:45',
        'transaction_id' => 'TRX-992100445',
        'method' => 'Bank Transfer (BCA)',
    ];

    public function toggleAcceptModal()
    {
        $this->showAcceptModal = !$this->showAcceptModal;
    }

    public function mount(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $this->order = $order->load(['umkm', 'product', 'review']);
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
