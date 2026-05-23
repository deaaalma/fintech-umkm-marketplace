<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Umkm;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->results = [
            'umkm' => Umkm::where('name', 'like', '%' . $this->query . '%')
                ->with('category')
                ->limit(3)
                ->get(),
            'users' => User::where('name', 'like', '%' . $this->query . '%')
                ->orWhere('email', 'like', '%' . $this->query . '%')
                ->limit(3)
                ->get(),
            'orders' => Order::where('invoice_number', 'like', '%' . $this->query . '%')
                ->limit(3)
                ->get(),
        ];

        $this->showResults = !empty($this->results['umkm']->count() || $this->results['users']->count() || $this->results['orders']->count());
    }

    public function clear()
    {
        $this->query = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.super-admin.global-search');
    }
}
