<x-slot:title>UMKM Partner</x-slot:title>

@push('styles')
<style>
    @keyframes cardEntrant {
        0% {
            opacity: 0;
            transform: scale(0.94) translateY(20px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    .animate-card-enter {
        animation: cardEntrant 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="max-w-[1200px] mx-auto animate-fade-in-up pb-20 font-plus">
    {{-- Header Section --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-[#000B44] font-plus tracking-tight mb-2">UMKM Partner</h1>
        <p class="text-slate-500 font-medium">Temukan mitra UMKM terbaik untuk kebutuhan Anda</p>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="space-y-4 mb-12">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari UMKM atau layanan..." 
                       aria-label="Cari UMKM atau layanan"
                       class="w-full pl-14 {{ $search ? 'pr-12' : 'pr-6' }} py-5 bg-white border border-slate-200 rounded-[28px] text-sm font-bold shadow-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-[#0077B6]/30 focus:border-[#0077B6] transition-all outline-none">
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
                    class="px-10 py-5 bg-[#000B44] hover:bg-[#001166] text-white rounded-[24px] font-black text-sm uppercase tracking-widest transition-all shadow-xl flex items-center justify-center gap-2 focus:ring-2 focus:ring-[#0077B6] focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
        </div>

        {{-- Contextual hint when category is active and no search text --}}
        @if($activeCategory !== 'semua' && !$search)
        <p class="text-xs text-slate-400 pl-2 flex items-center gap-1.5" role="status">
            <svg class="w-3.5 h-3.5 text-[#0077B6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Mengetik akan mereset filter kategori dan mencari dari semua jasa.
        </p>
        @endif

        {{-- Category Pills --}}
        <div class="flex flex-wrap gap-2 overflow-x-auto pb-2 hide-scrollbar" role="tablist" aria-label="Kategori Jasa">
            @foreach($categories as $cat)
            <button wire:click="$set('activeCategory', '{{ $cat['id'] }}')" 
                    role="tab"
                    aria-selected="{{ $activeCategory === $cat['id'] ? 'true' : 'false' }}"
                    class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all focus:ring-2 focus:ring-[#0077B6] focus:outline-none {{ $activeCategory === $cat['id'] ? 'bg-[#000B44] text-white shadow-lg shadow-[#000B44]/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>
    </div>

    <div class="mb-8 flex items-center justify-between">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
            Menampilkan <span class="text-[#000B44] font-black">{{ count($partners) }} UMKM</span>
        </p>
    </div>

    {{-- Partners Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($partners as $index => $partner)
        <div wire:key="partner-{{ $partner['id'] }}-cat-{{ $activeCategory }}" 
             class="bg-white border border-gray-100 rounded-[40px] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 group animate-card-enter"
             style="animation-delay: {{ $index * 0.05 }}s; opacity: 0;">
            
            {{-- Image Header --}}
            <div class="relative h-64 bg-gray-900 overflow-hidden">
                <img src="{{ $partner['img'] }}" 
                     alt="Cover image {{ $partner['name'] }}"
                     class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition-all duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-8 flex items-center gap-3">
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $partner['category'] }}</span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                <div class="flex justify-between items-start mb-4 gap-4">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 font-plus mb-1.5 leading-tight">{{ $partner['name'] }}</h3>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-xs font-bold text-gray-400">{{ $partner['location'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-xl border border-yellow-100 shrink-0" 
                         aria-label="Rating {{ $partner['rating'] }} dari 5 bintang">
                        <svg class="w-3.5 h-3.5 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-[11px] font-black text-yellow-700">
                            {{ $partner['rating'] }} <span class="text-yellow-400 font-medium">({{ $partner['reviews_count'] }})</span>
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($partner['tags'] as $tag)
                    <span class="px-3 py-1 bg-gray-50 border border-gray-100 rounded-lg text-[9px] font-bold text-gray-500 hover:bg-gray-100 transition-colors uppercase tracking-tighter">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Range Harga</p>
                    <p class="text-sm font-black text-gray-900">{{ $partner['price_range'] }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('customer.partner-detail', $partner['id']) }}" 
                       aria-label="Lihat detail {{ $partner['name'] }}"
                       class="flex-1 py-4 bg-[#000B44] hover:bg-[#001166] text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all text-center shadow-lg focus:ring-2 focus:ring-[#0077B6] focus:outline-none">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm border border-slate-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-base font-black text-[#000B44] font-plus mb-1">Tidak Ada Mitra Jasa</h3>
            <p class="text-slate-500 text-sm font-medium">Coba cari dengan kata kunci lain atau ubah kategori filter.</p>
        </div>
        @endforelse
    </div>
</div>