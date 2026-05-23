<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $perPage = 10;
    public $openFilter = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $newStatus = $user->status === 'ACTIVE' ? 'SUSPENDED' : 'ACTIVE';
        $user->update(['status' => $newStatus]);

        session()->flash('success', "Status pengguna {$user->name} berhasil diubah ke {$newStatus}.");
    }

    public function resetFilters()
    {
        $this->reset(['search', 'roleFilter', 'statusFilter', 'dateFilter']);
    }

    public function render()
    {
        $stats = [
            'total' => User::count(),
            'customer' => User::where('role', 'customer')->count(),
            'admin_umkm' => User::where('role', 'admin_umkm')->count(),
            'worker' => User::where('role', 'worker')->count(),
        ];

        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.super-admin.user-management', [
            'users' => $users,
            'stats' => $stats
        ])->layout('layouts.superadmin');
    }
}
