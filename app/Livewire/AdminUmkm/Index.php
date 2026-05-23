<?php

namespace App\Livewire\AdminUmkm;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.blank')]
class Index extends Component
{
    public $search = '';

    public function render()
    {
        $allOrders = [
            ['id' => 'ORD-12345', 'client' => 'Ahmad S.', 'item' => 'Deep Cleaning', 'status' => 'Pending', 'color' => 'amber', 'time' => '10:30'],
            ['id' => 'ORD-12344', 'client' => 'Budi T.', 'item' => 'Office Clean', 'status' => 'Active', 'color' => 'blue', 'time' => '10:15'],
            ['id' => 'ORD-12343', 'client' => 'Siti N.', 'item' => 'Regular Clean', 'status' => 'Pending', 'color' => 'amber', 'time' => '09:45'],
            ['id' => 'ORD-12342', 'client' => 'Joko W.', 'item' => 'Deep Cleaning', 'status' => 'Paid', 'color' => 'teal', 'time' => '09:20'],
            ['id' => 'ORD-12341', 'client' => 'Ani P.', 'item' => 'Office Clean', 'status' => 'Active', 'color' => 'blue', 'time' => '08:50'],
        ];

        $recentOrders = collect($allOrders)->filter(function($order) {
            if (empty($this->search)) return true;
            return str_contains(strtolower($order['id']), strtolower($this->search)) || 
                   str_contains(strtolower($order['client']), strtolower($this->search));
        });

        return view('livewire.admin-umkm.index', [
            'recentOrders' => $recentOrders
        ]);
    }
}
