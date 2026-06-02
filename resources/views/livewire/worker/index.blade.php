<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    {{-- Greeting Section --}}
    <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-1">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Semoga harimu produktif!</p>
        </div>
        <div class="flex items-center gap-4 bg-gray-50 px-6 py-4 rounded-2xl border border-gray-100">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-400 shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Absen Masuk</p>
                <p class="text-sm font-black text-gray-900">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>
    </div>

    {{-- Tasks Today --}}
    <div>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-xl font-black text-gray-900 font-plus">Tugas Hari Ini</h2>
            <a href="#" class="text-xs font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($tasksToday as $assignment)
            <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="space-y-4 flex-1">
                        <div class="flex items-center gap-3">
                            <span @class([
                                'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                'bg-blue-50 text-blue-600 border-blue-100' => $assignment->order->status === 'processing',
                                'bg-yellow-50 text-yellow-600 border-yellow-100' => $assignment->order->status === 'waiting_payment',
                                'bg-green-50 text-green-600 border-green-100' => $assignment->order->status === 'completed',
                            ])>
                                {{ str_replace('_', ' ', $assignment->order->status) }}
                            </span>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">#{{ strtoupper(substr($assignment->order->invoice_number ?? 'ORD-'.$assignment->order->id, 0, 8)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 font-plus mb-2 group-hover:text-[#2D2D2D] transition-colors">{{ $assignment->order->product->name }}</h3>
                            <div class="flex flex-wrap gap-6 text-xs font-bold text-gray-500">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $assignment->order->service_address ?? 'Alamat tidak diatur' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $assignment->order->booking_time ?? '09:00' }} - 12:00 WIB
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="px-8 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-gray-200">
                        Lihat Detail
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-gray-50 py-12 rounded-[32px] border border-dashed border-gray-200 text-center">
                <p class="text-gray-400 font-bold text-sm">Tidak ada tugas untuk hari ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Weekly Summary --}}
    <div>
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6 px-2">Tugas Minggu Ini</h2>
        <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
            @foreach($tasksThisWeek as $item)
            <div class="flex items-center justify-between p-6 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50/50 transition-colors">
                <div class="flex items-center gap-6">
                    <div class="w-12 text-center">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">{{ substr($item['day'], 0, 3) }}</p>
                        <p class="text-sm font-black {{ $item['is_today'] ? 'text-blue-600' : 'text-gray-900' }}">{{ explode(' ', $item['date'])[0] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $item['date'] }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item['count'] }} Tugas Terjadwal</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            @endforeach
        </div>
    </div>

    {{-- SOP & Guides --}}
    <div>
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6 px-2">SOP & Panduan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-5 cursor-pointer group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-gray-900 font-plus mb-1">SOP Deep Cleaning</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Standar kerja pembersihan</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-5 cursor-pointer group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-gray-900 font-plus mb-1">SOP Keselamatan Kerja</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Prosedur keamanan lapangan</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-5 cursor-pointer group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-gray-900 font-plus mb-1">Panduan Alat & Bahan</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Manajemen peralatan cleaning</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[28px] border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-5 cursor-pointer group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-gray-900 font-plus mb-1">Etika ke Customer</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Komunikasi & pelayanan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Announcements --}}
    <div>
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6 px-2">Pengumuman</h2>
        <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50">
            @foreach($announcements as $ann)
            <div class="p-8 hover:bg-gray-50/50 transition-all cursor-pointer">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-2">
                    <h3 class="text-base font-black text-gray-900 font-plus">{{ $ann['title'] }}</h3>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $ann['date'] }}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">{{ $ann['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>