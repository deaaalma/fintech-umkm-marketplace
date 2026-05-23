<div>
    <x-slot name="title">Manajemen Pengguna</x-slot>

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
        <div>
            <h2 class="text-3xl font-black font-plus text-[#000B44] tracking-tight">Manajemen Pengguna</h2>
            <p class="text-slate-500 font-medium mt-1">Kelola seluruh pengguna platform dari satu tempat.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm shadow-slate-200/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tambah Pengguna
            </button>
        </div>
    </div>

    {{-- ── Metric Cards ── --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-10">
        {{-- Total Users --}}
        <div class="bg-white p-8 rounded-[32px] border border-slate-200 animate-fade-in-up shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-500" style="animation-delay: 0.1s">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Total Pengguna</p>
            <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter">{{ number_format($stats['total']) }}</h3>
            <p class="text-[11px] text-slate-500 mt-2 font-medium flex items-center gap-1">
                <span class="text-teal-500 inline-flex items-center">↑ 12%</span> dibanding bulan lalu
            </p>
        </div>

        {{-- Customers --}}
        <div class="bg-white p-8 rounded-[32px] border border-slate-200 animate-fade-in-up shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-500" style="animation-delay: 0.15s">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Customer</p>
            <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter">{{ number_format($stats['customer']) }}</h3>
            <div class="w-full h-1.5 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['customer']/$stats['total'])*100 : 0 }}%"></div>
            </div>
        </div>

        {{-- UMKM Admin --}}
        <div class="bg-white p-8 rounded-[32px] border border-slate-200 animate-fade-in-up shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-500" style="animation-delay: 0.2s">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">UMKM Admin</p>
            <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter">{{ number_format($stats['admin_umkm']) }}</h3>
            <div class="w-full h-1.5 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['admin_umkm']/$stats['total'])*100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Staff --}}
        <div class="bg-white p-8 rounded-[32px] border border-slate-200 animate-fade-in-up shadow-sm hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-500" style="animation-delay: 0.25s">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Staff / Worker</p>
            <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter">{{ number_format($stats['worker']) }}</h3>
            <div class="w-full h-1.5 bg-slate-100 rounded-full mt-4 overflow-hidden">
                <div class="h-full bg-teal-500 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['worker']/$stats['total'])*100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- ── Compact Search & Filter Launcher ── --}}
    <div class="mt-10 flex flex-wrap items-center gap-4 animate-fade-in-up relative z-40" style="animation-delay: 0.3s">
        {{-- Search input --}}
        <div class="flex-1 min-w-[300px] relative group">
            <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau phone..." 
                class="w-full pl-14 pr-6 py-4 bg-white border border-slate-200 rounded-[24px] text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-[#0077B6] shadow-sm transition-all placeholder:text-slate-400">
        </div>

        {{-- Filter Launcher --}}
        <div class="relative" x-data="{ showFilters: false }">
            <button @click="showFilters = !showFilters" 
                class="px-8 py-4 bg-white border border-slate-200 rounded-[24px] text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center gap-3 active:scale-95">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filters
                @if($roleFilter || $statusFilter)
                    <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">
                        {{ ($roleFilter ? 1 : 0) + ($statusFilter ? 1 : 0) }}
                    </span>
                @endif
            </button>

            {{-- ── ACTUAL PREMIUM FILTER PANEL ── --}}
            <div x-show="showFilters" x-cloak wire:ignore.self
                @click.away="showFilters = false; $wire.resetFilters()"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="absolute right-0 mt-4 w-[600px] bg-white rounded-[32px] border border-slate-200 shadow-2xl z-[90] overflow-hidden"
                style="height: 400px;">
                
                <div class="flex h-full" x-data="{ activeTab: 'role' }">
                    {{-- Left Sidebar --}}
                    <div class="w-48 bg-slate-50/80 border-r border-slate-100 p-6 flex flex-col gap-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Categories</p>
                        <button @click="activeTab = 'role'" 
                            :class="activeTab === 'role' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-500 hover:bg-slate-100'"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Role
                        </button>
                        <button @click="activeTab = 'status'" 
                            :class="activeTab === 'status' ? 'bg-[#000B44] text-white shadow-lg' : 'text-slate-500 hover:bg-slate-100'"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Status
                        </button>

                        {{-- Placeholder element to push content if needed --}}
                        <div class="mt-auto"></div>
                    </div>

                    {{-- Main Options Content --}}
                    <div class="flex-1 flex flex-col h-full bg-white relative p-8">
                        <div x-show="activeTab === 'role'" class="space-y-6">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Show Only Role</p>
                            <div class="space-y-4">
                                @foreach(['customer' => 'Customer', 'admin_umkm' => 'UMKM Admin', 'worker' => 'Staff / Worker', 'superadmin' => 'Superadmin'] as $key => $val)
                                <label class="flex items-center gap-4 cursor-pointer group">
                                    <div class="relative w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center group-hover:border-blue-500 transition-all shadow-inner">
                                        <input type="radio" wire:model.live="roleFilter" value="{{ $key }}" class="hidden peer">
                                        <div class="w-3 h-3 rounded-full bg-blue-500 scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                    </div>
                                    <span class="text-base font-bold text-slate-600 group-hover:text-[#000B44] transition-colors">{{ $val }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div x-show="activeTab === 'status'" class="space-y-6">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Select Status</p>
                            <div class="space-y-4">
                                @foreach(['ACTIVE' => 'Aktif', 'SUSPENDED' => 'Dibatasi (Suspend)', 'INACTIVE' => 'Tidak Aktif'] as $key => $val)
                                <label class="flex items-center gap-4 cursor-pointer group">
                                    <div class="relative w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center group-hover:border-blue-500 transition-all shadow-inner">
                                        <input type="radio" wire:model.live="statusFilter" value="{{ $key }}" class="hidden peer">
                                        <div class="w-3 h-3 rounded-full bg-blue-500 scale-0 peer-checked:scale-100 transition-transform duration-200"></div>
                                    </div>
                                    <span class="text-base font-bold text-slate-600 group-hover:text-[#000B44] transition-colors">{{ $val }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="absolute bottom-8 right-8 flex gap-3">
                            <button wire:click="resetFilters" @click="showFilters = false" class="px-6 py-3 bg-slate-50 text-slate-500 font-bold text-sm rounded-xl hover:bg-slate-100 transition-colors">CANCEL</button>
                            <button @click="showFilters = false" class="px-8 py-3 bg-[#0077B6] text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 hover:scale-[1.02] transition-all uppercase">APPLY</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Active Chips Summary ── --}}
    @if($roleFilter || $statusFilter || $search)
    <div class="mt-8 flex flex-wrap items-center gap-3 animate-fade-in-up" style="animation-delay: 0.35s">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Active Filters:</p>
        
        @if($search)
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-blue-50/50 border border-blue-100 rounded-full">
            <span class="text-xs font-bold text-blue-600">Search: "{{ $search }}"</span>
            <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        @if($roleFilter)
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-indigo-50/50 border border-indigo-100 rounded-full">
            <span class="text-xs font-bold text-indigo-600">Role: {{ str_replace('_', ' ', $roleFilter) }}</span>
            <button wire:click="$set('roleFilter', '')" class="text-indigo-400 hover:text-indigo-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        @if($statusFilter)
        <div class="flex items-center gap-2 pl-4 pr-3 py-2 bg-teal-50/50 border border-teal-100 rounded-full">
            <span class="text-xs font-bold text-teal-600">Status: {{ strtolower($statusFilter) }}</span>
            <button wire:click="$set('statusFilter', '')" class="text-teal-400 hover:text-teal-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        <button wire:click="resetFilters" class="text-[10px] font-black text-red-500 hover:bg-red-50 px-4 py-2 rounded-full transition-colors ml-2 uppercase">Clear ALL</button>
    </div>
    @endif

    {{-- ── User Table ── --}}
    <div class="mt-4 bg-white rounded-[32px] border border-slate-200 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.4s">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[#000B44]">
                        <th class="px-8 py-6 text-xs font-black text-slate-400">User Profile</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400 text-center">Role</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400 text-center">Status</th>
                        <th class="px-6 py-6 text-xs font-black text-slate-400">Tanggal Daftar</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 group-hover:scale-105 transition-transform duration-300">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=000B44&color=fff" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-bold text-[#000B44] text-base">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">{{ $user->email }} • {{ $user->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php $rColor = match($user->role) {
                                'customer' => 'bg-blue-50 text-blue-600',
                                'admin_umkm' => 'bg-indigo-50 text-indigo-600',
                                'worker' => 'bg-teal-50 text-teal-600',
                                'superadmin' => 'bg-slate-800 text-white',
                                default => 'bg-slate-50 text-slate-600',
                            }; @endphp
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $rColor }} border border-current/10 inline-block min-w-[100px]">
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php $sCfg = match($user->status) {
                                'ACTIVE' => ['color' => 'text-teal-600 bg-teal-50', 'label' => 'AKTIF'],
                                'SUSPENDED' => ['color' => 'text-rose-500 bg-rose-50', 'label' => 'SUSPENDED'],
                                default => ['color' => 'text-slate-500 bg-slate-50', 'label' => 'INACTIVE'],
                            }; @endphp
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $sCfg['color'] }} border border-current/10 text-center inline-block min-w-[100px]">
                                {{ $sCfg['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-bold text-slate-700">{{ $user->created_at->format('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $user->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all shadow-sm" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button wire:click="toggleStatus({{ $user->id }})" @class([
                                    'w-10 h-10 flex items-center justify-center rounded-xl transition-all shadow-sm',
                                    'bg-red-50 text-red-500 hover:bg-red-100' => $user->status === 'ACTIVE',
                                    'bg-teal-50 text-teal-600 hover:bg-teal-100' => $user->status !== 'ACTIVE',
                                ]) title="{{ $user->status === 'ACTIVE' ? 'Suspend' : 'Activate' }}">
                                    @if($user->status === 'ACTIVE')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <h4 class="text-sm font-black text-slate-300 uppercase tracking-widest italic">Tidak ada pengguna ditemukan.</h4>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30 font-plus">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
