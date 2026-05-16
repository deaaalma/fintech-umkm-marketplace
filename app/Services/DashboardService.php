<?php

namespace App\Services;

use App\Models\Umkm;
use App\Models\OrderReview;
use App\Models\IssueType;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStatsSummary()
    {
        // 1. Ambil data dasar dari tabel umkms
        $totalUmkm = \App\Models\Umkm::count();
        $activeUmkm = \App\Models\Umkm::where('status', 'active')->count();
        $pendingUmkm = \App\Models\Umkm::where('status', 'pending_verification')->count();
        $suspendedUmkm = \App\Models\Umkm::where('status', 'suspended')->count();

        // 2. Hitung Growth UMKM (30 hari terakhir vs 30 hari sebelumnya)
        $newUmkmThisMonth = \App\Models\Umkm::where('created_at', '>=', now()->subDays(30))->count();
        $umkmBeforeLastMonth = \App\Models\Umkm::where('created_at', '<', now()->subDays(30))->count();
        
        // Rumus growth: (Baru / Total Sebelum) * 100
        $umkmGrowth = $umkmBeforeLastMonth > 0 
            ? ($newUmkmThisMonth / $umkmBeforeLastMonth) * 100 
            : ($newUmkmThisMonth > 0 ? 100 : 0);

        // 3. Ambil data rating dan review
        $avgRating = \App\Models\OrderReview::avg('rating') ?? 0;
        $totalReviews = \App\Models\OrderReview::count();
        $resolvedReviews = \App\Models\OrderReview::where('is_resolved', true)->count();

        return [
            // Card 1: UMKM Stats
            [
                'title' => 'TOTAL UMKM TERDAFTAR',
                'value' => number_format($totalUmkm),
                'details' => [
                    ['label' => 'Aktif', 'value' => number_format($activeUmkm)],
                    ['label' => 'Pending', 'value' => number_format($pendingUmkm)],
                    ['label' => 'Suspended', 'value' => number_format($suspendedUmkm)],
                ],
                'change' => ($umkmGrowth >= 0 ? '+' : '') . number_format($umkmGrowth, 1) . '%',
                'changeLabel' => '30 hari ini',
                'highlight' => false
            ],

            // Card 2: Kepuasan Pelanggan (Contoh kartu kedua)
            [
                'title' => 'KEPUASAN PELANGGAN',
                'value' => number_format($avgRating, 1) . ' / 5.0',
                'details' => [
                    ['label' => 'Total Review', 'value' => number_format($totalReviews)],
                    ['label' => 'Resolved', 'value' => number_format($resolvedReviews)],
                    ['label' => 'Pending Issue', 'value' => number_format($totalReviews - $resolvedReviews)],
                ],
                'change' => 'Rating Live',
                'changeLabel' => 'Dari semua pesanan',
                'highlight' => true // Misal ini yang mau di-highlight putih
            ],
        ];
    }

    public function getPendingApplications()
    {
        // Mengambil UMKM yang butuh verifikasi beserta detailnya
        return Umkm::with(['detail', 'category', 'owner'])
            ->where('status', 'pending_verification')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function getRecentUmkms()
    {
        // List UMKM terbaru yang masuk ke sistem
        return Umkm::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function getReviewStats()
    {
        // Menghitung statistik berdasarkan issue_type_id sesuai tabel order_reviews
        // Ini akan menghasilkan data seperti: Resolusi Tiket: 78, Policy: 45, dsb.
        return DB::table('order_reviews')
            ->join('issue_types', 'order_reviews.issue_type_id', '=', 'issue_types.id')
            ->select('issue_types.name', DB::raw('count(*) as total'))
            ->groupBy('issue_types.name')
            ->get();
    }

    public function getGrowthChartData()
    {
        $data = Umkm::select(
                DB::raw('COUNT(id) as total'), 
                DB::raw("DATE_FORMAT(created_at, '%M') as month"),
                DB::raw('MIN(created_at) as sort_date') 
            )
            ->groupBy('month')
            ->orderBy('sort_date', 'asc') 
            ->get();

        // Pastikan jika data kosong, tetap mengembalikan collection kosong, bukan null/0
        return $data ?? collect([]); 
    }
}