<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use App\Models\Umkm;
use App\Models\Order;
use App\Models\Category;

class UmkmDetail extends Component
{
    public Umkm $umkm;
    public $activeSection = 'overview'; // For future tabs inside detail

    public function mount(Umkm $umkm)
    {
        $this->umkm = $umkm->load(['owner', 'category', 'detail']);
    }

    public function render()
    {
        // Placeholder stats (In real app, calculate from orders)
        $stats = [
            'total_orders' => 1243,
            'revenue' => 45200000,
            'avg_rating' => 4.8,
            'total_reviews' => 234,
            'response_rate' => 98,
            'response_time' => '12 min',
            'completion_rate' => 96
        ];

        // Placeholder reviews
        $reviews = [
            ['user' => 'Ahmad Fauzi', 'rating' => 5, 'comment' => 'Makanan enak, pelayanan cepat. Sangat recommended!', 'date' => '20 Jan 2026'],
            ['user' => 'Siti Nurhaliza', 'rating' => 5, 'comment' => 'Nasi gorengnya juara! Porsi besar dan harga terjangkau.', 'date' => '11 Jan 2026'],
            ['user' => 'Dedi Kurniawan', 'rating' => 4, 'comment' => 'Enak, tapi kadang agak lama. Overall bagus sih.', 'date' => '25 Dec 2025'],
        ];

        return view('livewire.super-admin.umkm-detail', [
            'stats' => $stats,
            'reviews' => $reviews
        ])->layout('layouts.superadmin');
    }
}
