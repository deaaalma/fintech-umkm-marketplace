<div class="max-w-[1200px] mx-auto animate-fade-in-up">
    <style>
        .metric-card { transition: box-shadow 0.2s ease; }
        .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); }
    </style>

    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-[#000B44] font-plus tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}</h1>
        <p class="text-slate-600 mt-1 font-medium">Berikut ringkasan pesanan Anda</p>
        <p class="text-xs text-slate-400 font-medium mt-2">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">

        {{-- Pesanan Aktif --}}
        <a href="{{ route('customer.orders') }}" class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-[#0077B6] transition-all duration-300 overflow-hidden shadow-sm">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-blue-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-[#0077B6] transition-colors">Pesanan Aktif</span>
                <div class="text-slate-400 group-hover:text-[#0077B6] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-blue-50/30 transition-colors">
                <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left" aria-label="{{ $activeOrdersCount }} pesanan aktif">{{ $activeOrdersCount }}</h3>
            </div>
        </a>

        {{-- Perlu Tindakan --}}
        <a href="{{ route('customer.orders') }}" class="metric-card block bg-[#000B44] rounded-2xl border border-[#1a3a7a] flex flex-col group relative overflow-hidden hover:opacity-90 transition-opacity" role="status" aria-live="polite">
            @if($needsActionCount > 0)
                <div class="absolute top-4 right-4 w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse" aria-hidden="true"></div>
            @endif
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-white/15">
                <span class="text-base font-bold text-white/90 flex-1">Perlu Tindakan</span>
                <div class="text-white/30 group-hover:text-white/60 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-4 flex-1">
                <h3 class="text-5xl font-black text-white font-plus tracking-tighter leading-none" aria-label="{{ $needsActionCount }} pesanan perlu tindakan">{{ $needsActionCount }}</h3>
            </div>
            <div class="px-6 pb-6 pt-3 border-t border-white/15 flex items-center justify-between">
                <span class="text-white/70 text-xs font-medium">
                    @if($needsActionCount > 0)
                        Memerlukan perhatian Anda
                    @else
                        Semua pesanan berjalan lancar
                    @endif
                </span>
            </div>
        </a>

        {{-- Selesai --}}
        <a href="{{ route('customer.orders', ['statusFilter' => 'completed']) }}" class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-emerald-500 transition-all duration-300 overflow-hidden shadow-sm">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-emerald-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-emerald-600 transition-colors">Selesai</span>
                <div class="text-slate-400 group-hover:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-emerald-50/30 transition-colors">
                <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left" aria-label="{{ $successOrdersCount }} pesanan selesai">{{ $successOrdersCount }}</h3>
            </div>
        </a>
    </div>

    {{-- Active Orders Table --}}
    <div class="bg-white rounded-2xl border border-slate-300 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.4s">
        {{-- Header --}}
        <div class="px-8 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <h3 class="text-base font-bold text-slate-800">Pesanan Aktif</h3>
                <span class="bg-slate-800 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">{{ count($activeOrders) }}</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari layanan, toko, invoice..." class="pl-9 pr-4 py-2 text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-xl w-full md:w-72 focus:outline-none focus:border-[#0077B6] focus:bg-white transition-all placeholder:text-slate-400">
                </div>
                {{-- Chat Admin Button --}}
                <a href="https://wa.me/6281339925118" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-[#000B44] hover:bg-[#001166] rounded-xl transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-[#000B44] focus:ring-offset-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>
                    Chat Admin
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Invoice / Layanan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Penyedia Jasa</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activeOrders as $order)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-4">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">#{{ $order->invoice_number ?? 'ORDER-'.$order->id }}</p>
                            <p class="text-sm font-bold text-[#000B44]">{{ $order->product->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-800">{{ $order->umkm->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $order->booking_date?->translatedFormat('d M Y') ?? '-' }}</p>
                            <p class="text-[11px] text-slate-500 font-medium">{{ $order->booking_time ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-start gap-1.5">
                                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-[11px] font-bold rounded-lg uppercase tracking-wider">
                                    @switch($order->status)
                                        @case('pending_valuation')
                                            @if($order->agreed_price)
                                                Negosiasi Harga
                                            @else
                                                Menunggu Tinjauan
                                            @endif
                                            @break
                                        @case('waiting_payment') Menunggu Bayar @break
                                        @case('paid') Menunggu Review @break
                                        @case('processing') Sedang Diproses @break
                                        @default {{ $order->status }}
                                    @endswitch
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->current_step == 3 || ($order->status === 'pending_valuation' && !is_null($order->agreed_price)))
                                <a href="{{ route('customer.order-details', $order->id) }}" class="inline-flex items-center justify-center w-40 gap-2 px-4 py-2 bg-[#0077B6] text-white rounded-lg text-xs font-bold hover:bg-[#005f8e] transition-colors shadow-sm">
                                    Review Pre-invoice
                                </a>
                            @elseif($order->current_step == 4 || $order->status === 'waiting_payment')
                                <a href="{{ route('customer.order-details', $order->id) }}" class="inline-flex items-center justify-center w-40 gap-2 px-4 py-2 bg-[#0077B6] text-white rounded-lg text-xs font-bold hover:bg-[#005f8e] transition-colors shadow-sm">
                                    Bayar Sekarang
                                </a>
                            @else
                                <a href="{{ route('customer.order-details', $order->id) }}" class="inline-flex items-center justify-center w-40 gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                    Lihat Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-500">Tidak ada pesanan aktif.</p>
                            @if(!empty($search))
                                <p class="text-xs text-slate-400 mt-1">Coba kata kunci pencarian yang lain.</p>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($activeOrders) > 0 && empty($search))
            {{-- Pagination / Footer --}}
            <div class="px-8 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    Menampilkan <span class="font-bold text-slate-700">{{ count($activeOrders) }}</span> pesanan aktif
                </div>
                <a href="{{ route('customer.orders') }}" class="text-xs font-bold text-[#0077B6] hover:text-[#005f8e] transition-colors">
                    Lihat Semua History &rarr;
                </a>
            </div>
        @endif
    </div>
</div>