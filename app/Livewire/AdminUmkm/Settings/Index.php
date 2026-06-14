<?php

namespace App\Livewire\AdminUmkm\Settings;

use App\Models\OrderChecklist;
use App\Models\Umkm;
use App\Models\UmkmDetail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    use WithFileUploads;

    public Umkm $umkm;
    public $activeTab = 'profil_admin';

    // Profil Admin
    public $isEditing = false;
    public $admin_name;
    public $admin_email;
    public $admin_phone;
    public $admin_avatar;

    // Informasi Perusahaan
    public $name;
    public $tagline;
    public $description;
    public $logo;
    public $qris_image;
    public $address;
    public $email;
    public $phone;
    
    // Social Media
    public $instagram_url;
    public $whatsapp_number;
    public $facebook_url;
    public $website_url;

    // Checklist
    public $checklists = [];
    public $newChecklistLabel = '';
    public $editingChecklistId = null;
    public $editingChecklistLabel = '';

    public function mount()
    {
        $this->umkm = Umkm::where('owner_id', auth()->id())->firstOrFail();
        
        // Profil Admin
        $user = auth()->user();
        $this->admin_name = $user->name;
        $this->admin_email = $user->email;
        $this->admin_phone = $user->phone;
        $this->name = $this->umkm->name;
        $this->tagline = $this->umkm->tagline;
        $this->description = $this->umkm->description;
        $this->address = $this->umkm->address;
        $this->email = $this->umkm->email;
        $this->phone = $this->umkm->phone;
        $this->instagram_url = $this->umkm->instagram_url;
        $this->whatsapp_number = $this->umkm->whatsapp_number;
        $this->facebook_url = $this->umkm->facebook_url;
        $this->website_url = $this->umkm->website_url;

        // Load checklist
        $this->loadChecklists();
    }

    public function loadChecklists()
    {
        $this->checklists = OrderChecklist::where('umkm_id', $this->umkm->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->isEditing = false;
        $this->editingChecklistId = null;
        if ($tab === 'checklist') {
            $this->loadChecklists();
        }
    }

    public function save()
    {
        if ($this->activeTab === 'profil_admin') {
            $this->validate([
                'admin_name' => 'required|string|max:255',
                'admin_email' => 'required|email|max:255',
                'admin_phone' => 'nullable|string|max:20',
                'admin_avatar' => 'nullable|image|max:2048',
            ]);

            $user = auth()->user();
            $avatarPath = $user->profile_photo_path;

            if ($this->admin_avatar) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_photo_path));
                }
                $avatarPath = 'storage/' . $this->admin_avatar->store('admin-avatars', 'public');
            }

            $user->update([
                'name' => $this->admin_name,
                'email' => $this->admin_email,
                'phone' => $this->admin_phone,
                'profile_photo_path' => $avatarPath,
            ]);

            $this->admin_avatar = null;

        } else {
            $this->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'logo' => 'nullable|image|max:2048',
                'qris_image' => 'nullable|image|max:2048',
            ]);

            $logoPath = $this->umkm->logo_url;
            if ($this->logo) {
                if ($this->umkm->logo_url) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $this->umkm->logo_url));
                }
                $logoPath = 'storage/' . $this->logo->store('umkm-logos', 'public');
            }

            $qrisPath = $this->umkm->qris_image_url;
            if ($this->qris_image) {
                if ($this->umkm->qris_image_url) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $this->umkm->qris_image_url));
                }
                $qrisPath = 'storage/' . $this->qris_image->store('umkm-qris', 'public');
            }

            $this->umkm->update([
                'name' => $this->name,
                'tagline' => $this->tagline,
                'description' => $this->description,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'instagram_url' => $this->instagram_url,
                'whatsapp_number' => $this->whatsapp_number,
                'facebook_url' => $this->facebook_url,
                'website_url' => $this->website_url,
                'logo_url' => $logoPath,
                'qris_image_url' => $qrisPath,
            ]);

            $this->logo = null;
            $this->qris_image = null;
            $this->umkm->refresh();
        }

        $this->logo = null;
        $this->qris_image = null;
        $this->umkm->refresh();
        $this->isEditing = false;

        $this->dispatch('notify', [
            'message' => 'Pengaturan berhasil disimpan',
            'type' => 'success'
        ]);
    }

    public function addChecklist()
    {
        $this->validate([
            'newChecklistLabel' => 'required|string|max:255',
        ]);

        $maxOrder = OrderChecklist::where('umkm_id', $this->umkm->id)->max('sort_order') ?? 0;

        OrderChecklist::create([
            'umkm_id'    => $this->umkm->id,
            'product_id' => null,
            'label'      => $this->newChecklistLabel,
            'sort_order' => $maxOrder + 1,
            'is_active'  => true,
        ]);

        $this->newChecklistLabel = '';
        $this->loadChecklists();
    }

    public function updateChecklist($id)
    {
        $this->validate([
            'editingChecklistLabel' => 'required|string|max:255',
        ]);

        OrderChecklist::where('id', $id)
            ->where('umkm_id', $this->umkm->id)
            ->update(['label' => $this->editingChecklistLabel]);

        $this->editingChecklistId = null;
        $this->editingChecklistLabel = '';
        $this->loadChecklists();
    }

    public function deleteChecklist($id)
    {
        OrderChecklist::where('id', $id)
            ->where('umkm_id', $this->umkm->id)
            ->delete();

        $this->loadChecklists();
    }

    public function toggleChecklist($id)
    {
        $item = OrderChecklist::where('id', $id)
            ->where('umkm_id', $this->umkm->id)
            ->first();

        if ($item) {
            $item->update(['is_active' => !$item->is_active]);
        }

        $this->loadChecklists();
    }

    public function render()
    {
        return view('livewire.admin-umkm.settings.index');
    }
}
