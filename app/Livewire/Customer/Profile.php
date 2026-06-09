<?php

namespace App\Livewire\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.customer-layout')]
class Profile extends Component
{
    use WithFileUploads;

    // --- Personal Info ---
    public $name;
    public $email;
    public $phone;
    public $nik;
    public $date_of_birth;
    public $address;
    public $profile_photo;

    // --- Password Change ---
    public $current_password  = '';
    public $new_password      = '';
    public $new_password_confirmation = '';
    public $isPasswordVerified = false;

    // --- Delete Account ---
    public $delete_password   = '';
    public $showDeleteModal   = false;

    // --- View State ---
    public $viewState = 'profile'; // 'profile' or 'password'
    public $isEditing = false; // toggle for edit mode

    // --- Flash message ---
    public $successMessage = '';
    public $errorMessage   = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->phone         = $user->phone;
        $this->nik           = $user->nik;
        $this->date_of_birth = $user->date_of_birth?->format('Y-m-d');
        $this->address       = $user->address ?? '';
        $this->isEditing     = false;
    }

    public function cancelEdit()
    {
        $this->mount(); // Reset form data to original DB values
        $this->isEditing = false;
    }

    public function changeViewState($state)
    {
        $this->viewState      = $state;
        $this->successMessage = '';
        $this->errorMessage   = '';
        
        if ($state === 'password') {
            $this->isPasswordVerified = false;
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
        }
    }

    // ----------------------------------------------------------------
    //  UPDATE PERSONAL INFO
    // ----------------------------------------------------------------
    public function savePersonal()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name'          => 'required|string|max:100',
            'phone'         => ['required', 'string', 'max:20'],
            'nik'           => ['nullable', 'digits:16'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'address'       => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->profile_photo) {
            // Delete old photo
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $this->profile_photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name          = $this->name;
        $user->phone         = $this->phone;
        $user->nik           = $this->nik;
        $user->date_of_birth = $this->date_of_birth ?: null;
        $user->address       = $this->address;
        $user->save();

        session()->flash('successMessage', 'Informasi pribadi berhasil disimpan!');
        return $this->redirect(route('customer.profile'), navigate: true);
    }

    // ----------------------------------------------------------------
    //  UPDATE PASSWORD
    // ----------------------------------------------------------------
    public function verifyCurrentPassword()
    {
        $this->validate([
            'current_password' => 'required',
        ]);

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        $this->isPasswordVerified = true;
        $this->errorMessage = '';
    }

    public function savePassword()
    {
        if (!$this->isPasswordVerified) {
            return;
        }

        $this->validate([
            'new_password'             => 'required|min:8|confirmed',
            'new_password_confirmation'=> 'required',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($this->new_password)]);

        $this->current_password           = '';
        $this->new_password               = '';
        $this->new_password_confirmation  = '';
        $this->isPasswordVerified         = false;
        
        $this->changeViewState('profile');
        session()->flash('successMessage', 'Password berhasil diperbarui!');
        return $this->redirect(route('customer.profile'), navigate: true);
    }

    // ----------------------------------------------------------------
    //  DELETE ACCOUNT
    // ----------------------------------------------------------------
    public function confirmDelete()
    {
        $this->showDeleteModal = true;
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        if (! Hash::check($this->delete_password, $user->password)) {
            $this->errorMessage = 'Password tidak sesuai. Akun tidak dapat dihapus.';
            $this->showDeleteModal = false;
            return;
        }

        // Delete profile photo if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        Auth::logout();
        $user->delete();

        return redirect('/')->with('message', 'Akun Anda telah berhasil dihapus.');
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.customer.profile', compact('user'))
            ->title('Profil Saya');
    }
}
