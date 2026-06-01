<div class="max-w-[1200px] mx-auto animate-fade-in-up">
    
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}</h1>
        <p class="text-gray-500 mt-1 font-medium">Berikut ringkasan pesanan Anda</p>
        <p class="text-[10px] text-gray-400 font-bold mt-2">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
        {{-- Pesanan Aktif --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <div class="text-3xl font-black text-gray-900 font-plus leading-none mb-1">{{ $activeOrdersCount ?? 2 }}</div>
                <div class="text-xs font-bold text-gray-500">Pesanan Aktif</div>
            </div>
        </div>

        {{-- Perlu Tindakan --}}
        <div class="bg-[#2D2D2D] rounded-2xl p-6 border border-[#2D2D2D] shadow-lg shadow-black/10 flex items-center gap-5 relative overflow-hidden group">
            <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <div class="text-3xl font-black text-white font-plus leading-none mb-1">1</div>
                <div class="text-xs font-bold text-white/80">Perlu Tindakan</div>
                <div class="text-[9px] text-white/50 mt-1.5 leading-tight">Ada pesanan yang memerlukan perhatian Anda</div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-3xl font-black text-gray-900 font-plus leading-none mb-1">{{ $successOrdersCount ?? 8 }}</div>
                <div class="text-xs font-bold text-gray-500">Selesai</div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- Left Column (Active Orders) --}}
        <div class="lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-black text-gray-900 font-plus">Pesanan Aktif</h2>
                <a href="{{ route('customer.orders.preview') ?? '#' }}" class="text-xs font-bold text-gray-500 hover:text-black transition-colors flex items-center gap-1">
                    Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Mock Order Card 1: Normal Active --}}
            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #RWP-2026-0001</div>
                        <h3 class="text-lg font-black text-gray-900 font-plus mb-1">Deep Cleaning Service</h3>
                        <span class="text-[10px] font-bold text-gray-500">Menunggu Review Admin</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">18 Januari 2026</div>
                            <div class="text-[10px] text-gray-500 font-medium">10:00 WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">Jakarta Pusat</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Harga</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">Rp 2.500.000</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-50 pt-5">
                    <div>
                        <div class="text-[10px] text-gray-400 font-medium">Penyedia Jasa:</div>
                        <div class="text-xs font-bold text-gray-900">RWP Cleaning Service</div>
                    </div>
                    <button class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors flex items-center gap-2">
                        Lihat Detail <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mock Order Card 2: Needs Action (Review Pre-invoice) --}}
            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm relative">
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #ABC-2026-0012</div>
                        <h3 class="text-lg font-black text-gray-900 font-plus mb-2">Office Cleaning Service</h3>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black bg-red-100 text-red-700 uppercase tracking-widest border border-red-200">
                            Perlu Tindakan Anda
                        </span>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <svg class="w-4 h-4 text-gray-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-gray-700 font-medium leading-relaxed">Admin telah memproses pre-invoice. Silakan review dan setujui untuk melanjutkan ke tahap pembayaran.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">19 Januari 2026</div>
                            <div class="text-[10px] text-gray-500 font-medium">14:00 WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">Jakarta Selatan</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Harga</div>
                            <div class="text-xs font-bold text-gray-900 mt-0.5">Rp 3.200.000</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between border-t border-gray-50 pt-5 gap-4">
                    <div class="w-full md:w-auto text-left">
                        <div class="text-[10px] text-gray-400 font-medium">Penyedia Jasa:</div>
                        <div class="text-xs font-bold text-gray-900">ABC Cleaning Co</div>
                    </div>
                    <button class="w-full md:w-auto px-8 py-3 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors flex items-center justify-center gap-2 shadow-sm">
                        Review Pre-invoice <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mock Order Card 3: Waiting Payment --}}
            <div class="bg-white border border-[#2D2D2D]/20 rounded-3xl overflow-hidden shadow-sm relative">
                {{-- Dark Header --}}
                <div class="bg-[#2D2D2D] px-6 py-2.5 flex items-center gap-2 text-white">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">PENTING - Menunggu Pembayaran</span>
                </div>
                
                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #XYZ-2026-0033</div>
                        <h3 class="text-lg font-black text-gray-900 font-plus mb-2">Regular Cleaning</h3>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                        <svg class="w-4 h-4 text-gray-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <p class="text-xs text-gray-700 font-medium leading-relaxed">Selesaikan pembayaran untuk konfirmasi booking layanan Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu</div>
                                <div class="text-xs font-bold text-gray-900 mt-0.5">17 Januari 2026</div>
                                <div class="text-[10px] text-gray-500 font-medium">09:00 WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                                <div class="text-xs font-bold text-gray-900 mt-0.5">Tangerang</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Harga</div>
                                <div class="text-xs font-bold text-gray-900 mt-0.5">Rp 1.500.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between border-t border-gray-50 pt-5 gap-4">
                        <div class="w-full md:w-auto text-left">
                            <div class="text-[10px] text-gray-400 font-medium">Penyedia Jasa:</div>
                            <div class="text-xs font-bold text-gray-900">XYZ Services</div>
                        </div>
                        <button class="w-full md:w-auto px-8 py-3 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors flex items-center justify-center gap-2 shadow-sm">
                            Bayar Sekarang <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <button class="w-full py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl text-xs font-bold hover:bg-gray-50 transition-colors">
                Lihat Semua Pesanan
            </button>
        </div>

        {{-- Right Column (Sidebar) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- Menu Cepat --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus mb-4">Menu Cepat</h3>
                <div class="space-y-3">
                    <button class="w-full flex items-center justify-between p-3 bg-[#2D2D2D] hover:bg-black text-white rounded-xl transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span class="text-xs font-bold">Chat Admin</span>
                        </div>
                        <span class="w-5 h-5 flex items-center justify-center bg-white text-black text-[10px] font-black rounded-full">3</span>
                    </button>
                    
                    <button class="w-full flex items-center justify-between p-3 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="text-xs font-bold">Notifikasi</span>
                        </div>
                        <span class="w-5 h-5 flex items-center justify-center bg-[#2D2D2D] text-white text-[10px] font-black rounded-full">9</span>
                    </button>

                    <button class="w-full flex items-center p-3 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors gap-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-xs font-bold">Hubungi Kami</span>
                    </button>
                </div>
            </div>

            {{-- Notifikasi Terbaru --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-gray-900 font-plus">Notifikasi Terbaru</h3>
                    <span class="w-4 h-4 flex items-center justify-center bg-[#2D2D2D] text-white text-[9px] font-black rounded-full">5</span>
                </div>
                
                <div class="space-y-3">
                    {{-- Item 1 --}}
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex gap-3 relative">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 absolute top-4 right-3"></div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-900 font-bold leading-snug mb-1 pr-4">Pre-invoice dikirim untuk pesanan #RWP-2026-0001</p>
                            <p class="text-[9px] text-gray-400 font-medium">5 menit lalu</p>
                        </div>
                    </div>
                    
                    {{-- Item 2 --}}
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex gap-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-900 font-bold leading-snug mb-1">Pembayaran dikonfirmasi #XYZ-2026-0033</p>
                            <p class="text-[9px] text-gray-400 font-medium">2 jam lalu</p>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="p-3 border border-gray-100 rounded-xl flex gap-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-600 font-medium leading-snug mb-1">Staff ditugaskan ke pesanan Anda</p>
                            <p class="text-[9px] text-gray-400 font-medium">1 hari lalu</p>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-4 py-2.5 bg-gray-50 text-gray-600 hover:text-black hover:bg-gray-100 rounded-xl text-[10px] font-bold transition-colors uppercase tracking-widest">
                    Lihat Semua
                </button>
            </div>

            {{-- Butuh Bantuan --}}
            <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 text-center">
                <h3 class="text-sm font-black text-gray-900 font-plus mb-2">Butuh Bantuan?</h3>
                <p class="text-[10px] text-gray-500 font-medium mb-4">Tim support kami siap membantu Anda kapan saja.</p>
                <button class="w-full py-3 bg-[#2D2D2D] hover:bg-black text-white rounded-xl text-xs font-bold transition-colors">
                    Hubungi Support
                </button>
            </div>

        </div>
    </div>
</div>