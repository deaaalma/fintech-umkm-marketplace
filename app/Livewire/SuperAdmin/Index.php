<?php

namespace App\Livewire\Superadmin;

use App\Models\Order;
use App\Models\Umkm;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.superadmin')]
class Index extends Component
{
    public $search = '';
    public $showReviewModal = false;
    public $selectedUmkmLoad = null;

    public function openReview($id)
    {
        $this->selectedUmkmLoad = Umkm::with(['detail', 'category', 'owner'])->findOrFail($id);
        $this->showReviewModal = true;
    }

    public function approveUmkm($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'active']);

        $this->showReviewModal = false;
        session()->flash('success', "UMKM {$umkm->name} telah disetujui!");
    }

    public function rejectUmkm($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'suspended']); 

        $this->showReviewModal = false;
        session()->flash('error', "UMKM {$umkm->name} telah ditangguhkan.");
    }

    public function render(DashboardService $dashboardService)
    {
        return view('livewire.super-admin.index', [
            'stats' => $dashboardService->getStatsSummary(),
            'pendingApplications' => $dashboardService->getPendingApplications($this->search),
            'recentUMKM' => $dashboardService->getRecentUmkms(),
            'chartData' => $dashboardService->getGrowthChartData(),
        ]);
    }
}