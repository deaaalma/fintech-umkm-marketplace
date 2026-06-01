<?php

namespace App\Livewire\Customer\Order;

use App\Models\Order;
use App\Models\OrderLog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Review extends Component
{
    use WithFileUploads;

    public Order $order;
    public $rating = 5;
    public $review_text = '';
    public $photos = [];
    public $recommend = 'yes';
    public $agreed = false;

    public function mount(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            return redirect()->route('customer.order-details', $order->id);
        }

        $this->order = $order->load(['umkm', 'product']);
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|min:20',
            'agreed' => 'accepted',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        // Mock image processing
        $imagePaths = [];
        if ($this->photos) {
            foreach ($this->photos as $photo) {
                // In a real app: $imagePaths[] = $photo->store('reviews', 'public');
                $imagePaths[] = 'https://images.unsplash.com/photo-1581578731548-c64695cc6958'; // Mock
            }
        }

        \App\Models\OrderReview::create([
            'order_id' => $this->order->id,
            'customer_id' => auth()->id(),
            'umkm_id' => $this->order->umkm_id,
            'rating' => $this->rating,
            'is_recommended' => $this->recommend === 'yes',
            'comment' => $this->review_text,
            'images' => $imagePaths,
            'is_resolved' => true,
        ]);
        
        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Review Submitted',
            'reason' => 'Customer submitted a ' . $this->rating . '-star review.',
        ]);

        session()->flash('message', 'Thank you for your review!');
        return redirect()->route('customer.order-details', $this->order->id);
    }

    public function render()
    {
        return view('livewire.customer.order.review');
    }
}
