<?php

namespace App\Livewire\AdminUmkm\Order;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Umkm;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-umkm')]
class Show extends Component
{
    public Order $order;
    public $agreed_price;
    public $admin_note;

    public function mount(Order $order)
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        if ($order->umkm_id !== $umkmId) {
            abort(403);
        }

        $this->order = $order->load(['customer', 'product']);
        $this->agreed_price = $order->agreed_price ?? ($order->product->estimated_price ?? 0);
    }

    public function acceptOrder()
    {
        $this->validate([
            'agreed_price' => 'required|numeric|min:0',
        ]);

        $this->order->update([
            'agreed_price' => $this->agreed_price,
            'current_step' => 3, // Move to Negotiation step
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Admin Sent Proposal',
            'reason' => 'Admin set the price to Rp ' . number_format($this->agreed_price, 0, ',', '.') . '. ' . $this->admin_note,
        ]);

        session()->flash('message', 'Proposal harga berhasil dikirim ke pelanggan.');
        return redirect()->route('umkm.orders');
    }

    public function completeOrder()
    {
        $this->order->update([
            'status' => 'pending_valuation',
            'current_step' => 2 // Move to Payment step
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Service Completed',
            'reason' => 'Admin marked the service as completed. Waiting for customer payment.',
        ]);

        session()->flash('message', 'Layanan telah selesai. Menunggu pembayaran dari pelanggan.');
    }

    public function rejectOrder()
    {
        $this->order->update(['status' => 'cancelled']);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Admin Rejected Order',
            'reason' => 'Admin rejected the order request.',
        ]);

        session()->flash('message', 'Pesanan telah ditolak.');
        return redirect()->route('umkm.orders');
    }

    public function render()
    {
        $logs = OrderLog::where('order_id', $this->order->id)->latest()->get();
        return view('livewire.admin-umkm.order.show', [
            'logs' => $logs
        ]);
    }
}
