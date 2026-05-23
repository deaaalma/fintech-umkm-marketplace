<div class="min-h-screen bg-slate-50 -mx-6 -my-12 px-6 py-12 font-plus animate-fade-in text-slate-900">
    <div class="max-w-7xl mx-auto">
    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>

    {{-- ── PAGE HEADER ── --}}
    <div class="mb-12">
        <h1 class="text-3xl font-black font-plus text-[#000B44] tracking-tight">Manajemen Transaksi</h1>
        <p class="text-slate-500 font-medium mt-1">Pantau seluruh aliran dana dan pesanan di platform secara real-time.</p>
    </div>

    {{-- ── QUICK STATS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        {{-- Volume Transaksi --}}
        <div class="p-8 rounded-3xl bg-white shadow-none transition-all hover:bg-slate-50" style="border: 1px solid #e2e8f0 !important;">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Volume Transaksi</p>
            <h3 class="text-3xl font-black text-[#000B44] tracking-tighter">
                Rp {{ number_format($stats['total_volume'], 0, ',', '.') }}
            </h3>
        </div>

        {{-- Total Order --}}
        <div class="p-8 rounded-3xl bg-white shadow-none transition-all hover:bg-slate-50" style="border: 1px solid #e2e8f0 !important;">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Order</p>
            <h3 class="text-3xl font-black text-[#000B44] tracking-tighter">{{ number_format($stats['total_orders']) }}</h3>
        </div>

        {{-- Pending Payouts (Dark Card) --}}
        <div class="p-8 rounded-3xl bg-[#000B44] text-white shadow-none transition-all relative overflow-hidden group" style="border: 1px solid #ffffff10 !important;">
            <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-4 relative z-10">Pending Payouts</p>
            <h3 class="text-3xl font-black tracking-tighter text-white relative z-10">
                Rp {{ number_format($stats['pending_payouts'], 0, ',', '.') }}
            </h3>
            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-blue-500/10 blur-[60px] group-hover:bg-blue-400/20 transition-all"></div>
        </div>

        {{-- Success Rate --}}
        <div class="p-8 rounded-3xl bg-white shadow-none transition-all hover:bg-slate-50" style="border: 1px solid #e2e8f0 !important;">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Success Rate</p>
            <span class="text-3xl font-black text-[#000B44] tracking-tighter">{{ number_format($stats['success_rate'], 1) }}%</span>
        </div>
    </div>

    {{-- ── Compact Search & Filter Launcher ── --}}
    <div class="mt-10 flex flex-wrap items-center gap-4 animate-fade-in-up relative z-40" style="animation-delay: 0.3s">
        {{-- Search input --}}
        <div class="flex-1 min-w-[300px] relative group overflow-hidden">
            <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari invoice, merchant, atau buyer..." 
                class="w-full pl-14 pr-6 py-4 bg-white border border-slate-200 rounded-[24px] text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-[#0077B6] shadow-sm transition-all placeholder:text-slate-400">
        </div>

        {{-- Filter Launcher --}}
        <div class="relative" x-data="{ showFilters: false }">
            <button @click="showFilters = !showFilters" 
                class="px-8 py-4 bg-white border border-slate-200 rounded-[24px] text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center gap-3 active:scale-95">
                <svg class="w-5 h-5 text-slate-400 transition-colors group-focus-within:text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filters
                @if($statusFilter !== 'all' && $statusFilter !== '')
                    <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">1</span>
                @endif
            </button>

            {{-- ── ACTUAL PREMIUM FILTER PANEL ── --}}
            <div x-show="showFilters" x-cloak wire:ignore.self
                @click.away="showFilters = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="absolute right-0 mt-4 w-[550px] bg-white rounded-[32px] border border-slate-200 shadow-2xl z-[90] overflow-hidden"
                x-data="{ activeTab: 'status' }">
                
                <div class="flex" style="min-height: 380px;">
                    {{-- Left Sidebar --}}
                    <div class="w-44 bg-slate-50/80 border-r border-slate-100 p-6 flex flex-col gap-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Kategori</p>
                        <button @click="activeTab = 'status'" 
                            :class="activeTab === 'status' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-100'"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Status
                        </button>
                        <button @click="activeTab = 'date'" 
                            :class="activeTab === 'date' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-100'"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Rentang Tanggal
                        </button>
                    </div>

                    {{-- Main Options Content --}}
                    <div class="flex-1 flex flex-col bg-white p-8">
                        {{-- Tab Status --}}
                        <div x-show="activeTab === 'status'" class="space-y-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Status Transaksi</p>
                            <div class="space-y-3">
                                @foreach([
                                    'all' => 'Semua Transaksi',
                                    'pending_valuation' => 'Belum Dinilai',
                                    'waiting_payment' => 'Menunggu Bayar',
                                    'paid' => 'Sudah Bayar',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ] as $key => $val)
                                <label class="flex items-center gap-4 cursor-pointer group">
                                    <div class="relative w-5 h-5 rounded-full border-2 border-slate-200 flex items-center justify-center group-hover:border-blue-500 transition-all">
                                        <input type="radio" wire:model.live="statusFilter" value="{{ $key }}" class="hidden peer">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#000B44] scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-[#000B44] transition-colors">{{ $val }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tab Tanggal --}}
                        <div x-show="activeTab === 'date'" class="space-y-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Rentang Waktu</p>
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Tanggal Mulai</label>
                                    <input type="date" wire:model.live="startDate" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-100 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Tanggal Selesai</label>
                                    <input type="date" wire:model.live="endDate" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-100 transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="mt-auto pt-6 border-t border-slate-50 flex gap-3">
                            <button wire:click="resetFilters" @click="showFilters = false" class="flex-1 px-6 py-3 bg-slate-100 text-slate-500 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-all">Reset All</button>
                            <button @click="showFilters = false" class="flex-[2] px-8 py-3 bg-[#000B44] text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-lg shadow-blue-500/10 hover:scale-[1.02] transition-all">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Active Chips Summary ── --}}
    @if(($statusFilter !== 'all' && $statusFilter !== '') || $search || $startDate || $endDate)
    <div class="mt-8 flex flex-wrap items-center gap-3 animate-fade-in-up">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Filter Aktif:</p>
        
        @if($search)
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-blue-50/50 border border-blue-100 rounded-full">
            <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Cari: "{{ $search }}"</span>
            <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        @if($statusFilter !== 'all' && $statusFilter !== '')
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-indigo-50/50 border border-indigo-100 rounded-full">
            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Status: {{ str_replace('_', ' ', $statusFilter) }}</span>
            <button wire:click="$set('statusFilter', 'all')" class="text-indigo-400 hover:text-indigo-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        @if($startDate || $endDate)
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-teal-50/50 border border-teal-100 rounded-full">
            <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest">Periode: {{ $startDate ?: '...' }} — {{ $endDate ?: '...' }}</span>
            <button wire:click="clearDates" class="text-teal-400 hover:text-teal-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        <button wire:click="resetFilters" class="text-[10px] font-black text-rose-500 hover:bg-rose-50 px-4 py-2 rounded-full transition-colors ml-2 uppercase tracking-widest">Hapus Semua</button>
    </div>
    @endif

    {{-- ── TRANSACTION TABLE ── --}}
    <div class="mt-4 bg-white rounded-[32px] border border-slate-200 overflow-hidden shadow-sm animate-fade-in-up">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[#000B44]">
                        <th class="px-8 py-6 text-xs font-black text-slate-400">Order ID & Invoice</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400">Merchant (UMKM)</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400">Pembeli</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400">Total Pembayaran</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400 text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 text-right">Review</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/80 transition-all cursor-default group">
                        {{-- Invoice & ID --}}
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-black text-[#000B44]">{{ $ord->invoice_number ?? 'DRAFT-'.str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $ord->created_at->format('d M — H:i') }}</span>
                            </div>
                        </td>

                        {{-- Merchant --}}
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-plus font-black text-slate-400 text-sm shadow-inner group-hover:scale-105 transition-transform">
                                    {{ substr($ord->umkm->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-[#000B44] group-hover:text-blue-600 transition-colors">{{ $ord->umkm->name }}</span>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-bold text-slate-700">{{ $ord->customer->name ?? 'Guest' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Customer</span>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-6">
                            <span class="text-sm font-black text-[#000B44]">Rp {{ number_format($ord->agreed_price) }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-6 text-center">
                            @php
                                $s = match($ord->status) {
                                    'pending_valuation' => ['label' => 'BELUM DINILAI', 'color' => 'text-amber-500 bg-amber-50'],
                                    'waiting_payment'   => ['label' => 'MENUNGGU BAYAR', 'color' => 'text-blue-500 bg-blue-50'],
                                    'paid'              => ['label' => 'SUDAH BAYAR', 'color' => 'text-teal-600 bg-teal-50'],
                                    'processing'        => ['label' => 'DIPROSES', 'color' => 'text-indigo-600 bg-indigo-50'],
                                    'completed'         => ['label' => 'SELESAI', 'color' => 'text-emerald-600 bg-emerald-50'],
                                    'cancelled'         => ['label' => 'DIBATALKAN', 'color' => 'text-rose-500 bg-rose-50'],
                                    default => ['label' => strtoupper($ord->status), 'color' => 'text-slate-400 bg-slate-50'],
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $s['color'] }} border border-current/10 text-center inline-block min-w-[120px]">
                                {{ $s['label'] }}
                            </span>
                        </td>

                        {{-- Action --}}
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end">
                                <button class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 group-hover:text-indigo-500 group-hover:bg-indigo-50 rounded-xl transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <h4 class="text-sm font-black text-slate-300 uppercase tracking-widest">Belum ada data transaksi.</h4>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ── --}}
        @if(isset($orders) && method_exists($orders, 'links') && $orders->hasPages())
        <div class="px-10 py-8 border-t border-slate-100 bg-slate-50/10">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
