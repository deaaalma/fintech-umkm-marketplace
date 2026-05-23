<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use App\Models\Umkm;
use App\Models\CreditLog;

class UmkmDetail extends Component
{
    public Umkm $umkm;

    // Credit top-up form
    public int $creditAmount = 0;
    public string $creditNote = '';

    public function mount(Umkm $umkm)
    {
        $this->umkm = $umkm->load(['owner', 'category', 'detail']);
    }

    public function topUpCredit()
    {
        $this->validate([
            'creditAmount' => 'required|integer|min:1|max:100000',
            'creditNote'   => 'nullable|string|max:300',
        ]);

        CreditLog::create([
            'umkm_id'     => $this->umkm->id,
            'adjusted_by' => auth()->id(),
            'amount'      => $this->creditAmount,
            'type'        => 'topup',
            'note'        => $this->creditNote ?: 'Manual top-up by superadmin',
        ]);

        $this->umkm->increment('transaction_credit', $this->creditAmount);

        // Refresh model
        $this->umkm = $this->umkm->fresh(['owner', 'category', 'detail']);

        $this->reset(['creditAmount', 'creditNote']);
        $this->dispatch('message', 'Credit berhasil ditambahkan!');
    }

    public function toggleSuspend()
    {
        $newStatus = $this->umkm->status === 'suspended' ? 'active' : 'suspended';

        $this->umkm->update(['status' => $newStatus]);
        $this->umkm = $this->umkm->fresh(['owner', 'category', 'detail']);

        $label = $newStatus === 'suspended' ? 'UMKM berhasil disuspend.' : 'UMKM berhasil diaktifkan kembali.';
        $this->dispatch('message', $label);
    }

    public function render()
    {
        $creditLogs = $this->umkm->creditLogs()->with('adjustedBy')->take(5)->get();

        $stats = [
            'total_orders'    => $this->umkm->orders()->count(),
            'avg_rating'      => 4.8,
            'total_reviews'   => 234,
            'response_rate'   => 98,
            'response_time'   => '12 min',
            'completion_rate' => 96,
        ];

        $reviews = [
            ['user' => 'Ahmad Fauzi',    'rating' => 5, 'comment' => 'Makanan enak, pelayanan cepat. Sangat recommended!',     'date' => '20 Jan 2026'],
            ['user' => 'Siti Nurhaliza', 'rating' => 5, 'comment' => 'Nasi gorengnya juara! Porsi besar dan harga terjangkau.', 'date' => '11 Jan 2026'],
            ['user' => 'Dedi Kurniawan', 'rating' => 4, 'comment' => 'Enak, tapi kadang agak lama. Overall bagus sih.',          'date' => '25 Dec 2025'],
        ];

        return view('livewire.super-admin.umkm-detail', [
            'stats'      => $stats,
            'reviews'    => $reviews,
            'creditLogs' => $creditLogs,
        ])->layout('layouts.superadmin');
    }
}
