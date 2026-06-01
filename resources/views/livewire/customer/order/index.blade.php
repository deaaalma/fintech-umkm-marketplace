<x-slot:title>Pesanan Saya</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

<div class="max-w-[1200px] mx-auto animate-fade-in-up" x-data="{ 
    showFilterMenu: false,
    init() {
        flatpickr($refs.dateInput, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j M Y',
            onChange: (selectedDates) => {
                if (selectedDates.length === 2) {
                    $wire.set('dateRange', selectedDates.map(d => {
                        // Handle timezone offset to ensure local date is sent
                        let offset = d.getTimezoneOffset() * 60000;
                        let localDate = new Date(d.getTime() - offset);
                        return localDate.toISOString().split('T')[0];
                    }));
                } else if (selectedDates.length === 0) {
                    $wire.set('dateRange', []);
                }
            }
        });
    }
}">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="text-[10px] font-bold text-gray-400 mb-2">Dashboard / <span class="text-gray-900">Pesanan Saya</span></div>
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight">Pesanan Saya</h1>
        <p class="text-gray-500 mt-1 font-medium text-sm">Kelola riwayat pemesanan Anda di sini.</p>
    </div>

    {{-- Tabs Row --}}
    <div class="flex items-center gap-3 overflow-x-auto pb-4 mb-6 hide-scrollbar">
        @php
            $currentTab = $activeTab ?? 'semua';
        @endphp

        @foreach($tabs as $tab)
        <button wire:click="$set('activeTab', '{{ $tab['id'] }}')" 
                class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full border text-xs font-bold transition-all
                {{ $currentTab === $tab['id'] ? 'bg-[#2D2D2D] border-[#2D2D2D] text-white shadow-sm' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $tab['label'] }}
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $currentTab === $tab['id'] ? 'bg-white/20' : 'bg-gray-100 text-gray-500' }}">
                {{ $tab['count'] }}
            </span>
        </button>
        @endforeach
    </div>

    {{-- Filters & Actions Row --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10">
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
            <div class="relative w-full sm:w-[350px]">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari berdasarkan nomor pesanan atau nama layanan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-black/5 transition-all">
            </div>

            <div class="relative w-full sm:w-auto">
                <input type="text" x-ref="dateInput" placeholder="Filter Tanggal" readonly
                       class="w-full sm:w-40 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium cursor-pointer text-center">
                <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            
            <div class="flex gap-2">
                <select wire:model.live="statusFilter" class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium cursor-pointer">
                    <option value="">Status Layanan</option>
                    <option value="pending_valuation">Menunggu Review</option>
                    {{-- Negotiation is a sub-state of pending_valuation now --}}
                    <option value="waiting_payment">Payment</option>
                    <option value="paid">Sudah Dibayar</option>
                    <option value="processing">Diproses</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        <a href="#" class="w-full md:w-auto px-6 py-2.5 bg-white border border-gray-200 text-gray-900 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pesanan
        </a>
    </div>

    {{-- Order Cards List --}}
    <div class="space-y-6 min-h-[400px]">
        @forelse($orders as $order)
            @if($order['status'] === 'waiting_payment')
                {{-- Card: Menunggu Pembayaran (Dark) --}}
                <div class="bg-[#2D2D2D] border border-black/20 rounded-3xl overflow-hidden shadow-lg relative group">
                    <div class="bg-black/20 px-6 md:px-8 py-3 flex items-center gap-2 text-white border-b border-white/10">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span class="text-[11px] font-black uppercase tracking-widest text-white">PENTING - Menunggu Pembayaran</span>
                    </div>
                    
                    <div class="p-6 md:p-8">
                        <div class="mb-6 flex justify-between items-start">
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #{{ $order['invoice'] }}</div>
                                <h3 class="text-xl font-black text-white font-plus">{{ $order['service_name'] }}</h3>
                            </div>
                        </div>

                        <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-6 flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-[13px] text-gray-300 font-medium leading-relaxed">Selesaikan pembayaran untuk konfirmasi booking layanan Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu Booking</div>
                                    <div class="text-sm font-bold text-white mt-0.5">{{ $order['booking_date'] }}</div>
                                    <div class="text-[11px] text-gray-400 font-medium">{{ $order['booking_time'] }} WIB</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                                    <div class="text-sm font-bold text-white mt-0.5">{{ $order['location'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-black/30 rounded-2xl p-5 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border border-white/5">
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pembayaran</div>
                                <div class="text-2xl font-black text-white font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
                            <button class="w-full sm:w-1/2 py-3.5 bg-white text-black rounded-xl text-xs font-bold hover:bg-gray-100 transition-colors shadow-sm">
                                Bayar Sekarang
                            </button>
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-1/2 py-3.5 bg-transparent border border-white/20 text-white rounded-xl text-xs font-bold hover:bg-white/10 transition-colors text-center flex items-center justify-center">
                                Lihat Detail
                            </a>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-[11px] font-medium text-gray-400 pt-6 border-t border-white/10">
                            <div>Penyedia Jasa: <span class="text-white font-bold">{{ $order['provider'] }}</span></div>
                            <div class="flex items-center gap-1 hover:text-white cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Hubungi Bantuan jika ada kendala
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($order['status'] === 'completed')
                {{-- Card: Selesai --}}
                <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #{{ $order['invoice'] }}</div>
                            <h3 class="text-xl font-black text-gray-900 font-plus mb-2">{{ $order['service_name'] }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                                Selesai
                            </span>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-black text-gray-900 font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu Booking</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['booking_date'] }}</div>
                                <div class="text-[11px] text-gray-500 font-medium">{{ $order['booking_time'] }} WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['location'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
                        <button class="w-full sm:w-1/3 py-3.5 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors shadow-sm">
                            Tulis Review
                        </button>
                        <button class="w-full sm:w-1/3 py-3.5 bg-white border border-gray-200 text-gray-900 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors shadow-sm">
                            Pesan Lagi
                        </button>
                        <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-1/3 py-3.5 bg-white text-gray-500 hover:text-gray-900 rounded-xl text-xs font-bold transition-colors text-center flex items-center justify-center">
                            Lihat Detail
                        </a>
                    </div>

                    <div class="mt-2 flex items-center justify-between text-[11px] font-medium text-gray-500 pt-6 border-t border-gray-100">
                        <div>Penyedia Jasa: <span class="text-gray-900 font-bold">{{ $order['provider'] }}</span></div>
                    </div>
                </div>

            @elseif($order['status'] === 'cancelled')
                {{-- Card: Dibatalkan --}}
                <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #{{ $order['invoice'] }}</div>
                            <h3 class="text-xl font-black text-gray-900 font-plus mb-2">{{ $order['service_name'] }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500">
                                Dibatalkan
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex items-start gap-3 opacity-60">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu Booking</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['booking_date'] }}</div>
                                <div class="text-[11px] text-gray-500 font-medium">{{ $order['booking_time'] }} WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 opacity-60">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['location'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[12px] text-gray-600 font-medium leading-relaxed">{{ $order['cancel_reason'] }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
                        <button class="w-full sm:w-1/2 py-3.5 bg-white border border-gray-200 text-gray-900 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors shadow-sm">
                            Pesan Lagi
                        </button>
                        <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-1/2 py-3.5 bg-white text-gray-500 hover:text-gray-900 rounded-xl text-xs font-bold transition-colors text-center flex items-center justify-center">
                            Lihat Detail
                        </a>
                    </div>

                    <div class="mt-2 flex items-center justify-between text-[11px] font-medium text-gray-500 pt-6 border-t border-gray-100">
                        <div>Penyedia Jasa: <span class="text-gray-900 font-bold">{{ $order['provider'] }}</span></div>
                    </div>
                </div>

            @else
                {{-- Card Default (Menunggu Review, Negosiasi, Proses) --}}
                <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Pesanan: #{{ $order['invoice'] }}</div>
                            <h3 class="text-xl font-black text-gray-900 font-plus mb-2">{{ $order['service_name'] }}</h3>
                            
                            @if($order['status'] === 'pending_valuation')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600">Menunggu Review Admin</span>
                            @elseif($order['status'] === 'pending_valuation' && $order['agreed_price'] !== null)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-[#2D2D2D] text-white tracking-widest uppercase shadow-sm">Perlu Tindakan Anda</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Dalam Proses</span>
                            @endif

                        </div>
                        <div class="text-right">
                            <div class="text-lg font-black text-gray-900 font-plus">Rp {{ number_format($order['price'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    @if($order['status'] === 'pending_valuation' && $order['agreed_price'] !== null)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-[13px] text-gray-700 font-medium leading-relaxed">Admin telah merespon pesanan Anda. Silakan review dan setujui untuk lanjut.</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0 border border-gray-100 shadow-sm">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Tanggal & Waktu Booking</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['booking_date'] }}</div>
                                <div class="text-[11px] text-gray-500 font-medium">{{ $order['booking_time'] }} WIB</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0 border border-gray-100 shadow-sm">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Lokasi</div>
                                <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $order['location'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        @if($order['status'] === 'pending_valuation' && $order['agreed_price'] !== null)
                            <button class="w-full sm:w-1/2 py-3.5 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors shadow-sm">
                                Review Pesanan
                            </button>
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-1/2 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors text-center flex items-center justify-center">
                                Lihat Detail
                            </a>
                        @else
                            <a href="{{ route('customer.order-details', $order['id']) }}" class="w-full sm:w-1/2 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors text-center flex items-center justify-center">
                                Lihat Detail
                            </a>
                            <button class="w-full sm:w-1/2 py-3.5 bg-white border border-red-200 text-red-600 rounded-xl text-xs font-bold hover:bg-red-50 transition-colors text-center">
                                Batalkan
                            </button>
                        @endif
                    </div>

                    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-100">
                        <div class="text-[11px] font-medium text-gray-500">
                            Penyedia Jasa: <span class="text-gray-900 font-bold">{{ $order['provider'] }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="py-20 text-center border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Tidak ada pesanan ditemukan</h3>
                <p class="text-gray-500 text-xs font-medium">Coba cari dengan kata kunci lain atau filter berbeda.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-12 flex justify-center">
        {{ $orders_pagination->links() }}
    </div>
</div>