<x-slot:title>Manajemen Layanan</x-slot>

<div class="space-y-6 animate-fade-in-up">

    {{-- Title and Action --}}
    <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-4 mb-2">
        <div>
            <h1 class="text-2xl font-black text-[#000B44] font-plus tracking-tight">Manajemen Layanan</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Kelola semua layanan yang tampil ke pelanggan</p>
        </div>
        <a href="{{ route('umkm.services.create') }}" class="bg-[#000B44] hover:bg-[#0077B6] text-white px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center gap-2 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Layanan Baru
        </a>
    </div>

    {{-- Search and Info Bar --}}
    <div class="flex flex-col gap-4 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama layanan..." 
                       aria-label="Cari nama layanan"
                       class="w-full pl-14 {{ $search ? 'pr-12' : 'pr-6' }} py-4 bg-white border border-slate-200 rounded-[24px] text-sm font-bold shadow-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-[#0077B6]/30 focus:border-[#0077B6] focus:-translate-y-0.5 focus:shadow-lg transition-all outline-none">
                @if($search)
                <button wire:click="$set('search', '')" 
                        aria-label="Hapus pencarian"
                        class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                @endif
            </div>
            <button aria-label="Lakukan pencarian"
                    class="px-8 py-4 bg-[#000B44] hover:bg-[#001166] text-white rounded-[20px] font-black text-sm uppercase tracking-widest transition-all shadow-xl flex items-center justify-center gap-2 focus:ring-2 focus:ring-[#0077B6] focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
        </div>
        
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                Menampilkan <span class="text-[#000B44] font-black">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> dari <span class="text-[#000B44] font-black">{{ $products->total() }}</span> layanan
            </p>
        </div>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col">
            {{-- Image Placeholder --}}
            <div class="h-48 bg-[#A2B1C6]/50 flex items-center justify-center relative group">
                @if($product->thumbnail_url)
                    @php
                        $imgUrl = Str::startsWith($product->thumbnail_url, 'http') 
                                    ? $product->thumbnail_url 
                                    : Storage::url($product->thumbnail_url);
                    @endphp
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                @else
                    <span class="text-white font-bold tracking-widest uppercase text-sm">IMAGE</span>
                @endif
            </div>

            {{-- Content --}}
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-base font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                
                <div class="mb-4">
                    <span class="inline-block px-2.5 py-1 border border-gray-200 text-gray-500 rounded-lg text-[11px] font-bold uppercase tracking-wider">
                        {{ $product->type }}
                    </span>
                </div>

                <div class="mb-5 flex-1">
                    <p class="text-sm font-bold text-gray-900">
                        Mulai dari Rp {{ number_format($product->estimated_price, 0, ',', '.') }}<span class="text-xs text-gray-500 font-medium">@if(str_contains(strtolower($product->type), 'cleaning'))/m²@endif</span>
                    </p>
                </div>

                {{-- Status Toggle --}}
                <div class="flex items-center gap-3 mb-5">
                    <span class="text-sm font-bold text-gray-500">Status:</span>
                    <button wire:click="toggleStatus({{ $product->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $product->is_active ? 'bg-[#000B44]' : 'bg-gray-200' }}">
                        <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform {{ $product->is_active ? 'translate-x-4.5' : 'translate-x-1' }}" style="{{ $product->is_active ? 'transform: translateX(1.1rem);' : '' }}"></span>
                    </button>
                    <span class="text-sm font-bold {{ $product->is_active ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <hr class="border-gray-100 mb-4">

                {{-- Actions --}}
                <div class="flex gap-3 mt-auto">
                    <a href="{{ route('umkm.services.edit', $product->id) }}" class="flex-1 flex items-center justify-center gap-2 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <button wire:click="delete({{ $product->id }})" wire:confirm="Apakah Anda yakin ingin menghapus layanan ini?" class="flex-1 flex items-center justify-center gap-2 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada layanan</h3>
            <p class="text-sm text-gray-500 font-medium">Klik tombol "Tambah Layanan Baru" untuk mulai.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="pt-4 pb-8">
        {{ $products->links('components.custom-pagination') }}
    </div>
    @endif
</div>
