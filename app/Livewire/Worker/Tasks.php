<?php

namespace App\Livewire\Worker;

use App\Models\OrderAssignment;
use App\Models\OrderChecklist;
use App\Models\UserNotification;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.worker-layout')]
class Tasks extends Component
{
    use WithFileUploads;

    public $filter = 'hari-ini';
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
        $task  = $this->selectedTask;
        $order = $task->order;

        // If task hasn't started, mark as processing
        if ($order->status === 'paid' || $order->status === 'waiting_payment') {
            $order->update(['status' => 'processing']);
            \App\Models\OrderLog::create([
                'order_id' => $order->id,
                'actor_id' => Auth::id(),
                'action'   => 'Worker Started Job',
                'reason'   => 'Worker has arrived at the location and started the service.',
            ]);
        }

        // Reset form
        $this->summary = '';
        $this->photos  = [];

        // --- Checklist Dinamis ---
        $productId = $order->product_id;
        $umkmId    = $order->umkm_id;

        $items = OrderChecklist::where('umkm_id', $umkmId)
            ->where('is_active', true)
            ->where(function ($q) use ($productId) {
                $q->where('product_id', $productId)->orWhereNull('product_id');
            })
            ->orderBy('sort_order')
            ->get();

        if ($items->isNotEmpty()) {
            $this->checklist = $items->map(fn($item) => [
                'id'      => $item->id,
                'label'   => $item->label,
                'checked' => false,
            ])->toArray();
        } else {
            // Fallback hardcoded jika belum ada data di DB
            $this->checklist = [
                ['id' => 1, 'label' => 'Persiapan alat', 'checked' => false],
                ['id' => 2, 'label' => 'Briefing customer', 'checked' => false],
                ['id' => 3, 'label' => 'Pembersihan area utama', 'checked' => false],
                ['id' => 4, 'label' => 'Quality check', 'checked' => false],
            ];
        }
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
            'summary'  => 'required|min:10',
            'photos'   => 'required|array|min:1',
            'photos.*' => 'image|max:2048',
        ]);

        $task  = $this->selectedTask;
        $order = $task->order;

        // Process photos
        $photoPaths = [];
        foreach ($this->photos as $photo) {
            $photoPaths[] = $photo->store('work-results', 'public');
        }

        // Update Order
        $order->update([
            'worker_notes'       => $this->summary,
            'work_result_photos' => $photoPaths,
            'is_work_accepted'   => false,
        ]);

        // Update Assignment
        $task->update(['status' => 'completed']);

        // Log
        \App\Models\OrderLog::create([
            'order_id' => $order->id,
            'actor_id' => Auth::id(),
            'action'   => 'Staff Submitted Report',
            'reason'   => 'Staff finished the task and submitted work results. ' . $this->summary,
        ]);

        // Notifikasi ke Admin UMKM
        $adminId = Umkm::find($order->umkm_id)?->owner_id;
        if ($adminId) {
            UserNotification::create([
                'user_id' => $adminId,
                'title'   => 'Staff Telah Submit Laporan',
                'message' => 'Staff telah menyelesaikan pengerjaan pesanan #' . ($order->invoice_number ?? $order->id) . '. Silakan tinjau hasilnya atau tunggu persetujuan customer.',
                'type'    => 'order_status',
                'link'    => route('umkm.orders.show', $order->id),
            ]);
        }

        // Notifikasi ke Customer
        UserNotification::create([
            'user_id' => $order->customer_id,
            'title'   => 'Hasil Kerja Siap Ditinjau ✓',
            'message' => 'Pengerjaan pesanan #' . ($order->invoice_number ?? $order->id) . ' telah selesai. Silakan tinjau dan setujui hasilnya untuk melanjutkan ke pembayaran.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $order->id),
        ]);

        session()->flash('message', 'Laporan berhasil dikirim. Menunggu persetujuan dari customer.');
        $this->selectedTaskId = null;
    }

    public function render()
    {
        return view('livewire.worker.tasks', [
            'tasks'        => $this->tasks,
            'selectedTask' => $this->selectedTask,
        ]);
    }
}
