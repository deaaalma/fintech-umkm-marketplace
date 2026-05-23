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
        // 1. Ambil data dasar UMKM
        $totalUmkm = \App\Models\Umkm::count();
        $activeUmkm = \App\Models\Umkm::where('status', 'active')->count();
        $suspendedUmkm = \App\Models\Umkm::where('status', 'suspended')->count();
        $pendingUmkm = \App\Models\Umkm::where('status', 'pending_verification')->count();

        // 2. Data Transaksi & Pendapatan
        $totalOrders = \App\Models\Order::count();
        $completedOrders = \App\Models\Order::where('status', 'completed')->count();
        $totalRevenue = \App\Models\Payment::where('status', 'success')->sum('amount');

        // 4. Data Review & Rating
        $avgRating = \App\Models\OrderReview::avg('rating') ?? 0;
        $totalReviews = \App\Models\OrderReview::count();
        $resolvedIssues = \App\Models\OrderReview::where('is_resolved', true)->count();

        // 5. Data Pengguna (Untuk Dashboard Metrics)
        $totalUsers = \App\Models\User::count();
        $customers = \App\Models\User::where('role', 'customer')->count();
        $adminUmkm = \App\Models\User::where('role', 'admin_umkm')->count();
        $staffCount = $totalUsers - $customers - $adminUmkm;

        return [
            'user_stats' => [
                'total_users' => $totalUsers,
                'customer' => $customers,
                'admin_umkm' => $adminUmkm,
                'staff' => $staffCount
            ],
            'umkm_stats' => [
                'total_umkm' => $totalUmkm,
                'active' => $activeUmkm,
                'suspended' => $suspendedUmkm,
                'pending' => $pendingUmkm
            ],
            // ── EXISTING LIST FORMAT FOR OTHER CARDS ──
            'cards' => [
                [
                    'title' => 'PENDING APPROVAL',
                    'value' => number_format($pendingUmkm),
                    'details' => [['label' => 'Butuh Review', 'value' => number_format($pendingUmkm)]],
                    'highlight' => $pendingUmkm > 0,
                ],
                [
                    'title' => 'TOTAL TRANSAKSI',
                    'value' => number_format($totalOrders),
                    'details' => [
                        ['label' => 'Selesai', 'value' => number_format($completedOrders)],
                        ['label' => 'Revenue', 'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')],
                    ],
                    'highlight' => false
                ],
                [
                    'title' => 'KEPUASAN PELANGGAN',
                    'value' => number_format($totalReviews),
                    'details' => [
                        ['label' => 'Isu Selesai', 'value' => number_format($resolvedIssues)],
                        ['label' => 'Isu Pending', 'value' => number_format($totalReviews - $resolvedIssues)],
                    ],
                    'highlight' => false
                ]
            ]
        ];
    }

    public function getPendingApplications($search = null)
    {
        // Mengambil UMKM yang butuh verifikasi beserta detailnya
        $query = Umkm::with(['detail', 'category', 'owner'])
            ->where('status', 'pending_verification');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        return $query->orderBy('created_at', 'desc')
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