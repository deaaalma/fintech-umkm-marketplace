<?php

namespace App\Livewire\Customer\Partner;

use App\Models\Umkm;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Show extends Component
{
    public Umkm $partner;

    public function mount(Umkm $partner)
    {
        $this->partner = $partner->load(['category', 'products', 'reviews.customer']);
    }

    public function pesanSekarang($productId)
    {

        $order = Order::create([
            'customer_id' => Auth::id(),
            'umkm_id' => $this->partner->id,
            'product_id' => $productId,
            'status' => 'pending_valuation',
        ]);

        $this->redirect(route('customer.order-details', $order->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.partner.show');
    }
}
