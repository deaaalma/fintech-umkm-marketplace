<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $email;
    public $phone;
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

        $user->save();

        $this->isEditing = false;
        
        session()->flash('success', 'Profile updated successfully!');
        
        // Force full page refresh to update Navbar/Sidebar outside this component
        return redirect()->route('superadmin.profile');
    }

    public function render()
    {
        return view('livewire.super-admin.profile')
            ->layout('layouts.superadmin', ['title' => 'My Profile']);
    }
}
