<?php

namespace App\Livewire\Customer\Partner;

use App\Models\Umkm;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Show extends Component
{
    use WithFileUploads;

    public Umkm $partner;
    public $showOrderModal = false;
    public $selectedProductId;
    
    // Form fields
    public $address;
    public $booking_date;
    public $booking_time;
    public $notes;
    public $lat;
    public $lng;
    public $orderPhotos = [];
    public $selectedWorkerId;
    public $workers = [];

    public function mount(Umkm $partner)
    {
        $this->partner = $partner->load(['category', 'products', 'reviews.customer', 'workers.user']);
        $this->workers = $this->partner->workers;
    }

    public function removePhoto($index)
    {
        unset($this->orderPhotos[$index]);
        $this->orderPhotos = array_values($this->orderPhotos);
    }

    public function pesanSekarang($productId)
    {
        $this->selectedProductId = $productId;
        $this->showOrderModal = true;
    }

    public function confirmOrder()
    {
        $this->validate([
            'address' => 'required|string|max:500',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required',
            'orderPhotos.*' => 'image|max:2048', // 2MB max per photo
        ], [
            'booking_date.after' => 'Pemesanan minimal dilakukan H-1 (besok atau lusa).',
        ]);

        $photoPaths = [];
        if ($this->orderPhotos) {
            foreach ($this->orderPhotos as $photo) {
                $photoPaths[] = $photo->store('order-photos', 'public');
            }
        }

        $order = Order::create([
            'customer_id' => Auth::id(),
            'umkm_id' => $this->partner->id,
            'product_id' => $this->selectedProductId,
            'status' => 'pending_valuation',
            'service_address' => $this->address,
            'service_latitude' => $this->lat,
            'service_longitude' => $this->lng,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
            'notes' => $this->notes,
            'photos' => $photoPaths,
        ]);

        $this->showOrderModal = false;
        $this->redirect(route('customer.order-details', $order->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.partner.show');
    }
}
