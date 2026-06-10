<x-slot:title>Home</x-slot>

<div class="space-y-10">
    {{-- Dashboard Header --}}
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-black text-[#000B44] font-plus tracking-tight">Dashboard Overview</h1>
        <p class="text-slate-500 font-medium text-base mt-2">Selamat datang kembali, <span class="text-[#0077B6] font-bold">{{ auth()->user()->name }}</span>!</p>
    </div>
    <style>
        .metric-card { transition: box-shadow 0.2s ease; }
        .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
        {{-- New Orders --}}
        <a href="{{ route('umkm.orders') }}" class="metric-card block bg-[#000B44] rounded-2xl border border-[#1a3a7a] flex flex-col group relative overflow-hidden hover:opacity-90 transition-opacity animate-fade-in-up" style="animation-delay: 0.1s">
            @if($stats['new_orders'] > 0)
                <div class="absolute top-4 right-4 w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></div>
            @endif
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-white/15">
                <span class="text-base font-bold text-white/90 flex-1">New Orders</span>
                <div class="text-white/30 group-hover:text-white/60 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-4 flex-1">
                <h3 class="text-5xl font-black text-white font-plus tracking-tighter leading-none">{{ $stats['new_orders'] }}</h3>
            </div>
            <div class="px-6 pb-6 pt-3 border-t border-white/15 flex items-center justify-between">
                <span class="text-white/70 text-xs font-medium">Orders waiting for approval</span>
            </div>
        </a>

        {{-- Total Revenue --}}
        <div class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-emerald-500 transition-all duration-300 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-emerald-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-emerald-600 transition-colors">Total Revenue</span>
                <div class="text-slate-400 group-hover:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-emerald-50/30 transition-colors">
                <h3 class="text-3xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left whitespace-nowrap">Rp {{ number_format($stats['total_balance'], 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Active Orders --}}
        <a href="{{ route('umkm.orders', ['category' => 'Active']) }}" class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-[#0077B6] transition-all duration-300 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-blue-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-[#0077B6] transition-colors">Active Orders</span>
                <div class="text-slate-400 group-hover:text-[#0077B6] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-blue-50/30 transition-colors">
                <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left">{{ $stats['active_orders'] }}</h3>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-12 gap-8 items-stretch">
        {{-- Status Orderan (Formerly Live Pipeline) --}}
        <div class="col-span-12 xl:col-span-4 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm font-plus flex flex-col">
            <h3 class="text-2xl font-black text-[#000B44] tracking-tight mb-10">Status Orderan</h3>
            <div class="flex-1 flex flex-col items-center justify-center">
                @php
                    $totalPipelineOrders = array_sum($pipeline) > 0 ? array_sum($pipeline) : 1;
                    $cumulativePercent = 0;
                    $colors = [
                        'waiting'    => '#f59e0b', // amber-500
                        'paid'       => '#14b8a6', // teal-500
                        'processing' => '#3b82f6', // blue-500
                        'completed'  => '#10b981', // emerald-500
                    ];
                @endphp
                
                {{-- Donut Chart --}}
                <div class="relative w-48 h-48 mb-10">
                    <svg viewBox="0 0 100 100" class="transform -rotate-90 w-full h-full drop-shadow-sm">
                        <!-- Background circle -->
                        <circle cx="50" cy="50" r="40" fill="transparent" stroke="#f8fafc" stroke-width="14" />
                        
                        @foreach($pipeline as $label => $count)
                            @php
                                $percent = ($count / $totalPipelineOrders) * 100;
                                // Circumference = 2 * pi * 40 = 251.327
                                $dasharray = ($percent * 251.327 / 100) . ' 251.327'; 
                                $offset = -($cumulativePercent * 251.327 / 100);
                            @endphp
                            @if($percent > 0)
                                <circle cx="50" cy="50" r="40" fill="transparent" stroke="{{ $colors[strtolower($label)] ?? '#cbd5e1' }}" stroke-width="14" stroke-dasharray="{{ $dasharray }}" stroke-dashoffset="{{ $offset }}" class="transition-all duration-1000 ease-out" />
                            @endif
                            @php $cumulativePercent += $percent; @endphp
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-black text-[#000B44] tracking-tighter">{{ array_sum($pipeline) }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Orders</span>
                    </div>
                </div>

                {{-- KPI Cards (Legend) --}}
                <div class="w-full grid grid-cols-2 gap-4 mt-auto">
                    @foreach($pipeline as $label => $count)
                    <div class="bg-slate-50/50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $colors[strtolower($label)] ?? '#cbd5e1' }}"></div>
                        <div class="flex-1">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $label }}</p>
                            <p class="text-lg font-black text-[#000B44] leading-none">{{ $count }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pesanan Baru (Table) --}}
        <div class="col-span-12 xl:col-span-8 bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm animate-fade-in-up font-plus flex flex-col h-full" style="animation-delay: 0.4s">
            {{-- Header --}}
            <div class="px-10 py-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <h3 class="text-2xl font-black text-[#000B44] tracking-tight">New Orders</h3>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('umkm.orders') }}" class="px-6 py-3 bg-[#000B44] text-white rounded-xl text-xs font-bold hover:bg-[#001166] transition-colors shadow-sm">
                        View All Orders &rarr;
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Invoice / Layanan</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-10 py-6">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">#{{ $order->invoice_number ?? 'ORDER-'.$order->id }}</p>
                                <p class="text-sm font-bold text-[#000B44]">{{ $order->product->name ?? 'Layanan Umum' }}</p>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-sm font-bold text-slate-800">{{ $order->customer->name ?? 'Guest' }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <p class="text-sm font-semibold text-slate-700">{{ $order->booking_date?->translatedFormat('d M Y') ?? '-' }}</p>
                                <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $order->booking_time ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                    NEW ORDER
                                </span>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <a href="{{ route('umkm.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-[120px] px-4 py-2 bg-white text-slate-600 rounded-xl text-[11px] font-bold hover:bg-slate-50 hover:text-[#000B44] border border-slate-200 transition-colors shadow-sm">
                                    Proses Order
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-12 text-center">
                                <p class="text-sm font-bold text-slate-400">Tidak ada pesanan baru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Footer Note --}}
            @if($stats['new_orders'] > 4)
            <div class="px-10 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-center items-center">
                <p class="text-[11px] font-bold text-slate-400">
                    Menampilkan 4 dari total <span class="text-[#000B44]">{{ $stats['new_orders'] }}</span> pesanan baru.
                </p>
            </div>
            @else
            <div class="px-10 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-center items-center">
                <p class="text-[11px] font-bold text-slate-400">
                    Menampilkan semua pesanan baru.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>