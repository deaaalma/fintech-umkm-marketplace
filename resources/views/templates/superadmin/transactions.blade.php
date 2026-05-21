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
                    <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-3">Manajemen Transaksi</h2>
                    <p class="text-slate-500 font-medium">Pantau seluruh aliran dana dan pembayaran di platform.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-[#000B44] px-6 py-4 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-black/20 flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Report
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach([['Volume Transaksi', 'Rp 142.5M', 'bg-white'], ['Total Order', '842', 'bg-white'], ['Pending Payouts', 'Rp 12.8M', 'bg-[#000B44] text-white'], ['Success Rate', '98.5%', 'bg-white']] as $stat)
                <div class="{{ $stat[2] }} p-8 rounded-[2rem] border border-slate-50 shadow-xl shadow-slate-200/50 animate-fade-in-up">
                    <p class="text-[10px] font-bold uppercase tracking-widest mb-4 {{ str_contains($stat[2], 'text-white') ? 'text-white/50' : 'text-slate-400' }}">{{ $stat[0] }}</p>
                    <h3 class="text-4xl font-black font-plus tracking-tighter leading-none">{{ $stat[1] }}</h3>
                </div>
                @endforeach
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/30 overflow-hidden animate-fade-in-up">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-10">Order ID</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">UMKM</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nominal</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Metode</th>
                                <th class="p-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php
                                $txs = [
                                    ['TRX-9823', 'Warung Sedap Malam', 'Rp 450.000', 'SUCCESS', 'OVO', '10:45 AM'],
                                    ['TRX-9822', 'Konveksi Makmur', 'Rp 1.200.000', 'SUCCESS', 'BCA Transfer', '09:30 AM'],
                                    ['TRX-9821', 'Bengkel Motor Jaya', 'Rp 150.000', 'PENDING', 'GOPAY', '08:15 AM'],
                                    ['TRX-9820', 'Toko Kue Bunda', 'Rp 275.000', 'SUCCESS', 'ShopeePay', 'Yesterday'],
                                    ['TRX-9819', 'Laundry Express 24', 'Rp 85.000', 'FAILED', 'OVO', 'Yesterday'],
                                ]
                            @endphp
                            @foreach($txs as $tx)
                            <tr class="hover:bg-slate-50/70 transition-all cursor-pointer group">
                                <td class="p-8 px-10"><span class="text-[11px] font-black text-slate-400 font-mono tracking-tighter">{{ $tx[0] }}</span></td>
                                <td class="p-8"><span class="text-sm font-black text-[#000B44] font-plus tracking-tight">{{ $tx[1] }}</span></td>
                                <td class="p-8"><span class="text-sm font-black text-[#0077B6] font-plus">{{ $tx[2] }}</span></td>
                                <td class="p-8">
                                    <span @class([
                                        'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                        'bg-teal-50 text-teal-600 border-teal-100' => $tx[3] === 'SUCCESS',
                                        'bg-amber-50 text-amber-600 border-amber-100' => $tx[3] === 'PENDING',
                                        'bg-red-50 text-red-600 border-red-100' => $tx[3] === 'FAILED'
                                    ])>{{ $tx[3] }}</span>
                                </td>
                                <td class="p-8"><span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $tx[4] }}</span></td>
                                <td class="p-8"><span class="text-xs font-bold text-slate-300">{{ $tx[5] }}</span></td>
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
