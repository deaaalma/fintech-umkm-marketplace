<x-slot:title>Edit Data Staff</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="space-y-6 pb-24 relative animate-fade-in-up">
    {{-- Breadcrumbs & Header --}}
    <div>

        
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Data Staff</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Perbarui informasi dan hak akses staff</p>
        </div>
    </div>

    {{-- Form Sections --}}
    <form wire:submit.prevent="save" class="space-y-6">
        
        {{-- 1. Foto Profil --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Foto Profil</h2>
            <div class="flex items-center gap-8">
                <div class="relative group cursor-pointer" onclick="document.getElementById('profile-upload').click()">
                    @if($profile_picture)
                        <img src="{{ $profile_picture->temporaryUrl() }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-100">
                    @elseif($worker->user->profile_photo_path)
                        <img src="{{ Storage::url($worker->user->profile_photo_path) }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-100">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-400 group-hover:bg-gray-100 transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-8 h-8 bg-black rounded-full flex items-center justify-center text-white border-2 border-white shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <input type="file" id="profile-upload" wire:model.live="profile_picture" class="hidden" accept="image/*">
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Unggah Foto</h3>
                    <p class="text-xs text-gray-500 font-medium">JPG, PNG, atau GIF. Maksimal 2MB.</p>
                </div>
            </div>
            @error('profile_picture') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
        </div>

        {{-- 2. Data Pribadi Staff --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Data Pribadi Staff</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama Lengkap *</label>
                    <input type="text" wire:model="name" autocomplete="off" placeholder="Masukkan nama lengkap staff" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Email *</label>
                    <input type="email" wire:model="email" autocomplete="off" placeholder="contoh@email.com" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all">
                    @error('email') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon *</label>
                    <input type="text" wire:model="phone" autocomplete="off" placeholder="0812..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all">
                    @error('phone') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">NIK</label>
                    <input type="text" wire:model="nik" autocomplete="off" placeholder="16 digit NIK" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all">
                    @error('nik') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tanggal Lahir</label>
                    <div wire:ignore x-data="{ init() { setTimeout(() => { if (typeof flatpickr !== 'undefined') flatpickr($refs.dob, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'j M Y', defaultDate: $wire.get('date_of_birth'), onChange: (d, str) => { $wire.set('date_of_birth', str) } }) }, 100) } }">
                        <input type="text" x-ref="dob" autocomplete="off" placeholder="Pilih Tanggal" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all cursor-pointer">
                    </div>
                    @error('date_of_birth') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Posisi / Spesialisasi</label>
                    <input type="text" wire:model="specialization" autocomplete="off" placeholder="Contoh: Cleaning Service, Teknisi, Admin" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all">
                </div>
            </div>
        </div>

        {{-- 3. Password & Akses Login --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-2">Password & Akses Login</h2>
            <p class="text-xs text-gray-500 font-medium mb-6">Kosongkan jika tidak ingin mengubah password.</p>
            
            <div class="space-y-6">
                <div x-data="{ showPassword: false }">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Password Baru</label>
                    <div class="relative">
                        <input x-bind:type="showPassword ? 'text' : 'password'" wire:model="password" autocomplete="new-password" placeholder="Min. 8 karakter" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm placeholder:text-gray-400 focus:ring-2 focus:ring-black/5 transition-all pr-12">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-cloak x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- 4. Status Staff --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Status Staff</h2>
            <div class="space-y-4">
                <label class="flex items-start gap-4 p-5 rounded-2xl border transition-all cursor-pointer {{ $is_active ? 'bg-[#000B44] border-[#000B44] text-white' : 'bg-gray-50 border-gray-100' }}">
                    <div class="w-5 h-5 rounded-full border-2 mt-0.5 flex items-center justify-center {{ $is_active ? 'border-white' : 'border-gray-300' }}">
                        @if($is_active) <div class="w-2.5 h-2.5 rounded-full bg-white"></div> @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold {{ $is_active ? 'text-white' : 'text-gray-900' }}">Aktif</h4>
                        <p class="text-xs mt-1 {{ $is_active ? 'text-blue-100' : 'text-gray-500' }} font-medium leading-relaxed">Pelanggan dapat melihat dan memesan layanan dari staff ini.</p>
                    </div>
                    <input type="radio" wire:model.live="is_active" value="1" class="sr-only">
                </label>
                <label class="flex items-start gap-4 p-5 rounded-2xl border transition-all cursor-pointer {{ !$is_active ? 'bg-[#000B44] border-[#000B44] text-white' : 'bg-gray-50 border-gray-100' }}">
                    <div class="w-5 h-5 rounded-full border-2 mt-0.5 flex items-center justify-center {{ !$is_active ? 'border-white' : 'border-gray-300' }}">
                        @if(!$is_active) <div class="w-2.5 h-2.5 rounded-full bg-white"></div> @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold {{ !$is_active ? 'text-white' : 'text-gray-900' }}">Nonaktif</h4>
                        <p class="text-xs mt-1 {{ !$is_active ? 'text-blue-100' : 'text-gray-500' }} font-medium leading-relaxed">Staff tidak akan muncul di website dan tidak dapat menerima pesanan baru.</p>
                    </div>
                    <input type="radio" wire:model.live="is_active" value="0" class="sr-only">
                </label>
            </div>
        </div>



        {{-- Sticky Bottom Action Bar --}}
        <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="hidden md:block">
                    <p class="text-xs text-gray-500 font-medium">Perubahan akan langsung diterapkan setelah disimpan.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('umkm.staff') }}" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 md:flex-none px-8 py-2.5 bg-[#0077B6] hover:bg-[#000B44] text-white rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
