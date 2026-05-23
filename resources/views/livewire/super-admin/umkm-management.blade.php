<div>
    <x-slot name="title">Manajemen UMKM</x-slot>

    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
        .custom-checkbox { @apply w-5 h-5 rounded-lg border-2 border-slate-200 text-[#0077B6] focus:ring-[#0077B6] transition-all cursor-pointer; }
        .glass-dark { background: rgba(0, 11, 68, 0.95); backdrop-filter: blur(10px); }
    </style>

    <div class="pb-20">
        
        {{-- ── Dynamic Page Header ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
            <div>
                <h2 class="text-3xl font-black font-plus text-[#000B44] tracking-tight">
                    {{ $activeTab === 'directory' ? 'List UMKM' : 'Pending UMKM' }}
                </h2>
                <p class="text-slate-500 font-medium mt-1">
                    {{ $activeTab === 'directory' ? 'Kelola semua toko mitra yang sudah terdaftar di sistem.' : 'Tinjau permintaan pendaftaran mitra baru yang masuk.' }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export
                </button>
            </div>
        </div>

        {{-- ── TAB NAVIGATION ── --}}
        <div class="mt-8 flex items-center p-1 bg-slate-100/80 rounded-[24px] w-fit border border-slate-200 animate-fade-in-up">
            <button wire:click="$set('activeTab', 'directory')" 
                @class([
                    'px-8 py-3.5 rounded-[20px] text-sm font-bold transition-all flex items-center gap-3',
                    'bg-white text-[#000B44] shadow-sm shadow-slate-200' => $activeTab === 'directory',
                    'text-slate-500 hover:text-slate-700' => $activeTab !== 'directory'
                ])>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                List UMKM
            </button>
            <button wire:click="$set('activeTab', 'queue')" 
                @class([
                    'px-8 py-3.5 rounded-[20px] text-sm font-bold transition-all flex items-center gap-3 relative',
                    'bg-white text-[#000B44] shadow-sm shadow-slate-200' => $activeTab === 'queue',
                    'text-slate-500 hover:text-slate-700' => $activeTab !== 'queue'
                ])>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Pending UMKM
                @if($stats['pending'] > 0)
                <span class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white animate-pulse">
                    {{ $stats['pending'] }}
                </span>
                @endif
            </button>
        </div>

        {{-- ── Compact Search & Filter Launcher ── --}}
        <div class="mt-10 flex flex-wrap items-center gap-4 animate-fade-in-up relative z-40" style="animation-delay: 0.3s">
            {{-- Search input --}}
            <div class="flex-1 min-w-[300px] relative group overflow-hidden">
                <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari UMKM, Pemilik, atau Kota..." 
                    class="w-full pl-14 pr-6 py-4 bg-white border border-slate-200 rounded-[24px] text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-[#0077B6] shadow-sm transition-all placeholder:text-slate-400">
            </div>

            {{-- Filter Launcher --}}
            <div class="relative" x-data="{ showFilters: false }">
                <button @click="showFilters = !showFilters" 
                    class="px-8 py-4 bg-white border border-slate-200 rounded-[24px] text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center gap-3 active:scale-95">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filters
                    @if($statusFilter || $categoryFilter)
                        <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">
                            {{ ($statusFilter ? 1 : 0) + ($categoryFilter ? 1 : 0) }}
                        </span>
                    @endif
                </button>

                {{-- ── ACTUAL PREMIUM FILTER PANEL ── --}}
                <div x-show="showFilters" x-cloak wire:ignore.self
                    @click.away="showFilters = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    class="absolute right-0 mt-4 w-[550px] bg-white rounded-[32px] border border-slate-200 shadow-2xl z-[90] overflow-hidden"
                    x-data="{ activeFilterTab: 'status' }">
                    
                    <div class="flex" style="min-height: 380px;">
                        {{-- Left Sidebar --}}
                        <div class="w-44 bg-slate-50/80 border-r border-slate-100 p-6 flex flex-col gap-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Kategori</p>
                            <button @click="activeFilterTab = 'status'" 
                                :class="activeFilterTab === 'status' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-100'"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Status
                            </button>
                            <button @click="activeFilterTab = 'category'" 
                                :class="activeFilterTab === 'category' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-100'"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Bidang
                            </button>
                        </div>

                        {{-- Main Options Content --}}
                        <div class="flex-1 flex flex-col bg-white p-8">
                            {{-- Tab Status --}}
                            <div x-show="activeFilterTab === 'status'" class="space-y-6">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Status UMKM</p>
                                <div class="space-y-3">
                                    @foreach(['' => 'Semua Status', 'active' => 'Aktif / Terverifikasi', 'suspended' => 'Dibatasi (Suspended)', 'rejected' => 'Ditolak'] as $key => $val)
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

                            {{-- Tab Bidang --}}
                            <div x-show="activeFilterTab === 'category'" class="space-y-6">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Bidang Usaha</p>
                                <div class="space-y-3 overflow-y-auto max-h-[200px] pr-2 no-scrollbar">
                                    @foreach($categories as $cat)
                                    <label class="flex items-center gap-4 cursor-pointer group">
                                        <div class="relative w-5 h-5 rounded-full border-2 border-slate-200 flex items-center justify-center group-hover:border-blue-500 transition-all">
                                            <input type="radio" wire:model.live="categoryFilter" value="{{ $cat->id }}" class="hidden peer">
                                            <div class="w-2.5 h-2.5 rounded-full bg-[#000B44] scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                        </div>
                                        <span class="text-sm font-bold text-slate-600 group-hover:text-[#000B44] transition-colors">{{ $cat->name }}</span>
                                    </label>
                                    @endforeach
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
        @if($statusFilter || $categoryFilter || $search)
        <div class="mt-8 flex flex-wrap items-center gap-3 animate-fade-in-up">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Filter Aktif:</p>
            
            @if($search)
            <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-blue-50/50 border border-blue-100 rounded-full">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Cari: "{{ $search }}"</span>
                <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif

            @if($statusFilter)
            <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-indigo-50/50 border border-indigo-100 rounded-full">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Status: {{ $statusFilter }}</span>
                <button wire:click="$set('statusFilter', '')" class="text-indigo-400 hover:text-indigo-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif

            @if($categoryFilter)
            <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-teal-50/50 border border-teal-100 rounded-full">
                <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest">Bidang: {{ $categories->find($categoryFilter)->name ?? 'Selected' }}</span>
                <button wire:click="$set('categoryFilter', '')" class="text-teal-400 hover:text-teal-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif

            <button wire:click="resetFilters" class="text-[10px] font-black text-rose-500 hover:bg-rose-50 px-4 py-2 rounded-full transition-colors ml-2 uppercase tracking-widest">Hapus Semua</button>
        </div>
        @endif

        {{-- ── DYNAMIC BULK ACTIONS ── --}}
        <div x-show="$wire.selectedUmkms.length > 0" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            class="fixed bottom-10 left-1/2 -translate-x-1/2 w-full max-w-2xl bg-[#000833] text-white px-8 py-5 rounded-[28px] shadow-[0_20px_60px_rgba(0,0,0,0.5)] z-[100] flex items-center justify-between border border-white/10" x-cloak>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 pr-6 border-r border-white/10">
                    <span class="text-2xl font-black font-plus" x-text="$wire.selectedUmkms.length"></span>
                    <span class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Terpilih</span>
                </div>
                <div class="flex items-center gap-2">
                    @if($activeTab === 'directory')
                        <button wire:click="bulkSuspend" class="flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-white text-white hover:text-amber-600 border border-white/20 rounded-xl text-xs font-black uppercase tracking-wider transition-all group">
                            <svg class="w-4 h-4 text-amber-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Suspend
                        </button>
                        <button wire:click="bulkDelete" onclick="confirm('Yakin ingin hapus permanently?') || event.stopImmediatePropagation()" class="flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-red-500 text-white border border-white/20 rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    @else
                        <button wire:click="bulkApprove" class="flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-white text-white hover:text-teal-600 border border-white/20 rounded-xl text-xs font-black uppercase tracking-wider transition-all group">
                            <svg class="w-4 h-4 text-teal-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Verify All
                        </button>
                        <button wire:click="bulkReject" class="flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-red-500 text-white border border-white/20 rounded-xl text-xs font-black uppercase tracking-wider transition-all group">
                            <svg class="w-4 h-4 text-red-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Reject
                        </button>
                    @endif
                </div>
            </div>
            <button @click="$wire.set('selectedUmkms', [])" class="p-2 hover:bg-white/10 rounded-full transition-all">
                <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/></svg>
            </button>
        </div>

        {{-- ── Data Table ── --}}
        <div class="mt-4 bg-white rounded-[32px] border border-slate-200 overflow-hidden shadow-sm animate-fade-in-up">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[#000B44]">
                            <th class="px-8 py-6 w-12 text-center">
                                <input type="checkbox" 
                                    @click="if ($el.checked) { $wire.set('selectedUmkms', @js($umkms->pluck('id')->toArray())) } else { $wire.set('selectedUmkms', []) }"
                                    :checked="$wire.selectedUmkms.length === @js($umkms->count()) && $wire.selectedUmkms.length > 0"
                                    class="custom-checkbox">
                            </th>
                            <th class="px-6 py-6 text-xs font-black text-slate-400">Informasi UMKM</th>
                            <th class="px-6 py-6 text-xs font-black text-slate-400">Pemilik & Lokasi</th>
                            <th class="px-6 py-6 text-xs font-black text-slate-400 text-center">Status</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($umkms as $umkm)
                        <tr 
                            {{-- INTERACTIVE ROW LOGIC --}}
                            @if($activeTab === 'directory')
                                onclick="if(!event.target.closest('input') && !event.target.closest('button')) { window.Livewire.navigate('{{ route('admin.dashboard.umkm.detail', $umkm->slug) }}') }"
                                class="hover:bg-slate-50/80 transition-all cursor-pointer group"
                            @else
                                class="hover:bg-slate-50/80 transition-all group"
                            @endif
                            :class="$wire.selectedUmkms.includes({{ $umkm->id }}) ? 'bg-blue-50/40' : ''">
                            
                            <td class="px-8 py-6 text-center">
                                <input type="checkbox" value="{{ $umkm->id }}" wire:model.live="selectedUmkms" class="custom-checkbox">
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-plus font-black text-slate-400 text-base shadow-inner">
                                        {{ substr($umkm->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-[#000B44] text-base group-hover:text-[#0077B6] transition-colors whitespace-nowrap">{{ $umkm->name }}</p>
                                            @if($umkm->status === 'active')
                                            <div class="flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100">
                                                <svg class="w-3 h-3 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 8.768c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.951-.69l1.286-3.957z"/></svg>
                                                <span class="text-[10px] font-black text-amber-600">4.{{ rand(1,9) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium mt-1 uppercase tracking-wider">{{ $umkm->category->name ?? 'Usaha' }} • {{ $umkm->city ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6"><p class="text-sm font-bold text-slate-700">{{ $umkm->owner->name ?? 'Guest' }}</p><p class="text-xs text-slate-400 mt-0.5 leading-tight">{{ $umkm->owner->phone ?? '-' }}</p></td>
                            <td class="px-6 py-6 text-center">
                                @php $cfg = match($umkm->status) {
                                    'active' => 'text-teal-600 bg-teal-50', 
                                    'pending_verification' => 'text-blue-600 bg-blue-50',
                                    'suspended' => 'text-red-400 bg-red-50', 
                                    'rejected' => 'text-slate-400 bg-slate-50',
                                    default => 'text-slate-500 bg-slate-50'
                                }; @endphp
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $cfg }} border border-current/10 text-center inline-block min-w-[120px] shadow-sm">
                                    {{ str_replace(['active', 'pending_verification'], ['TERVERIFIKASI', 'PENDING'], strtoupper($umkm->status)) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($activeTab === 'queue')
                                        <button wire:click="showDetail({{ $umkm->id }})" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-xl transition-all shadow-sm" title="Review Pendaftaran">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                        </button>
                                    @else
                                        <div class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 group-hover:text-indigo-500 group-hover:bg-indigo-50 rounded-xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-20 text-center"><h4 class="text-sm font-black text-slate-300">{{ $activeTab === 'directory' ? 'Belum ada UMKM terverifikasi.' : 'Antrean verifikasi kosong.' }}</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($umkms->hasPages())<div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">{{ $umkms->links() }}</div>@endif
        </div>
    </div>

    {{-- Modal Review Pendaftaran --}}
    @if($viewingUmkm && $viewingUmkm->status === 'pending_verification')
    <div class="fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#000833]/80 backdrop-blur-sm shadow-2xl" wire:click="closeDetail"></div>
        <div class="relative bg-white w-full max-w-4xl rounded-[40px] shadow-2xl overflow-hidden animate-fade-in-up flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-xl font-black text-blue-600 border border-slate-100">{{ substr($viewingUmkm->name, 0, 1) }}</div>
                    <div><h3 class="text-2xl font-black font-plus text-[#000B44] tracking-tight">Review Pendaftaran</h3><p class="text-sm font-medium text-slate-500 uppercase tracking-widest mt-0.5">{{ $viewingUmkm->application_code ?? 'REG-'.str_pad($viewingUmkm->id, 5, '0', STR_PAD_LEFT) }}</p></div>
                </div>
                <button wire:click="closeDetail" class="p-3 bg-white hover:bg-slate-100 rounded-full transition-all border border-slate-100 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto no-scrollbar px-10 py-10 space-y-12">
                <div class="grid grid-cols-2 gap-x-12 gap-y-8">
                    <div class="col-span-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Profil Usaha</h4>
                        <div class="bg-slate-50 rounded-[32px] p-8 border border-slate-100">
                            <div class="grid grid-cols-2 gap-8">
                                <div><p class="text-[10px] font-black text-slate-400 uppercase mb-2">Nama Toko/UMKM</p><p class="text-lg font-bold text-[#000B44]">{{ $viewingUmkm->name }}</p></div>
                                <div><p class="text-[10px] font-black text-slate-400 uppercase mb-2">Kategori Bidang</p><span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">{{ $viewingUmkm->category->name ?? 'N/A' }}</span></div>
                                <div class="col-span-2"><p class="text-[10px] font-black text-slate-400 uppercase mb-2">Alamat & Lokasi</p><p class="text-slate-600 font-medium leading-relaxed">{{ $viewingUmkm->address }}, {{ $viewingUmkm->city }}</p></div>
                                <div class="col-span-2"><p class="text-[10px] font-black text-slate-400 uppercase mb-2">Deskripsi Bisnis</p><p class="text-slate-600 font-medium leading-relaxed italic">"{{ $viewingUmkm->detail->description ?? ($viewingUmkm->description ?? 'Tidak ada deskripsi.') }}"</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-10 py-8 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <button wire:click="closeDetail" class="text-sm font-black text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">Tutup</button>
                <div class="flex items-center gap-4">
                    <button wire:click="reject({{ $viewingUmkm->id }})" class="px-8 py-4 bg-white text-red-500 border border-red-100 font-black rounded-2xl hover:bg-red-50 transition-all uppercase text-xs tracking-widest shadow-sm">Tolak</button>
                    <button wire:click="approve({{ $viewingUmkm->id }})" class="px-10 py-4 bg-[#0077B6] text-white font-black rounded-2xl hover:scale-105 transition-all shadow-xl shadow-blue-500/20 uppercase text-xs tracking-widest">Setujui</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Notification --}}
    <div x-data="{ show: false, message: '' }" x-on:message.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)" class="fixed bottom-10 right-10 z-[300]">
        <div x-show="show" x-transition class="bg-[#000B44] text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border border-white/10">
            <div class="w-8 h-8 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
            <p class="text-sm font-bold" x-text="message"></p>
        </div>
    </div>
</div>
