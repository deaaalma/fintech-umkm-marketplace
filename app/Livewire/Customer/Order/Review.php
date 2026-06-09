<?php

namespace App\Livewire\Customer\Order;

use App\Models\Order;
use App\Models\OrderReview;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.customer-layout')]
class Review extends Component
{
    use WithFileUploads;

    public Order $order;
    
    // Form fields
    public $rating = 5;
    public $is_recommended = true;
    public $comment;
    public $images = [];
    public $issue_type_id = null;
    public $is_resolved = false;

    public function mount(Order $order)
    {
        $this->order = $order;
        
        // Ensure only the customer of this order can review
        if ($this->order->customer_id !== auth()->id()) {
            abort(403);
        }

        // Redirect if already reviewed
        if ($this->order->review) {
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submit()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'is_recommended' => 'required|boolean',
            'comment' => 'required|string|min:10',
            'images.*' => 'nullable|image|max:2048',
            'issue_type_id' => 'nullable|integer',
            'is_resolved' => 'required|boolean',
        ]);

        $imagePaths = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagePaths[] = $image->store('reviews', 'public');
            }
        }

        OrderReview::create([
            'order_id' => $this->order->id,
            'customer_id' => auth()->id(),
            'umkm_id' => $this->order->umkm_id,
            'rating' => $this->rating,
            'is_recommended' => $this->is_recommended,
            'comment' => $this->comment,
            'images' => $imagePaths,
            'issue_type_id' => $this->issue_type_id,
            'is_resolved' => $this->is_resolved,
        ]);

        // Update order status if needed (optional)
        // $this->order->update(['status' => 'completed']);

        session()->flash('message', 'Thank you for your review!');
        return redirect()->route('customer.order-details', $this->order->id);
    }

    public function render()
    {
        return view('livewire.customer.order.review');
    }
}
