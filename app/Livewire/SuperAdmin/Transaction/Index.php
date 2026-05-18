<?php

namespace App\Livewire\SuperAdmin\Transaction;

use App\Models\Payment; // Ganti Transaction menjadi Payment
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $activeTab = 'all';
    public $filterStatus = '';
    public $filterMethod = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $minAmount = null;
    public $maxAmount = null;

    protected $queryString = ['activeTab', 'search'];

    public function updating($property)
    {
        if (in_array($property, ['search', 'activeTab', 'filterStatus', 'filterMethod', 'dateFrom', 'dateTo', 'minAmount', 'maxAmount'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterMethod', 'dateFrom', 'dateTo', 'minAmount', 'maxAmount']);
        $this->resetPage();
    }

    public function render()
    {
        // Join 3 Tabel: payments -> orders -> umkms
        $query = Payment::query()
            ->select(
                'payments.*', 
                'orders.invoice_number', // Asumsi nama kolom di tabel orders adalah order_code
                'umkms.name as umkm_name'
            )
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->join('umkms', 'orders.umkm_id', '=', 'umkms.id');

        // 1. Logika Tabs (Sesuai dengan enum di tabel payments)
        if ($this->activeTab === 'payments') {
            $query->whereIn('payments.status', ['success', 'pending']);
        } elseif ($this->activeTab === 'refunds') {
            $query->where('payments.status', 'refunded');
        } 
        // Note: Untuk tab 'payouts' biasanya butuh tabel terpisah (misal: tabel withdrawals).
        // Sementara kita lewati filter payout agar tidak error.

        // 2. Filter Pencarian
        if ($this->search) {
            $query->where(function($q) {
                // Cari berdasarkan ref pembayaran, kode order, atau nama UMKM
                $q->where('payments.payment_gateway_ref', 'like', '%' . $this->search . '%')
                  ->orWhere('orders.order_code', 'like', '%' . $this->search . '%')
                  ->orWhere('umkms.name', 'like', '%' . $this->search . '%');
            });
        }

        // 3. Filter Status & Method (Ubah filterStatus menjadi lowercase agar cocok dengan ENUM database)
        if ($this->filterStatus) $query->where('payments.status', strtolower($this->filterStatus));
        if ($this->filterMethod) $query->where('payments.payment_method', $this->filterMethod);

        // 4. Filter Range Tanggal & Nominal
        if ($this->dateFrom) $query->whereDate('payments.created_at', '>=', $this->dateFrom);
        if ($this->dateTo) $query->whereDate('payments.created_at', '<=', $this->dateTo);
        if ($this->minAmount) $query->where('payments.amount', '>=', $this->minAmount);
        if ($this->maxAmount) $query->where('payments.amount', '<=', $this->maxAmount);

        // Hitung Statistik (Menghitung dari tabel payments)
        $totalGMV = Payment::where('status', 'success')->sum('amount');
        $commission = $totalGMV * 0.1; // Contoh komisi 10%
        $pendingPayments = Payment::where('status', 'pending')->sum('amount');
        $totalRefunds = Payment::where('status', 'refunded')->sum('amount');

        $stats = [
            ['title' => 'TOTAL GMV', 'value' => 'Rp ' . number_format($totalGMV, 0, ',', '.'), 'subtitle' => 'Total transaksi sukses'],
            ['title' => 'PLATFORM COMMISSION', 'value' => 'Rp ' . number_format($commission, 0, ',', '.'), 'subtitle' => 'Estimasi 10% dari GMV'],
            ['title' => 'PENDING PAYMENTS', 'value' => 'Rp ' . number_format($pendingPayments, 0, ',', '.'), 'subtitle' => 'Menunggu dibayar customer'],
            ['title' => 'TOTAL REFUNDS', 'value' => 'Rp ' . number_format($totalRefunds, 0, ',', '.'), 'subtitle' => 'Dana dikembalikan'],
        ];

        return view('livewire.super-admin.transaction.index', [
            'transactions' => $query->latest('payments.created_at')->paginate(15),
            'stats' => $stats
        ]);
    }
}