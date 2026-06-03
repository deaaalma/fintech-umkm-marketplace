<?php

namespace App\Livewire\Worker;

use App\Models\UserNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.worker-layout')]
class Notifications extends Component
{
    public function markAsRead($id)
    {
        $notification = UserNotification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['read_at' => now()]);
        
        if ($notification->link) {
            return redirect($notification->link);
        }
    }

    public function markAllAsRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Semua notifikasi ditandai sebagai dibaca.'
        ]);
    }

    public function render()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.worker.notifications', [
            'notifications' => $notifications
        ])->title('Pusat Notifikasi');
    }
}
