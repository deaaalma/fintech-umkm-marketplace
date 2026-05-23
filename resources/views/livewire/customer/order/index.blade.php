<x-slot:title>My Orders</x-slot>

@section('extra-head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

<div x-data="{ 
    showFilterMenu: false,
    init() {
        flatpickr($refs.dateInput, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j M Y',
            onChange: (selectedDates) => {
                if (selectedDates.length === 2) {
                    @this.set('dateRange', selectedDates.map(d => d.toISOString().split('T')[0]));
                }
            }
        });
    }
}">
    <div class="mb-12">
        <div class="mb-2">
            <span class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em]">History</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-[#000B44] tracking-tighter mb-4 font-plus">
            My <span class="italic font-normal text-[#0077B6]">Orders</span>
        </h1>
        <p class="text-slate-400 text-lg max-w-2xl font-medium">Lacak dan kelola semua pesanan layanan Anda di satu tempat secara efisien.</p>
    </div>

    <div class="mb-12 relative z-30">
        <div class="flex flex-row gap-4 mb-6 items-stretch">
            <div class="relative w-full lg:w-[480px] transition-all duration-700 ease-in-out group">
                <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-[#0077B6] transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor invoice atau layanan..." 
                       class="w-full pl-14 pr-6 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-bold text-[#000B44] placeholder:text-slate-300 focus:outline-none focus:border-[#0077B6]/30 focus:ring-4 focus:ring-[#0077B6]/5 transition-all shadow-sm">
            </div>

            <div class="relative flex-shrink-0">
                <button @click="showFilterMenu = !showFilterMenu"
                        class="h-full px-8 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-black text-[#000B44] hover:bg-slate-50 transition-all flex items-center gap-3 shadow-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    <span class="hidden sm:inline">Filter</span>
                </button>

                <div x-show="showFilterMenu" @click.away="showFilterMenu = false" x-cloak x-transition
                     class="absolute right-0 mt-3 w-72 bg-white border border-slate-100 rounded-[2.2rem] shadow-2xl p-8 z-50">
                    
                    <div class="mb-8">
                        <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Rentang Tanggal</div>
                        <div class="relative">
                            <input type="text" x-ref="dateInput" placeholder="Pilih Tanggal" readonly
                                   class="w-full pl-4 py-3 bg-slate-50 border border-transparent rounded-xl text-[12px] font-bold text-[#000B44] transition-all cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Urutkan Status</div>
                        <div class="space-y-1.5">
                            <select wire:model.live="statusFilter" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-[12px] font-bold text-[#000B44] focus:ring-0 cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="pending_valuation">Review Admin</option>
                                <option value="waiting_payment">Menunggu Bayar</option>
                                <option value="paid">Sudah Dibayar</option>
                                <option value="processing">Dalam Proses</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-12 flex flex-wrap gap-4">
        @foreach($tabs as $tab)
        <button wire:click="$set('activeTab', '{{ $tab['id'] }}')"
                class="px-8 py-5 rounded-[2rem] border font-black text-[10px] uppercase tracking-[0.2em] transition-all flex items-center gap-4 group
                {{ $activeTab === $tab['id'] ? 'bg-[#000B44] text-white border-[#000B44] shadow-2xl shadow-[#000B44]/20' : 'bg-white text-slate-400 border-slate-100 hover:border-[#0077B6]/20' }}">
            <span>{{ $tab['label'] }}</span>
            <span class="px-3 py-1 rounded-full text-[9px] font-black {{ $activeTab === $tab['id'] ? 'bg-white/20 text-white' : 'bg-slate-50 text-slate-400' }}">
                {{ $tab['count'] }}
            </span>
        </button>
        @endforeach
    </div>

    <div class="space-y-6 min-h-[400px]">
        @forelse($orders as $order)
            <div class="order-item bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-[#0077B6]/15 transition-all group overflow-hidden premium-card-hover">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] font-mono">ORDER ID: #{{ $order['invoice'] }}</span>
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]">{{ $order['date'] }}</span>
                </div>

                <div class="mb-6 flex justify-between items-start">
                    <div>
                        <h4 class="text-3xl font-bold text-[#000B44] tracking-tight mb-2 group-hover:text-[#0077B6] transition-colors">{{ $order['service_name'] }}</h4>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $order['status']) }}</p>
                    </div>
                    <a href="#" class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                        Lihat Detail <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($order['status'] == 'pending_valuation' || $order['status'] == 'waiting_payment')
                    <div class="mb-8 p-6 bg-slate-50 border border-slate-100/50 rounded-[1.5rem] flex items-start gap-4 ring-1 ring-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm text-[#0077B6]">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </div>
                        <p class="text-[13px] font-bold text-slate-500 leading-relaxed">
                            {{ $order['status'] == 'pending_valuation' ? 'Admin sedang meninjau permintaan Anda.' : 'Pre-invoice sudah dikirim. Silakan selesaikan pembayaran.' }}
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-10 border-b border-slate-50">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4M8 2v4"/><path d="M3 10h18"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jadwal Pakai</div>
                            <div class="text-sm font-bold text-[#000B44]">{{ $order['booking_date'] }}</div>
                            <div class="text-xs font-bold text-slate-400">{{ $order['booking_time'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</div>
                            <div class="text-sm font-bold text-[#000B44] truncate max-w-[200px]">{{ $order['location'] }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-[11px] font-medium text-slate-400">
                        Penyedia Jasa: <span class="text-[#000B44] font-black">{{ $order['provider'] }}</span>
                    </div>
                    <button class="w-full sm:w-auto px-10 py-4 bg-[#000B44] text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all">
                        {{ $order['status'] == 'waiting_payment' ? 'Bayar Sekarang' : 'Detail Pesanan' }}
                    </button>
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                <h3 class="text-lg font-bold text-[#000B44] mb-2">Tidak ada pesanan ditemukan</h3>
                <p class="text-slate-400 text-sm">Coba cari dengan kata kunci lain atau filter berbeda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-16 flex justify-center">
        {{ $orders_pagination->links() }}
    </div>
</div>