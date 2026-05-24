<?php

namespace App\Livewire\Customer\Partner;

use App\Models\Umkm;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Index extends Component
{
    public $search = '';
    public $activeCategory = 'semua';

    protected $queryString = ['search', 'activeCategory'];

    public function render()
    {
        $query = Umkm::where('status', 'approved')->latest();

        // Filter Search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        // Filter Category (Jika tabel UMKM punya kolom category)
        if ($this->activeCategory !== 'semua') {
            $query->where('category', $this->activeCategory);
        }

        $partners = $query->get()->map(function($p) {
            return [
                'name' => $p->name,
                'category' => $p->category ?? 'General',
                'desc' => $p->description ?? 'Layanan profesional untuk kebutuhan Anda.',
                'rating' => 5.0, // Placeholder jika belum ada sistem review
                'reviews' => 0,
                'img' => $p->logo_url ?? 'https://images.unsplash.com/photo-1521791136064-7986c2923216?w=500&q=80',
                'verified' => $p->status === 'approved'
            ];
        });

        $categories = [
            ['id' => 'semua', 'label' => 'Semua'],
            ['id' => 'digital', 'label' => 'Digital'],
            ['id' => 'cleaning', 'label' => 'Cleaning'],
            ['id' => 'catering', 'label' => 'Catering'],
            ['id' => 'laundry', 'label' => 'Laundry'],
        ];

        return view('livewire.customer.partner.index', [
            'partners' => $partners,
            'categories' => $categories
        ]);
    }
}