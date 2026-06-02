<?php

namespace App\Livewire\Customer\Partner;

use App\Models\Umkm;
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

    public function render()
    {
        return view('livewire.customer.partner.show');
    }
}
