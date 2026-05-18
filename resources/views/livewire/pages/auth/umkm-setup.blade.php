<?php

use App\Models\Category;
use App\Models\Umkm;
use App\Models\UmkmDetail;
use App\Models\BankAccount;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

new #[Layout('layouts.blank')] 
class extends Component {
    use WithFileUploads;

    public int $currentStep = 1;
    public bool $isPending = false;

    // Data Form (Stored in Session for Persistence)
    public array $formData = [
        'business_name' => '',
        'category_id' => '',
        'business_description' => '',
        'business_address' => '',
        'province_id' => '',
        'province_name' => '',
        'city_id' => '',
        'city_name' => '',
        'district_id' => '',
        'district_name' => '',
        'business_phone' => '',
        'latitude' => '',
        'longitude' => '',
        'owner_full_name' => '',
        'owner_nik' => '',
        'owner_dob' => '',
        'bank_name' => '',
        'bank_account_number' => '',
        'bank_account_holder' => '',
    ];

    // Options for Dropdowns
    public array $provinces = [];
    public array $cities = [];
    public array $districts = [];

    // File Uploads
    public $owner_ktp_photo;
    public $owner_selfie_ktp;
    public $doc_business_permit;
    public $doc_npwp;
    public $doc_business_photo;
    public $qris_photo;

    // Checkboxes
    public bool $agreed_direct_payment = false;
    public bool $agreed_subscription = false;

    public function mount()
    {
        $this->currentStep = session()->get('umkm_setup_step', 1);
        
        if (session()->has('umkm_form_data')) {
            $this->formData = array_merge($this->formData, session()->get('umkm_form_data'));
        }

        $this->loadProvinces();
        
        // Re-load cities/districts if data exists
        if ($this->formData['province_id']) $this->loadCities($this->formData['province_id']);
        if ($this->formData['city_id']) $this->loadDistricts($this->formData['city_id']);

        $existingUmkm = Umkm::where('owner_id', auth()->id())->first();
        if ($existingUmkm && $existingUmkm->status === 'pending_verification') {
            $this->isPending = true;
            $this->currentStep = 5;
        }
    }

    public function loadProvinces()
    {
        try {
            $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            $this->provinces = $response->json() ?? [];
        } catch (\Exception $e) { $this->provinces = []; }
    }

    public function updatedFormDataProvinceId($value)
    {
        $this->formData['city_id'] = '';
        $this->formData['district_id'] = '';
        $this->cities = [];
        $this->districts = [];
        if ($value) {
            $this->formData['province_name'] = collect($this->provinces)->firstWhere('id', $value)['name'] ?? '';
            $this->loadCities($value);
        }
        $this->saveToSession();
    }

    public function loadCities($provinceId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
            $this->cities = $response->json() ?? [];
        } catch (\Exception $e) { $this->cities = []; }
    }

    public function updatedFormDataCityId($value)
    {
        $this->formData['district_id'] = '';
        $this->districts = [];
        if ($value) {
            $this->formData['city_name'] = collect($this->cities)->firstWhere('id', $value)['name'] ?? '';
            $this->loadDistricts($value);
        }
        $this->saveToSession();
    }

    public function loadDistricts($cityId)
    {
        try {
            $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json");
            $this->districts = $response->json() ?? [];
        } catch (\Exception $e) { $this->districts = []; }
    }

    public function updatedFormDataDistrictId($value)
    {
        if ($value) {
            $this->formData['district_name'] = collect($this->districts)->firstWhere('id', $value)['name'] ?? '';
        }
        $this->saveToSession();
    }

    public function saveToSession() { session()->put('umkm_form_data', $this->formData); }

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
                'formData.business_name' => 'required|min:3',
                'formData.category_id' => 'required',
                'formData.business_description' => 'required|min:20',
                'formData.province_id' => 'required',
                'formData.city_id' => 'required',
                'formData.district_id' => 'required',
                'formData.business_address' => 'required',
                'formData.business_phone' => 'required|numeric',
                'formData.latitude' => 'required',
                'formData.longitude' => 'required',
            ]);
        } elseif ($this->currentStep === 2) {
            $eighteenYearsAgo = Carbon::now()->subYears(18)->format('Y-m-d');
            $this->validate([
                'formData.owner_full_name' => 'required|min:3',
                'formData.owner_nik' => 'required|numeric|digits:16',
                'formData.owner_dob' => "required|date|before_or_equal:$eighteenYearsAgo",
                'owner_ktp_photo' => 'required|image|max:5120',
                'owner_selfie_ktp' => 'required|image|max:5120',
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'doc_business_permit' => 'required|file|max:5120',
                'doc_business_photo' => 'required|image|max:5120',
            ]);
        } elseif ($this->currentStep === 4) {
            $this->validate([
                'formData.bank_name' => 'required',
                'formData.bank_account_number' => 'required|numeric',
                'formData.bank_account_holder' => 'required',
                'qris_photo' => 'required|image|max:5120',
            ]);
        }
    }

    public function submit()
    {
        // Final Validation for ALL steps to prevent SQL errors (like category_id being empty)
        $this->validate([
            'formData.business_name' => 'required|min:3',
            'formData.category_id' => 'required|exists:categories,id',
            'formData.business_description' => 'required|min:20',
            'formData.province_id' => 'required',
            'formData.city_id' => 'required',
            'formData.district_id' => 'required',
            'formData.business_address' => 'required',
            'formData.business_phone' => 'required|numeric',
            'formData.latitude' => 'required|numeric',
            'formData.longitude' => 'required|numeric',
            'formData.owner_full_name' => 'required|min:3',
            'formData.owner_nik' => 'required|numeric|digits:16',
            'formData.owner_dob' => "required|date",
            'formData.bank_name' => 'required',
            'formData.bank_account_number' => 'required|numeric',
            'formData.bank_account_holder' => 'required',
            'agreed_direct_payment' => 'accepted',
            'agreed_subscription' => 'accepted',
            'owner_ktp_photo' => 'required', 
            'owner_selfie_ktp' => 'required',
            'doc_business_permit' => 'required',
            'doc_business_photo' => 'required',
            'qris_photo' => 'required',
        ], [
            'formData.*.required' => 'Ada data wajib yang masih kosong.',
            'formData.latitude.required' => 'Tentukan lokasi bisnis di peta.',
            'formData.longitude.required' => 'Tentukan lokasi bisnis di peta.',
            'agreed_direct_payment.accepted' => 'Anda harus menyetujui sistem pembayaran langsung.',
            'agreed_subscription.accepted' => 'Anda harus menyetujui model biaya langganan.',
        ]);

        DB::beginTransaction();
        try {
            // Attempt to ensure coordinates are handled safely
            $umkm = new Umkm();
            $umkm->owner_id = auth()->id();
            $umkm->application_code = 'APP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $umkm->category_id = $this->formData['category_id'];
            $umkm->name = $this->formData['business_name'];
            $umkm->slug = Str::slug($this->formData['business_name']) . '-' . auth()->id() . '-' . time();
            $umkm->description = $this->formData['business_description'];
            $umkm->address = $this->formData['business_address'] . ', ' . $this->formData['district_name'] . ', ' . $this->formData['city_name'] . ', ' . $this->formData['province_name'];
            $umkm->city = $this->formData['city_name'];
            
            // Check if these columns exist to avoid SQL crash if migration failed
            if (Schema::hasColumn('umkms', 'latitude')) {
                $umkm->latitude = (float)$this->formData['latitude'];
                $umkm->longitude = (float)$this->formData['longitude'];
            }
            
            $umkm->status = 'pending_verification';
            $umkm->save();

            UmkmDetail::create([
                'umkm_id' => $umkm->id,
                'description' => $this->formData['business_description'],
                'nib_file_path' => $this->doc_business_permit->store('uploads/nib', 'public'),
                'ktp_file_path' => $this->owner_ktp_photo->store('uploads/ktp', 'public'),
                'photo' => $this->doc_business_photo->store('uploads/business', 'public'),
                'contact_person' => $this->formData['owner_full_name'],
            ]);

            BankAccount::create([
                'user_id' => auth()->id(),
                'bank_name' => $this->formData['bank_name'],
                'account_number' => $this->formData['bank_account_number'],
                'account_holder_name' => $this->formData['bank_account_holder'],
            ]);

            DB::commit();
            session()->forget(['umkm_setup_step', 'umkm_form_data']);
            $this->isPending = true;
            $this->currentStep = 5;

        } catch (\Exception $e) {
            DB::rollBack();
            // provide more specific error info
            if (str_contains($e->getMessage(), 'category_id')) {
                $this->addError('submission', 'Data kategori bisnis tidak valid. Silakan kembali ke Step 1.');
            } else {
                $this->addError('submission', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            }
        }
    }

    public function getUploadedCountProperty() {
        return ($this->doc_business_permit ? 1 : 0) + ($this->doc_npwp ? 1 : 0) + ($this->doc_business_photo ? 1 : 0);
    }
}; ?>

<div class="min-h-screen bg-[#f8fafc] font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .input-focus:focus { border-color: #0077B6 !important; box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1) !important; }
        .animate-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulseSlow { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.7; } }
        .animate-pulse-slow { animation: pulseSlow 3s infinite ease-in-out; }
        #map { height: 400px; border-radius: 1.5rem; width: 100%; border: 2px solid #f1f5f9; }
        .leaflet-control-geocoder { border-radius: 1rem !important; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; border: 2px solid #f1f5f9 !important; }
        .leaflet-control-geocoder-form input { border-radius: 0.75rem !important; padding: 0.5rem 1rem !important; font-family: 'Figtree', sans-serif !important; border: none !important; }
    </style>

    <!-- Leaflet CSS & Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto border-transparent">
        <div class="flex justify-center mb-12 animate-in text-center">
            <a href="/" class="px-8 py-3.5 bg-[#000B44] rounded-2xl font-plus font-bold text-lg text-white tracking-tight shadow-xl" wire:navigate>JOS Partner</a>
        </div>

        @if($isPending)
            <div class="mb-8 p-6 bg-blue-50 border-2 border-blue-100/50 rounded-3xl flex items-center gap-5 animate-in">
                <div class="w-12 h-12 bg-[#0077B6] rounded-full flex items-center justify-center text-white shadow-lg"><svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-sm font-black text-[#000B44] font-plus tracking-tight uppercase">Permohonan Sedang Diproses</p><p class="text-xs text-slate-500 font-medium leading-relaxed mt-0.5">Berikan waktu 1-2 hari kerja untuk proses verifikasi.</p></div>
            </div>
        @endif

        @if($errors->any() && $currentStep < 5)
            <div class="mb-8 p-4 bg-red-50 border-2 border-red-100/50 rounded-2xl flex items-center gap-3 animate-in text-red-600 font-bold text-xs uppercase tracking-tight">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5"></path></svg>
                Data wajib belum diisi dengan lengkap.
            </div>
        @endif

        <div class="mb-20 animate-in">
            <div class="flex items-center justify-between relative px-2">
                <div class="absolute top-[22px] left-0 w-full h-[2px] bg-slate-100 -z-0">
                    <div class="h-full bg-[#0077B6] transition-all duration-1000" style="width: {{ (($currentStep - 1) / 4) * 100 }}%"></div>
                </div>
                @for ($i = 1; $i <= 5; $i++)
                    <div class="relative z-10 flex flex-col items-center flex-1">
                        <div @class(['w-11 h-11 rounded-xl flex items-center justify-center transition-all duration-500 shadow-sm border-2', 'bg-[#0077B6] border-[#0077B6] text-white' => $currentStep >= $i, 'bg-white border-slate-100 text-slate-300' => $currentStep < $i])>
                            @if($currentStep > $i) <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5"><path d="M5 13l4 4L19 7"></path></svg>
                            @elseif($currentStep == $i) <div class="w-2.5 h-2.5 bg-white rounded-sm animate-pulse-slow"></div>
                            @else <div class="w-2 h-2 bg-slate-100 rounded-sm"></div> @endif
                        </div>
                        <div class="mt-4 text-center">
                            <p @class(['text-[11px] font-black font-plus tracking-tight', 'text-[#000B44]' => $currentStep >= $i, 'text-slate-400' => $currentStep < $i])>Step {{ $i }}</p>
                            <p @class(['text-[9px] font-bold font-plus uppercase tracking-widest mt-0.5 whitespace-nowrap', 'text-[#0077B6]' => $currentStep == $i, 'text-slate-300' => $currentStep != $i])>{{ ['Informasi', 'Pemilik', 'Dokumen', 'Rekening', 'Review'][$i-1] }}</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/80 border-2 border-slate-100 overflow-hidden animate-in">
            <div class="p-10 sm:p-20">

                @if($currentStep === 1)
                    <div wire:key="step-1" class="space-y-10 animate-in">
                        <div class="space-y-2"><h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Informasi Bisnis</h2><p class="text-slate-500 font-medium tracking-tight">Identitas fundamental untuk operasional UMKM Anda.</p></div>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Nama Bisnis <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.business_name" type="text" placeholder="Contoh: JOS Cleaning Service" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.business_name') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Kategori Bisnis <span class="text-red-500">*</span></label>
                                    <select wire:model.blur="formData.category_id" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus appearance-none">
                                        <option value="">Pilih...</option>@foreach(Category::all() as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                                    </select>
                                    @error('formData.category_id') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Deskripsi Singkat <span class="text-red-500">*</span></label>
                                <textarea wire:model.blur="formData.business_description" rows="3" placeholder="Ceritakan apa yang bisnis Anda tawarkan..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus resize-none"></textarea>
                                @error('formData.business_description') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-slate-50 mt-8">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Provinsi <span class="text-red-500">*</span></label>
                                    <select wire:model.live="formData.province_id" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus appearance-none">
                                        <option value="">Pilih...</option>@foreach($provinces as $prov) <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option> @endforeach
                                    </select>
                                    @error('formData.province_id') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                    <select wire:model.live="formData.city_id" @disabled(!$formData['province_id']) class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus appearance-none disabled:opacity-50">
                                        <option value="">Pilih...</option>@foreach($cities as $city) <option value="{{ $city['id'] }}">{{ $city['name'] }}</option> @endforeach
                                    </select>
                                    @error('formData.city_id') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Kecamatan <span class="text-red-500">*</span></label>
                                    <select wire:model.live="formData.district_id" @disabled(!$formData['city_id']) class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus appearance-none disabled:opacity-50">
                                        <option value="">Pilih...</option>@foreach($districts as $dist) <option value="{{ $dist['id'] }}">{{ $dist['name'] }}</option> @endforeach
                                    </select>
                                    @error('formData.district_id') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-4 pt-4">
                                <div class="flex items-center justify-between">
                                    <div class="space-y-1">
                                        <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Lokasi Koordinat <span class="text-red-500">*</span></label>
                                        <p class="text-[10px] text-slate-400 font-medium">Gunakan kotak pencarian di peta atau geser pin manual.</p>
                                    </div>
                                    <a href="https://www.google.com/maps" target="_blank" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest flex items-center gap-1 hover:underline">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="3"></path></svg>
                                        Buka Google Maps
                                    </a>
                                </div>
                                <div wire:ignore class="relative">
                                    <div id="map" x-data="{
                                        map: null,
                                        marker: null,
                                        geocoder: null,
                                        init() {
                                            const defaultLat = {{ $formData['latitude'] ?: -6.200000 }};
                                            const defaultLng = {{ $formData['longitude'] ?: 106.816666 }};
                                            
                                            this.map = L.map('map').setView([defaultLat, defaultLng], 13);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                attribution: '&copy; OpenStreetMap contributors'
                                            }).addTo(this.map);

                                            this.marker = L.marker([defaultLat, defaultLng], {
                                                draggable: true
                                            }).addTo(this.map);

                                            // Init Geocoder (Search)
                                            this.geocoder = L.Control.geocoder({
                                                defaultMarkGeocode: false,
                                                placeholder: 'Cari alamat atau tempat...',
                                                errorMessage: 'Alamat tidak ditemukan'
                                            })
                                            .on('markgeocode', function(e) {
                                                var bbox = e.geocode.bbox;
                                                var poly = L.polygon([
                                                    [bbox.getSouthEast().lat, bbox.getSouthEast().lng],
                                                    [bbox.getNorthEast().lat, bbox.getNorthEast().lng],
                                                    [bbox.getNorthWest().lat, bbox.getNorthWest().lng],
                                                    [bbox.getSouthWest().lat, bbox.getSouthWest().lng]
                                                ]);
                                                this.map.fitBounds(poly.getBounds());
                                                this.marker.setLatLng(e.geocode.center);
                                                @this.set('formData.latitude', e.geocode.center.lat);
                                                @this.set('formData.longitude', e.geocode.center.lng);
                                            }, this)
                                            .addTo(this.map);

                                            this.marker.on('dragend', (e) => {
                                                let pos = e.target.getLatLng();
                                                @this.set('formData.latitude', pos.lat);
                                                @this.set('formData.longitude', pos.lng);
                                            });

                                            this.map.on('click', (e) => {
                                                this.marker.setLatLng(e.latlng);
                                                @this.set('formData.latitude', e.latlng.lat);
                                                @this.set('formData.longitude', e.latlng.lng);
                                            });
                                        }
                                    }"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Latitude</label>
                                        <input wire:model.blur="formData.latitude" type="text" placeholder="-6.123" class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-[12px] font-bold text-[#0077B6] input-focus">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Longitude</label>
                                        <input wire:model.blur="formData.longitude" type="text" placeholder="106.123" class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-[12px] font-bold text-[#0077B6] input-focus">
                                    </div>
                                </div>
                                @if($errors->has('formData.latitude') || $errors->has('formData.longitude'))
                                    <p class="text-[10px] font-bold text-red-500 uppercase">Wajib menentukan lokasi (search atau geser pin)</p>
                                @endif
                            </div>

                            <div class="space-y-2 pt-4 border-t border-slate-50">
                                <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input wire:model.blur="formData.business_address" type="text" placeholder="Jl. Raya No. 123..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                @error('formData.business_address') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">No Telepon Bisnis <span class="text-red-500">*</span></label>
                                <input wire:model.blur="formData.business_phone" type="text" placeholder="0812..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                @error('formData.business_phone') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                @elseif($currentStep === 2)
                    <div wire:key="step-2" class="space-y-10 animate-in">
                        <div class="space-y-2"><h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Data Pemilik</h2><p class="text-slate-500 font-medium tracking-tight">Verifikasi identitas penanggung jawab bisnis.</p></div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Nama Lengkap Pemilik <span class="text-red-500">*</span></label>
                                <input wire:model.blur="formData.owner_full_name" type="text" placeholder="Sesuai KTP" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                @error('formData.owner_full_name') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">NIK (16 Digit) <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.owner_nik" type="text" maxlength="16" placeholder="Contoh: 3201..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.owner_nik') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Tgl Lahir (Min 18th) <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.owner_dob" type="date" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.owner_dob') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                <div class="space-y-3">
                                    <label class="text-sm font-black text-[#000B44] font-plus tracking-wide uppercase opacity-80 text-center">Foto KTP Resmi <span class="text-red-500">*</span></label>
                                    <label class="group relative flex items-center justify-center w-full h-52 border-[3px] border-dashed border-slate-100 rounded-3xl cursor-pointer bg-slate-50 hover:bg-slate-100/50 transition-all overflow-hidden text-center">
                                        @if($owner_ktp_photo) <img src="{{ $owner_ktp_photo->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover"> @else <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest px-5">Klik Untuk Upload Foto KTP</p> @endif
                                        <input type="file" wire:model="owner_ktp_photo" class="hidden">
                                    </label>
                                    @error('owner_ktp_photo') <p class="text-[10px] font-bold text-red-500 uppercase text-center mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-3">
                                    <label class="text-sm font-black text-[#000B44] font-plus tracking-wide uppercase opacity-80 text-center">Selfie dengan KTP <span class="text-red-500">*</span></label>
                                    <label class="group relative flex items-center justify-center w-full h-52 border-[3px] border-dashed border-slate-100 rounded-3xl cursor-pointer bg-slate-50 hover:bg-slate-100/50 transition-all overflow-hidden text-center">
                                        @if($owner_selfie_ktp) <img src="{{ $owner_selfie_ktp->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover"> @else <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest px-5">Klik Untuk Upload Selfie</p> @endif
                                        <input type="file" wire:model="owner_selfie_ktp" class="hidden">
                                    </label>
                                    @error('owner_selfie_ktp') <p class="text-[10px] font-bold text-red-500 uppercase text-center mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($currentStep === 3)
                    <div wire:key="step-3" class="space-y-10 animate-in">
                        <div class="space-y-2 text-center"><h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Dokumen Izin</h2><p class="text-slate-500 font-medium tracking-tight">Lengkapi dokumen pendukung legalitas usaha Anda.</p></div>
                        <div class="space-y-4">
                            @foreach([['Sertifikat/Izin Usaha (NIB)', 'doc_business_permit'], ['Foto Toko/Tempat Usaha Utama', 'doc_business_photo']] as $doc)
                            <div class="p-8 bg-slate-50 rounded-[2.5rem] border-2 border-slate-50 hover:border-[#0077B6]/10 transition-all">
                                <div class="flex items-center justify-between gap-6">
                                    <span class="text-sm font-black text-[#000B44] font-plus tracking-tight uppercase tracking-widest">{{ $doc[0] }} <span class="text-red-500">*</span></span>
                                    <label class="cursor-pointer bg-[#000B44] hover:bg-[#0077B6] text-white px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg hover:-translate-y-1">
                                        {{ $this->{$doc[1]} ? 'Berhasil Diupload' : 'Upload File' }} <input type="file" wire:model="{{ $doc[1] }}" class="hidden">
                                    </label>
                                </div>
                                @error($doc[1]) <p class="text-[10px] font-bold text-red-500 uppercase mt-3">{{ $message }}</p> @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($currentStep === 4)
                    <div wire:key="step-4" class="space-y-10 animate-in">
                        <div class="space-y-2"><h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Metode Pembayaran</h2><p class="text-slate-500 font-medium">Customer akan membayar langsung ke QRIS Anda.</p></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6 text-left">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Nama Bank <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.bank_name" type="text" placeholder="Contoh: BCA" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.bank_name') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Nomor Rekening <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.bank_account_number" type="text" placeholder="Contoh: 1234..." class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.bank_account_number') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">A/N Pemilik <span class="text-red-500">*</span></label>
                                    <input wire:model.blur="formData.bank_account_holder" type="text" placeholder="Sesuai Buku Tabungan" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-medium input-focus">
                                    @error('formData.bank_account_holder') <p class="text-[10px] font-bold text-red-500 uppercase mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="space-y-4 text-center">
                                <label class="text-sm font-black text-[#000B44] font-plus tracking-wide uppercase opacity-80">Upload QRIS Toko <span class="text-red-500">*</span></label>
                                <label class="group relative flex flex-col items-center justify-center w-full h-[280px] border-[3px] border-dashed border-teal-100 rounded-[2.5rem] cursor-pointer bg-teal-50/20 hover:bg-teal-50/50 transition duration-500 overflow-hidden text-center">
                                    @if($qris_photo) <img src="{{ $qris_photo->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-contain p-4"> @else <p class="text-[11px] text-teal-800 font-black uppercase tracking-widest px-8">Klik Untuk Upload Foto QRIS</p> @endif
                                    <input type="file" wire:model="qris_photo" class="hidden">
                                </label>
                                @error('qris_photo') <p class="text-[10px] font-bold text-red-500 uppercase text-center mt-3">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                @elseif($currentStep === 5)
                    <div wire:key="step-5" class="space-y-12 animate-in text-center">
                        @if($isPending)
                            <!-- SUCCESS STATE -->
                            <div class="space-y-6 flex flex-col items-center">
                                <div class="w-24 h-24 bg-teal-500 rounded-[2.5rem] flex items-center justify-center text-white shadow-2xl shadow-teal-200 animate-in">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5"><path d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="space-y-2">
                                    <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight uppercase">Pendaftaran Sukses!</h2>
                                    <p class="text-slate-500 font-medium max-w-md mx-auto leading-relaxed">Terima kasih telah bergabung. Data Anda sedang kami verifikasi. Proses ini biasanya memakan waktu 1-2 hari kerja.</p>
                                </div>
                                <div class="pt-8">
                                    <a href="/dashboard" wire:navigate class="px-12 py-5 bg-[#000B44] hover:bg-[#0077B6] text-white rounded-3xl font-black text-sm uppercase tracking-widest transition-all duration-500 shadow-xl hover:-translate-y-1 inline-flex items-center gap-3">
                                        Pergi ke Dashboard
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- REVIEW FORM -->
                            <div class="space-y-2 text-center"><h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Review Verifikasi</h2><p class="text-slate-500 font-medium tracking-tight">Periksa kembali data Anda sebelum kami tinjau.</p></div>
                            <div class="bg-indigo-900 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">
                                <h4 class="text-xl font-black font-plus tracking-tight uppercase text-center">Sistem Pembayaran Langsung</h4><p class="text-sm text-indigo-100/70 font-medium mt-2 leading-relaxed text-center">Seluruh hasil penjualan masuk 100% ke QRIS/rekening Anda tanpa potongan dari platform.</p>
                            </div>
                            <div class="space-y-6 pt-4 text-left">
                                <label class="flex items-start gap-4 cursor-pointer group"><input wire:model.live="agreed_direct_payment" type="checkbox" class="peer hidden"><div class="w-6 h-6 border-2 border-slate-200 rounded-lg peer-checked:bg-[#0077B6] peer-checked:border-[#0077B6] transition-all flex-shrink-0 mt-0.5"></div><span class="text-sm text-slate-500 font-medium group-hover:text-[#000B44] leading-relaxed">Saya setuju dengan sistem pembayaran langsung ke QRIS toko. <span class="text-red-500">*</span></span></label>
                                <label class="flex items-start gap-4 cursor-pointer group"><input wire:model.live="agreed_subscription" type="checkbox" class="peer hidden"><div class="w-6 h-6 border-2 border-slate-200 rounded-lg peer-checked:bg-[#0077B6] peer-checked:border-[#0077B6] transition-all flex-shrink-0 mt-0.5"></div><span class="text-sm text-slate-500 font-medium group-hover:text-[#000B44] leading-relaxed">Saya memahami model biaya langganan platform di masa mendatang. <span class="text-red-500">*</span></span></label>
                            </div>
                            <div class="pt-10 flex flex-col items-center gap-5">
                                @error('submission')
                                    <div class="mb-5 p-4 bg-red-50 border-2 border-red-100/50 rounded-2xl w-full text-red-600 font-bold text-xs uppercase text-center animate-in">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <button wire:click="submit" wire:loading.attr="disabled" @disabled(!$agreed_direct_payment || !$agreed_subscription) class="w-full max-w-sm py-5 bg-[#000B44] hover:bg-[#0077B6] text-white rounded-3xl font-black text-sm uppercase tracking-widest transition-all duration-500 shadow-xl enabled:hover:-translate-y-1 flex items-center justify-center gap-3 relative">
                                    <span wire:loading.remove>Kirim Aplikasi</span>
                                    <div wire:loading class="flex items-center gap-2">
                                        <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                        <span>Proses...</span>
                                    </div>
                                </button> 
                                <p class="text-[11px] text-slate-400 font-black uppercase tracking-[0.2em] italic text-center">Review kilat: 1-2 hari kerja</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-12 flex justify-between items-center px-4 animate-in">
            @if($currentStep > 1 && !$isPending)
                <button wire:click="previousStep" class="flex items-center gap-2 text-sm font-black text-[#000B44]/50 hover:text-[#000B44] uppercase tracking-widest transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3"></path></svg> Kembali</button>
            @else
                <div></div>
            @endif

            @if($currentStep < 5)
                <button wire:click="nextStep" class="group px-16 py-5 bg-[#000B44] hover:bg-[#0077B6] text-white rounded-2xl text-base font-black uppercase tracking-[0.2em] transition-all hover:-translate-y-1 flex items-center gap-3 shadow-2xl">
                    Lanjut 
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5">
                        <path d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Leaflet JS & Geocoder JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</div>