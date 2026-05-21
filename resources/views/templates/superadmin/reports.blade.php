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
        <!-- Top Header -->
        <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight flex items-center gap-2">
                        Superadmin Portal
                    </h1>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-10 lg:p-12 space-y-12">
            <!-- Page Title Area -->
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-3">Laporan & Analytics</h2>
                    <p class="text-slate-500 font-medium">Analisis performa platform secara mendalam.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-[#2D333D] px-6 py-4 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-black/20 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Buat Laporan Baru
                    </button>
                </div>
            </div>

            <!-- Dashboard Split (Charts) -->
            <div class="grid grid-cols-12 gap-10">
                <div class="col-span-12 lg:col-span-8 bg-white p-12 rounded-[3.5rem] border border-slate-100 shadow-xl shadow-slate-200/20">
                    <h3 class="text-2xl font-black text-[#000B44] font-plus tracking-tight mb-12">Revenue Growth</h3>
                    <div class="h-[350px] bg-slate-50/50 rounded-[2.5rem] border border-slate-50 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#000B44]/5 to-transparent"></div>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] relative z-10">Line Chart visualization will be here</p>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-4 bg-[#000B44] p-12 rounded-[3.5rem] text-white shadow-2xl shadow-slate-300/30 flex flex-col justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-6">Total Pendapatan (Yearly)</p>
                        <h3 class="text-5xl font-black font-plus tracking-tighter leading-none mb-8">Rp 1.4B</h3>
                    </div>
                    <div class="space-y-6">
                        @foreach([['Platform Fee', 'Rp 42.5M'], ['Merchants', '3,247'], ['Success Rate', '99.2%']] as $v)
                        <div class="flex justify-between items-center border-b border-white/5 pb-4 last:border-0 last:pb-0">
                            <span class="text-[11px] font-bold text-white/40 uppercase tracking-wider">{{ $v[0] }}</span>
                            <span class="text-sm font-black text-white">{{ $v[1] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Scheduled Reports -->
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/30 overflow-hidden animate-fade-in-up">
                <div class="p-10 flex items-center justify-between border-b border-slate-50">
                    <h3 class="text-2xl font-black text-[#000B44] font-plus tracking-tight leading-none">Laporan Terjadwal</h3>
                </div>
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-10">Nama Laporan</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Frekuensi</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Format</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Next Run</th>
                                <th class="p-8 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach([
                                ['Weekly Revenue Report', 'SETIAP SENIN', 'PDF', '27 Jan 2026'],
                                ['Monthly UMKM Performance', 'SETIAP BULAN', 'EXCEL', '01 Feb 2026'],
                                ['Daily Transaction Summary', 'SETIAP HARI', 'CSV', 'Besok, 23:00'],
                            ] as $r)
                            <tr class="hover:bg-slate-50/70 transition-all cursor-pointer group">
                                <td class="p-8 px-10"><span class="text-sm font-black text-[#000B44] font-plus tracking-tight">{{ $r[0] }}</span></td>
                                <td class="p-8"><span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $r[1] }}</span></td>
                                <td class="p-8"><span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">{{ $r[2] }}</span></td>
                                <td class="p-8"><span class="text-xs font-bold text-slate-300">{{ $r[3] }}</span></td>
                                <td class="p-8 text-center">
                                    <button class="bg-slate-100 text-slate-400 p-3 rounded-xl hover:bg-[#000B44] hover:text-white transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg></button>
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
