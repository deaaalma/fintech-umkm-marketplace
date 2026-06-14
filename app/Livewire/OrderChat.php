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
    public $otherPartyOnline = false;
    public $isAdmin = false;
    
    public $additionalFeeName = '';
    public $additionalFeeAmount = '';
    
    public function mount(Order $order)
    {
        $this->order = $order;
        $this->isAdmin = request()->routeIs('umkm.*');
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
            'status' => 'processing',
            'current_step' => 4,
        ]);

        $latestProposal = $this->order->messages()->where('type', 'proposal')->latest()->first();
        if ($latestProposal) {
            $metadata = $latestProposal->metadata;
            $metadata['status'] = 'accepted';
            $latestProposal->update(['metadata' => $metadata]);
        }

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

        // Hanya tolak penawaran harga, bukan batalkan pesanan
        // Reset agreed_price agar admin bisa kirim penawaran baru
        $this->order->update([
            'agreed_price' => null,
        ]);

        $latestProposal = $this->order->messages()->where('type', 'proposal')->latest()->first();
        if ($latestProposal) {
            $metadata = $latestProposal->metadata;
            $metadata['status'] = 'rejected';
            $latestProposal->update(['metadata' => $metadata]);
        }

        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Penawaran harga ditolak. Menunggu admin memberikan penawaran harga baru.',
            'type' => 'system',
        ]);

        \App\Models\OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => Auth::id(),
            'action' => 'Customer Rejected Proposal',
            'reason' => 'Customer rejected the price proposal and is waiting for a new offer.',
        ]);
        
        $this->dispatch('proposal-action-taken');
    }

    public function sendAdditionalFee()
    {
        $this->validate([
            'additionalFeeName' => 'required|string|max:255',
            'additionalFeeAmount' => 'required|numeric|min:1000',
        ]);

        if ($this->order->status !== 'processing') return;

        $fee = \App\Models\OrderAdditionalFee::create([
            'order_id' => $this->order->id,
            'name' => $this->additionalFeeName,
            'amount' => $this->additionalFeeAmount,
            'status' => 'pending'
        ]);

        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Admin mengajukan biaya tambahan untuk layanan Anda.',
            'type' => 'additional_cost',
            'metadata' => [
                'fee_id' => $fee->id,
                'name' => $this->additionalFeeName,
                'amount' => $this->additionalFeeAmount,
                'status' => 'pending'
            ]
        ]);

        $this->additionalFeeName = '';
        $this->additionalFeeAmount = '';
        $this->dispatch('message-sent');
    }

    public function acceptAdditionalFee($messageId)
    {
        $message = OrderMessage::findOrFail($messageId);
        if ($message->type !== 'additional_cost' || !isset($message->metadata['fee_id'])) return;

        $fee = \App\Models\OrderAdditionalFee::find($message->metadata['fee_id']);
        if (!$fee || $fee->status !== 'pending') return;

        $fee->update(['status' => 'accepted']);

        // Update message metadata
        $metadata = $message->metadata;
        $metadata['status'] = 'accepted';
        $message->update(['metadata' => $metadata]);

        // Send system message
        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Biaya tambahan "' . $fee->name . '" telah disetujui oleh pelanggan.',
            'type' => 'system',
        ]);

        \App\Models\OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => Auth::id(),
            'action' => 'Accepted Additional Fee',
            'reason' => 'Customer agreed to additional fee: ' . $fee->name . ' (Rp ' . number_format($fee->amount, 0, ',', '.') . ')',
        ]);
        
        $this->dispatch('additional-fee-action');
    }

    public function rejectAdditionalFee($messageId)
    {
        $message = OrderMessage::findOrFail($messageId);
        if ($message->type !== 'additional_cost' || !isset($message->metadata['fee_id'])) return;

        $fee = \App\Models\OrderAdditionalFee::find($message->metadata['fee_id']);
        if (!$fee || $fee->status !== 'pending') return;

        $fee->update(['status' => 'rejected']);

        // Update message metadata
        $metadata = $message->metadata;
        $metadata['status'] = 'rejected';
        $message->update(['metadata' => $metadata]);

        // Send system message
        OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => Auth::id(),
            'message' => 'Biaya tambahan "' . $fee->name . '" ditolak oleh pelanggan.',
            'type' => 'system',
        ]);
        
        $this->dispatch('additional-fee-action');
    }

    private function checkOtherPartyOnline(): bool
    {
        // Admin melihat status online customer
        if ($this->isAdmin) {
            $other = $this->order->customer;
        } else {
            // Customer melihat status online admin UMKM
            $other = $this->order->umkm?->owner;
        }
        
        if (!$other || !$other->last_seen_at) return false;
        
        return $other->last_seen_at->diffInMinutes(now()) <= 2;
    }

    public function render()
    {
        $this->unreadCount = $this->order->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->count();
        
        $this->otherPartyOnline = $this->checkOtherPartyOnline();

        return view('livewire.order-chat', [
            'messages' => $this->order->messages()->with('sender')->orderBy('created_at', 'asc')->get()
        ]);
    }
}
