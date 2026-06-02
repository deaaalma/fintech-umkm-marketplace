@component('layouts.blank')
<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    </style>

    <!-- Sidebar -->
    @include('components.super-admin.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Top Header -->
        <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight flex items-center gap-2">
                        System Overview
                    </h1>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden xl:flex flex-1 max-w-2xl mx-12">
                <div class="relative w-full">
                    <input type="text" placeholder="Quick search UID, TRX, or Email..." class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-medium focus:ring-2 focus:ring-[#0077B6]/20 transition-all font-plus">
                    <svg class="w-5 h-5 text-slate-300 absolute left-5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- User Actions -->
            <div class="flex items-center gap-6">
                <button class="relative w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-4 pl-6 border-l border-slate-100">
                    <div class="w-12 h-12 bg-slate-100 rounded-full overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=000B44&color=fff" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-10 lg:p-12 space-y-10">
            <!-- Top Section: Key Metrics -->
            <style>
                @keyframes sparkPulse { 0%,100%{opacity:.5} 50%{opacity:.9} }
                .spark-line { animation: sparkPulse 2.5s ease-in-out infinite; }
                .metric-card { transition: box-shadow 0.2s ease; }
                .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); }
            </style>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- ── Card 1: Total Pengguna ── --}}
                <a href="{{ route('superadmin.dashboard.users') }}" class="metric-card group bg-white rounded-2xl border border-slate-300 animate-fade-in-up hover:border-[#0077B6] hover:scale-[1.01] transition-all duration-300 overflow-hidden shadow-sm flex flex-col" style="animation-delay: 0.08s">
                    {{-- Top row: label + dots --}}
                    <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-blue-50/50 transition-colors">
                        <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-[#0077B6] transition-colors">Total Pengguna</span>
                        <div class="text-slate-400 group-hover:text-[#0077B6] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </div>

                    {{-- Main number --}}
                    <div class="px-6 pt-5 pb-4 group-hover:bg-blue-50/30 transition-colors">
                        <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left">142</h3>
                    </div>

                    {{-- Role breakdown --}}
                    <div class="px-6 pb-6 space-y-3 border-t border-slate-200 pt-4 bg-slate-50/30 group-hover:bg-white transition-colors flex-1">
                        <div class="flex h-2.5 rounded-full overflow-hidden bg-slate-100">
                            <div class="bg-[#0077B6]" style="width:63.4%"></div>
                            <div class="bg-indigo-400" style="width:28.9%"></div>
                            <div class="bg-teal-400" style="width:7.7%"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#0077B6] flex-shrink-0"></span>
                                    <span class="text-xs text-slate-500 font-semibold">Customer</span>
                                </div>
                                <span class="text-base font-black text-[#000B44] pl-4">90</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                    <span class="text-xs text-slate-500 font-semibold">Admin</span>
                                </div>
                                <span class="text-base font-black text-[#000B44] pl-4">41</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-teal-400 flex-shrink-0"></span>
                                    <span class="text-xs text-slate-500 font-semibold">Staff</span>
                                </div>
                                <span class="text-base font-black text-[#000B44] pl-4">11</span>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- ── Card 2: UMKM Terdaftar ── --}}
                <div class="metric-card bg-white rounded-2xl border border-slate-300 animate-fade-in-up" style="animation-delay: 0.16s">
                    {{-- Top row --}}
                    <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200">
                        <span class="text-base font-bold text-slate-700 flex-1">UMKM Terdaftar</span>
                        <button class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                        </button>
                    </div>

                    {{-- Main number --}}
                    <div class="px-6 pt-5 pb-4">
                        <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none">38</h3>
                    </div>

                    {{-- Aktif vs Pending --}}
                    <div class="px-6 pb-6 space-y-3 border-t border-slate-200 pt-4">
                        <div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 inline-block"></span> Aktif
                                </span>
                                <span class="text-xs font-bold text-slate-700">32 · 84%</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width:84%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span> Pending
                                </span>
                                <span class="text-xs font-bold text-slate-700">6 · 16%</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width:16%"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <span class="text-xs text-slate-500 font-medium">6 menunggu persetujuan</span>
                            <span class="bg-red-100 text-red-500 text-xs font-semibold px-4 py-1.5 rounded-full">Perlu Review</span>
                        </div>
                    </div>
                </div>

                {{-- ── Card 3: Total Transaksi ── --}}
                <div class="metric-card bg-[#000B44] rounded-2xl border border-[#1a3a7a] animate-fade-in-up flex flex-col group" style="animation-delay: 0.24s">
                    {{-- Top row --}}
                    <div class="flex items-center px-6 pt-6 pb-4 border-b border-white/15">
                        <span class="text-base font-bold text-white/80 flex-1">Total Transaksi</span>
                        <button class="text-white/30 hover:text-white/60 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                        </button>
                    </div>

                    {{-- Main number --}}
                    <div class="px-6 pt-5 pb-4">
                        <h3 class="text-5xl font-black text-white font-plus tracking-tighter leading-none">312</h3>
                    </div>

                    {{-- Mini bar sparkline --}}
                    <div class="px-6 pb-3 flex items-end gap-1 h-14 flex-1">
                        @foreach([35, 52, 41, 68, 50, 78, 62, 85, 71, 100] as $h)
                        <div class="flex-1 rounded-t bg-white/20 group-hover:bg-white/35 transition-colors spark-line" style="height:{{ $h }}%; animation-delay: {{ $loop->index * 0.07 }}s"></div>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 pb-6 pt-3 border-t border-white/15 flex items-center justify-between">
                        <span class="text-white/60 text-xs font-medium">Rata-rata harian</span>
                        <span class="text-white text-xs font-bold">~10 transaksi/hari</span>
                    </div>
                </div>

            </div>

            <!-- Pending UMKM Applications Table -->
            <div class="bg-white rounded-2xl border border-slate-300 overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">

                {{-- Header --}}
                <div class="px-8 py-5 flex items-center justify-between border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <h3 class="text-base font-bold text-slate-800">Pending UMKM Applications</h3>
                        <span class="bg-slate-800 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">6</span>
                        <span class="bg-red-100 text-red-500 text-xs font-semibold px-3 py-1 rounded-full">6 PRIORITY TINGGI</span>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Search --}}
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                            </svg>
                            <input type="text" placeholder="Cari nama atau kategori..." class="pl-9 pr-4 py-2 text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-xl w-60 focus:outline-none focus:border-[#0077B6] focus:bg-white transition-all placeholder:text-slate-400">
                        </div>
                        {{-- Filter --}}
                        <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:border-slate-300 hover:bg-slate-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID Aplikasi</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Bisnis</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Apply</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelengkapan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach([
                                ['APP-2847', 'Warung Sedap Malam',  'Kuliner',  '2 jam lalu',  95,  'TINGGI'],
                                ['APP-2846', 'Konveksi Makmur',     'Fashion',  '4 jam lalu',  100, 'TINGGI'],
                                ['APP-2845', 'Bengkel Motor Jaya',  'Otomotif', '5 jam lalu',  85,  'NORMAL'],
                                ['APP-2844', 'Toko Kue Bunda',      'Kuliner',  '1 hari lalu', 90,  'NORMAL'],
                                ['APP-2843', 'Laundry Express 24',  'Jasa',     '1 hari lalu', 100, 'TINGGI'],
                                ['APP-2842', 'Sablon Kilat',        'Printing', '2 hari lalu', 75,  'RENDAH'],
                            ] as $app)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-8 py-4 text-xs text-slate-400 font-mono">{{ $app[0] }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-slate-800">{{ $app[1] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 text-xs font-medium rounded-lg">{{ $app[2] }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $app[3] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-slate-700 rounded-full" style="width: {{ $app[4] }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600">{{ $app[4] }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'inline-block px-3 py-1 text-xs font-bold rounded-lg',
                                        'bg-slate-800 text-white'     => $app[5] === 'TINGGI',
                                        'bg-slate-200 text-slate-600' => $app[5] === 'NORMAL',
                                        'bg-slate-100 text-slate-400' => $app[5] === 'RENDAH',
                                    ])>{{ $app[5] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition-colors">Review</button>
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-slate-600 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-8 py-4 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        Menampilkan 1-6 dari
                        <span class="font-semibold text-slate-700">6</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors disabled:opacity-40" disabled>Sebelumnya</button>
                        <button class="w-8 h-8 flex items-center justify-center text-sm font-bold bg-slate-800 text-white rounded-lg">1</button>
                        <button class="w-8 h-8 flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">2</button>
                        <button class="w-8 h-8 flex items-center justify-center text-sm text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">3</button>
                        <button class="px-3 py-1.5 text-sm font-semibold text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Selanjutnya</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
@endcomponent
