<x-slot:title>Order Management</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="space-y-6 animate-fade-in-up" x-data="{
    showFilters: false,
    init() {
        if (typeof flatpickr !== 'undefined') {
            flatpickr($refs.dateInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j M Y',
                onChange: (selectedDates) => {
                    if (selectedDates.length === 2) {
                        let offset1 = selectedDates[0].getTimezoneOffset() * 60000;
                        let start = new Date(selectedDates[0].getTime() - offset1).toISOString().split('T')[0];
                        let offset2 = selectedDates[1].getTimezoneOffset() * 60000;
                        let end = new Date(selectedDates[1].getTime() - offset2).toISOString().split('T')[0];
                        $wire.set('date_start', start);
                        $wire.set('date_end', end);
                    } else if (selectedDates.length === 0) {
                        $wire.set('date_start', '');
                        $wire.set('date_end', '');
                    }
                }
            });
        }
    }
}">

    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-up">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Table Header / Inner Title --}}
    <div>
        <h1 class="text-2xl font-black text-[#000B44] font-plus tracking-tight">Daftar Pesanan ({{ $orders_pagination->total() }})</h1>
        <p class="text-slate-500 mt-1 font-medium text-sm">Kelola riwayat dan status seluruh pesanan Anda di sini.</p>
    </div>

    {{-- Search and Filters --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4" @click.away="if (!$event.target.closest('.flatpickr-calendar')) showFilters = false">
        <div class="flex flex-col md:flex-row items-center gap-3">
            <div class="relative flex-1 w-full group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Cari pesanan berdasarkan ID, pelanggan, layanan..." 
                    class="block w-full pl-11 pr-3 py-3 border border-slate-200 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#0077B6]/30 focus:border-[#0077B6] text-sm transition-all">
            </div>

            <div class="relative w-full md:w-auto">
                <button @click="showFilters = !showFilters" 
                    class="w-full md:w-auto px-6 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                    @php
                        $filterCount = ($category != 'All' ? 1 : 0) + ($staff_id ? 1 : 0) + ($date_start || $date_end ? 1 : 0) + ($amount_min || $amount_max ? 1 : 0);
                    @endphp
                    @if($filterCount > 0)
                        <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">
                            {{ $filterCount }}
                        </span>
                    @endif
                </button>
            </div>
        </div>

        {{-- Expanded Filter Panel --}}
        <div x-show="showFilters" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="pt-6 border-t border-slate-100">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Date Range --}}
                <div class="space-y-3" wire:ignore>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Rentang Tanggal</label>
                    <div class="relative">
                        <input type="text" x-ref="dateInput" placeholder="Pilih rentang tanggal..." readonly class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium cursor-pointer text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all">
                    </div>
                </div>

                {{-- Status --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <select wire:model.live="category" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all cursor-pointer">
                        <option value="All">Semua</option>
                        <option value="Active">Aktif (Diproses/Menunggu Review)</option>
                        <option value="Pending Review">Menunggu Tinjauan</option>
                        <option value="Negotiating">Negosiasi</option>
                        <option value="Awaiting Payment">Menunggu Bayar</option>
                        <option value="Paid">Menunggu Review</option>
                        <option value="In Process">Sedang Diproses</option>
                        <option value="Completed">Selesai</option>
                        <option value="Cancelled">Dibatalkan</option>
                    </select>
                </div>

                {{-- Staff Assignment --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Staff</label>
                    <select wire:model.live="staff_id" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all cursor-pointer">
                        <option value="">Semua</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Amount Range --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Amount</label>
                    <div class="space-y-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-xs">Rp</span>
                            <input type="number" wire:model.live.debounce.500ms="amount_min" placeholder="Min" class="w-full pl-8 pr-2 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6]">
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-xs">Rp</span>
                            <input type="number" wire:model.live.debounce.500ms="amount_max" placeholder="Max" class="w-full pl-8 pr-2 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6]">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="resetFilters" @click="if($refs.dateInput && $refs.dateInput._flatpickr) $refs.dateInput._flatpickr.clear(); showFilters = false" type="button" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Reset</button>
                <button @click="showFilters = false" class="px-6 py-2 bg-[#000B44] text-white rounded-xl text-sm font-bold hover:bg-[#001166] transition-colors shadow-sm">Tutup Filter</button>
            </div>
        </div>

        {{-- Active Filter Tags --}}
        @if($search || $category != 'All' || $staff_id || $date_start || $date_end || $amount_min || $amount_max)
        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-slate-100">
            @if($search)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-lg">
                <span class="text-xs font-bold text-blue-700">Cari: "{{ $search }}"</span>
                <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($category != 'All')
            <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg">
                <span class="text-xs font-bold text-indigo-700">Status: {{ $category }}</span>
                <button wire:click="$set('category', 'All')" class="text-indigo-400 hover:text-indigo-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($staff_id)
            @php $selectedStaff = $staffs->firstWhere('id', $staff_id); @endphp
            <div class="flex items-center gap-2 px-3 py-1.5 bg-purple-50 border border-purple-100 rounded-lg">
                <span class="text-xs font-bold text-purple-700">Staff: {{ $selectedStaff ? $selectedStaff->name : $staff_id }}</span>
                <button wire:click="$set('staff_id', '')" class="text-purple-400 hover:text-purple-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($date_start || $date_end)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 border border-amber-100 rounded-lg">
                <span class="text-xs font-bold text-amber-700">Date: {{ $date_start }} {{ $date_end ? '- '.$date_end : '' }}</span>
                <button @click="if($refs.dateInput && $refs.dateInput._flatpickr) $refs.dateInput._flatpickr.clear(); $wire.set('date_start', ''); $wire.set('date_end', '')" class="text-amber-400 hover:text-amber-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($amount_min || $amount_max)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-rose-50 border border-rose-100 rounded-lg">
                <span class="text-xs font-bold text-rose-700">Rp: {{ $amount_min ?: '0' }} - {{ $amount_max ?: 'Max' }}</span>
                <button wire:click="$set('amount_min', ''); $set('amount_max', '')" class="text-rose-400 hover:text-rose-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            <button wire:click="resetFilters" @click="if($refs.dateInput && $refs.dateInput._flatpickr) $refs.dateInput._flatpickr.clear()" class="text-xs text-slate-400 font-bold hover:text-slate-600 ml-2">Clear All</button>
        </div>
        @endif
    </div>


    {{-- Bulk Action Bar --}}
    @if(count($selected) > 0)
    <div class="flex items-center justify-between bg-[#000B44] text-white p-4 rounded-xl shadow-lg animate-in fade-in slide-in-from-bottom-4 duration-300">
        <div class="flex items-center gap-4 pl-4">
            <span class="text-sm font-bold">{{ count($selected) }} selected</span>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="sendReminder" class="px-6 py-2 border border-white/20 rounded-lg text-sm font-bold hover:bg-white/10 transition-all">Send Reminder</button>
            <button class="px-6 py-2 border border-white/20 rounded-lg text-sm font-bold hover:bg-white/10 transition-all">Export Selected</button>
            <button wire:click="$set('selected', [])" class="p-2 text-white/50 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Table Section --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4">
                            <input type="checkbox" wire:click="selectAll(@json($orders->pluck('id_raw')))" 
                                {{ count($selected) === count($orders) && count($orders) > 0 ? 'checked' : '' }}
                                class="w-4 h-4 text-[#0077B6] border-slate-300 rounded focus:ring-[#0077B6] cursor-pointer">
                        </th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Order ID <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Booking Date <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Created <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Staff</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($orders as $o)
                    <tr class="hover:bg-slate-50/80 transition-all {{ in_array($o['id_raw'], $selected) ? 'bg-slate-50' : '' }}">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model.live="selected" value="{{ $o['id_raw'] }}" class="w-4 h-4 text-[#0077B6] border-slate-300 rounded focus:ring-[#0077B6] cursor-pointer">
                        </td>

                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-slate-900 underline decoration-slate-300 underline-offset-4">{{ $o['id'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                    {{ substr($o['client'], 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-slate-900">{{ $o['client'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $o['service'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $o['booking'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $o['time'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                @if($o['color'] == 'amber') bg-amber-50 text-amber-600 border border-amber-200
                                @elseif($o['color'] == 'orange') bg-orange-50 text-orange-600 border border-orange-200
                                @elseif($o['color'] == 'teal') bg-teal-50 text-teal-600 border border-teal-200
                                @elseif($o['color'] == 'blue') bg-blue-50 text-blue-600 border border-blue-200
                                @elseif($o['color'] == 'green') bg-green-50 text-green-600 border border-green-200
                                @elseif($o['color'] == 'red') bg-red-50 text-red-600 border border-red-200
                                @else bg-slate-100 text-slate-500 border border-slate-200 @endif">
                                {{ $o['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-slate-900">{{ $o['price'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-sm text-slate-400">{{ $o['staff'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('umkm.orders.show', $o['id_raw']) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 hover:bg-[#000B44] text-slate-500 hover:text-white rounded-lg transition-all shadow-sm group"
                               title="Lihat Detail Pesanan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-400 text-sm font-medium">No orders found matching your criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pt-4 pb-8">
        {{ $orders_pagination->links('components.custom-pagination') }}
    </div>
</div>