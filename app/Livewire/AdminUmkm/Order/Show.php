<?php

namespace App\Livewire\AdminUmkm\Order;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-umkm')]
class Show extends Component
{
    public Order $order;
    public $agreed_price;
    public $admin_note;
    public $selectedWorkerId;
    public $availableWorkers = [];

    public function mount(Order $order)
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        if ($order->umkm_id !== $umkmId) {
            abort(403);
        }

        $this->order = $order->load(['customer', 'product', 'orderAssignment.worker']);
        $this->agreed_price = $order->agreed_price ?? ($order->product->estimated_price ?? 0);
        
        $this->availableWorkers = UmkmWorker::where('umkm_id', $umkmId)
            ->with('user')
            ->where('is_active', true)
            ->get();
            
        if ($this->order->orderAssignment) {
            $this->selectedWorkerId = $this->order->orderAssignment->worker_id;
        }
    }

    public function assignWorker()
    {
        $this->validate([
            'selectedWorkerId' => 'required|exists:users,id'
        ]);

        \App\Models\OrderAssignment::updateOrCreate(
            ['order_id' => $this->order->id],
            ['worker_id' => $this->selectedWorkerId, 'status' => 'assigned']
        );

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Worker Assigned',
            'reason' => 'Admin assigned a worker to this order.',
        ]);

        $this->order->load('orderAssignment.worker');
        session()->flash('message', 'Petugas berhasil ditugaskan.');
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

    public function getSitePhotosProperty()
    {
        $photos = $this->order->photos;
        
        // Safety decode if it comes back as a string
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
        
        return [];
    }

    public function render()
    {
        $logs = OrderLog::where('order_id', $this->order->id)->latest()->get();
        return view('livewire.admin-umkm.order.show', [
            'logs' => $logs
        ]);
    }
}
