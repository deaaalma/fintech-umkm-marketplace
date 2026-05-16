<?php

namespace App\Livewire\Superadmin;

use App\Models\Order;
use App\Models\Umkm;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    public function render(DashboardService $dashboardService)
    {
        return view('livewire.super-admin.index', [
            'stats' => $dashboardService->getStatsSummary(),
            'pendingApplications' => $dashboardService->getPendingApplications(),
            'recentUMKM' => $dashboardService->getRecentUmkms(),
            'chartData' => $dashboardService->getGrowthChartData(),
        ]);
    }
}