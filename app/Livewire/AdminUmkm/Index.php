<?php

namespace App\Livewire\AdminUmkm;

use App\Services\DashboardService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    public function render(DashboardService $dashboardService)
    {
        return view('livewire.admin-umkm.index', [
            'stats' => $dashboardService->getStatsSummary(),
            'pendingApplications' => $dashboardService->getPendingApplications(),
            'recentUMKM' => $dashboardService->getRecentUmkms(),
            'chartData' => $dashboardService->getGrowthChartData(),
        ]);
    }
}
