<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderChat extends Component
{
    public Order $order;
    public $newMessage = '';
    public $unreadCount = 0;
    
    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function markAsRead()
    {
        $this->order->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        $this->unreadCount = 0;
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000'
        ]);

        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => $this->newMessage,
        ]);

        $this->newMessage = '';
    }

    public function acceptProposal()
    {
        if ($this->order->status !== 'pending_valuation') return;

        $this->order->update([
            'status' => 'waiting_payment',
            'current_step' => 4,
        ]);

        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Penawaran harga telah disetujui.',
            'type' => 'system',
        ]);

        \App\Models\OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => Auth::id(),
            'action' => 'Customer Accepted Proposal',
            'reason' => 'Customer agreed to the price of Rp ' . number_format($this->order->agreed_price, 0, ',', '.'),
        ]);
        
        $this->dispatch('proposal-action-taken');
    }

    public function rejectProposal()
    {
        if ($this->order->status !== 'pending_valuation') return;

        $this->order->update([
            'status' => 'cancelled',
        ]);

        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Penawaran harga telah ditolak dan pesanan dibatalkan.',
            'type' => 'system',
        ]);

        \App\Models\OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => Auth::id(),
            'action' => 'Customer Rejected Proposal',
            'reason' => 'Customer cancelled the order during price negotiation.',
        ]);
        
        $this->dispatch('proposal-action-taken');
    }

    public function render()
    {
        $this->unreadCount = $this->order->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('livewire.order-chat', [
            'messages' => $this->order->messages()->with('sender')->orderBy('created_at', 'asc')->get()
        ]);
    }
}
