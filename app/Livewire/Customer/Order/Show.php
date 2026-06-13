<?php

namespace App\Livewire\Customer\Order;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Payment;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.customer-layout')]
class Show extends Component
{
    use WithFileUploads;

    public Order $order;
    public $showAcceptModal = false;
    public $showNoteModal = false;
    public $newNote = '';
    public $paymentProof;
    
    public $staffTeam = [];
    public $workScope = [];
    public $workProgress = [];
    public $paymentDetails = [];
    public $verificationData = [];

    public function getWorkResultsProperty()
    {
        $photos = $this->order->photos;
        
        if (is_string($photos)) {
            $photos = json_decode($photos, true);
        }

        if (empty($photos)) {
            $raw = $this->order->getRawOriginal('photos');
            $photos = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        if ($photos && is_array($photos) && count($photos) > 0) {
            return collect($photos)->map(fn($path) => asset('storage/' . $path))->toArray();
        }
        
        return [
            'https://images.unsplash.com/photo-1581578731548-c64695cc6958?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1527515545081-5db817172677?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?q=80&w=500&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=500&auto=format&fit=crop',
        ];
    }


    public function toggleAcceptModal()
    {
        $this->showAcceptModal = !$this->showAcceptModal;
    }

    public function toggleNoteModal()
    {
        $this->showNoteModal = !$this->showNoteModal;
        $this->newNote = '';
    }

    public function submitNote()
    {
        $this->validate([
            'newNote' => 'required|string|max:500',
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Catatan Pelanggan',
            'reason' => $this->newNote,
        ]);

        $this->newNote = '';
        $this->showNoteModal = false;
        
        session()->flash('message', 'Catatan berhasil ditambahkan ke aktivitas pesanan.');
    }

    public function mount(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->order = $order->load(['umkm', 'product', 'orderAssignment.worker']);

        if ($this->order->orderAssignment && $this->order->orderAssignment->worker) {
            $worker = $this->order->orderAssignment->worker;
            $this->staffTeam = [
                [
                    'name' => $worker->name, 
                    'role' => 'Spesialis Ditugaskan', 
                    'experience' => 'Staf Tersertifikasi @ ' . $this->order->umkm->name, 
                    'initials' => strtoupper(substr($worker->name, 0, 1)),
                    'phone' => $worker->phone ?? 'Nomor tidak tersedia'
                ]
            ];
        } else {
            $this->staffTeam = [
                ['name' => 'Menunggu Penugasan', 'role' => 'Menunggu Admin', 'experience' => '-', 'initials' => '?', 'phone' => '-']
            ];
        }

        $this->workScope = [
            'Layanan: ' . $this->order->product->name,
            'Lokasi: ' . ($this->order->service_address ?? 'Alamat terdaftar'),
            'Catatan: ' . ($this->order->notes ?? 'Prosedur standar'),
        ];

        if ($this->order->status === 'processing') {
            if ($this->order->orderAssignment) {
                $this->workProgress = [
                    ['task' => 'Persiapan Alat & Bahan', 'status' => 'completed', 'time' => $this->order->updated_at->format('H:i')],
                    ['task' => 'Pengerjaan Layanan: ' . $this->order->product->name, 'status' => 'in_progress', 'time' => 'Sedang dikerjakan...'],
                    ['task' => 'Pembersihan & Finishing', 'status' => 'pending', 'time' => ''],
                    ['task' => 'Verifikasi Hasil', 'status' => 'pending', 'time' => ''],
                ];
            } else {
                $this->workProgress = [
                    ['task' => 'Menunggu Admin Menugaskan Staf', 'status' => 'pending', 'time' => ''],
                ];
            }
        } elseif (in_array($this->order->status, ['waiting_payment', 'paid', 'completed'])) {
            $this->workProgress = [
                ['task' => 'Persiapan Alat & Bahan', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Pengerjaan Layanan', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Pembersihan & Finishing', 'status' => 'completed', 'time' => '-'],
                ['task' => 'Verifikasi Hasil', 'status' => 'completed', 'time' => '-'],
            ];
        } else {
            $this->workProgress = [
                ['task' => 'Menunggu Penugasan', 'status' => 'pending', 'time' => ''],
            ];
        }

        $additionalFees = \App\Models\OrderAdditionalFee::where('order_id', $this->order->id)
                            ->where('status', 'accepted')
                            ->get();

        $additionalServices = [];
        $additionalTotal = 0;
        foreach ($additionalFees as $fee) {
            $additionalServices[] = ['name' => $fee->name, 'price' => $fee->amount];
            $additionalTotal += $fee->amount;
        }

        $this->paymentDetails = [
            'base_services' => [
                ['name' => $this->order->product->name, 'price' => $this->order->agreed_price ?? 0],
            ],
            'additional_services' => $additionalServices,
            'discounts' => [],
            'fees' => [
                ['name' => 'Biaya Layanan', 'amount' => $this->order->platform_fee ?? 0],
            ],
            'final_total' => ($this->order->agreed_price ?? 0) + $additionalTotal
        ];

        $successPayment = $this->order->payments->where('status', 'success')->first();
        if ($this->order->status === 'completed' || $this->order->status === 'paid' || $successPayment) {
            $this->verificationData = [
                'completed_at' => $successPayment ? $successPayment->paid_at->format('d M Y, H:i') : $this->order->updated_at->format('d M Y, H:i'),
                'transaction_id' => $successPayment ? (str_contains($successPayment->payment_gateway_ref, '/') ? 'TRX-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT) : ($successPayment->payment_gateway_ref ?? ('TRX-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT)))) : ($this->order->invoice_number ?? ('TRX-' . str_pad($this->order->id, 8, '0', STR_PAD_LEFT))),
                'method' => $successPayment ? $successPayment->payment_method : 'Saldo / Transfer',
                'amount' => $successPayment ? $successPayment->amount : $this->order->agreed_price,
            ];
        }
    }

    public function approveWork()
    {
        $this->order->update([
            'is_work_accepted' => true,
            'status' => 'waiting_payment',
            'current_step' => 5
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Customer Approved Work',
            'reason' => 'Customer has reviewed and accepted the work results submitted by the staff.',
        ]);

        session()->flash('message', 'Hasil kerja telah disetujui. Silahkan lakukan pembayaran.');
        $this->order->refresh();
    }

    public function submitPayment()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048',
        ], [
            'paymentProof.required' => 'File bukti transfer wajib diunggah.',
            'paymentProof.image' => 'File harus berupa gambar (JPG, PNG).',
            'paymentProof.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $this->paymentProof->store('payments/proofs', 'public');

        Payment::create([
            'order_id' => $this->order->id,
            'payment_method' => 'QRIS',
            'amount' => $this->order->agreed_price,
            'payment_gateway_ref' => $path, // Storing path here
            'status' => 'pending',
        ]);

        OrderLog::create([
            'order_id' => $this->order->id,
            'actor_id' => auth()->id(),
            'action' => 'Payment Proof Uploaded',
            'reason' => 'Customer has uploaded payment proof for verification.',
        ]);

        session()->flash('message', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi Admin.');
    }

    public function cancelOrder()
    {
        if (in_array($this->order->status, ['pending_valuation', 'negotiation', 'waiting_payment'])) {
            $this->order->update(['status' => 'cancelled']);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Order Cancelled',
                'reason' => 'Customer cancelled the order via detail page.',
            ]);

            session()->flash('message', 'Pesanan berhasil dibatalkan.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function acceptPrice()
    {
        if ($this->order->status === 'pending_valuation' && $this->order->agreed_price !== null) {
            $this->order->update([
                'status' => 'processing', // Move to processing after price agreement
                'current_step' => 4 // Move to Service Process step
            ]);
            
            $latestProposal = $this->order->messages()->where('type', 'proposal')->latest()->first();
            if ($latestProposal) {
                $metadata = $latestProposal->metadata ?? [];
                $metadata['status'] = 'accepted';
                $latestProposal->update(['metadata' => $metadata]);
            }

            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Customer Accepted Price',
                'reason' => 'Customer agreed to the negotiated price (Rp ' . number_format($this->order->agreed_price, 0, ',', '.') . ') and proceeded to payment.',
            ]);

            session()->flash('message', 'Harga disetujui. Silakan lanjutkan ke pembayaran.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function rejectPrice()
    {
        if ($this->order->status === 'pending_valuation') {
            $latestProposal = $this->order->messages()->where('type', 'proposal')->latest()->first();
            
            if ($latestProposal) {
                $metadata = $latestProposal->metadata ?? [];
                $metadata['status'] = 'rejected';
                $latestProposal->update(['metadata' => $metadata]);
            }
            
            \App\Models\OrderMessage::create([
                'order_id' => $this->order->id,
                'sender_id' => auth()->id(),
                'message' => 'Pelanggan telah menolak penawaran harga. Menunggu penawaran harga baru.',
                'type' => 'system',
            ]);

            \App\Models\UserNotification::create([
                'user_id' => $this->order->umkm->owner_id ?? $this->order->umkm_id,
                'title'   => 'Proposal Harga Ditolak',
                'message' => 'Pelanggan menolak proposal harga untuk pesanan #' . ($this->order->invoice_number ?? $this->order->id) . '. Silakan berikan penawaran harga baru.',
                'type'    => 'order_status',
                'link'    => route('umkm.orders.show', $this->order->id),
            ]);
            
            OrderLog::create([
                'order_id' => $this->order->id,
                'actor_id' => auth()->id(),
                'action' => 'Price Rejected',
                'reason' => 'Customer rejected the price proposal. Waiting for a new proposal from Admin.',
            ]);

            session()->flash('message', 'Penawaran harga ditolak. Menunggu admin memberikan harga baru.');
            return redirect()->route('customer.order-details', $this->order->id);
        }
    }

    public function render()
    {
        $logs = OrderLog::where('order_id', $this->order->id)
            ->latest()
            ->get();
            
        return view('livewire.customer.order.show', [
            'logs' => $logs
        ]);
    }
}
