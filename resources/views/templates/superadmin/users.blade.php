@component('layouts.blank')
<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .active-nav { background: rgba(255, 255, 255, 0.05); position: relative; }
        .active-nav::after { content: ''; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #0077B6; border-radius: 0 4px 4px 0; }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    </style>

    <!-- Sidebar -->
    @include('components.super-admin.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Top Header (Matches Image) -->
        <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight flex items-center gap-2">
                        Superadmin Portal
                    </h1>
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
                    <div class="hidden sm:block">
                        <p class="text-sm font-black text-[#000B44] font-plus leading-none">Admin</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Superadmin</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-10 lg:p-12 space-y-12">
            <!-- Page Title Area -->
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-3">Manajemen Pengguna</h2>
                    <p class="text-slate-500 font-medium">Kelola seluruh pengguna platform umkmconnect.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-[#000B44] px-6 py-4 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl transform hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-black/20 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach([['Total Pengguna', '1,247', 'bg-white'], ['Customer', '1,150', 'bg-white'], ['UMKM Admin', '85', 'bg-[#000B44] text-white'], ['Staff', '12', 'bg-white']] as $stat)
                <div class="{{ $stat[2] }} p-8 rounded-[2rem] border border-slate-50 shadow-xl shadow-slate-200/50 animate-fade-in-up">
                    <p class="text-[10px] font-bold uppercase tracking-widest mb-4 {{ str_contains($stat[2], 'text-white') ? 'text-white/50' : 'text-slate-400' }}">{{ $stat[0] }}</p>
                    <h3 class="text-4xl font-black font-plus tracking-tighter leading-none">{{ $stat[1] }}</h3>
                </div>
                @endforeach
            </div>

            <!-- Search & Filters -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/30">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-4 relative">
                        <input type="text" placeholder="Cari nama, email, phone..." class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-14 text-sm font-medium font-plus focus:ring-2 focus:ring-[#0077B6]/20 transition-all">
                        <svg class="w-5 h-5 text-slate-300 absolute left-5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <select class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black uppercase tracking-widest text-slate-400 focus:ring-2 focus:ring-[#0077B6]/20 transition-all font-plus">
                            <option>Role: SEMUA</option>
                            <option>Role: CUSTOMER</option>
                            <option>Role: UMKM ADMIN</option>
                            <option>Role: STAFF</option>
                        </select>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <select class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black uppercase tracking-widest text-slate-400 focus:ring-2 focus:ring-[#0077B6]/20 transition-all font-plus">
                            <option>Status: AKTIF</option>
                            <option>Status: SUSPENDED</option>
                            <option>Status: NON-AKTIF</option>
                        </select>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <button class="w-full py-4 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-[#000B44] hover:text-white transition-all">Clear Filters</button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/30 overflow-hidden animate-fade-in-up">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-10">Nama & Kontak</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal Daftar</th>
                                <th class="p-8 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php
                                $users = [
                                    ['Ahmad Fauzi', 'ahmad.fauzi@email.com', 'Customer', 'ACTIVE', '15 Jan 2026'],
                                    ['Siti Nurhaliza', 'siti.nur@email.com', 'Customer', 'ACTIVE', '20 Jan 2026'],
                                    ['Budi Santoso', 'budi@bwpcleaning.com', 'UMKM Admin', 'ACTIVE', '05 Jan 2026'],
                                    ['Rina Wijaya', 'rina.wj@email.com', 'Customer', 'SUSPENDED', '12 Jan 2026'],
                                    ['Dedi Kurniawan', 'dedi@expresslaundry.com', 'UMKM Admin', 'ACTIVE', '18 Jan 2026'],
                                    ['Linda Kusuma', 'linda.k@email.com', 'Staff', 'ACTIVE', '01 Jan 2026'],
                                ]
                            @endphp
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50/70 transition-all cursor-pointer group">
                                <td class="p-8 px-10">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-[#000B44] font-plus tracking-tight">{{ $user[0] }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $user[1] }}</span>
                                    </div>
                                </td>
                                <td class="p-8">
                                    <span @class([
                                        'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                        'bg-blue-50 text-blue-600 border-blue-100' => $user[2] === 'Customer',
                                        'bg-indigo-50 text-indigo-600 border-indigo-100' => $user[2] === 'UMKM Admin',
                                        'bg-teal-50 text-teal-600 border-teal-100' => $user[2] === 'Staff'
                                    ])>{{ $user[2] }}</span>
                                </td>
                                <td class="p-8">
                                    <span @class([
                                        'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                        'bg-teal-50 text-teal-600 border-teal-100' => $user[3] === 'ACTIVE',
                                        'bg-red-50 text-red-600 border-red-100' => $user[3] === 'SUSPENDED'
                                    ])>{{ $user[3] }}</span>
                                </td>
                                <td class="p-8"><span class="text-xs font-bold text-slate-500 tracking-tight">{{ $user[4] }}</span></td>
                                <td class="p-8">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <button class="bg-[#2D333D] px-4 py-2 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all">Edit</button>
                                        <button class="w-10 h-10 border border-slate-100 rounded-xl flex items-center justify-center text-slate-300 hover:text-red-600 hover:bg-red-50 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-10 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Halaman 1 dari 12</p>
                    <div class="flex items-center gap-2">
                         <button class="px-6 py-3 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-300 hover:text-[#000B44] transition-all">Sebelumnya</button>
                         <button class="px-6 py-3 bg-[#2D333D] rounded-xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-black transition-all shadow-lg">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endcomponent
