<?php

namespace App\Livewire\AdminUmkm;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.blank')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin-umkm.index');
    }
}
