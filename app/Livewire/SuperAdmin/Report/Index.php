<?php

namespace App\Livewire\SuperAdmin\Report;

use Carbon\Carbon;
use App\Models\Umkm;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    // Properti Form Generator
    public $reportType = 'revenue';
    public $dateFrom = '';
    public $dateTo = '';
    public $filterUmkm = '';
    public $filterStatus = '';
    public $datePreset = '30days';
    public $filterCategory = '';
    public $format = 'pdf';

    // Hook untuk mengubah Custom Date secara otomatis saat Preset dipilih
    public function updatedDatePreset($value)
    {
        $today = Carbon::today()->format('Y-m-d');
        
        switch ($value) {
            case '7days':
                $this->dateFrom = Carbon::today()->subDays(7)->format('Y-m-d');
                $this->dateTo = $today;
                break;
            case '30days':
                $this->dateFrom = Carbon::today()->subDays(30)->format('Y-m-d');
                $this->dateTo = $today;
                break;
            case '90days':
                $this->dateFrom = Carbon::today()->subDays(90)->format('Y-m-d');
                $this->dateTo = $today;
                break;
            case 'this_month':
                $this->dateFrom = Carbon::today()->startOfMonth()->format('Y-m-d');
                $this->dateTo = $today;
                break;
            case 'last_month':
                $this->dateFrom = Carbon::today()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->dateTo = Carbon::today()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->dateFrom = Carbon::today()->startOfYear()->format('Y-m-d');
                $this->dateTo = $today;
                break;
            case 'custom':
                $this->dateFrom = '';
                $this->dateTo = '';
                break;
        }
    }

    public function generateReport()
    {
        // Simulasi proses loading (agar efek tombol berubah jadi "Generating..." terlihat)
        sleep(1); 
        
        // Logika untuk query data berdasarkan filter dan merender PDF/Excel nantinya
        
        session()->flash('message', 'Laporan ' . strtoupper($this->format) . ' sedang diproses dan akan segera diunduh.');
    }

    public function addSchedule()
    {
        // Logika membuka modal tambah jadwal
    }

    public function editSchedule($id)
    {
        // Logika membuka modal edit jadwal
    }

    public function deleteSchedule($id)
    {
        // Logika menghapus jadwal
    }

    public function mount()
    {
        // Set tanggal default saat halaman pertama kali dibuka
        $this->updatedDatePreset($this->datePreset);
    }

    public function render()
    {
        // 1. Ambil daftar UMKM untuk dropdown filter
        // Hasilnya berupa array: [1 => 'BWP Cleaning', 2 => 'Express Laundry', ...]
        $availableUmkms = Umkm::orderBy('name')->pluck('name', 'id')->toArray();

        // 2. Mengambil Top 10 UMKM Asli dari Database
        $topUmkmsData = Umkm::select(
                'umkms.name',
                DB::raw('SUM(payments.amount) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->join('orders', 'umkms.id', '=', 'orders.umkm_id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'success')
            ->groupBy('umkms.id', 'umkms.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Mapping format angka
        $topUMKMs = $topUmkmsData->map(function ($umkm, $index) {
            return [
                'rank' => $index + 1,
                'name' => $umkm->name,
                'revenue' => 'Rp ' . number_format($umkm->total_revenue, 0, ',', '.'),
                'orders' => $umkm->total_orders
            ];
        });

        // 3. Data Scheduled Reports (Masih dummy, siap diganti dari DB jika tabelnya sudah ada)
        $scheduledReports = [
            [
                'id' => 1,
                'name' => 'Weekly Revenue Report',
                'frequency' => 'Every Monday, 9:00 AM',
                'next_run' => '27 Jan 2026, 09:00',
                'format' => 'PDF'
            ],
            [
                'id' => 2,
                'name' => 'Monthly UMKM Performance',
                'frequency' => 'First day of month, 10:00 AM',
                'next_run' => '01 Feb 2026, 10:00',
                'format' => 'Excel'
            ],
        ];

        return view('livewire.super-admin.report.index', compact('topUMKMs', 'scheduledReports', 'availableUmkms'));
    }
}