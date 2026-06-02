<?php

namespace App\Livewire\Worker;

use App\Models\Order;
use App\Models\OrderAssignment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('layouts.worker-layout')]
class Index extends Component
{
    public function render()
    {
        $workerId = Auth::id();
        
        // Tugas Hari Ini
        $tasksToday = OrderAssignment::where('worker_id', $workerId)
            ->whereHas('order', function($query) {
                $query->whereDate('booking_date', Carbon::today());
            })
            ->with(['order.umkm', 'order.product'])
            ->get();

        // Tugas Minggu Ini (Summary)
        $tasksThisWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $count = OrderAssignment::where('worker_id', $workerId)
                ->whereHas('order', function($query) use ($date) {
                    $query->whereDate('booking_date', $date);
                })
                ->count();
            
            $tasksThisWeek[] = [
                'day' => $date->translatedFormat('l'),
                'date' => $date->translatedFormat('d M Y'),
                'count' => $count,
                'is_today' => $i === 0
            ];
        }

        // Mock Announcements
        $announcements = [
            [
                'title' => 'Perubahan SOP Cleaning Area Basah',
                'description' => 'Mulai 10 Jan, gunakan cairan pembersih jenis baru untuk area kamar mandi.',
                'date' => '10 Jan 2024'
            ],
            [
                'title' => 'Jadwal Training Bulanan',
                'description' => 'Training wajib untuk semua staff akan diadakan tanggal 20 Jan di kantor pusat.',
                'date' => '08 Jan 2024'
            ],
            [
                'title' => 'Update Seragam Tim',
                'description' => 'Seragam baru sudah bisa diambil di bagian HR mulai hari Senin besok.',
                'date' => '05 Jan 2024'
            ]
        ];

        return view('livewire.worker.index', [
            'tasksToday' => $tasksToday,
            'tasksThisWeek' => $tasksThisWeek,
            'announcements' => $announcements
        ]);
    }
}