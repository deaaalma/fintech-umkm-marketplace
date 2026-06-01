<x-slot:title>Manajemen Staff</x-slot>

<div class="space-y-6 animate-fade-in-up">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Staff</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Kelola data staff dan admin internal</p>
        </div>
        <a href="{{ route('umkm.staff.create') }}" class="bg-[#2D2D2D] hover:bg-black text-white px-6 py-2.5 rounded-full font-bold flex items-center gap-2 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Staff Baru
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau nomor telepon..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
        </div>
        <div class="flex gap-2">
            <select class="px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-black/5 transition-all min-w-[140px]">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <button wire:click="$set('search', '')" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-bold transition-all">Reset</button>
        </div>
    </div>

    {{-- Staff Table --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Foto/Profil</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Posisi</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Nomor Telepon</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Role</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal Bergabung</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- Owner (Admin UMKM) --}}
                    @if(!$search)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#0077B6]/10 flex items-center justify-center text-[#0077B6] font-bold text-xs uppercase">{{ substr($owner->name, 0, 2) }}</div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-gray-900">{{ $owner->name }}</h4>
                                        <span class="bg-black text-white text-[9px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider">You</span>
                                    </div>
                                    <p class="text-[11px] text-gray-500">{{ $owner->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-700">Owner / Manager</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-500">{{ $owner->phone }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-2.5 py-1 bg-[#2D2D2D] text-white text-[9px] font-black rounded uppercase tracking-wider">Admin</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-[#2D2D2D]">
                                    <span class="inline-block h-3 w-3 transform rounded-full bg-white translate-x-5 transition-transform"></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-500">{{ $owner->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <button class="p-1.5 hover:text-gray-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @forelse($workers as $worker)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                @if($worker->user->profile_photo_path)
                                    <img src="{{ Storage::url($worker->user->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs uppercase">{{ substr($worker->user->name, 0, 2) }}</div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $worker->user->name }}</h4>
                                    <p class="text-[11px] text-gray-500">{{ $worker->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-700">{{ $worker->specialization ?? 'General Staff' }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-500">{{ $worker->user->phone }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[9px] font-black rounded uppercase tracking-wider">Staff</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                <button wire:click="toggleStatus({{ $worker->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $worker->is_active ? 'bg-[#2D2D2D]' : 'bg-gray-200' }}">
                                    <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $worker->is_active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-gray-500">{{ $worker->joined_at ? date('d M Y', strtotime($worker->joined_at)) : $worker->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('umkm.staff.edit', $worker->id) }}" class="p-1.5 hover:text-gray-900 transition-colors">
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
