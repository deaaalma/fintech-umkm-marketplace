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

    public function mount(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $this->order = $order->load(['umkm', 'product']);
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
            $this->order->update(['status' => 'waiting_payment']);
            
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
