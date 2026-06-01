<?php

namespace App\Livewire\AdminUmkm\Staff;

use App\Models\User;
use App\Models\Umkm;
use App\Models\UmkmWorker;
use App\Services\Staff\StaffService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-umkm')]
class Edit extends Component
{
    use WithFileUploads;

    public UmkmWorker $worker;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $nik = '';
    public $date_of_birth = '';
    public $specialization = '';
    public $password = '';
    public $profile_picture;
    public $is_active = true;

    // Permissions
    public $permissions = [];

    public function mount($id)
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        $this->worker = UmkmWorker::with('user')->where('umkm_id', $umkmId)->findOrFail($id);
        
        $user = $this->worker->user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->nik = $user->nik;
        $this->date_of_birth = $user->date_of_birth;
        $this->specialization = $this->worker->specialization;
        $this->is_active = $this->worker->is_active;
        $this->permissions = $this->worker->permissions ?? [
            'order' => ['view' => false, 'manage' => false, 'delete' => false],
            'service' => ['create' => false, 'manage' => false, 'delete' => false],
            'staff' => ['manage' => false, 'delete' => false],
            'setting' => ['schedule' => false, 'profile' => false],
        ];
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->worker->user_id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'nik' => 'nullable|string|max:16',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $service = app(StaffService::class);
        $service->update($this->worker, [
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
            'message' => 'Data staff berhasil diperbarui',
            'type' => 'success'
        ]);

        return redirect()->route('umkm.staff');
    }

    public function render()
    {
        return view('livewire.admin-umkm.staff.edit');
    }
}
