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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Pengguna -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 animate-fade-in-up flex flex-col justify-between h-full" style="animation-delay: 0.1s">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-[#000B44] border border-slate-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Pengguna (Semua Role)</p>
                        </div>
                        <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-6">5,124</h3>
                    </div>
                    
                    <div class="mt-auto">
                        <!-- Role Breakdown -->
                        <div class="space-y-3 mb-5">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div> Customer</span>
                                <span class="text-xs font-black text-[#000B44]">3,820</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-indigo-500"></div> Admin UMKM</span>
                                <span class="text-xs font-black text-[#000B44]">1,280</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div> Staff Internal</span>
                                <span class="text-xs font-black text-[#000B44]">24</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                            <span class="text-teal-500 font-black text-[10px]">+12.5% vs bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- UMKM Terdaftar -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 animate-fade-in-up flex flex-col justify-between h-full" style="animation-delay: 0.2s">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">UMKM Terdaftar</p>
                        </div>
                        <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-6">1,284</h3>
                    </div>

                    <div class="mt-auto">
                        <!-- Target Progress -->
                        <div class="mb-5">
                            <div class="flex justify-between items-end mb-3">
                                <span class="text-[10px] font-bold text-slate-400">Aktif vs Pending</span>
                                <span class="text-[10px] font-black text-[#000B44]">85% Aktif</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden flex">
                                <div class="h-full bg-indigo-500" style="width: 85%"></div>
                                <div class="h-full bg-amber-400" style="width: 15%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-50 mt-[34px]">
                            <span class="text-indigo-500 font-black text-[10px]">+24 UMKM Baru Bulan Ini</span>
                        </div>
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-[#000B44] p-8 rounded-[2rem] text-white shadow-2xl shadow-indigo-900/40 animate-fade-in-up flex flex-col justify-between h-full relative overflow-hidden group" style="animation-delay: 0.3s">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    <div class="relative z-10 flex-1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white border border-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-[10px] font-black text-white/60 uppercase tracking-widest">Total Transaksi</p>
                        </div>
                        <h3 class="text-4xl font-black text-white font-plus tracking-tighter leading-none mb-6">84,592</h3>
                    </div>

                    <div class="relative z-10 mt-auto">
                        <!-- Bar Chart Mockup (White) -->
                        <div class="flex items-end gap-1.5 h-12 mb-5">
                            @foreach([40, 60, 45, 80, 55, 90, 75, 100] as $h)
                            <div class="w-full bg-white/30 rounded-t-sm group-hover:bg-white/50 transition-colors" style="height: {{ $h }}%"></div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-white/10 mt-[20px]">
                            <span class="text-white font-black text-[10px]">+18.4% Pertumbuhan</span>
                            <span class="text-white/40 font-bold text-[9px] uppercase">Rata-rata: 2.8k/Hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Section: Activity & Quick Task Split -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Activity Logs -->
                <div class="lg:col-span-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/30 animate-fade-in-up" style="animation-delay: 0.5s">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-black text-[#000B44] font-plus tracking-tight">System Alerts & Logs</h3>
                        <button class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-[#0077B6] transition-colors border-b border-transparent hover:border-[#0077B6]">Lihat Lengkap</button>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            ['08:32 AM', 'Peringatan: API Payment Gateway timeout pada route /payouts', 'error'],
                            ['08:15 AM', 'UMKM Baru "Warung Sederhana" mendaftar (Pending Approval)', 'info'],
                            ['07:00 AM', 'Backup database sistem harian berhasil dieksekusi (342MB)', 'success'],
                            ['Kemarin', 'User (Admin UMKM) ID: 1984 dibanned sementara', 'admin']
                        ] as $log)
                        <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                            <div @class([
                                'w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0',
                                'bg-red-50 text-red-500 border border-red-100' => $log[2] === 'error',
                                'bg-blue-50 text-blue-500 border border-blue-100' => $log[2] === 'info',
                                'bg-teal-50 text-teal-500 border border-teal-100' => $log[2] === 'success',
                                'bg-slate-100 text-[#000B44] border border-slate-200' => $log[2] === 'admin',
                            ])>
                                @if($log[2] === 'error') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($log[2] === 'success') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($log[2] === 'info') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @else <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-black text-slate-400 font-mono tracking-tighter mb-1">{{ $log[0] }}</p>
                                <p class="text-sm font-bold text-[#000B44] leading-snug">{{ $log[1] }}</p>
                            </div>
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 opacity-0 group-hover:opacity-100 hover:text-[#000B44] hover:bg-white border border-transparent hover:border-slate-200 transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:col-span-4 bg-[#000B44] text-white p-10 rounded-[2.5rem] shadow-2xl shadow-slate-300/30 animate-fade-in-up flex flex-col relative overflow-hidden" style="animation-delay: 0.6s">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                    <h3 class="text-xl font-black font-plus tracking-tight mb-8 relative z-10">Aksi Superadmin</h3>
                    <div class="flex-1 space-y-4 relative z-10">
                        @foreach([
                            ['Ekspor Laporan PDF', 'superadmin.reports.preview', 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                            ['Review UMKM Tertunda', 'superadmin.dashboard.preview', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                            ['Manajemen Pengguna', 'superadmin.users.preview', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z']
                        ] as $action)
                        <a href="{{ route($action[1]) }}" class="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white hover:text-[#000B44] transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-[#000B44]/5 transition-colors">
                                    <svg class="w-4 h-4 text-white group-hover:text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action[2] }}"></path></svg>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $action[0] }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Detailed Management Modules -->
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/30 overflow-hidden animate-fade-in-up" style="animation-delay: 0.7s">
                <div class="p-10 flex items-center justify-between border-b border-slate-50">
                    <div class="flex items-center gap-6">
                        <h3 class="text-xl font-black text-[#000B44] font-plus tracking-tight leading-none">Antrean Persetujuan UMKM</h3>
                        <span class="bg-red-50 text-red-600 text-[9px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest border border-red-100">12 Pending</span>
                    </div>
                </div>

                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-10">Kredensial UMKM</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori Bisnis</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Dokumen Profil</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Label Prioritas</th>
                                <th class="p-8 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach([
                                ['APP-2547', 'Warung Sedap Malam', 'Kuliner', '2 jam lalu', 100, 'HIGH', 'red'],
                                ['APP-2546', 'Konveksi Makmur', 'Fashion', '4 jam lalu', 100, 'HIGH', 'red'],
                                ['APP-2545', 'Bengkel Motor Jaya', 'Otomotif', '5 jam lalu', 85, 'NORMAL', 'amber'],
                                ['APP-2544', 'Toko Kue Bunda', 'Kuliner', '1 hari lalu', 90, 'NORMAL', 'amber'],
                            ] as $app)
                            <tr class="hover:bg-slate-50/70 transition-all cursor-pointer group">
                                <td class="p-8 px-10">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-[#000B44] font-plus tracking-tight">{{ $app[1] }}</span>
                                        <span class="text-[10px] font-black text-slate-400 font-mono tracking-tighter mt-1">{{ $app[0] }} • {{ $app[3] }}</span>
                                    </div>
                                </td>
                                <td class="p-8">
                                    <span class="inline-block px-3 py-1 bg-slate-100/50 text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-lg border border-slate-100">{{ $app[2] }}</span>
                                </td>
                                <td class="p-8">
                                    <div class="flex items-center gap-3">
                                        <div class="w-20 h-2 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                            <div class="h-full bg-teal-500 rounded-full" style="width: {{ $app[4] }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-teal-600">{{ $app[4] }}%</span>
                                    </div>
                                </td>
                                <td class="p-8">
                                    <span @class([
                                        'px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                        'bg-red-50 text-red-600 border-red-100' => $app[5] === 'HIGH',
                                        'bg-amber-50 text-amber-600 border-amber-100' => $app[5] === 'NORMAL'
                                    ])>{{ $app[5] }}</span>
                                </td>
                                <td class="p-8">
                                    <div class="flex items-center justify-center">
                                        <button class="bg-[#2D333D] px-6 py-2.5 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all shadow-md active:scale-95">Review Cepat</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </main>
</div>
@endcomponent
