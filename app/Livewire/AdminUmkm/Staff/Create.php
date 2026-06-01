<?php

namespace App\Livewire\AdminUmkm\Staff;

use App\Models\User;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use App\Services\Staff\StaffService;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-umkm')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $nik = '';
    public $date_of_birth = '';
    public $specialization = '';
    public $password = '';
    public $profile_picture;
    public $is_active = true;
    public $userExists = false;
    public $existingUser = null;
    public $showSuggestions = false;
    public $suggestions = [];

    // Permissions
    public $permissions = [
        'order' => [
            'view' => false,
            'manage' => false,
            'delete' => false,
        ],
        'service' => [
            'create' => false,
            'manage' => false,
            'delete' => false,
        ],
        'staff' => [
            'manage' => false,
            'delete' => false,
        ],
        'setting' => [
            'schedule' => false,
            'profile' => false,
        ],
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'password' => 'required|string|min:8',
        'nik' => 'nullable|string|max:16',
        'date_of_birth' => 'nullable|date',
        'specialization' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|max:2048',
    ];

    public function updatedName($value)
    {
        if (strlen($value) >= 2 && !$this->userExists) {
            $this->suggestions = User::where('name', 'like', '%' . $value . '%')
                ->limit(5)
                ->get()
                ->toArray();
            $this->showSuggestions = count($this->suggestions) > 0;
        } else {
            $this->showSuggestions = false;
        }
    }

    public function selectUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->existingUser = $user;
            $this->userExists = true;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->nik = $user->nik;
            $this->date_of_birth = $user->date_of_birth;
            $this->password = '********';
            $this->showSuggestions = false;
        }
    }

    public function resetUser()
    {
        $this->userExists = false;
        $this->existingUser = null;
        $this->reset(['name', 'email', 'phone', 'nik', 'date_of_birth', 'password']);
    }

    public function updatedEmail($value)
    {
        // Keep email check as secondary verification
        if (filter_var($value, FILTER_VALIDATE_EMAIL) && !$this->userExists) {
            $user = User::where('email', $value)->first();
            if ($user) {
                $this->selectUser($user->id);
            }
        }
    }

    public function save()
    {
        if ($this->userExists) {
            $this->rules['password'] = 'nullable';
        }

        $this->validate();

        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        $service = app(StaffService::class);
        $service->create([
            'umkm_id' => $umkmId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'nik' => $this->nik,
            'date_of_birth' => $this->date_of_birth,
            'specialization' => $this->specialization,
            'is_active' => $this->is_active,
            'permissions' => $this->permissions,
        ], $this->profile_picture);

        $this->dispatch('notify', [
            'message' => 'Staff baru berhasil ditambahkan',
            'type' => 'success'
        ]);

        return redirect()->route('umkm.staff');
    }

    public function render()
    {
        return view('livewire.admin-umkm.staff.create');
    }
}
