<?php

namespace App\Livewire\Worker;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.worker-layout')]
class Tasks extends Component
{
    public function render()
    {
        return <<<'HTML'
            <div>
                <h1 class="text-2xl font-black text-gray-900 font-plus mb-6">Tugas Saya</h1>
                <p class="text-gray-500 font-medium italic">Halaman daftar tugas sedang dalam pengerjaan...</p>
            </div>
        HTML;
    }
}
