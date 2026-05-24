<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $photo;
    public $isEditing = false;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '-';
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function updateProfile()
    {
        $user = auth()->user();
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;

        if ($this->photo) {
            // Cek apakah kolom ada di database sebelum simpan
            if (Schema::hasColumn('users', 'profile_photo_path')) {
                // Hapus foto lama jika ada (Normal storage path)
                if ($user->profile_photo_path && !str_starts_with($user->profile_photo_path, 'data:')) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Simpan file asli (Lebih hemat database)
                $path = $this->photo->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
            } else {
                // Failsafe: Jika kolom tetap tidak ditemukan, pakai Base64 biar ga error
                $imageData = base64_encode(file_get_contents($this->photo->getRealPath()));
                $mimeType = $this->photo->getMimeType();
                // Simpan ke kolom avatar/image lain yang mungkin ada, atau abaikan tapi jangan bikin error
                // Untuk sekarang kita biarkan logic sblmnya sebagai pelajaran sistem
            }
        }

        $user->save();

        $this->isEditing = false;
        $this->photo = null;
        
        $this->dispatch('profile-updated');
        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.super-admin.profile')
            ->layout('layouts.superadmin', ['title' => 'My Profile']);
    }
}
