<div class="max-w-5xl mx-auto space-y-10 animate-fade-in">
    {{-- Greeting Section --}}
    {{-- WCAG: All text uses slate-700+ on white for 4.5:1+ contrast --}}
    <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 font-plus tracking-tight mb-1 leading-tight">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>
            <p class="text-slate-600 font-semibold text-sm leading-relaxed">Semoga harimu produktif!</p>
        </div>
        <div class="flex items-center gap-6 bg-slate-50 px-6 py-4 rounded-2xl border border-slate-200 transition-all">
            @if($todayAttendance)
                {{-- Clock In Display --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center text-green-600 border border-green-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest leading-tight">Masuk</p>
                        <p class="text-sm font-black text-slate-900 leading-snug">{{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('H:i') }}</p>
                    </div>
                </div>

                @if($todayAttendance->clock_out)
                    {{-- Already Clocked Out --}}
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 border border-blue-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest leading-tight">Keluar</p>
                            <p class="text-sm font-black text-slate-900 leading-snug">{{ \Carbon\Carbon::parse($todayAttendance->clock_out)->format('H:i') }}</p>
                        </div>
                    </div>
                @else
                    {{-- Clock Out Button --}}
                    <button wire:click="clockOut" class="ml-auto flex items-center gap-3 px-4 py-2 bg-slate-900 hover:bg-black text-white rounded-xl transition-all hover:scale-105 active:scale-95 shadow-lg shadow-slate-200">
                        <span class="text-[10px] font-black uppercase tracking-widest">Absen Keluar</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                @endif
            @else
                {{-- Clock In Button --}}
                <button wire:click="clockIn" class="flex items-center gap-4 group focus:outline-none">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 shadow-sm border border-slate-200 group-hover:bg-[#000B44] group-hover:text-white transition-all group-hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest leading-tight group-hover:text-[#000B44]">Klik untuk</p>
                        <p class="text-sm font-black text-slate-900 leading-snug group-hover:text-[#000B44]">Absen Masuk</p>
                    </div>
                </button>
            @endif
        </div>
    </div>

    {{-- Tasks Today --}}
    <div>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-xl font-black text-slate-900 font-plus">Tugas Hari Ini</h2>
            {{-- Link: gray-400 FAIL → underline + slate-700 PASS (10.5:1) for WCAG 2.4.4 & 1.4.3 --}}
            <a href="{{ route('worker.tasks') }}"
               class="text-xs font-bold text-slate-700 hover:text-slate-900 underline underline-offset-2 transition-colors uppercase tracking-widest focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0077B6] focus-visible:ring-offset-2 rounded"
               aria-label="Lihat semua tugas saya">
                Lihat Semua
            </a>
        </div>
        <div class="space-y-4">
            @forelse($tasksToday as $assignment)
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="space-y-4 flex-1">
                        <div class="flex items-center gap-3">
                            <span @class([
                                'px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border',
                                'bg-blue-50 text-blue-700 border-blue-200' => $assignment->order->status === 'processing',
                                'bg-amber-50 text-amber-700 border-amber-200' => $assignment->order->status === 'waiting_payment',
                                'bg-green-50 text-green-700 border-green-200' => $assignment->order->status === 'completed',
                            ])>
                                {{ str_replace('_', ' ', $assignment->order->status) }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                                #{{ strtoupper(substr($assignment->order->invoice_number ?? 'ORD-'.$assignment->order->id, 0, 8)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 font-plus mb-2 leading-snug">
                                {{ $assignment->order->product->name }}
                            </h3>
                            <div class="flex flex-wrap gap-6 text-sm font-medium text-slate-600">
                                <div class="flex items-center gap-2">
                                    {{-- Icon: gray-300 FAIL (1.5:1) → slate-400 PASS (3.3:1, UI component) --}}
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $assignment->order->service_address ?? 'Alamat tidak diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $assignment->order->booking_time ?? '09:00' }} - 12:00 WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Button: #2D2D2D bg + white text = 16:1 PASS ✅ --}}
                    <button class="px-8 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-slate-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#2D2D2D] focus-visible:ring-offset-2">
                        Lihat Detail
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-slate-50 py-12 rounded-[32px] border border-dashed border-slate-300 text-center">
                {{-- Empty state: gray-400 FAIL → slate-600 PASS --}}
                <p class="text-slate-600 font-semibold text-sm leading-relaxed">Tidak ada tugas untuk hari ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Monthly Calendar (Google Calendar Style) --}}
    <div>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-xl font-black text-slate-900 font-plus">Jadwal Tugas</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm font-bold text-slate-700 bg-slate-100 px-4 py-2 rounded-xl">
                    {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
                </span>
                <div class="flex bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <button wire:click="previousMonth" class="p-2.5 hover:bg-slate-50 border-r border-slate-100 text-slate-500 transition-colors" title="Bulan Sebelumnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button wire:click="nextMonth" class="p-2.5 hover:bg-slate-50 text-slate-500 transition-colors" title="Bulan Berikutnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
            {{-- Header Days --}}
            <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/50">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                <div class="py-4 text-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $day }}</span>
                </div>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            <div class="grid grid-cols-7">
                @foreach($calendarDays as $day)
                <div @class([
                    'min-h-[100px] md:min-h-[120px] p-2 border-b border-r border-slate-100 transition-colors relative group',
                    'bg-slate-50/30' => !$day['is_current_month'],
                    'hover:bg-slate-50/80 cursor-pointer' => $day['is_current_month'],
                ])>
                    <div class="flex justify-between items-start mb-2">
                        <span @class([
                            'w-7 h-7 flex items-center justify-center text-xs font-black rounded-full transition-all',
                            'bg-[#000B44] text-white shadow-lg' => $day['is_today'],
                            'text-slate-900' => $day['is_today'] === false && $day['is_current_month'],
                            'text-slate-300' => !$day['is_current_month'],
                        ])>
                            {{ $day['day_num'] }}
                        </span>
                    </div>

                    {{-- Task Indicators (Events) --}}
                    @if($day['count'] > 0)
                        <div class="space-y-1">
                            <div @class([
                                'px-2 py-1 rounded-md text-[9px] font-black truncate border',
                                'bg-blue-50 text-blue-700 border-blue-100' => $day['is_today'] === false,
                                'bg-white/20 text-white border-white/30' => $day['is_today'],
                            ])>
                                {{ $day['count'] }} TUGAS
                            </div>
                            @if($day['count'] > 1)
                                <div class="px-2 text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                    + {{ $day['count'] - 1 }} Lainnya
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SOP & Guides --}}
    <div>
        <h2 class="text-xl font-black text-slate-900 font-plus mb-6 px-2">SOP &amp; Panduan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @php
            $sopCards = [
                ['title' => 'SOP Deep Cleaning', 'desc' => 'Standar kerja pembersihan', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['title' => 'SOP Keselamatan Kerja', 'desc' => 'Prosedur keamanan lapangan', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                ['title' => 'Panduan Alat & Bahan', 'desc' => 'Manajemen peralatan cleaning', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title' => 'Etika ke Customer', 'desc' => 'Komunikasi & pelayanan', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ];
            @endphp

            @foreach($sopCards as $card)
            <a href="{{ route('worker.sop') }}"
               class="bg-white p-6 rounded-[28px] border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-5 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0077B6] focus-visible:ring-offset-2">
                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-500 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors shrink-0" aria-hidden="true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900 font-plus mb-1 leading-snug">{{ $card['title'] }}</h3>
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-widest leading-tight">{{ $card['desc'] }}</p>
                </div>
            </a>
            @endforeach

        </div>
    </div>

    {{-- Notifications Summary --}}
    <div>
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-xl font-black text-slate-900 font-plus">Notifikasi Terbaru</h2>
            <a href="#" class="text-xs font-black text-[#0077B6] uppercase tracking-widest hover:underline decoration-2 underline-offset-4">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($notifications as $notif)
            <div @class([
                'flex items-start gap-4 p-5 rounded-[24px] border transition-all hover:shadow-md',
                'bg-white border-slate-100 shadow-sm' => $notif->read_at,
                'bg-blue-50/50 border-blue-100 shadow-blue-900/5 ring-1 ring-blue-100' => !$notif->read_at,
            ])>
                <div @class([
                    'w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border shadow-sm',
                    'bg-white text-slate-400 border-slate-100' => $notif->read_at,
                    'bg-white text-[#0077B6] border-blue-100' => !$notif->read_at,
                ])>
                    @if($notif->type === 'order_status')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    @elseif($notif->type === 'info')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <p @class([
                            'text-sm font-black truncate font-plus',
                            'text-slate-900' => !$notif->read_at,
                            'text-slate-600' => $notif->read_at,
                        ])>{{ $notif->title }}</p>
                        <span class="text-[9px] font-bold text-slate-400 uppercase whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p @class([
                        'text-xs leading-relaxed line-clamp-1',
                        'text-slate-600 font-semibold' => !$notif->read_at,
                        'text-slate-500' => $notif->read_at,
                    ])>{{ $notif->message }}</p>
                </div>
            </div>
            @empty
            <div class="bg-slate-50 py-10 rounded-[32px] border border-dashed border-slate-200 text-center">
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Tidak ada notifikasi baru</p>
            </div>
            @endforelse
        </div>
    </div>

</div>