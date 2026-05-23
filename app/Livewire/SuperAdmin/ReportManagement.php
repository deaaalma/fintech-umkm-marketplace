<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Order;
use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReportManagement extends Component
{
    // Report Generator Parameters
    public $reportType = 'revenue';
    public $datePreset = '30_days';
    public $dateFrom;
    public $dateTo;
    public $filterUmkm = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $exportFormat = 'pdf';

    public function generateReport()
    {
        // 1. Process Date Range
        $start = Carbon::now()->subDays(30);
        $end = Carbon::now();

        if ($this->datePreset == 'this_month') {
            $start = Carbon::now()->startOfMonth();
        } elseif ($this->datePreset == 'last_quarter') {
            $start = Carbon::now()->subMonths(3)->startOfMonth();
        } elseif ($this->datePreset == 'custom' && $this->dateFrom && $this->dateTo) {
            $start = Carbon::parse($this->dateFrom)->startOfDay();
            $end = Carbon::parse($this->dateTo)->endOfDay();
        }

        // 2. Query Data
        $query = Order::with(['umkm.category'])
            ->whereBetween('created_at', [$start, $end]);

        if ($this->filterUmkm) {
            $query->where('umkm_id', $this->filterUmkm);
        }
        if ($this->filterCategory) {
            $query->whereHas('umkm', function($q) {
                $q->where('category_id', $this->filterCategory);
            });
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $orders = $query->get();

        // 3. Export Logic (CSV)
        if ($this->exportFormat == 'csv') {
            $csvHeader = ['ID', 'Date', 'UMKM', 'Category', 'Status', 'Total (Rp)'];
            $callback = function () use ($orders, $csvHeader) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $csvHeader);
                foreach ($orders as $o) {
                    fputcsv($file, [
                        $o->id,
                        $o->created_at->format('Y-m-d H:i'),
                        $o->umkm->name ?? '-',
                        $o->umkm->category->name ?? '-',
                        $o->status,
                        $o->agreed_price
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="Report_'.$this->reportType.'_'.date('YmdHis').'.csv"',
            ]);
        }

        // 4. Export Logic (PDF)
        if ($this->exportFormat == 'pdf') {
            // Kita generate simple view HTML untuk PDF
            $html = '<h2>' . strtoupper($this->reportType) . ' REPORT</h2>';
            $html .= '<p>Date: ' . $start->format('Y-m-d') . ' to ' . $end->format('Y-m-d') . '</p>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%"><tr><th>ID</th><th>Date</th><th>UMKM</th><th>Category</th><th>Status</th><th>Total (Rp)</th></tr>';
            foreach ($orders as $o) {
                $html .= '<tr>';
                $html .= '<td>'.$o->id.'</td>';
                $html .= '<td>'.$o->created_at->format('Y-m-d').'</td>';
                $html .= '<td>'.($o->umkm->name ?? '-').'</td>';
                $html .= '<td>'.($o->umkm->category->name ?? '-').'</td>';
                $html .= '<td>'.$o->status.'</td>';
                $html .= '<td>Rp '.number_format((float)$o->agreed_price, 0, ',', '.').'</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            $pdf = Pdf::loadHTML($html);
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->stream();
            }, 'Report_'.$this->reportType.'_'.date('YmdHis').'.pdf');
        }
    }

    public function render()
    {
        // 1. Core Stats
        $totalRevenue = Order::whereNotIn('status', ['cancelled'])->sum('agreed_price');
        $totalOrders = Order::count();
        $totalUmkms = Umkm::count();

        // 2. Chart Data: Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // 3. Chart Data: Monthly Revenue Trend (Last 6 Months)
        $revenueTrend = Order::where('created_at', '>=', Carbon::now()->subMonths(6))
            ->whereNotIn('status', ['cancelled'])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(agreed_price) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => Carbon::create($item->year, $item->month)->translatedFormat('M Y'),
                    'total' => (float) $item->total,
                ];
            });

        // 4. Top UMKM by Volume (Order count)
        $topUmkms = Umkm::join('orders', 'umkms.id', '=', 'orders.umkm_id')
            ->select('umkms.*', DB::raw('SUM(orders.agreed_price) as total_revenue'), DB::raw('COUNT(orders.id) as valid_orders_count'))
            ->whereNotIn('orders.status', ['cancelled'])
            ->groupBy('umkms.id')
            ->orderByDesc('valid_orders_count')
            ->limit(5)
            ->get();

        $umkmOptions = Umkm::select('id', 'name')->orderBy('name')->get();
        $categoryOptions = Category::select('id', 'name')->orderBy('name')->get();

        return view('livewire.super-admin.report-management', [
            'stats' => [
                'revenue' => $totalRevenue,
                'orders' => $totalOrders,
                'umkms' => $totalUmkms
            ],
            'chartData' => [
                'status' => $ordersByStatus,
                'trend' => $revenueTrend,
            ],
            'topUmkms' => $topUmkms,
            'umkmOptions' => $umkmOptions,
            'categoryOptions' => $categoryOptions,
        ])->layout('layouts.superadmin', ['title' => 'Laporan & Analytics']);
    }
}
