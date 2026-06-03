<?php

namespace App\Livewire\AdminUmkm\Settings;

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
    public $activeTab = 'informasi';

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

    public function mount()
    {
        $this->umkm = Umkm::where('owner_id', auth()->id())->firstOrFail();
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
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function save()
    {
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

        $this->dispatch('notify', [
            'message' => 'Pengaturan berhasil disimpan',
            'type' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.admin-umkm.settings.index');
    }
}
