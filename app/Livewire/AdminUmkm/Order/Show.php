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
            // We keep it as pending_valuation but the customer view will detect agreed_price
            // This acts as the "Negotiation" state without adding a new DB status
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
