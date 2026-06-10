<?php

namespace App\Livewire\AdminUmkm;

use App\Models\Umkm;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Verification extends Component
{
    public function render()
    {
        $umkm = Umkm::where('owner_id', auth()->id())->first();

        // Redirect if already active (verified)
        if ($umkm && $umkm->status === 'active') {
            return redirect()->route('umkm.dashboard');
        }

        // Ambil status asli dari database, default 'pending' jika belum ada
        $currentStatus = $umkm->status ?? 'pending';

        // Mapping step untuk tampilan dinamis
        $steps = [
            [
                'title' => 'Tahap pendaftaran',
                'status' => in_array($currentStatus, ['pending', 'reviewed', 'approved']) ? 'check' : 'waiting'
            ],
            [
                'title' => 'Proses verifikasi admin',
                'status' => $currentStatus == 'reviewed' ? 'active' : ($currentStatus == 'approved' ? 'check' : 'waiting')
            ],
            [
                'title' => 'Status pendaftaran selesai',
                'status' => $currentStatus == 'approved' ? 'check' : 'waiting'
            ]
        ];

        return view('livewire.admin-umkm.verification', [
            'steps' => $steps,
            'umkmStatus' => $currentStatus
        ]);
    }
}
