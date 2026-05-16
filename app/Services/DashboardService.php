<?php

namespace App\Services;

use App\Models\Umkm;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStatsSummary(): array
    {
        $now = Carbon::now();
        $last30Days = $now->copy()->subDays(30);
        $last60Days = $now->copy()->subDays(60);

        // Perhitungan UMKM
        $totalUmkm = Umkm::count();
        $activeUmkm = Umkm::where('status', 'active')->count();
        $pendingUmkm = Umkm::where('status', 'pending_verification')->count();
        $suspendedUmkm = Umkm::where('status', 'suspended')->count();
        
        $umkmThisMonth = Umkm::where('created_at', '>=', $last30Days)->count();
        $umkmLastMonth = Umkm::whereBetween('created_at', [$last60Days, $last30Days])->count();
        $umkmGrowth = $umkmLastMonth > 0 ? (($umkmThisMonth - $umkmLastMonth) / $umkmLastMonth) * 100 : ($umkmThisMonth > 0 ? 100 : 0);

        // Perhitungan Transaksi
        $totalOrders = Order::count();
        $successOrders = Order::whereIn('status', ['paid', 'processing', 'completed'])->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        return [
            [
                'title' => 'TOTAL UMKM TERDAFTAR',
                'value' => number_format($totalUmkm),
                'details' => [
                    ['label' => 'Aktif', 'value' => number_format($activeUmkm)],
                    ['label' => 'Pending', 'value' => number_format($pendingUmkm)],
                    ['label' => 'Suspended', 'value' => number_format($suspendedUmkm)],
                ],
                'change' => ($umkmGrowth >= 0 ? '+' : '') . number_format($umkmGrowth, 1) . '%',
                'changeLabel' => '30 hari ini'
            ],
            [
                'title' => 'APPROVAL PENDING',
                'value' => number_format($pendingUmkm),
                'highlight' => true,
                'details' => [
                    ['label' => 'High risk auto-reject', 'value' => '12 hari'],
                    ['label' => 'Avg approval (30 d)', 'value' => '2.4 hari'],
                ],
                'action' => 'Review Sekarang'
            ],
            [
                'title' => 'TOTAL TRANSAKSI',
                'value' => number_format($totalOrders),
                'details' => [
                    ['label' => 'Sukses (Selesai/Dibayar)', 'value' => number_format($successOrders)],
                    ['label' => 'Dibatalkan', 'value' => number_format($cancelledOrders)],
                ]
            ],
            // Dummy Data Kepuasan & Rating...
            [
                'title' => 'KEPUASAN PELANGGAN',
                'value' => '189',
                'details' => [
                    ['label' => 'Resolusi tiketnya', 'value' => '78'],
                    ['label' => 'Lainnya', 'value' => '32'],
                ]
            ],
            [
                'title' => 'RATING RATA-RATA',
                'value' => '4.7',
                'rating' => true,
                'ratingBars' => [
                    ['stars' => 5, 'count' => 892],
                    ['stars' => 4, 'count' => 456],
                ]
            ]
        ];
    }

    public function getPendingApplications()
    {
        return Umkm::where('status', 'pending_verification')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($umkm) {
                $waitingDays = Carbon::parse($umkm->created_at)->diffInDays(Carbon::now());
                $priority = $waitingDays > 3 ? 'TINGGI' : ($waitingDays == 0 ? 'RENDAH' : 'NORMAL');
                
                $completeness = 50; 
                if ($umkm->description) $completeness += 20;
                if ($umkm->address) $completeness += 30;

                return [
                    'id' => 'APP-' . str_pad($umkm->id, 4, '0', STR_PAD_LEFT),
                    'name' => $umkm->name,
                    'category' => 'General',
                    'date' => Carbon::parse($umkm->created_at)->diffForHumans(),
                    'completeness' => $completeness,
                    'priority' => $priority,
                    'status' => 'Review'
                ];
            });
    }

    public function getRecentUmkms($limit = 5)
    {
        return Umkm::where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->take($limit)
            ->get()
            ->map(fn($umkm) => [
                'name' => $umkm->name,
                'category' => 'General UMKM',
                'time' => Carbon::parse($umkm->updated_at)->diffForHumans(),
            ]);
    }

    public function getGrowthChartData(): array
    {
        $trendUmkm = Umkm::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')->orderBy('month')->pluck('total', 'month')->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $trendUmkm[$i] ?? 0;
        }
        return $chartData;
    }
}