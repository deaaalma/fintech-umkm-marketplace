<?php

namespace App\Livewire\AdminUmkm\Staff;

use App\Models\User;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

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
            $worker->delete();
            $this->dispatch('notify', [
                'message' => 'Staff berhasil dihapus dari tim',
                'type' => 'success'
            ]);
        }
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        // Fetch workers associated with this UMKM
        $workers = UmkmWorker::with('user')
            ->where('umkm_id', $umkmId)
            ->when($this->search, function ($query) {
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
            'owner' => auth()->user(),
        ]);
    }
}
