<?php

namespace App\Livewire\AdminUmkm\Order;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use App\Models\Payment;
use App\Models\UserNotification;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-umkm')]
class Show extends Component
{
    public Order $order;
    public $agreed_price;
    public $admin_note;
    public $selectedWorkerId;
    public $availableWorkers = [];
    public $showCancelModal = false;
    public $cancellationReason = '';

    public function mount(Order $order)
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        if ($order->umkm_id !== $umkmId) {
            abort(403);
        }

        $this->order = $order->load(['customer', 'product', 'orderAssignment.worker', 'payments']);
        $this->agreed_price = $order->agreed_price ?? ($order->product->estimated_price ?? 0);
        
        $this->availableWorkers = UmkmWorker::where('umkm_id', $umkmId)
            ->with('user')
            ->where('is_active', true)
            ->get();
            
        if ($this->order->orderAssignment) {
            $this->selectedWorkerId = $this->order->orderAssignment->worker_id;
        }

        // Update step ke "Tinjauan Admin" saat admin pertama kali membuka pesanan
        if ($this->order->current_step == 1) {
            $this->order->update(['current_step' => 2]);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Admin Reviewing',
                'reason' => 'Admin sedang meninjau pesanan dan mengevaluasi layanan.',
            ]);
        }
    }

    public function verifyPayment($paymentId)
    {
        $payment = Payment::find($paymentId);
        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $this->order->update([
            'status' => 'paid',
            'current_step' => 6 // Completed/Review step
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Payment Verified',
            'reason' => 'Admin has verified the QRIS payment proof and confirmed receipt of funds.',
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Order Completed',
            'reason' => 'Pesanan telah selesai. Menunggu penilaian dan ulasan dari pelanggan.',
        ]);

        // Notifikasi ke customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Pembayaran Dikonfirmasi ✓',
            'message' => 'Pembayaran untuk pesanan #' . ($this->order->invoice_number ?? 'ORDER-' . $this->order->id) . ' telah berhasil dikonfirmasi. Terima kasih!',
            'type'    => 'payment',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Jangan Lupa Berikan Ulasan ⭐',
            'message' => 'Layanan pesanan #' . ($this->order->invoice_number ?? 'ORDER-' . $this->order->id) . ' telah selesai. Yuk, berikan ulasan untuk membantu UMKM kami!',
            'type'    => 'order_status',
            'link'    => route('customer.order-review', $this->order->id),
        ]);

        session()->flash('message', 'Pembayaran berhasil diverifikasi.');
        $this->order->refresh();
    }

    public function rejectPayment($paymentId)
    {
        $payment = Payment::find($paymentId);
        $payment->update(['status' => 'failed']);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Payment Rejected',
            'reason' => 'Admin rejected the payment proof. Please re-upload a valid receipt.',
        ]);

        // Notifikasi ke customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Bukti Pembayaran Ditolak',
            'message' => 'Bukti pembayaran pesanan #' . ($this->order->invoice_number ?? $this->order->id) . ' ditolak. Silakan unggah ulang bukti pembayaran yang valid.',
            'type'    => 'payment',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        session()->flash('error', 'Pembayaran ditolak.');
        $this->order->refresh();
    }

    public function assignWorker()
    {
        $this->validate([
            'selectedWorkerId' => 'required|exists:users,id'
        ]);

        \App\Models\OrderAssignment::updateOrCreate(
            ['order_id' => $this->order->id],
            ['worker_id' => $this->selectedWorkerId, 'status' => 'assigned']
        );

        $worker = \App\Models\User::find($this->selectedWorkerId);
        $workerName = $worker ? $worker->name : 'seorang staf';

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Worker Assigned',
            'reason' => "Admin menugaskan staf ($workerName) untuk mengerjakan pesanan ini.",
        ]);

        $this->order->load('orderAssignment.worker');
        session()->flash('message', 'Petugas berhasil ditugaskan.');
    }

    public function acceptOrder()
    {
        $this->validate([
            'agreed_price' => 'required|numeric|min:0',
        ]);

        $this->order->update([
            'agreed_price' => $this->agreed_price,
            'current_step' => 3, // Move to Negotiation step
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Admin Sent Proposal',
            'reason' => 'Admin set the price to Rp ' . number_format($this->agreed_price, 0, ',', '.') . '. ' . $this->admin_note,
        ]);

        \App\Models\OrderMessage::create([
            'order_id' => $this->order->id,
            'sender_id' => auth()->id(),
            'message' => 'Penawaran harga baru',
            'type' => 'proposal',
            'metadata' => [
                'price' => $this->agreed_price,
                'note' => $this->admin_note
            ],
        ]);

        // Notifikasi ke customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Proposal Harga Diterima',
            'message' => 'Admin telah mengirimkan proposal harga Rp ' . number_format($this->agreed_price, 0, ',', '.') . ' untuk pesanan #' . ($this->order->invoice_number ?? $this->order->id) . '. Segera tinjau dan setujui harga.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        session()->flash('message', 'Proposal harga berhasil dikirim ke pelanggan.');
    }

    public function completeOrder()
    {
        $this->order->update([
            'status' => 'waiting_payment',
            'current_step' => 5
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Service Completed',
            'reason' => 'Admin marked the service as completed. Waiting for customer payment.',
        ]);

        // Notifikasi ke customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Layanan Selesai – Lakukan Pembayaran',
            'message' => 'Pengerjaan layanan untuk pesanan #' . ($this->order->invoice_number ?? $this->order->id) . ' telah selesai. Silakan tinjau hasil dan lakukan pembayaran.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        session()->flash('message', 'Layanan telah selesai. Menunggu pembayaran dari pelanggan.');
    }

    public function markAsPaidManual()
    {
        Payment::create([
            'order_id' => $this->order->id,
            'payment_method' => 'Manual/Cash',
            'amount' => $this->order->agreed_price,
            'status' => 'success',
            'paid_at' => now(),
            'payment_gateway_ref' => 'MANUAL-PAID-' . auth()->id(),
        ]);

        $this->order->update([
            'status' => 'paid',
            'current_step' => 6
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Payment Completed (Manual)',
            'reason' => 'Admin manually marked this order as paid (Cash/Manual).',
        ]);

        // Notifikasi ke customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Pesanan Lunas ✓',
            'message' => 'Pesanan #' . ($this->order->invoice_number ?? 'ORDER-' . $this->order->id) . ' telah ditandai sebagai LUNAS oleh admin. Terima kasih telah menggunakan layanan kami!',
            'type'    => 'payment',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Jangan Lupa Berikan Ulasan ⭐',
            'message' => 'Layanan pesanan #' . ($this->order->invoice_number ?? 'ORDER-' . $this->order->id) . ' telah selesai. Yuk, berikan ulasan untuk membantu UMKM kami!',
            'type'    => 'order_status',
            'link'    => route('customer.order-review', $this->order->id),
        ]);

        session()->flash('message', 'Pesanan berhasil ditandai sebagai LUNAS.');
        $this->order->refresh();
    }

    public function adminMarkServiceComplete()
    {
        // Guard: hanya bisa jika staff sudah submit (ada work_result_photos) tapi customer belum setujui
        if (!$this->order->work_result_photos || $this->order->is_work_accepted) {
            return;
        }

        $this->order->update([
            'is_work_accepted' => true,
            'status'           => 'waiting_payment',
            'current_step'     => 5,
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action'   => 'Admin Marked Service Complete',
            'reason'   => 'Admin manually confirmed service completion on behalf of the customer.',
        ]);

        // Notifikasi ke Customer
        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Layanan Selesai – Lakukan Pembayaran',
            'message' => 'Layanan pesanan #' . ($this->order->invoice_number ?? $this->order->id) . ' telah dikonfirmasi selesai oleh admin. Silakan lakukan pembayaran.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        // Notifikasi ke Staff (Worker yang ditugaskan)
        $workerId = $this->order->orderAssignment?->worker_id;
        if ($workerId) {
            UserNotification::create([
                'user_id' => $workerId,
                'title'   => 'Pekerjaan Dikonfirmasi ✓',
                'message' => 'Admin telah mengkonfirmasi penyelesaian pekerjaan Anda untuk pesanan #' . ($this->order->invoice_number ?? $this->order->id) . '. Terima kasih atas kerja keras Anda!',
                'type'    => 'order_status',
                'link'    => '#',
            ]);
        }

        session()->flash('message', 'Layanan berhasil ditandai selesai. Customer akan diminta melakukan pembayaran.');
        $this->order->refresh();
    }

    public function requestCancel()
    {
        $this->validate([
            'cancellationReason' => 'required|string|min:10|max:500',
        ], [
            'cancellationReason.required' => 'Alasan pembatalan wajib diisi.',
            'cancellationReason.min'      => 'Alasan minimal 10 karakter.',
        ]);

        $this->order->update([
            'previous_status'           => $this->order->status,
            'status'                    => 'cancel_requested',
            'cancellation_reason'       => $this->cancellationReason,
            'cancellation_requested_by' => 'admin',
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action'   => 'Admin Requested Cancellation',
            'reason'   => $this->cancellationReason,
        ]);

        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Permintaan Pembatalan Pesanan dari Admin',
            'message' => 'Admin mengajukan pembatalan pesanan #' . ($this->order->invoice_number ?? $this->order->id) . '. Alasan: ' . $this->cancellationReason . '. Silakan tinjau dan berikan persetujuan Anda.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        $this->cancellationReason = '';
        $this->showCancelModal = false;
        session()->flash('message', 'Permintaan pembatalan telah dikirim ke customer. Menunggu persetujuan.');
        $this->order->refresh();
    }

    public function approveCancel()
    {
        if ($this->order->status !== 'cancel_requested' || $this->order->cancellation_requested_by !== 'customer') {
            return;
        }

        $this->order->update(['status' => 'cancelled']);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action'   => 'Admin Approved Cancellation',
            'reason'   => 'Admin menyetujui permintaan pembatalan dari Customer.',
        ]);

        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Pesanan Dibatalkan',
            'message' => 'Permintaan pembatalan pesanan #' . ($this->order->invoice_number ?? $this->order->id) . ' telah disetujui oleh Admin.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        session()->flash('message', 'Permintaan pembatalan customer disetujui. Pesanan dibatalkan.');
        $this->order->refresh();
    }

    public function rejectCancel()
    {
        if ($this->order->status !== 'cancel_requested' || $this->order->cancellation_requested_by !== 'customer') {
            return;
        }

        $this->order->update([
            'status'                    => $this->order->previous_status ?? 'pending_valuation',
            'cancellation_reason'       => null,
            'cancellation_requested_by' => null,
            'previous_status'           => null,
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action'   => 'Admin Rejected Cancellation',
            'reason'   => 'Admin menolak permintaan pembatalan dari Customer. Pesanan dilanjutkan.',
        ]);

        UserNotification::create([
            'user_id' => $this->order->customer_id,
            'title'   => 'Permintaan Pembatalan Ditolak',
            'message' => 'Admin menolak permintaan pembatalan pesanan #' . ($this->order->invoice_number ?? $this->order->id) . '. Pesanan Anda dilanjutkan kembali.',
            'type'    => 'order_status',
            'link'    => route('customer.order-details', $this->order->id),
        ]);

        session()->flash('message', 'Permintaan pembatalan ditolak. Pesanan dilanjutkan kembali.');
        $this->order->refresh();
    }

    public function getSitePhotosProperty()
    {
        $photos = $this->order->photos;
        
        // Safety decode if it comes back as a string
        if (is_string($photos)) {
            $photos = json_decode($photos, true);
        }

        // Final fallback to raw original if still empty/null
        if (!$photos) {
            $raw = $this->order->getRawOriginal('photos');
            $photos = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        if ($photos && is_array($photos) && count($photos) > 0) {
            return collect($photos)->map(fn($path) => asset('storage/' . $path))->toArray();
        }
        
        return [];
    }

    public function render()
    {
        $logs = OrderLog::where('order_id', $this->order->id)->latest()->get();
        return view('livewire.admin-umkm.order.show', [
            'logs' => $logs
        ]);
    }
}
