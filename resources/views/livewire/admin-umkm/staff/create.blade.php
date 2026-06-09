<x-slot:title>Tambah Staff Baru</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="space-y-6 pb-24 relative animate-fade-in-up">
    {{-- Breadcrumbs & Header --}}
    <div>

        
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Staff Baru</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Kelola data staff dan admin internal</p>
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
                    @elseif($userExists && $existingUser && $existingUser->profile_photo_path)
                        <img src="{{ Storage::url($existingUser->profile_photo_path) }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-100">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-400 group-hover:bg-gray-100 transition-all">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-8 h-8 bg-black rounded-full flex items-center justify-center text-white border-2 border-white shadow-sm group-hover:scale-110 transition-transform {{ $userExists ? 'hidden' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    @if(!$userExists)
                        <input type="file" id="profile-upload" wire:model="profile_picture" class="hidden" accept="image/*">
                    @endif
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
                <div class="md:col-span-2 relative">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Nama Lengkap *</label>
                        @if($userExists)
                            <button type="button" wire:click="resetUser" class="text-[10px] font-bold text-red-500 uppercase tracking-widest hover:text-red-600 transition-all flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Reset / Cari Lain
                            </button>
                        @endif
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="name" placeholder="Ketik nama untuk mencari user..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed' : '' }}" {{ $userExists ? 'readonly' : '' }}>
                    
                    {{-- Suggestions Dropdown --}}
                    @if($showSuggestions && !$userExists)
                        <div class="absolute z-50 left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                            <div class="p-3 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pilih User Terdaftar</span>
                            </div>
                            @foreach($suggestions as $suggestion)
                                <button type="button" wire:click="selectUser({{ $suggestion['id'] }})" class="w-full flex items-center gap-3 p-3 hover:bg-gray-50 transition-all text-left group">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center text-gray-500">
                                        @if($suggestion['profile_photo_path'])
                                            <img src="{{ Storage::url($suggestion['profile_photo_path']) }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-black">{{ $suggestion['name'] }}</h4>
                                        <p class="text-xs text-gray-500 font-medium">{{ $suggestion['email'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                    @error('name') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Email *</label>
                    <input type="email" wire:model.live.debounce.500ms="email" placeholder="contoh@email.com" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed' : '' }}" {{ $userExists ? 'readonly' : '' }}>
                    @if($userExists)
                        <div class="flex items-center gap-1.5 mt-2 text-[#0077B6]">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider">User Terdaftar</span>
                        </div>
                    @endif
                    @error('email') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon *</label>
                    <input type="text" wire:model="phone" placeholder="0812..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed' : '' }}" {{ $userExists ? 'readonly' : '' }}>
                    @error('phone') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">NIK</label>
                    <input type="text" wire:model="nik" placeholder="16 digit NIK" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed' : '' }}" {{ $userExists ? 'readonly' : '' }}>
                    @error('nik') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tanggal Lahir</label>
                    <div x-data="{ init() { if (typeof flatpickr !== 'undefined' && !{{ $userExists ? 'true' : 'false' }}) flatpickr($refs.dob, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'j M Y', onChange: (d, str) => { @this.set('date_of_birth', str) } }) } }">
                        <input type="text" x-ref="dob" wire:model="date_of_birth" placeholder="Pilih Tanggal" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer' }}" {{ $userExists ? 'readonly' : '' }}>
                    </div>
                    @error('date_of_birth') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Posisi / Spesialisasi</label>
                    <input type="text" wire:model="specialization" placeholder="Contoh: Cleaning Service, Teknisi, Admin" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
                </div>
            </div>
        </div>

        {{-- 3. Password & Akses Login --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-2">Password & Akses Login</h2>
            <p class="text-xs text-gray-500 font-medium mb-6">Berikan akses untuk staff ini agar dapat login ke dashboard manajemen.</p>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Password *</label>
                    <input type="password" wire:model="password" placeholder="{{ $userExists ? 'Berhasil Terverifikasi' : 'Min. 8 karakter' }}" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all {{ $userExists ? 'opacity-60 cursor-not-allowed font-black tracking-widest' : '' }}" {{ $userExists ? 'readonly' : '' }}>
                    @error('password') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 mb-1">Berikan akses ke website manajemen</h4>
                        <p class="text-xs text-blue-700 font-medium leading-relaxed text-opacity-80">Staff akan menggunakan email dan password di atas untuk masuk ke sistem dashboard ini.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Status Staff --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Status Staff</h2>
            <div class="space-y-4">
                <label class="flex items-start gap-4 p-5 rounded-2xl border transition-all cursor-pointer {{ $is_active ? 'bg-black border-black text-white' : 'bg-gray-50 border-gray-100' }}">
                    <div class="w-5 h-5 rounded-full border-2 mt-0.5 flex items-center justify-center {{ $is_active ? 'border-white' : 'border-gray-300' }}">
                        @if($is_active) <div class="w-2.5 h-2.5 rounded-full bg-white"></div> @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold {{ $is_active ? 'text-white' : 'text-gray-900' }}">Aktif</h4>
                        <p class="text-xs mt-1 {{ $is_active ? 'text-gray-300' : 'text-gray-500' }} font-medium leading-relaxed">Pelanggan dapat melihat dan memesan layanan dari staff ini.</p>
                    </div>
                    <input type="radio" wire:model="is_active" value="1" class="sr-only">
                </label>
                <label class="flex items-start gap-4 p-5 rounded-2xl border transition-all cursor-pointer {{ !$is_active ? 'bg-black border-black text-white' : 'bg-gray-50 border-gray-100' }}">
                    <div class="w-5 h-5 rounded-full border-2 mt-0.5 flex items-center justify-center {{ !$is_active ? 'border-white' : 'border-gray-300' }}">
                        @if(!$is_active) <div class="w-2.5 h-2.5 rounded-full bg-white"></div> @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold {{ !$is_active ? 'text-white' : 'text-gray-900' }}">Nonaktif</h4>
                        <p class="text-xs mt-1 {{ !$is_active ? 'text-gray-300' : 'text-gray-500' }} font-medium leading-relaxed">Staff tidak akan muncul di website dan tidak dapat menerima pesanan baru.</p>
                    </div>
                    <input type="radio" wire:model="is_active" value="0" class="sr-only">
                </label>
            </div>
        </div>

        {{-- 5. Akses & Permissions --}}
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Akses & Permissions</h2>
            
            <div class="space-y-8">
                {{-- PESANAN --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Pesanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['order']['view'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['order']['view']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.order.view" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat melihat pesanan</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['order']['manage'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['order']['manage']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.order.manage" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat mengelola pesanan</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['order']['delete'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['order']['delete']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.order.delete" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat menghapus pesanan</span>
                        </label>
                    </div>
                </div>

                <hr class="border-gray-50">

                {{-- LAYANAN --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Layanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['service']['create'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['service']['create']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.service.create" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat membuat layanan</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['service']['manage'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['service']['manage']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.service.manage" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat mengelola layanan</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['service']['delete'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['service']['delete']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.service.delete" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat menghapus layanan</span>
                        </label>
                    </div>
                </div>

                <hr class="border-gray-50">

                {{-- MANAJEMEN STAFF --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Manajemen Staff</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['staff']['manage'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['staff']['manage']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.staff.manage" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat mengelola data staff</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['staff']['delete'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['staff']['delete']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.staff.delete" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat menghapus staff</span>
                        </label>
                    </div>
                </div>

                <hr class="border-gray-50">

                {{-- PENGATURAN --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Pengaturan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['setting']['schedule'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['setting']['schedule']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.setting.schedule" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat mengatur jadwal</span>
                        </label>
                        <label class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-5 h-5 rounded border-2 border-gray-200 flex items-center justify-center transition-all {{ $permissions['setting']['profile'] ? 'bg-black border-black' : 'group-hover:border-gray-400' }}">
                                @if($permissions['setting']['profile']) <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                            </div>
                            <input type="checkbox" wire:model.live="permissions.setting.profile" class="sr-only">
                            <span class="text-sm font-bold text-gray-700">Dapat mengatur profil</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Bottom Action Bar --}}
        <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="hidden md:block">
                    <p class="text-xs text-gray-500 font-medium">Pastikan semua data sudah terisi dengan benar.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('umkm.staff') }}" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 md:flex-none px-8 py-2.5 bg-[#2D2D2D] hover:bg-black text-white rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Staff Baru
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
