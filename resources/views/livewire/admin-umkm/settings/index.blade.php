<x-slot:title>Pengaturan UMKM</x-slot>

<div class="space-y-6 pb-24 relative animate-fade-in-up">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan UMKM</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">Kelola konfigurasi dan preferensi bisnis</p>
    </div>



    <div class="flex flex-col gap-8">
        {{-- Horizontal Settings Tabs --}}
        <div class="w-full">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-2">
                <div class="flex overflow-x-auto hide-scrollbar gap-2 pb-1">
                    <button wire:click="setTab('profil_admin')" class="flex-shrink-0 flex items-center gap-3 px-5 py-3 rounded-xl transition-all {{ $activeTab === 'profil_admin' ? 'bg-[#000B44] text-white shadow-md shadow-[#000B44]/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $activeTab === 'profil_admin' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-sm font-bold whitespace-nowrap">Profil Admin</span>
                    </button>
                    <button wire:click="setTab('informasi')" class="flex-shrink-0 flex items-center gap-3 px-5 py-3 rounded-xl transition-all {{ $activeTab === 'informasi' ? 'bg-[#000B44] text-white shadow-md shadow-[#000B44]/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $activeTab === 'informasi' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="text-sm font-bold whitespace-nowrap">Informasi Perusahaan</span>
                    </button>

                    <button wire:click="setTab('pembayaran')" class="flex-shrink-0 flex items-center gap-3 px-5 py-3 rounded-xl transition-all {{ $activeTab === 'pembayaran' ? 'bg-[#000B44] text-white shadow-md shadow-[#000B44]/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $activeTab === 'pembayaran' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-sm font-bold whitespace-nowrap">Pembayaran</span>
                    </button>

                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="flex-1 space-y-6">
            
            @if($activeTab === 'profil_admin')
            {{-- Profil Admin Section --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden animate-fade-in">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Profil Admin</h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">Kelola data diri dan foto profil Anda</p>
                    </div>
                    @if(!$isEditing)
                    <button wire:click="$set('isEditing', true)" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Profil
                    </button>
                    @endif
                </div>
                
                <div class="p-8 space-y-8">
                    {{-- Avatar --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Foto Profil</label>
                        <div class="flex items-center gap-8">
                            <div class="w-24 h-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                                @if($admin_avatar)
                                    <img wire:key="admin-avatar-preview" src="{{ $admin_avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif(auth()->user()->profile_photo_path)
                                    <img wire:key="admin-avatar-active" src="{{ asset(auth()->user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @endif
                            </div>
                            <div class="space-y-3">
                                @if($isEditing)
                                <button type="button" onclick="document.getElementById('admin-avatar-upload').click()" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Unggah Foto
                                </button>
                                <p class="text-[10px] text-gray-500 font-medium leading-relaxed">Pilih foto dengan rasio 1:1, maksimal 1MB. Format: JPG, PNG.</p>
                                <input type="file" id="admin-avatar-upload" wire:model="admin_avatar" class="hidden" accept="image/*">
                                @else
                                <p class="text-xs font-bold text-gray-900">Foto Profil Aktif</p>
                                <p class="text-[10px] text-gray-500 font-medium">Ini adalah foto yang ditampilkan di sistem.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama Lengkap *</label>
                            @if($isEditing)
                            <input type="text" wire:model="admin_name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $admin_name ?: '-' }}</div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Email *</label>
                            @if($isEditing)
                            <input type="email" wire:model="admin_email" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $admin_email ?: '-' }}</div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon</label>
                            @if($isEditing)
                            <input type="text" wire:model="admin_phone" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $admin_phone ?: '-' }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab === 'informasi')
            {{-- Informasi Perusahaan Section --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden animate-fade-in">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Informasi Perusahaan</h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">Kelola data profil publik bisnis Anda</p>
                    </div>
                    @if(!$isEditing)
                    <button wire:click="$set('isEditing', true)" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Perusahaan
                    </button>
                    @endif
                </div>
                
                <div class="p-8 space-y-8">
                    {{-- Logo --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Logo Perusahaan</label>
                        <div class="flex items-center gap-8">
                            <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                                @if($logo)
                                    <img wire:key="logo-preview" src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain p-2">
                                @elseif($umkm->logo_url)
                                    <img wire:key="logo-active" src="{{ asset($umkm->logo_url) }}" class="w-full h-full object-contain p-2">
                                @else
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @endif
                            </div>
                            <div class="space-y-3">
                                @if($isEditing)
                                <button type="button" onclick="document.getElementById('logo-upload').click()" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Unggah Logo
                                </button>
                                <p class="text-[10px] text-gray-500 font-medium leading-relaxed">Pilih logo dengan rasio 1:1, maksimal 1MB. Format: JPG, PNG, atau SVG.</p>
                                <input type="file" id="logo-upload" wire:model="logo" class="hidden" accept="image/*">
                                @else
                                <p class="text-xs font-bold text-gray-900">Logo Aktif</p>
                                <p class="text-[10px] text-gray-500 font-medium">Ini adalah logo yang ditampilkan di profil publik UMKM Anda.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama UMKM *</label>
                            @if($isEditing)
                            <input type="text" wire:model="name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $name ?: '-' }}</div>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tagline</label>
                            @if($isEditing)
                            <input type="text" wire:model="tagline" placeholder="Slogan singkat bisnis Anda..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $tagline ?: '-' }}</div>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Deskripsi</label>
                            @if($isEditing)
                            <textarea wire:model="description" rows="4" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all resize-none font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400"></textarea>
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700 whitespace-pre-line">{{ $description ?: '-' }}</div>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Alamat Kantor</label>
                            @if($isEditing)
                            <textarea wire:model="address" rows="3" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all resize-none font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400"></textarea>
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700 whitespace-pre-line">{{ $address ?: '-' }}</div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Email UMKM *</label>
                            @if($isEditing)
                            <input type="email" wire:model="email" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $email ?: '-' }}</div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon UMKM</label>
                            @if($isEditing)
                            <input type="text" wire:model="phone" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                            @else
                            <div class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $phone ?: '-' }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Social Media Links</label>
                        <div class="space-y-3">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44-1.44-.645-1.44-1.44.645-1.44 1.44-1.44z"/></svg>
                                </div>
                                @if($isEditing)
                                <input type="text" wire:model="instagram_url" placeholder="Username Instagram" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                                @else
                                <div class="w-full pl-12 pr-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $instagram_url ?: '-' }}</div>
                                @endif
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.139 1.462 4.75 1.463 5.462 0 9.906-4.444 9.908-9.906.002-5.461-4.442-9.905-9.904-9.905-2.65 0-5.14 1.031-7.013 2.904-1.872 1.872-2.903 4.362-2.905 7.011-.002 1.714.475 3.391 1.378 4.85l-1.061 3.873 3.967-1.041zm11.089-7.129c-.285-.143-1.688-.832-1.948-.927-.261-.095-.45-.143-.64.143-.19.285-.736.927-.903 1.116-.166.19-.332.214-.617.071-.285-.143-1.202-.443-2.289-1.411-.846-.756-1.417-1.689-1.583-1.974-.166-.285-.018-.439.124-.581.128-.127.285-.332.427-.499.143-.166.19-.285.285-.475.095-.19.047-.356-.024-.5-.071-.143-.64-1.543-.878-2.113-.232-.554-.467-.478-.64-.488-.166-.008-.356-.01-.546-.01s-.5.071-.76.356c-.261.285-.997.974-.997 2.375s1.021 2.755 1.164 2.946c.143.19 2.01 3.067 4.869 4.302.68.295 1.21.471 1.623.601.683.216 1.305.186 1.796.113.547-.082 1.688-.689 1.925-1.354.237-.665.237-1.235.166-1.354-.07-.118-.261-.19-.546-.333z"/></svg>
                                </div>
                                @if($isEditing)
                                <input type="text" wire:model="whatsapp_number" placeholder="Nomor WhatsApp" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                                @else
                                <div class="w-full pl-12 pr-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $whatsapp_number ?: '-' }}</div>
                                @endif
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                                </div>
                                @if($isEditing)
                                <input type="text" wire:model="facebook_url" placeholder="Facebook Page URL" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                                @else
                                <div class="w-full pl-12 pr-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $facebook_url ?: '-' }}</div>
                                @endif
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                </div>
                                @if($isEditing)
                                <input type="text" wire:model="website_url" placeholder="Alamat Website" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900 placeholder:font-medium placeholder:text-gray-400">
                                @else
                                <div class="w-full pl-12 pr-5 py-3.5 bg-gray-50 rounded-2xl text-sm text-gray-700">{{ $website_url ?: '-' }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Placeholder sections for other tabs --}}


            @if($activeTab === 'pembayaran')
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden animate-fade-in">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Pengaturan Pembayaran</h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">Kelola metode pembayaran yang diterima</p>
                    </div>
                    @if(!$isEditing)
                    <button wire:click="$set('isEditing', true)" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Pembayaran
                    </button>
                    @endif
                </div>
                
                <div class="p-8 space-y-10">
                    {{-- QRIS Static Upload --}}
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">QRIS</h3>
                                <p class="text-[10px] text-gray-500 font-medium mt-1">Unggah gambar QRIS bisnis Anda untuk mempermudah pembayaran pelanggan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                            {{-- Preview Area --}}
                            <div 
                                @if($isEditing)
                                x-data="{ isDropping: false }"
                                x-on:dragover.prevent="isDropping = true"
                                x-on:dragleave.prevent="isDropping = false"
                                x-on:drop.prevent="isDropping = false; @this.upload('qris_image', $event.dataTransfer.files[0])"
                                onclick="document.getElementById('qris-upload').click()"
                                :class="isDropping ? 'border-teal-500 bg-teal-50 scale-[1.02] shadow-xl shadow-teal-500/10' : 'border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer'"
                                @endif
                                class="rounded-[40px] p-8 border-2 border-dashed flex flex-col items-center justify-center relative group min-h-[350px] transition-all duration-300 {{ !$isEditing ? 'bg-gray-50 border-gray-200' : '' }}">
                                @if($qris_image)
                                    <img wire:key="qris-preview" src="{{ $qris_image->temporaryUrl() }}" class="w-full h-full object-contain rounded-2xl shadow-2xl">
                                    <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center rounded-[38px]">
                                        <span class="px-5 py-2.5 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl">New Selection Preview</span>
                                    </div>
                                @elseif($umkm->qris_image_url)
                                    <img wire:key="qris-active" src="{{ asset($umkm->qris_image_url) }}" class="w-full h-full object-contain rounded-2xl shadow-xl">
                                    <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center rounded-[38px]">
                                        <span class="px-5 py-2.5 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl">Current Active QRIS</span>
                                    </div>
                                @else
                                    <div class="text-center space-y-4">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto shadow-sm text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                        </div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                            {{ $isEditing ? 'Tarik file atau klik untuk unggah' : 'Belum ada QRIS' }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions & Guide --}}
                            <div class="space-y-6">
                                @if($isEditing)
                                <input type="file" id="qris-upload" wire:model="qris_image" class="hidden" accept="image/*">
                                @endif
                                @error('qris_image') <span class="text-[10px] text-red-500 font-bold mt-1 inline-block">{{ $message }}</span> @enderror
                                @if($isEditing && ($qris_image || $umkm->qris_image_url))
                                    <button type="button" class="w-full py-3 text-[10px] font-black text-red-500 uppercase tracking-widest hover:bg-red-50 rounded-xl transition-all border border-red-50">
                                        Hapus Gambar
                                    </button>
                                @endif

                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Panduan QRIS</h4>
                                    <ul class="space-y-4">
                                        <li class="flex gap-3">
                                            <div class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-black shrink-0">1</div>
                                            <p class="text-[11px] font-medium text-gray-600 leading-relaxed">Gunakan gambar QRIS statis yang Anda dapatkan dari bank atau penyedia e-wallet.</p>
                                        </li>
                                        <li class="flex gap-3">
                                            <div class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-black shrink-0">2</div>
                                            <p class="text-[11px] font-medium text-gray-600 leading-relaxed">Pastikan kode QR terlihat jelas dan tidak terpotong (Crop tepat di area QR).</p>
                                        </li>
                                        <li class="flex gap-3">
                                            <div class="w-5 h-5 rounded-full bg-teal-500 text-white flex items-center justify-center text-[10px] font-black shrink-0">3</div>
                                            <p class="text-[11px] font-medium text-gray-600 leading-relaxed">Gambar ini akan ditampilkan secara otomatis saat pelanggan berada di tahap pembayaran.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Other Payment Options --}}
                    <div class="pt-10 border-t border-gray-50 opacity-40 grayscale pointer-events-none">
                         <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-sm font-black text-gray-400 font-plus uppercase tracking-wider">Virtual Account (Auto)</h3>
                                <p class="text-[10px] text-gray-400 font-medium mt-1">Integrasi pembayaran otomatis melalui Payment Gateway.</p>
                            </div>
                            <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-lg text-[9px] font-black uppercase tracking-widest border border-gray-200">Soon</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif



        </div>
    </div>

    {{-- Sticky Footer Actions --}}
    @if($isEditing)
    <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)] animate-fade-in-up">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="hidden md:block">
                <p class="text-xs text-gray-500 font-medium">Informasi perusahaan akan ditampilkan di halaman depan website Anda.</p>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button type="button" wire:click="mount" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    Reset
                </button>
                <button type="button" wire:click="save" class="flex-1 md:flex-none px-8 py-2.5 bg-[#000B44] hover:bg-[#000B44]/90 text-white rounded-full text-sm font-bold shadow-sm shadow-[#000B44]/20 transition-all flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
