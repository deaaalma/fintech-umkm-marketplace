<x-slot:title>Pesanan Saya</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

<div class="max-w-[1200px] mx-auto animate-fade-in-up" x-data="{
    showFilters: false,
    init() {
        flatpickr($refs.dateInput, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j M Y',
            onChange: (selectedDates) => {
                if (selectedDates.length === 2) {
                    $wire.set('dateRange', selectedDates.map(d => {
                        let offset = d.getTimezoneOffset() * 60000;
                        let localDate = new Date(d.getTime() - offset);
                        return localDate.toISOString().split('T')[0];
                    }));
                } else if (selectedDates.length === 0) {
                    $wire.set('dateRange', null);
                }
            }
        });
    }
}">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-[#000B44] font-plus tracking-tight">Pesanan Saya ({{ $orders_pagination->total() }})</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Kelola riwayat pemesanan Anda di sini.</p>
            </div>
            <a href="{{ route('customer.partners') }}" class="flex items-center gap-2 px-5 py-2.5 bg-[#000B44] hover:bg-[#001166] text-white rounded-xl text-sm font-bold transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Pesanan
            </a>
        </div>
    </div>

    {{-- Search & Filters Panel (admin UMKM style) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6 space-y-4">
        <div class="flex flex-col md:flex-row items-center gap-3">
            {{-- Search --}}
            <div class="relative flex-1 w-full group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nomor pesanan, nama layanan, atau penyedia jasa..."
                    class="block w-full pl-11 pr-3 py-3 border border-slate-200 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#0077B6]/30 focus:border-[#0077B6] text-sm transition-all">
            </div>

            {{-- Filter Launcher --}}
            <div class="relative w-full md:w-auto">
                <button @click="showFilters = !showFilters" 
                    class="w-full md:w-auto px-6 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                    @if($statusFilter || (is_array($dateRange) && count($dateRange) === 2))
                        <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">
                            {{ ($statusFilter ? 1 : 0) + ((is_array($dateRange) && count($dateRange) === 2) ? 1 : 0) }}
                        </span>
                    @endif
                </button>

                {{-- Dropdown Filter Panel --}}
                <div x-show="showFilters" x-cloak wire:ignore.self
                    @click.away="if (!$event.target.closest('.flatpickr-calendar')) showFilters = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    class="absolute right-0 mt-3 w-full md:w-[320px] bg-white rounded-2xl border border-slate-200 shadow-xl z-50 p-5 space-y-5">
                    
                    <div wire:ignore>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rentang Tanggal</label>
                        <div class="relative">
                            <input type="text" x-ref="dateInput" placeholder="Pilih tanggal..." readonly
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium cursor-pointer text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pesanan</label>
                        <select wire:model.live="statusFilter" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending_valuation">Menunggu Review</option>
                            <option value="pending_valuation_negotiation">Perlu Tindakan (Negosiasi)</option>
                            <option value="waiting_payment">Menunggu Bayar</option>
                            <option value="paid">Sudah Dibayar</option>
                            <option value="processing">Sedang Diproses</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex gap-2">
                        <button @click="$wire.set('statusFilter', ''); $wire.set('dateRange', null); $refs.dateInput._flatpickr.clear(); showFilters = false;" type="button" class="flex-1 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">Reset</button>
                        <button @click="showFilters = false" class="flex-1 py-2 bg-[#000B44] text-white rounded-xl text-xs font-bold hover:bg-[#001166] transition-colors">Terapkan</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Filter Tags --}}
        @if($search || $statusFilter || (is_array($dateRange) && count($dateRange) === 2))
        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-slate-100">
            @if($search)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-lg">
                <span class="text-xs font-bold text-blue-700">Cari: "{{ $search }}"</span>
                <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
            @if($statusFilter)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg">
                <span class="text-xs font-bold text-indigo-700">Status: {{ str_replace('_', ' ', $statusFilter) }}</span>
                <button wire:click="$set('statusFilter', '')" class="text-indigo-400 hover:text-indigo-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
            @if(is_array($dateRange) && count($dateRange) === 2)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-teal-50 border border-teal-100 rounded-lg">
                <span class="text-xs font-bold text-teal-700">Tanggal Aktif</span>
                <button @click="$refs.dateInput._flatpickr.clear(); $wire.set('dateRange', null)" class="text-teal-400 hover:text-teal-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Order Cards List --}}
    <div class="space-y-5 min-h-[400px]">
        @forelse($orders as $order)

            @php
                $isPayment   = $order['status'] === 'waiting_payment';
                $isCompleted = $order['status'] === 'completed';
                $isCancelled = $order['status'] === 'cancelled';
                $needsAction = $order['status'] === 'pending_valuation' && $order['agreed_price'] !== null;

                $statusLabel = match($order['status']) {
                    'pending_valuation' => 'Menunggu Review',
                    'waiting_payment'   => 'Menunggu Pembayaran',
                    'paid'              => 'Sudah Dibayar',
                    'processing'        => 'Sedang Diproses',
                    'completed'         => 'Selesai',
                    'cancelled'         => 'Dibatalkan',
                    default             => $order['status'],
                };
                $statusColor = match($order['status']) {
                    'pending_valuation' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'waiting_payment'   => 'bg-blue-50 text-blue-700 border border-blue-200',
                    'paid'              => 'bg-teal-50 text-teal-700 border border-teal-200',
                    'processing'        => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                    'completed'         => 'bg-green-50 text-green-700 border border-green-200',
                    'cancelled'         => 'bg-slate-100 text-slate-500 border border-slate-200',
                    default             => 'bg-slate-100 text-slate-500 border border-slate-200',
                };
            @endphp

            {{-- ══ PAYMENT CARD (Navy / #000B44) ══ --}}
            @if($isPayment)
            <div class="bg-[#000B44] border border-[#1a3a7a] rounded-2xl overflow-hidden shadow-lg relative">
                {{-- Alert Banner --}}
                <div class="bg-white/10 px-6 md:px-8 py-3 flex items-center gap-2 border-b border-white/10">
                    <div class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse shrink-0"></div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-white">Menunggu Pembayaran</span>
                </div>

                <div class="p-6 md:p-8">
                    {{-- Header --}}
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                        <div>
                            <div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">#{{ $order['invoice'] }}</div>
                            <h3 class="text-xl font-black text-white font-plus mb-2">{{ $order['service_name'] }}</h3>
                            <p class="text-sm text-white/60 font-medium">{{ $order['provider'] }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">Total Pembayaran</div>
                            <div class="text-2xl font-black text-white font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    {{-- Info Row --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-white/40 uppercase">Tanggal</div>
                                <div class="text-sm font-bold text-white mt-0.5">{{ $order['booking_date'] }}</div>
                                <div class="text-[11px] text-white/50 font-medium">{{ $order['booking_time'] }} WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-white/40 uppercase">Lokasi</div>
                                <div class="text-sm font-bold text-white mt-0.5">{{ $order['location'] }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-white/10">
                        <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-white text-[#000B44] rounded-xl text-sm font-black hover:bg-slate-100 transition-colors shadow-sm">
                            Bayar Sekarang
                        </a>
                        <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-transparent border border-white/20 text-white rounded-xl text-sm font-bold hover:bg-white/10 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            {{-- ══ COMPLETED CARD ══ --}}
            @elseif($isCompleted)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-5">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">#{{ $order['invoice'] }}</div>
                        <h3 class="text-xl font-black text-[#000B44] font-plus mb-2">{{ $order['service_name'] }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black {{ $statusColor }}">{{ $statusLabel }}</span>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</div>
                        <div class="text-xl font-black text-[#000B44] font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 bg-slate-50 rounded-xl p-5 border border-slate-100">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Tanggal</div>
                            <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['booking_date'] }}</div>
                            <div class="text-[11px] text-slate-500">{{ $order['booking_time'] }} WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Lokasi</div>
                            <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['location'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Penyedia Jasa</div>
                            <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['provider'] }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 pt-5 border-t border-slate-100">
                    <button class="w-full sm:w-auto flex-1 py-3 bg-[#000B44] text-white rounded-xl text-sm font-bold hover:bg-[#001166] transition-colors shadow-sm">
                        Tulis Review
                    </button>
                    <button class="w-full sm:w-auto flex-1 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                        Pesan Lagi
                    </button>
                    <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-white text-slate-500 hover:text-[#000B44] hover:bg-slate-50 rounded-xl text-sm font-bold transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            {{-- ══ CANCELLED CARD ══ --}}
            @elseif($isCancelled)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm opacity-80 hover:opacity-100 transition-opacity">
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-5">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">#{{ $order['invoice'] }}</div>
                        <h3 class="text-xl font-black text-slate-500 font-plus mb-2">{{ $order['service_name'] }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black {{ $statusColor }}">{{ $statusLabel }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">{{ $order['cancel_reason'] }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5 opacity-60">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Tanggal</div>
                            <div class="text-sm font-bold text-slate-600 mt-0.5">{{ $order['booking_date'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Lokasi</div>
                            <div class="text-sm font-bold text-slate-600 mt-0.5">{{ $order['location'] }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 pt-5 border-t border-slate-100">
                    <button class="w-full sm:w-auto flex-1 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                        Pesan Lagi
                    </button>
                    <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center text-slate-500 hover:text-[#000B44] rounded-xl text-sm font-bold transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>

            {{-- ══ DEFAULT CARD (Active Orders) ══ --}}
            @else
            <div class="bg-white border {{ $needsAction ? 'border-[#0077B6]/40 shadow-md' : 'border-slate-200 shadow-sm' }} rounded-2xl overflow-hidden hover:shadow-md transition-shadow">
                @if($needsAction)
                <div class="bg-[#0077B6] px-6 md:px-8 py-2.5 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-yellow-300 animate-pulse shrink-0"></div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-white">Perlu Tindakan Anda — Review Pre-Invoice</span>
                </div>
                @endif

                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-5">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">#{{ $order['invoice'] }}</div>
                            <h3 class="text-xl font-black text-[#000B44] font-plus mb-2">{{ $order['service_name'] }}</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black {{ $statusColor }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</div>
                            <div class="text-xl font-black text-[#000B44] font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 bg-slate-50 rounded-xl p-5 border border-slate-100">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Tanggal</div>
                                <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['booking_date'] }}</div>
                                <div class="text-[11px] text-slate-500">{{ $order['booking_time'] }} WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Lokasi</div>
                                <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['location'] }}</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-100 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Penyedia Jasa</div>
                                <div class="text-sm font-bold text-[#000B44] mt-0.5">{{ $order['provider'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-5 border-t border-slate-100">
                        @if($needsAction)
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-[#0077B6] text-white rounded-xl text-sm font-black hover:bg-[#005f8e] transition-colors shadow-sm">
                                Review Pre-Invoice
                            </a>
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                Lihat Detail
                            </a>
                        @else
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-auto flex-1 py-3 text-center bg-[#000B44] text-white rounded-xl text-sm font-bold hover:bg-[#001166] transition-colors shadow-sm">
                                Lihat Detail
                            </a>
                            <button class="w-full sm:w-auto flex-1 py-3 bg-white border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-colors text-center">
                                Batalkan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        @empty
            <div class="py-20 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm border border-slate-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-base font-black text-[#000B44] font-plus mb-1">Tidak Ada Pesanan</h3>
                <p class="text-slate-500 text-sm font-medium">Coba cari dengan kata kunci lain atau ubah filter.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-10 pb-8">
        {{ $orders_pagination->links() }}
    </div>
</div>