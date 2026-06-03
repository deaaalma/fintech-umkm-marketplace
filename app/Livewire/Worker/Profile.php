<?php

namespace App\Livewire\Worker;

use App\Models\WorkerSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.worker-layout')]
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $profile_photo;
    
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    public $availability = [
        'Senin' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Selasa' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Rabu' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Kamis' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Jumat' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Sabtu' => ['active' => false, 'slots' => [['time' => '09:00']]],
        'Minggu' => ['active' => false, 'slots' => [['time' => '09:00']]],
    ];

    public function addSlot($day)
    {
        $this->availability[$day]['slots'][] = ['time' => '09:00'];
    }

    public function removeSlot($day, $index)
    {
        unset($this->availability[$day]['slots'][$index]);
        $this->availability[$day]['slots'] = array_values($this->availability[$day]['slots']);
        
        if (empty($this->availability[$day]['slots'])) {
            $this->availability[$day]['active'] = false;
        }
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        
        // Load existing schedules
        $schedules = WorkerSchedule::where('user_id', $user->id)->get();
        if ($schedules->isNotEmpty()) {
            // Reset default slots first
            foreach($this->availability as $day => $data) {
                $this->availability[$day]['active'] = false;
                $this->availability[$day]['slots'] = [];
            }

            foreach($schedules as $schedule) {
                $this->availability[$schedule->day]['active'] = true;
                $this->availability[$schedule->day]['slots'][] = ['time' => date('H:i', strtotime($schedule->start_time))];
            }
        }
    }

    public function save()
    {
        $user = Auth::user();
        
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
        ];

        if ($this->profile_photo) {
            $data['profile_photo_path'] = $this->profile_photo->store('profile-photos', 'public');
        }

        $user->update($data);

        // Save Schedules
        WorkerSchedule::where('user_id', $user->id)->delete();
        foreach($this->availability as $day => $config) {
            if ($config['active'] && !empty($config['slots'])) {
                foreach($config['slots'] as $slot) {
                    WorkerSchedule::create([
                        'user_id' => $user->id,
                        'day' => $day,
                        'start_time' => $slot['time'],
                        'is_active' => true
                    ]);
                }
            }
        }

        // Password update logic
        if ($this->old_password) {
            $this->validate([
                'old_password' => 'required|current_password',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($this->new_password),
            ]);
        }

        session()->flash('message', 'Profil dan jadwal berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.worker.profile');
    }
}
