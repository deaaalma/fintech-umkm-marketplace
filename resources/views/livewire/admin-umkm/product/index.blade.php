<x-slot:title>Manajemen Produk / Layanan</x-slot>

<div class="space-y-6">


    {{-- Title and Action --}}
    <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk / Layanan</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Kelola semua layanan yang tampil ke pelanggan</p>
        </div>
        <a href="{{ route('umkm.services.create') }}" class="bg-[#2D2D2D] hover:bg-black text-white px-6 py-2.5 rounded-full font-bold flex items-center gap-2 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Layanan Baru
        </a>
    </div>

    {{-- Search and Info Bar --}}
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" wire:model.live="search" 
                placeholder="Cari nama layanan..." 
                class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-gray-300 focus:border-gray-300 sm:text-sm transition-all font-medium">
        </div>
        <div class="text-sm font-medium text-gray-500 w-full md:w-auto text-right">
            Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} layanan
        </div>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col">
            {{-- Image Placeholder --}}
            <div class="h-48 bg-[#A2B1C6]/50 flex items-center justify-center relative group">
                @if($product->thumbnail_url)
                    <img src="{{ Storage::url($product->thumbnail_url) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
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
                    <button wire:click="toggleStatus({{ $product->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $product->is_active ? 'bg-[#2D2D2D]' : 'bg-gray-200' }}">
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
