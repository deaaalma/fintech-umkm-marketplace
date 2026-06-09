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

    public function updatedSearch()
    {
        // Auto-reset category to 'semua' whenever user types in search box
        // so search is always global and not constrained by a previous category filter
        if ($this->search) {
            $this->activeCategory = 'semua';
        }
    }

    public function render()
    {
        $query = Umkm::where('status', 'active')->latest()->with('category');

        // Filter Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filter Category
        if ($this->activeCategory !== 'semua') {
            $query->where('category_id', $this->activeCategory);
        }

        $partners = $query->get()->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'category' => $p->category->name ?? 'Cleaning Service',
                'location' => $p->city ?? 'Jakarta Pusat',
                'rating' => 4.8,
                'reviews_count' => rand(50, 200),
                'tags' => ['Deep Cleaning', 'Office Cleaning', 'Home Cleaning'],
                'price_range' => 'Rp 150.000 - Rp 2.500.000',
                'img' => $p->logo_url ?? 'https://images.unsplash.com/photo-1581578731548-c64695cc6958?w=800&q=80',
            ];
        });

        // Fetch real categories from DB
        $dbCategories = \App\Models\Category::all();
        $categories = collect([
            ['id' => 'semua', 'label' => 'Semua']
        ]);

        foreach ($dbCategories as $cat) {
            $categories->push(['id' => $cat->id, 'label' => $cat->name]);
        }

        return view('livewire.customer.partner.index', [
            'partners' => $partners,
            'categories' => $categories
        ]);
    }
}