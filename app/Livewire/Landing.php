<?php

namespace App\Livewire;

use App\Models\Umkm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Landing extends Component
{
    public function render()
    {
        // Mengambil 10 UMKM aktif terbaru
        $apps = Umkm::where('status', 'active')
            ->select('name', 'logo_url as logo') // Sesuaikan dengan kolom di umkm2.sql
            ->limit(10)
            ->get();

        // Jika data di database masih kosong (saat dev), kita buatkan dummy agar tidak error
        if ($apps->isEmpty()) {
            $apps = collect([
                ['name' => 'Mitra 1', 'logo' => 'https://via.placeholder.com/150?text=Mitra+1'],
                ['name' => 'Mitra 2', 'logo' => 'https://via.placeholder.com/150?text=Mitra+2'],
                ['name' => 'Mitra 3', 'logo' => 'https://via.placeholder.com/150?text=Mitra+3'],
            ]);
        }
        return view('livewire.landing', compact('apps'));
    }
}
