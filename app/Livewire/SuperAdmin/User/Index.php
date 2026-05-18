<?php

namespace App\Livewire\SuperAdmin\User;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    use WithPagination;

    // Mendefinisikan properti yang di-bind dengan wire:model di Blade
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';
    public $filterDate = '';

    // Me-reset ke halaman pertama jika user mengetik di pencarian atau mengubah filter
    public function updating($property)
    {
        if (in_array($property, ['search', 'filterRole', 'filterStatus', 'filterDate'])) {
            $this->resetPage();
        }
    }

    // Fungsi untuk tombol "Clear Filter"
    public function clearFilters()
    {
        $this->reset(['search', 'filterRole', 'filterStatus', 'filterDate']);
        $this->resetPage();
    }

    // Aksi: Suspend atau Activate User
    public function toggleStatus($userId)
    {
        $user = User::find($userId);
        if ($user) {
            // Catatan: Pastikan tabel users punya kolom 'status'
            $user->status = $user->status === 'ACTIVE' ? 'SUSPENDED' : 'ACTIVE';
            $user->save();
        }
    }

    // Aksi: Reset Password Default
    public function resetPassword($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update([
                'password' => bcrypt('password123') // Atur default password sesuai kebijakan sistemmu
            ]);
            
            // Opsional: Kirim notifikasi sukses ke frontend
            // session()->flash('message', 'Password berhasil direset menjadi password123');
        }
    }

    // Aksi: Lihat Detail
    public function viewDetails($userId)
    {
        // Arahkan ke halaman detail user
        // return redirect()->route('superadmin.users.show', $userId);
    }

    public function render()
    {
        $query = User::query();

        // 1. Filter Pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Filter Role (Mapping dari text select option ke format ENUM database)
        if ($this->filterRole) {
            $roleMap = [
                'Customer' => 'customer',
                'UMKM Admin' => 'admin_umkm',
                'Staff' => 'worker'
            ];
            
            if (isset($roleMap[$this->filterRole])) {
                $query->where('role', $roleMap[$this->filterRole]);
            }
        }

        // 3. Filter Tanggal Daftar
        if ($this->filterDate) {
            if ($this->filterDate === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($this->filterDate === '7days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($this->filterDate === '30days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            }
        }

        // 4. Filter Status (Jika ada kolom status di DB)
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Menghitung statistik dinamis dari database
        $stats = [
            ['title' => 'TOTAL PENGGUNA', 'value' => number_format(User::count())],
            ['title' => 'CUSTOMER', 'value' => number_format(User::where('role', 'customer')->count())],
            ['title' => 'UMKM ADMIN', 'value' => number_format(User::where('role', 'admin_umkm')->count())],
            ['title' => 'STAFF / WORKER', 'value' => number_format(User::where('role', 'worker')->count())],
        ];

        return view('livewire.super-admin.user.index', [
            // Ambil data user beserta pagination-nya
            'users' => $query->latest()->paginate(15),
            'stats' => $stats
        ]);
    }
}