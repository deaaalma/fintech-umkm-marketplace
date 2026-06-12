<?php

namespace App\Livewire\AdminUmkm\Staff;

use App\Models\User;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use App\Services\Staff\StaffService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $status = '';

    public function resetFilters()
    {
        $this->search = '';
        $this->role = '';
        $this->status = '';
    }

    public function toggleStatus($workerId)
    {
        $worker = UmkmWorker::find($workerId);
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        if ($worker && $worker->umkm_id === $umkmId) {
            $worker->update([
                'is_active' => !$worker->is_active
            ]);
            
            $this->dispatch('notify', [
                'message' => 'Status staff berhasil diperbarui',
                'type' => 'success'
            ]);
        }
    }

    public function delete($workerId)
    {
        $worker = UmkmWorker::find($workerId);
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        if ($worker && $worker->umkm_id === $umkmId) {
            $service = app(StaffService::class);
            $service->delete($worker);
            $this->dispatch('notify', [
                'message' => 'Staff berhasil dihapus dari tim',
                'type' => 'success'
            ]);
        }
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        $showOwner = $this->role !== 'staff';
        $showStaff = $this->role !== 'admin';

        $owner = auth()->user();
        if ($this->search && $showOwner) {
            $searchLower = strtolower($this->search);
            if (!str_contains(strtolower($owner->name ?? ''), $searchLower) &&
                !str_contains(strtolower($owner->email ?? ''), $searchLower) &&
                !str_contains(strtolower($owner->phone ?? ''), $searchLower)) {
                $showOwner = false;
            }
        }

        // Fetch workers associated with this UMKM
        $workersQuery = UmkmWorker::with('user')->where('umkm_id', $umkmId);
        
        if (!$showStaff) {
            $workersQuery->whereRaw('1 = 0');
        }

        if ($this->status === 'active') {
            $workersQuery->where('is_active', true);
        } elseif ($this->status === 'inactive') {
            $workersQuery->where('is_active', false);
        }

        $workers = $workersQuery->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                })->orWhere('specialization', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-umkm.staff.index', [
            'workers' => $workers,
            'owner' => $owner,
            'showOwner' => $showOwner,
        ]);
    }
}
