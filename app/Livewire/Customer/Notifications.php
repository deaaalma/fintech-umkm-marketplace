<?php

namespace App\Livewire\Customer;

use App\Models\UserNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.customer-layout')]
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

        session()->flash('message', 'Semua notifikasi ditandai sebagai dibaca.');
    }

    public function clearRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->whereNotNull('read_at')
            ->delete();

        session()->flash('message', 'Notifikasi yang sudah dibaca telah dihapus.');
    }

    public function clearAll()
    {
        UserNotification::where('user_id', Auth::id())->delete();
        session()->flash('message', 'Semua notifikasi telah dihapus.');
    }

    public function render()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->latest()
            ->get();

        $unreadCount = $notifications->whereNull('read_at')->count();

        return view('livewire.customer.notifications', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ])->title('Pusat Notifikasi');
    }
}
