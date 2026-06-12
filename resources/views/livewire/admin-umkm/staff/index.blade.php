<x-slot:title>Manajemen Staff</x-slot>

<div class="space-y-6 animate-fade-in-up" x-data="{ showFilters: false }">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#000B44] font-plus tracking-tight">Manajemen Staff</h1>
            <p class="text-sm text-[#000066]/70 mt-1 font-circular-book">Kelola data staff dan admin internal</p>
        </div>
        <a href="{{ route('umkm.staff.create') }}" class="bg-[#000B44] hover:bg-[#000066] text-white px-6 py-2.5 rounded-full font-bold flex items-center gap-2 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Staff Baru
        </a>
    </div>

    {{-- Search and Filters --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4" @click.away="showFilters = false">
        <div class="flex flex-col md:flex-row items-center gap-3">
            <div class="relative flex-1 w-full group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau nomor telepon..." class="block w-full pl-11 pr-3 py-3 border border-slate-200 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-[#0077B6]/30 focus:border-[#0077B6] text-sm transition-all">
            </div>

            <div class="relative w-full md:w-auto">
                <button @click="showFilters = !showFilters" 
                    class="w-full md:w-auto px-6 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                    @if($role || $status)
                        <span class="w-5 h-5 flex items-center justify-center rounded-full bg-[#0077B6] text-white text-[10px] font-black">
                            {{ ($role ? 1 : 0) + ($status ? 1 : 0) }}
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Role --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Role</label>
                    <select wire:model.live="role" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                {{-- Status --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                    <select wire:model.live="status" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#0077B6] transition-all cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="resetFilters" @click="showFilters = false" type="button" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">Reset</button>
                <button @click="showFilters = false" class="px-6 py-2 bg-[#000B44] text-white rounded-xl text-sm font-bold hover:bg-[#001166] transition-colors shadow-sm">Tutup Filter</button>
            </div>
        </div>

        {{-- Active Filter Tags --}}
        @if($search || $role || $status)
        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-slate-100">
            @if($search)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-lg">
                <span class="text-xs font-bold text-blue-700">Cari: "{{ $search }}"</span>
                <button wire:click="$set('search', '')" class="text-blue-400 hover:text-blue-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($role)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg">
                <span class="text-xs font-bold text-indigo-700">Role: {{ ucfirst($role) }}</span>
                <button wire:click="$set('role', '')" class="text-indigo-400 hover:text-indigo-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if($status)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-purple-50 border border-purple-100 rounded-lg">
                <span class="text-xs font-bold text-purple-700">Status: {{ ucfirst($status) }}</span>
                <button wire:click="$set('status', '')" class="text-purple-400 hover:text-purple-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            <button wire:click="resetFilters" class="text-xs text-slate-400 font-bold hover:text-slate-600 ml-2">Clear All</button>
        </div>
        @endif
    </div>

    {{-- Staff Table --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Foto/Profil</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nomor Telepon</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    {{-- Owner (Admin UMKM) --}}
                    @if($showOwner)
                    <tr class="hover:bg-slate-50/80 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs uppercase">{{ substr($owner->name, 0, 2) }}</div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900">{{ $owner->name }}</h4>
                                        <span class="bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider">You</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">{{ $owner->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-slate-700">Owner / Manager</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $owner->phone }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-lg border border-indigo-100 uppercase tracking-wider">Admin</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-[#000B44]">
                                    <span class="inline-block h-3 w-3 transform rounded-full bg-white translate-x-5 transition-transform"></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $owner->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-slate-400">
                                <a href="{{ route('umkm.settings') }}" class="p-1.5 hover:text-slate-700 transition-colors" title="Pengaturan & Profile">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endif
                    
                    @forelse($workers as $worker)
                    <tr class="hover:bg-slate-50/80 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($worker->user->profile_photo_path)
                                    <img src="{{ Storage::url($worker->user->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs uppercase">{{ substr($worker->user->name, 0, 2) }}</div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $worker->user->name }}</h4>
                                    <p class="text-[11px] text-slate-500">{{ $worker->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-slate-700">{{ $worker->specialization ?? 'General Staff' }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $worker->user->phone }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-lg border border-slate-200 uppercase tracking-wider">Staff</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <button wire:click="toggleStatus({{ $worker->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $worker->is_active ? 'bg-[#000B44]' : 'bg-slate-200' }}">
                                    <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $worker->is_active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">{{ $worker->joined_at ? date('d M Y', strtotime($worker->joined_at)) : $worker->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-slate-400">
                                <a href="{{ route('umkm.staff.edit', $worker->id) }}" class="p-1.5 hover:text-slate-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <button wire:click="delete({{ $worker->id }})" wire:confirm="Apakah Anda yakin ingin menghapus staff ini?" class="p-1.5 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        @if($search)
                        <tr>
                            <td colspan="7" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <p class="text-gray-400 text-sm font-medium">Tidak ada staff yang cocok dengan pencarian "{{ $search }}"</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(!$search && $workers->isEmpty())
        <div class="py-24 text-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada staff</h3>
            <p class="text-sm text-gray-500 font-medium max-w-xs mx-auto mb-8">Mulai kelola tim Anda dengan menambahkan staff pertama.</p>
            <a href="{{ route('umkm.staff.create') }}" class="bg-[#2D2D2D] hover:bg-black text-white px-8 py-3 rounded-full font-bold transition-all shadow-sm">
                Tambah Staff Pertama
            </a>
        </div>
        @endif

        @if($workers->isNotEmpty())
        <div class="px-8 py-4 bg-gray-50/50 border-t border-gray-100">
            {{ $workers->links('components.custom-pagination') }}
        </div>
        @endif
    </div>
</div>
