<?php

namespace App\Livewire\Worker;

use App\Models\Order;
use App\Models\OrderAssignment;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.worker-layout')]
class Tasks extends Component
{
    use WithFileUploads;

    public $filter = 'hari-ini'; // upcoming, hari-ini, in-progress, completed
    public $selectedTaskId = null;
    
    // Progress Form
    public $summary;
    public $photos = [];
    public $checklist = [];

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->selectedTaskId = null;
    }

    public function selectTask($id)
    {
        $this->selectedTaskId = $id;
        // Reset form
        $this->summary = '';
        $this->photos = [];
        // In real app, load checklist from DB
        $this->checklist = [
            ['id' => 1, 'label' => 'Persiapan alat', 'checked' => false],
            ['id' => 2, 'label' => 'Briefing customer', 'checked' => false],
            ['id' => 3, 'label' => 'Pembersihan area utama', 'checked' => false],
            ['id' => 4, 'label' => 'Quality check', 'checked' => false],
        ];
    }

    public function backToList()
    {
        $this->selectedTaskId = null;
    }

    public function getTasksProperty()
    {
        $query = OrderAssignment::where('worker_id', Auth::id())
            ->with(['order.umkm', 'order.product']);

        switch ($this->filter) {
            case 'upcoming':
                $query->whereHas('order', fn($q) => $q->where('booking_date', '>', now())->where('status', 'processing'));
                break;
            case 'hari-ini':
                $query->whereHas('order', fn($q) => $q->whereDate('booking_date', now()));
                break;
            case 'in-progress':
                $query->whereHas('order', fn($q) => $q->where('status', 'processing'));
                break;
            case 'completed':
                $query->whereHas('order', fn($q) => $q->where('status', 'completed'));
                break;
        }

        return $query->get();
    }

    public function getSelectedTaskProperty()
    {
        if (!$this->selectedTaskId) return null;
        return OrderAssignment::with(['order.umkm', 'order.product'])
            ->find($this->selectedTaskId);
    }

    public function render()
    {
        return view('livewire.worker.tasks', [
            'tasks' => $this->tasks,
            'selectedTask' => $this->selectedTask
        ]);
    }
}
