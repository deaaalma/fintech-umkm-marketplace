<?php

namespace App\Livewire\AdminUmkm;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.blank')]
class VerificationPending extends Component
{
    public $status = 'reviewing'; // reviewing, processing, pending_data
    public $progress = 40; // Simulated progress percentage

    public function render()
    {
        return view('livewire.admin-umkm.verification-pending');
    }
}
