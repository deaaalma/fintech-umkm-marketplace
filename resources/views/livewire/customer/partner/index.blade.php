<x-slot:title>UMKM Partner</x-slot:title>

<div class="max-w-[1200px] mx-auto animate-fade-in-up pb-20">
    {{-- Header Section --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-900 font-plus tracking-tight mb-2">UMKM Partner</h1>
        <p class="text-gray-500 font-medium">Temukan mitra UMKM terbaik untuk kebutuhan Anda</p>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="space-y-6 mb-12">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-gray-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari UMKM atau layanan..." 
                       class="w-full pl-14 pr-6 py-5 bg-white border border-gray-100 rounded-[28px] text-sm font-bold shadow-sm focus:ring-0 focus:border-gray-900 transition-all outline-none">
            </div>
            <button class="px-10 py-5 bg-[#2D2D2D] hover:bg-black text-white rounded-[24px] font-black text-sm uppercase tracking-widest transition-all shadow-xl flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
        </div>

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-2 overflow-x-auto pb-2 hide-scrollbar">
            @foreach($categories as $cat)
            <button wire:click="$set('activeCategory', '{{ $cat['id'] }}')" 
                    class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ $activeCategory === $cat['id'] ? 'bg-[#2D2D2D] text-white shadow-lg' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>
    </div>

    <div class="mb-8 flex items-center justify-between">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Menampilkan <span class="text-gray-900">{{ count($partners) }} UMKM</span></p>
    </div>

    {{-- Partners Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($partners as $partner)
        <div class="bg-white border border-gray-100 rounded-[40px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group">
            {{-- Image Header --}}
            <div class="relative h-64 bg-gray-900 overflow-hidden">
                <img src="{{ $partner['img'] }}" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $partner['category'] }}</span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 font-plus mb-1">{{ $partner['name'] }}</h3>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs font-bold text-gray-400">{{ $partner['location'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-yellow-50 px-3 py-1.5 rounded-xl border border-yellow-100">
                        <svg class="w-3.5 h-3.5 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="text-[11px] font-black text-yellow-700">{{ $partner['rating'] }} <span class="text-yellow-400 font-medium">({{ $partner['reviews_count'] }})</span></span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($partner['tags'] as $tag)
                    <span class="px-3 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[9px] font-bold text-gray-500 uppercase tracking-tighter">{{ $tag }}</span>
                    @endforeach
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Range Harga</p>
                    <p class="text-sm font-black text-gray-900">{{ $partner['price_range'] }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('customer.order-details', $partner['id']) }}" class="flex-1 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all text-center shadow-lg">
                        Lihat Detail
                    </a>
                    <button class="w-14 h-14 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-900 hover:border-gray-900 transition-all shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <h3 class="text-lg font-bold text-gray-400">Tidak ada UMKM ditemukan.</h3>
        </div>
        @endforelse
    </div>
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>