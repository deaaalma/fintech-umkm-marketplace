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
        $task = $this->selectedTask;
        $order = $task->order;

        // If task hasn't started, mark as processing
        if ($order->status === 'paid' || $order->status === 'waiting_payment') {
            $order->update(['status' => 'processing']);
            \App\Models\OrderLog::create([
                'order_id' => $order->id,
                'actor_id' => Auth::id(),
                'action' => 'Worker Started Job',
                'reason' => 'Worker has arrived at the location and started the service.',
            ]);
        }

        // Reset form
        $this->summary = '';
        $this->photos = [];
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

    public function submitReport()
    {
        $this->validate([
            'summary' => 'required|min:10',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|max:2048', // 2MB Max
        ]);

        $task = $this->selectedTask;
        $order = $task->order;

        // Process photos
        $photoPaths = [];
        foreach ($this->photos as $photo) {
            $path = $photo->store('work-results', 'public');
            $photoPaths[] = $path;
        }

        // Update Order
        $order->update([
            'status' => 'waiting_payment',
            'worker_notes' => $this->summary,
            'work_result_photos' => $photoPaths,
            'current_step' => 5 // Payment step
        ]);

        // Update Assignment
        $task->update(['status' => 'completed']);

        // Log
        \App\Models\OrderLog::create([
            'order_id' => $order->id,
            'actor_id' => Auth::id(),
            'action' => 'Staff Submitted Report',
            'reason' => 'Staff finished the task and submitted work results. ' . $this->summary,
        ]);

        session()->flash('message', 'Laporan berhasil dikirim. Menunggu pembayaran dari customer.');
        $this->selectedTaskId = null;
    }

    public function render()
    {
        return view('livewire.worker.tasks', [
            'tasks' => $this->tasks,
            'selectedTask' => $this->selectedTask
        ]);
    }
}
