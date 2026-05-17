<?php

use App\Models\Bank_account;
use App\Models\BankAccount;
use App\Models\Umkm;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.blank')] 
class extends Component {
    use WithFileUploads;

    public int $currentStep = 1;
    public bool $isPending = false; // Flag untuk cek apakah

    // Step 1: Informasi Bisnis
    public string $business_name = '';
    public string $business_category = '';
    public string $business_description = '';
    public string $business_address = '';
    public string $business_city = '';
    public string $business_phone = '';

    // Step 2: Data Pemilik
    public string $owner_full_name = '';
    public string $owner_nik = '';
    public string $owner_dob = '';
    public $owner_ktp_photo;
    public $owner_selfie_ktp;

    // Step 3: Dokumen
    public $doc_business_permit;
    public $doc_npwp;
    public $doc_business_photo;

    // Step 4: Rekening Bank
    public string $bank_name = '';
    public string $bank_account_number = '';
    public string $bank_account_holder = '';

    // Step 5: Review
    public bool $agreed_terms = false;
    public bool $agreed_commission = false;

    public function mount()
    {
        // Auto-save logic: ambil step terakhir dari session agar tidak reset saat refresh
        // Auto-save step tetap ada
        $this->currentStep = session()->get('umkm_setup_step', 1);

        // Cek apakah user sudah punya UMKM dengan status pending
        $existingUmkm = Umkm::where('owner_id', auth()->id())->first();
        
        if ($existingUmkm && $existingUmkm->status === 'pending_verification') {
            $this->isPending = true;
            $this->currentStep = 5; // Paksa ke halaman review untuk melihat status
        }
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->currentStep++;
        session()->put('umkm_setup_step', $this->currentStep);
    }

    public function previousStep()
    {
        $this->currentStep--;
        session()->put('umkm_setup_step', $this->currentStep);
    }

    private function validateStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'business_name' => 'required|string|max:255',
                'business_category' => 'required|string',
                'business_description' => 'required|string|max:300',
                'business_address' => 'required|string',
                'business_city' => 'required|string',
                'business_phone' => 'required|string',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'owner_full_name' => 'required|string',
                'owner_nik' => 'required|numeric|digits:16',
                'owner_dob' => 'required|date',
                'owner_ktp_photo' => 'required|image|max:5120',
                'owner_selfie_ktp' => 'required|image|max:5120',
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'owner_ktp_photo' => 'required', // Re-check file from step 2
                'doc_business_permit' => 'required|file|max:5120',
                'doc_business_photo' => 'required|file|max:5120',
            ]);
        } elseif ($this->currentStep === 4) {
            $this->validate([
                'bank_name' => 'required',
                'bank_account_number' => 'required|numeric',
                'bank_account_holder' => 'required|string',
            ]);
        }
    }

    public function submit()
    {
        $this->validate([
            'agreed_terms' => 'accepted',
            'agreed_commission' => 'accepted',
        ]);

        // 1. Simpan Data UMKM
        $umkm = Umkm::create([
            'owner_id' => auth()->id(),
            'name' => $this->business_name,
            'slug' => str($this->business_name)->slug(),
            'description' => $this->business_description,
            'address' => $this->business_address,
            'status' => 'pending_verification',
        ]);

        // 2. Simpan Rekening Bank
        BankAccount::create([
            'user_id' => auth()->id(),
            'bank_name' => $this->bank_name,
            'account_number' => $this->bank_account_number,
            'account_holder_name' => $this->bank_account_holder,
        ]);

        // Hapus session step setelah berhasil
        session()->forget('umkm_setup_step');

        $this->isPending = true;
    }

    // Helper untuk hitung dokumen di Step 3
    public function getUploadedCountProperty()
    {
        $count = 0;
        if ($this->owner_ktp_photo) $count++;
        if ($this->doc_business_permit) $count++;
        if ($this->doc_npwp) $count++;
        if ($this->doc_business_photo) $count++;
        return $count;
    }
}; ?>

<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 font-jakarta">

    
    <div class="max-w-3xl mx-auto">
        @if($isPending)
            <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-amber-800">Dokumen Sedang Diverifikasi</p>
                    <p class="text-[10px] text-amber-600 font-medium">Anda tidak dapat mengubah data sampai proses review selesai.</p>
                </div>
            </div>
        @endif
        
        <div class="flex items-center justify-between mb-12 relative">
            <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-300 -z-0"></div>
            @for ($i = 1; $i <= 5; $i++)
                <div class="relative z-10 flex flex-col items-center">
                    <div @class([
                        'w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors duration-300',
                        'bg-black text-white' => $currentStep >= $i,
                        'bg-gray-300 text-gray-500' => $currentStep < $i,
                    ])>
                        @if($currentStep > $i)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $i }}
                        @endif
                    </div>
                    <span class="text-[10px] uppercase font-bold mt-2 text-gray-500">
                        {{ ['Informasi Bisnis', 'Data Pemilik', 'Dokumen', 'Rekening', 'Review'][$i-1] }}
                    </span>
                </div>
            @endfor
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8 sm:p-12">

                {{-- STEP 1: INFORMASI BISNIS --}}
                @if($currentStep === 1)
                    <div wire:key="step-1" class="space-y-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Informasi Bisnis</h2>
                            <p class="text-gray-500 text-sm">Ceritakan tentang bisnis UMKM Anda.</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Bisnis *</label>
                                <input wire:model="business_name" type="text" placeholder="Contoh: BWP Cleaning Service" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-black focus:border-black">
                                <x-input-error :messages="$errors->get('business_name')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori Bisnis *</label>
                                <input wire:model="business_category" type="text" placeholder="Cleaning Service, Laundry, dll" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-black focus:border-black">
                                <x-input-error :messages="$errors->get('business_category')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat *</label>
                                <textarea wire:model="business_description" rows="4" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-black focus:border-black"></textarea>
                                <x-input-error :messages="$errors->get('business_description')" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap *</label>
                                    <input wire:model="business_address" type="text" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Kota *</label>
                                    <input wire:model="business_city" type="text" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon *</label>
                                    <input wire:model="business_phone" type="text" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                {{-- STEP 2: DATA PEMILIK --}}
                @elseif($currentStep === 2)
                    <div wire:key="step-2" class="space-y-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Data Pemilik</h2>
                            <p class="text-gray-500 text-sm">Informasi penanggung jawab bisnis</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap Pemilik *</label>
                                <input wire:model="owner_full_name" type="text" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('owner_full_name')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">NIK *</label>
                                <input wire:model="owner_nik" type="text" maxlength="16" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('owner_nik')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Lahir *</label>
                                <input wire:model="owner_dob" type="date" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('owner_dob')" />
                            </div>
                            
                            {{-- Foto KTP Preview --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto KTP *</label>
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer bg-gray-50 overflow-hidden relative">
                                        @if($owner_ktp_photo)
                                            <img src="{{ $owner_ktp_photo->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] text-gray-400 font-bold uppercase">Upload KTP</span>
                                        @endif
                                        <input type="file" wire:model="owner_ktp_photo" class="hidden">
                                    </label>
                                    <x-input-error :messages="$errors->get('owner_ktp_photo')" />
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Selfie KTP *</label>
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer bg-gray-50 overflow-hidden relative">
                                        @if($owner_selfie_ktp)
                                            <img src="{{ $owner_selfie_ktp->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <span class="text-[10px] text-gray-400 font-bold uppercase">Upload Selfie</span>
                                        @endif
                                        <input type="file" wire:model="owner_selfie_ktp" class="hidden">
                                    </label>
                                    <x-input-error :messages="$errors->get('owner_selfie_ktp')" />
                                </div>
                            </div>
                        </div>
                    </div>

                {{-- STEP 3: DOKUMEN (Sesuai Gambar List) --}}
                @elseif($currentStep === 3)
                    <div wire:key="step-3" class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-900">Upload Dokumen</h2>
                        <div class="bg-gray-100 p-4 rounded-xl text-[10px] text-gray-500 font-bold">FORMAT: JPG, PNG, PDF • MAX 5MB</div>
                        
                        <div class="divide-y divide-gray-100">
                            {{-- Item List Dokumen --}}
                            @php
                                $docs = [
                                    ['label' => 'Foto KTP Pemilik', 'model' => 'owner_ktp_photo'],
                                    ['label' => 'Sertifikat/Izin Usaha', 'model' => 'doc_business_permit'],
                                    ['label' => 'NPWP (Opsional)', 'model' => 'doc_npwp'],
                                    ['label' => 'Foto Tempat Usaha', 'model' => 'doc_business_photo'],
                                ];
                            @endphp

                            @foreach($docs as $doc)
                            <div class="py-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div @class(['w-5 h-5 rounded-full flex items-center justify-center', 'bg-green-500 text-white' => $this->{$doc['model']}, 'bg-gray-200' => !$this->{$doc['model']}])>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-sm font-medium">{{ $doc['label'] }}</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    @if($this->{$doc['model']}) <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Uploaded</span> @endif
                                    <label class="cursor-pointer border px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase hover:bg-gray-50 transition">
                                        {{ $this->{$doc['model']} ? 'Ganti' : 'Upload' }}
                                        <input type="file" wire:model="{{ $doc['model'] }}" class="hidden">
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-center text-[10px] text-gray-400 italic">{{ $this->uploadedCount }} dari 4 dokumen telah diupload</p>
                    </div>

                {{-- STEP 4: REKENING BANK --}}
                @elseif($currentStep === 4)
                    <div wire:key="step-4" class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-900">Informasi Rekening Bank</h2>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-[11px] font-bold text-gray-700">Penting</p>
                            <p class="text-[11px] text-gray-500">Pastikan nama pemilik rekening sama dengan nama pemilik bisnis yang terdaftar.</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Bank *</label>
                                <input wire:model="bank_name" type="text" placeholder="BCA, Mandiri, BNI, dll" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('bank_name')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Rekening *</label>
                                <input wire:model="bank_account_number" type="text" placeholder="1234567890" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('bank_account_number')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Pemilik Rekening *</label>
                                <input wire:model="bank_account_holder" type="text" placeholder="Nama sesuai buku tabungan" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                <x-input-error :messages="$errors->get('bank_account_holder')" />
                            </div>
                        </div>
                    </div>

                {{-- STEP 5: REVIEW --}}
                    @elseif($currentStep === 5)
                        <div wire:key="step-5" class="space-y-6" x-data="{ openSection: 'bisnis' }">
                            <div class="mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">Review & Submit</h2>
                                <p class="text-sm text-gray-500">Periksa kembali semua informasi sebelum mengirim</p>
                            </div>

                            <div class="space-y-3">
                                
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <button @click="openSection = (openSection === 'bisnis' ? '' : 'bisnis')" 
                                            class="w-full flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 transition">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-bold text-gray-800 font-jakarta">Informasi Bisnis</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] bg-gray-200 px-2 py-0.5 rounded font-bold text-gray-500 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Lengkap
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openSection === 'bisnis' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </button>
                                    <div x-show="openSection === 'bisnis'" x-collapse>
                                        <div class="p-6 border-t border-gray-100 space-y-4">
                                            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                                                <div>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Bisnis</p>
                                                    <p class="text-sm font-medium text-gray-800">{{ $business_name }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kategori</p>
                                                    <p class="text-sm font-medium text-gray-800">{{ $business_category }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Telepon</p>
                                                    <p class="text-sm font-medium text-gray-800">{{ $business_phone }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kota</p>
                                                    <p class="text-sm font-medium text-gray-800">{{ $business_city }}</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-end pt-2">
                                                <button wire:click="set('currentStep', 1)" class="text-[10px] border border-gray-200 px-4 py-1 rounded font-bold hover:bg-gray-50 transition uppercase tracking-wider">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <button @click="openSection = (openSection === 'pemilik' ? '' : 'pemilik')" 
                                            class="w-full flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 transition">
                                        <span class="text-sm font-bold text-gray-800 font-jakarta">Data Pemilik</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] bg-gray-200 px-2 py-0.5 rounded font-bold text-gray-500 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Lengkap
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openSection === 'pemilik' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </button>
                                    <div x-show="openSection === 'pemilik'" x-collapse>
                                        <div class="p-6 border-t border-gray-100 grid grid-cols-2 gap-4 text-sm">
                                            <div><p class="text-[9px] font-bold text-gray-400 mb-1 uppercase">Nama</p><p>{{ $owner_full_name }}</p></div>
                                            <div><p class="text-[9px] font-bold text-gray-400 mb-1 uppercase">NIK</p><p>{{ $owner_nik }}</p></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <button @click="openSection = (openSection === 'dokumen' ? '' : 'dokumen')" 
                                            class="w-full flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 transition">
                                        <span class="text-sm font-bold text-gray-800 font-jakarta">Dokumen ({{ $this->uploadedCount }} items)</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] bg-gray-200 px-2 py-0.5 rounded font-bold text-gray-500 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Lengkap
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openSection === 'dokumen' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </button>
                                    <div x-show="openSection === 'dokumen'" x-collapse>
                                        <div class="p-6 border-t border-gray-100 text-xs text-gray-600 space-y-1">
                                            <p>• Foto KTP Pemilik</p>
                                            <p>• Sertifikat/Izin Usaha</p>
                                            @if($doc_npwp) <p>• NPWP (Opsional)</p> @endif
                                            <p>• Foto Tempat Usaha</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 mt-8">
                                <h4 class="text-xs font-bold text-gray-700 mb-4 font-jakarta">Informasi Komisi Platform</h4>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs text-gray-500">Komisi per transaksi</p>
                                    <p class="text-xl font-black text-gray-900">10%</p>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic font-medium">Contoh: Transaksi Rp 100.000 — Anda terima Rp 90.000</p>
                            </div>

                            <div class="space-y-3 pt-4">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input wire:model.live="agreed_terms" type="checkbox" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                                    <span class="text-xs text-gray-500 group-hover:text-gray-800 transition">
                                        Saya menyetujui <a href="#" class="font-bold underline text-black">Syarat & Ketentuan</a> dan <a href="#" class="font-bold underline text-black">Kebijakan Privasi</a>
                                    </span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input wire:model.live="agreed_commission" type="checkbox" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                                    <span class="text-xs text-gray-500 group-hover:text-gray-800 transition">
                                        Saya memahami struktur komisi platform 10% per transaksi
                                    </span>
                                </label>
                            </div>

                            {{-- Di bagian bawah Step 5 --}}
                            <div class="pt-6 flex flex-col items-center">
                                
                                @if($isPending)
                                    {{-- TOMBOL SAAT STATUS PENDING --}}
                                    <button disabled 
                                            class="w-full max-w-xs py-4 bg-amber-50 text-amber-600 rounded-xl font-bold text-sm border border-amber-200 flex items-center justify-center gap-2 cursor-not-allowed">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Menunggu Verifikasi
                                    </button>
                                    <p class="text-[10px] text-amber-500 mt-4 font-medium italic">Tim kami sedang meninjau dokumen Anda.</p>
                                
                                @else
                                    {{-- TOMBOL KIRIM DEFAULT --}}
                                    <button wire:click="submit" 
                                            @disabled(!$agreed_terms || !$agreed_commission)
                                            class="w-full max-w-xs py-4 bg-gray-200 text-gray-400 rounded-xl font-bold text-sm transition-all duration-300 disabled:cursor-not-allowed
                                                enabled:bg-black enabled:text-white enabled:hover:bg-gray-800 enabled:shadow-lg"
                                            wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="submit">Kirim Aplikasi</span>
                                        <span wire:loading wire:target="submit">Sedang Mengirim...</span>
                                    </button>
                                    <p class="text-[10px] text-gray-400 mt-4 font-medium">Aplikasi akan direview dalam 1-2 hari kerja</p>
                                @endif

                            </div>
                        </div>
                @endif

            </div>
        </div>

        {{-- NAVIGATION BUTTONS --}}
        <div class="mt-8 flex justify-between items-center">
            @if($currentStep > 1)
                <button wire:click="previousStep" class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Kembali</button>
            @else
                <button class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">Simpan Draft</button>
            @endif

            <div class="flex gap-3">
                @if($currentStep < 5)
                    <button wire:click="nextStep" class="px-8 py-2.5 bg-[#333] text-white rounded-lg text-sm font-bold hover:bg-black transition">Lanjut</button>
                @else
                    <button wire:click="submit" @disabled(!$agreed_terms || !$agreed_commission) class="px-12 py-2.5 bg-black text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition disabled:bg-gray-300">Kirim Aplikasi</button>
                @endif
            </div>
        </div>
        
    </div>
</div>