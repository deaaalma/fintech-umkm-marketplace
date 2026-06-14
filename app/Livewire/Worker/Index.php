<?php

namespace App\Livewire\Worker;

use App\Models\OrderAssignment;
use App\Models\UserNotification;
use App\Models\WorkerAttendance;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('layouts.worker-layout')]
class Index extends Component
{
    public $month;
    public $year;
    public $todayAttendance;

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->checkAttendance();
    }

    public function checkAttendance()
    {
        $this->todayAttendance = WorkerAttendance::where('user_id', Auth::id())
            ->whereDate('date', Carbon::today())
            ->first();
    }

    public function clockIn()
    {
        if (!$this->todayAttendance) {
            $this->todayAttendance = WorkerAttendance::create([
                'user_id' => Auth::id(),
                'date' => Carbon::today(),
                'clock_in' => Carbon::now()->toTimeString(),
                'status' => 'present'
            ]);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Berhasil absen masuk! Selamat bekerja.'
            ]);
        }
    }

    public function clockOut()
    {
        if ($this->todayAttendance && !$this->todayAttendance->clock_out) {
            $this->todayAttendance->update([
                'clock_out' => Carbon::now()->toTimeString()
            ]);
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Berhasil absen keluar! Sampai jumpa besok.'
            ]);
        }
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

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

        // Full Month Calendar logic
        $targetDate = Carbon::createFromDate($this->year, $this->month, 1);
        $startOfMonth = $targetDate->copy()->startOfMonth();
        $endOfMonth = $targetDate->copy()->endOfMonth();
        
        // Find the start of the calendar grid (leading days from prev month)
        $startOfGrid = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endOfGrid = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        
        $calendarDays = [];
        $currentDate = $startOfGrid->copy();

        // [OPTIMIZATION] Pre-fetch semua tugas dalam rentang grid kalender (1x query)
        $assignmentsData = OrderAssignment::where('worker_id', $workerId)
            ->whereHas('order', function($query) use ($startOfGrid, $endOfGrid) {
                $query->whereBetween('booking_date', [$startOfGrid->copy()->startOfDay(), $endOfGrid->copy()->endOfDay()]);
            })
            ->with('order:id,booking_date')
            ->get();
            
        $assignmentsCounts = $assignmentsData->groupBy(function($item) {
            return Carbon::parse($item->order->booking_date)->toDateString();
        })->map->count();
        
        while ($currentDate <= $endOfGrid) {
            $dateString = $currentDate->toDateString();
            
            // Ambil count dari collection yang sudah di-group di memori, fallback ke 0
            $count = $assignmentsCounts->get($dateString, 0);
                
            $calendarDays[] = [
                'date_obj' => $currentDate->copy(),
                'date_string' => $dateString,
                'day_num' => $currentDate->format('d'),
                'is_today' => $currentDate->isToday(),
                'is_current_month' => $currentDate->month === (int)$this->month,
                'count' => $count
            ];
            
            $currentDate->addDay();
        }

        // Real Notifications from DB
        $notifications = UserNotification::where('user_id', $workerId)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.worker.index', [
            'tasksToday' => $tasksToday,
            'calendarDays' => $calendarDays,
            'notifications' => $notifications
        ]);
    }
}