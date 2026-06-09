<x-slot:title>{{ $partner->name }}</x-slot:title>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="w-full pb-20 font-plus">


    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left: Partner Info & Products --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Partner Hero --}}
            <div class="bg-white rounded-[32px] overflow-hidden border border-slate-200 shadow-sm">
                <div class="h-64 relative">
                    <img src="{{ $partner->logo_url ?? 'https://images.unsplash.com/photo-1581578731548-c64695cc6958?w=1200&q=80' }}" class="w-full h-full object-cover" alt="Foto {{ $partner->name }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-8 left-8">
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/30 mb-3 inline-block">
                            {{ $partner->category->name }}
                        </span>
                        <h1 class="text-3xl font-black text-white font-plus tracking-tight">{{ $partner->name }}</h1>
                    </div>
                </div>
                <div class="p-8">
                    <p class="text-slate-700 leading-relaxed mb-6">{{ $partner->description ?? 'Tidak ada deskripsi.' }}</p>
                    <div class="flex flex-wrap gap-6 text-sm font-bold text-slate-600">
                        <div class="flex items-center gap-2" aria-label="Lokasi">
                            <svg class="w-4 h-4 text-slate-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $partner->city ?? 'Lokasi tidak diatur' }}
                        </div>
                        <div class="flex items-center gap-2" aria-label="Rating">
                            <svg class="w-4 h-4 text-yellow-600 fill-yellow-600" aria-hidden="true" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            4.8 <span class="text-slate-500">({{ $partner->reviews->count() }} Reviews)</span>
                        </div>
                        @if($partner->is_verified)
                        <div class="flex items-center gap-2 text-[#0077B6]" aria-label="Partner Terverifikasi">
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.25.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Partner
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Products Section --}}
            <div>
                <h2 class="text-xl font-black text-[#000B44] font-plus mb-6">Layanan Tersedia</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($partner->products as $product)
                    <div class="bg-white border border-slate-100 rounded-[32px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 group flex flex-col">
                        {{-- Image Header --}}
                        <div class="relative h-48 bg-slate-900 overflow-hidden shrink-0">
                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80' }}" 
                                 alt="Foto {{ $product->name }}"
                                 class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-all duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-5 left-6">
                                <span class="px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black text-white uppercase tracking-widest border border-white/30 shadow-sm">
                                    {{ $product->category->name ?? $partner->category->name }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-black text-slate-900 font-plus mb-2 leading-tight">{{ $product->name }}</h3>
                            <p class="text-sm text-slate-600 mb-6 line-clamp-2 leading-relaxed flex-1">{{ $product->description ?? 'Deskripsi layanan tidak tersedia.' }}</p>
                            
                            <div class="flex items-end justify-between mt-auto pt-5 border-t border-slate-100">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Mulai dari</p>
                                    <p class="text-base font-black text-slate-900 font-plus">Rp {{ number_format($product->estimated_price ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <button 
                                    wire:click="pesanSekarang({{ $product->id }})"
                                    class="px-5 py-2.5 bg-[#000B44] hover:bg-black text-white rounded-xl text-xs font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-[#0077B6] focus:ring-offset-2 shadow-sm"
                                    aria-label="Pesan layanan {{ $product->name }}"
                                >
                                    Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-[#000B44]/5 rounded-[32px] border border-dashed border-[#000B44]/20">
                        <p class="text-slate-600 font-bold text-sm">Belum ada layanan yang ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right: Reviews & Contact --}}
        <div class="lg:col-span-4 space-y-8">
            {{-- Quick Stats --}}
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm">
                <h2 class="text-sm font-black text-slate-900 font-plus mb-6">Informasi Kontak</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-500 border border-slate-200" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">WhatsApp</p>
                            <p class="text-sm font-bold text-slate-900">{{ $partner->owner->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-500 border border-slate-200" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Email</p>
                            <p class="text-sm font-bold text-slate-900">{{ $partner->owner->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reviews --}}
            <div x-data="{ showAll: false }" class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-sm font-black text-slate-900 font-plus">Reviews</h2>
                    <span class="text-xs font-bold text-yellow-700">{{ $partner->reviews->count() }} Total</span>
                </div>
                <div class="space-y-6">
                    @forelse($partner->reviews as $index => $review)
                    <div class="space-y-3" {{ $index >= 3 ? 'x-show=showAll x-transition.opacity.duration.300ms style=display:none;' : '' }}>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600" aria-hidden="true">
                                    {{ substr($review->customer->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-900">{{ $review->customer->name }}</span>
                            </div>
                            <div class="flex items-center gap-1" aria-label="Rating {{ $review->rating }} bintang">
                                @for($i = 0; $i < $review->rating; $i++)
                                <svg class="w-2.5 h-2.5 text-yellow-600 fill-yellow-600" aria-hidden="true" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed italic">"{{ $review->comment }}"</p>
                    </div>
                    @empty
                    <p class="text-center text-sm text-slate-500 py-4">Belum ada review.</p>
                    @endforelse
                </div>

                @if($partner->reviews->count() > 3)
                <button 
                    x-show="!showAll" 
                    @click="showAll = true" 
                    class="w-full mt-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-[#0077B6] focus:ring-offset-2"
                >
                    Tampilkan lebih banyak
                </button>
                @endif
            </div>
        </div>

        {{-- Order Form Modal --}}
        @if($showOrderModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" wire:click="$set('showOrderModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-fade-in border border-slate-100">
                    <div class="bg-white px-8 pt-8 pb-8">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-left w-full">
                                <h3 class="text-2xl font-black text-slate-900 font-plus mb-2" id="modal-title">
                                    Detail Pemesanan
                                </h3>
                                <p class="text-xs text-slate-600 font-bold uppercase tracking-widest mb-8">
                                    Lengkapi detail berikut untuk melanjutkan pesanan
                                </p>

                                <div class="space-y-6">
                                    {{-- Address --}}
                                    <div class="space-y-2">
                                        <label for="address" class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Alamat Layanan</label>
                                        <textarea id="address" wire:model.live.blur="address" rows="3" placeholder="Masukkan alamat lengkap lokasi pembersihan..." class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-[#0077B6] focus:border-[#0077B6] outline-none transition-all resize-none text-slate-900 placeholder-slate-400"></textarea>
                                        @error('address') <span class="text-xs text-red-600 font-bold ml-1" role="alert">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Map Picker --}}
                                    <div class="space-y-2" 
                                         x-data="{
                                            lat: @entangle('lat'),
                                            lng: @entangle('lng'),
                                            map: null,
                                            marker: null,
                                            initMap() {
                                                const defaultLat = -8.6500; // Bali default
                                                const defaultLng = 115.2167;
                                                
                                                this.map = L.map('map-picker').setView([this.lat || defaultLat, this.lng || defaultLng], 13);
                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '© OpenStreetMap'
                                                }).addTo(this.map);

                                                this.marker = L.marker([this.lat || defaultLat, this.lng || defaultLng], {
                                                    draggable: true
                                                }).addTo(this.map);

                                                this.marker.on('dragend', (e) => {
                                                    const pos = e.target.getLatLng();
                                                    this.lat = pos.lat;
                                                    this.lng = pos.lng;
                                                });

                                                this.map.on('click', (e) => {
                                                    this.marker.setLatLng(e.latlng);
                                                    this.lat = e.latlng.lat;
                                                    this.lng = e.latlng.lng;
                                                });
                                                
                                                // Trigger resize after modal animation
                                                setTimeout(() => this.map.invalidateSize(), 100);
                                            },
                                            useCurrentLocation() {
                                                if (navigator.geolocation) {
                                                    navigator.geolocation.getCurrentPosition((position) => {
                                                        const pos = [position.coords.latitude, position.coords.longitude];
                                                        this.lat = position.coords.latitude;
                                                        this.lng = position.coords.longitude;
                                                        this.map.setView(pos, 16);
                                                        this.marker.setLatLng(pos);
                                                    });
                                                }
                                            }
                                         }" 
                                         x-init="initMap()">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Pin Point Lokasi</span>
                                            <button type="button" @click="useCurrentLocation" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest flex items-center gap-1 hover:text-[#005f92] transition-colors focus:outline-none focus:ring-2 focus:ring-[#0077B6] rounded px-1" aria-label="Gunakan lokasi saat ini">
                                                <svg class="w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                Gunakan Lokasi Saat Ini
                                            </button>
                                        </div>
                                        <div id="map-picker" class="h-48 w-full rounded-2xl border border-slate-200 z-0 shadow-inner" wire:ignore aria-label="Peta pemilih lokasi"></div>
                                        <div class="flex gap-4 mt-2">
                                            <div class="flex-1 px-3 py-2 bg-slate-50 rounded-lg border border-slate-200">
                                                <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest">Latitude</p>
                                                <p class="text-[10px] font-mono font-bold text-slate-700" x-text="lat || '-'"></p>
                                            </div>
                                            <div class="flex-1 px-3 py-2 bg-slate-50 rounded-lg border border-slate-200">
                                                <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest">Longitude</p>
                                                <p class="text-[10px] font-mono font-bold text-slate-700" x-text="lng || '-'"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Date --}}
                                        <div class="space-y-2">
                                            <label for="booking_date" class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Tanggal</label>
                                            <div wire:ignore x-data="{
                                                init() {
                                                    if (typeof flatpickr !== 'undefined') {
                                                        flatpickr($refs.dateInput, {
                                                            dateFormat: 'Y-m-d',
                                                            altInput: true,
                                                            altFormat: 'j M Y',
                                                            minDate: 'today',
                                                            onChange: (selectedDates, dateStr) => {
                                                                @this.set('booking_date', dateStr);
                                                            }
                                                        });
                                                    }
                                                }
                                            }">
                                                <input type="text" id="booking_date" x-ref="dateInput" readonly placeholder="Pilih Tanggal" wire:model="booking_date" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-[#0077B6] focus:border-[#0077B6] outline-none transition-all cursor-pointer text-slate-900">
                                            </div>
                                            @error('booking_date') <span class="text-xs text-red-600 font-bold ml-1" role="alert">{{ $message }}</span> @enderror
                                        </div>
                                        {{-- Time --}}
                                        <div class="space-y-2">
                                            <label for="booking_time" class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Jam</label>
                                            <div wire:ignore x-data="{
                                                init() {
                                                    if (typeof flatpickr !== 'undefined') {
                                                        flatpickr($refs.timeInput, {
                                                            enableTime: true,
                                                            noCalendar: true,
                                                            dateFormat: 'H:i',
                                                            time_24hr: true,
                                                            altInput: true,
                                                            altFormat: 'H:i',
                                                            onChange: (selectedDates, dateStr) => {
                                                                @this.set('booking_time', dateStr);
                                                            }
                                                        });
                                                    }
                                                }
                                            }">
                                                <input type="text" id="booking_time" x-ref="timeInput" readonly placeholder="Pilih Jam" wire:model="booking_time" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-[#0077B6] focus:border-[#0077B6] outline-none transition-all cursor-pointer text-slate-900">
                                            </div>
                                            @error('booking_time') <span class="text-xs text-red-600 font-bold ml-1" role="alert">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Photo Uploads --}}
                                    <div class="space-y-3">
                                        <label for="orderPhotos" class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Foto Kondisi Area (Opsional)</label>
                                        <div class="grid grid-cols-4 gap-4">
                                            <label class="aspect-square bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center cursor-pointer hover:border-[#0077B6] hover:bg-slate-100 transition-all group focus-within:ring-2 focus-within:ring-[#0077B6] focus-within:ring-offset-2">
                                                <input type="file" id="orderPhotos" multiple wire:model="orderPhotos" class="sr-only">
                                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-[#0077B6] group-hover:text-white transition-all shadow-sm" aria-hidden="true">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                </div>
                                                <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest mt-2">Tambah</span>
                                            </label>

                                            @foreach($orderPhotos as $index => $photo)
                                            <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden relative group">
                                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview foto area">
                                                <button type="button" wire:click="removePhoto({{ $index }})" class="absolute top-1 right-1 w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-lg focus:opacity-100 focus:outline-none focus:ring-2 focus:ring-white" aria-label="Hapus foto">
                                                    <svg class="w-3 h-3" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('orderPhotos.*') <span class="text-xs text-red-600 font-bold ml-1" role="alert">{{ $message }}</span> @enderror
                                        <p class="text-[10px] text-slate-500 font-medium ml-1">Maksimal 2MB per foto. Membantu UMKM memberikan estimasi biaya lebih akurat.</p>
                                    </div>

                                    {{-- Notes --}}
                                    <div class="space-y-2">
                                        <label for="notes" class="text-[10px] font-black text-slate-600 uppercase tracking-widest ml-1">Catatan Khusus (Opsional)</label>
                                        <textarea id="notes" wire:model.live.blur="notes" rows="2" placeholder="Contoh: Fokus ke area dapur, ada noda membandel di karpet..." class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-[#0077B6] focus:border-[#0077B6] outline-none transition-all resize-none text-slate-900 placeholder-slate-400"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-8 py-6 sm:flex sm:flex-row-reverse gap-3 border-t border-slate-100">
                        <button type="button" wire:click="confirmOrder" class="w-full inline-flex justify-center rounded-2xl border border-transparent shadow-lg shadow-[#0077B6]/20 px-8 py-4 bg-[#0077B6] hover:bg-[#005f92] text-xs font-black text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-[#0077B6] focus:ring-offset-2 transition-all sm:w-auto">
                            Konfirmasi Pesanan
                        </button>
                        <button type="button" wire:click="$set('showOrderModal', false)" class="mt-3 w-full inline-flex justify-center rounded-2xl border border-slate-300 px-8 py-4 bg-white text-xs font-black text-slate-700 uppercase tracking-widest hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 transition-all sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
