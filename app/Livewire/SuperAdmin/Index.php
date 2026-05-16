<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
       return view('livewire.super-admin.index')
            ->layout('layouts.admin-layout'); // Menunjuk ke folder layouts
    }
}
