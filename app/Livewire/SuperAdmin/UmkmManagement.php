<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Umkm;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class UmkmManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';
    public $ratingFilter = 0;
    public $activeTab = 'directory'; // 'directory' or 'queue'
    public $viewingUmkm = null; // Store UMKM object for detail modal
    public $selectedUmkms = []; // Store selected IDs for bulk actions
    
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'activeTab' => ['except' => 'directory'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'categoryFilter', 'ratingFilter']);
    }

    public function render()
    {
        // Filter Dasar berdasarkan Tab
        if ($this->activeTab === 'queue') {
            $query = Umkm::where('status', 'pending_verification')->with(['owner', 'category', 'detail']);
        } else {
            $query = Umkm::whereIn('status', ['active', 'suspended', 'rejected'])->with(['owner', 'category', 'detail']);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('owner', fn($oq) => $oq->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Stats calculation for the header cards
        $stats = [
            'total' => Umkm::count(),
            'active' => Umkm::where('status', 'active')->count(),
            'pending' => Umkm::where('status', 'pending_verification')->count(),
            'suspended' => Umkm::where('status', 'suspended')->count(),
            'rejected' => Umkm::where('status', 'rejected')->count(),
        ];

        return view('livewire.super-admin.umkm-management', [
            'umkms' => $query->latest()->paginate(10),
            'categories' => Category::all(),
            'stats' => $stats
        ])->layout('layouts.superadmin');
    }

    public function bulkSuspend()
    {
        if (empty($this->selectedUmkms)) return;
        Umkm::whereIn('id', $this->selectedUmkms)->update(['status' => 'suspended']);
        $this->reset(['selectedUmkms']);
        $this->dispatch('message', 'Berhasil suspend UMKM yang dipilih!');
    }

    public function bulkDelete()
    {
        if (empty($this->selectedUmkms)) return;
        
        try {
            \DB::transaction(function() {
                // Delete related records first to avoid integrity issues
                \App\Models\Order::whereIn('umkm_id', $this->selectedUmkms)->delete();
                \App\Models\Product::whereIn('umkm_id', $this->selectedUmkms)->delete();
                \App\Models\UmkmDetail::whereIn('umkm_id', $this->selectedUmkms)->delete();
                
                // Finally delete the UMKMs
                Umkm::whereIn('id', $this->selectedUmkms)->delete();
            });

            $this->reset(['selectedUmkms']);
            $this->dispatch('message', 'Berhasil membersihkan UMKM yang dipilih!');
        } catch (\Exception $e) {
            $this->dispatch('message', 'Gagal hapus: Beberapa data masih terkunci sistem. Gunakan "Suspend" sebagai alternatif.');
        }
    }

    public function bulkApprove()
    {
        if (empty($this->selectedUmkms)) return;
        Umkm::whereIn('id', $this->selectedUmkms)->update(['status' => 'active']);
        $count = count($this->selectedUmkms);
        $this->reset(['selectedUmkms']);
        $this->dispatch('message', "Sukses memverifikasi $count UMKM!");
    }

    public function bulkReject()
    {
        if (empty($this->selectedUmkms)) return;
        Umkm::whereIn('id', $this->selectedUmkms)->update(['status' => 'rejected']);
        $count = count($this->selectedUmkms);
        $this->reset(['selectedUmkms']);
        $this->dispatch('message', "Berhasil menolak $count pengajuan UMKM.");
    }

    public function showDetail($id)
    {
        $this->viewingUmkm = Umkm::with(['owner', 'category', 'detail'])->find($id);
    }

    public function closeDetail()
    {
        $this->viewingUmkm = null;
    }

    public function approve($id)
    {
        $umkm = Umkm::find($id);
        $umkm->update(['status' => 'active']);
        $this->closeDetail();
        $this->dispatch('message', "UMKM {$umkm->name} resmi terverifikasi!");
    }

    public function reject($id)
    {
        $umkm = Umkm::find($id);
        $umkm->update(['status' => 'rejected']);
        $this->closeDetail();
        $this->dispatch('message', "Pengajuan {$umkm->name} telah ditolak.");
    }
}
