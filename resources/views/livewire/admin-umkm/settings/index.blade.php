<x-slot:title>Pengaturan UMKM</x-slot>

<div class="space-y-6 pb-24 relative animate-fade-in-up">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan UMKM</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">Kelola konfigurasi dan preferensi bisnis</p>
    </div>

    {{-- Disclaimer Banner --}}
    <div class="bg-[#F8FAFC] border border-gray-100 p-4 rounded-2xl flex items-center gap-3">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-xs text-gray-500 font-medium leading-none">Informasi ini: Data ini akan tampil di profil publik Anda / Mohon masukkan data dengan benar tanpa motif penipuan.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Settings Sidebar --}}
        <div class="w-full lg:w-72 shrink-0">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-2">
                <button wire:click="setTab('informasi')" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ $activeTab === 'informasi' ? 'bg-[#2D2D2D] text-white shadow-md shadow-black/10' : 'text-gray-500 hover:bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $activeTab === 'informasi' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-sm font-bold">Informasi Perusahaan</span>
                </button>
                <button wire:click="setTab('operasional')" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ $activeTab === 'operasional' ? 'bg-[#2D2D2D] text-white shadow-md shadow-black/10' : 'text-gray-500 hover:bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $activeTab === 'operasional' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm font-bold">Jam Operasional</span>
                </button>
                <button wire:click="setTab('kebijakan')" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ $activeTab === 'kebijakan' ? 'bg-[#2D2D2D] text-white shadow-md shadow-black/10' : 'text-gray-500 hover:bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $activeTab === 'kebijakan' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-sm font-bold">Kebijakan Pemesanan</span>
                </button>
                <button wire:click="setTab('pembayaran')" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ $activeTab === 'pembayaran' ? 'bg-[#2D2D2D] text-white shadow-md shadow-black/10' : 'text-gray-500 hover:bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $activeTab === 'pembayaran' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="text-sm font-bold">Pembayaran</span>
                </button>
                <button wire:click="setTab('notifikasi')" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all {{ $activeTab === 'notifikasi' ? 'bg-[#2D2D2D] text-white shadow-md shadow-black/10' : 'text-gray-500 hover:bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $activeTab === 'notifikasi' ? 'bg-white/10' : 'bg-gray-100 text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <span class="text-sm font-bold">Notifikasi</span>
                </button>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="flex-1 space-y-6">
            
            @if($activeTab === 'informasi')
            {{-- Informasi Perusahaan Section --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden animate-fade-in">
                <div class="p-8 border-b border-gray-50">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Perusahaan</h2>
                </div>
                
                <div class="p-8 space-y-8">
                    {{-- Logo --}}
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Logo Perusahaan</label>
                        <div class="flex items-center gap-8">
                            <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain p-2">
                                @elseif($umkm->logo_url)
                                    <img src="{{ asset($umkm->logo_url) }}" class="w-full h-full object-contain p-2">
                                @else
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @endif
                            </div>
                            <div class="space-y-3">
                                <button type="button" onclick="document.getElementById('logo-upload').click()" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Unggah Logo
                                </button>
                                <p class="text-[10px] text-gray-500 font-medium leading-relaxed">Pilih logo dengan rasio 1:1, maksimal 1MB. Format: JPG, PNG, atau SVG.</p>
                                <input type="file" id="logo-upload" wire:model="logo" class="hidden" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama UMKM *</label>
                            <input type="text" wire:model="name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-bold text-gray-900">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tagline</label>
                            <input type="text" wire:model="tagline" placeholder="Slogan singkat bisnis Anda..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Deskripsi</label>
                            <textarea wire:model="description" rows="4" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all resize-none"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Alamat Kantor</label>
                            <textarea wire:model="address" rows="3" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Email UMKM *</label>
                            <input type="email" wire:model="email" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nomor Telepon UMKM</label>
                            <input type="text" wire:model="phone" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Social Media Links</label>
                        <div class="space-y-3">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44-1.44-.645-1.44-1.44.645-1.44 1.44-1.44z"/></svg>
                                </div>
                                <input type="text" wire:model="instagram_url" placeholder="Username Instagram" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-medium">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.139 1.462 4.75 1.463 5.462 0 9.906-4.444 9.908-9.906.002-5.461-4.442-9.905-9.904-9.905-2.65 0-5.14 1.031-7.013 2.904-1.872 1.872-2.903 4.362-2.905 7.011-.002 1.714.475 3.391 1.378 4.85l-1.061 3.873 3.967-1.041zm11.089-7.129c-.285-.143-1.688-.832-1.948-.927-.261-.095-.45-.143-.64.143-.19.285-.736.927-.903 1.116-.166.19-.332.214-.617.071-.285-.143-1.202-.443-2.289-1.411-.846-.756-1.417-1.689-1.583-1.974-.166-.285-.018-.439.124-.581.128-.127.285-.332.427-.499.143-.166.19-.285.285-.475.095-.19.047-.356-.024-.5-.071-.143-.64-1.543-.878-2.113-.232-.554-.467-.478-.64-.488-.166-.008-.356-.01-.546-.01s-.5.071-.76.356c-.261.285-.997.974-.997 2.375s1.021 2.755 1.164 2.946c.143.19 2.01 3.067 4.869 4.302.68.295 1.21.471 1.623.601.683.216 1.305.186 1.796.113.547-.082 1.688-.689 1.925-1.354.237-.665.237-1.235.166-1.354-.07-.118-.261-.19-.546-.333z"/></svg>
                                </div>
                                <input type="text" wire:model="whatsapp_number" placeholder="Nomor WhatsApp" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-medium">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                                </div>
                                <input type="text" wire:model="facebook_url" placeholder="Facebook Page URL" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-medium">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                </div>
                                <input type="text" wire:model="website_url" placeholder="Alamat Website" class="w-full pl-12 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-black/5 transition-all font-medium">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Placeholder sections for other tabs --}}
            @if($activeTab === 'operasional')
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center py-20 animate-fade-in">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Segera Hadir</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Fitur manajemen jam operasional sedang dalam pengembangan.</p>
            </div>
            @endif

            @if($activeTab === 'kebijakan')
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center py-20 animate-fade-in">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Segera Hadir</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Fitur kebijakan pemesanan sedang dalam pengembangan.</p>
            </div>
            @endif

            @if($activeTab === 'pembayaran')
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center py-20 animate-fade-in">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Segera Hadir</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Fitur manajemen pembayaran sedang dalam pengembangan.</p>
            </div>
            @endif

            @if($activeTab === 'notifikasi')
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm text-center py-20 animate-fade-in">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900">Segera Hadir</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Fitur pengaturan notifikasi sedang dalam pengembangan.</p>
            </div>
            @endif

        </div>
    </div>

    {{-- Sticky Footer Actions --}}
    <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="hidden md:block">
                <p class="text-xs text-gray-500 font-medium">Informasi perusahaan akan ditampilkan di halaman depan website Anda.</p>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button type="button" wire:click="mount" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    Reset
                </button>
                <button type="button" wire:click="save" class="flex-1 md:flex-none px-8 py-2.5 bg-[#2D2D2D] hover:bg-black text-white rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
