<x-slot:title>Explore Partners</x-slot:title>

@section('extra-styles')
    .partner-card {
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .partner-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(0, 11, 68, 0.1);
    }
    .partner-img-overlay {
        background: linear-gradient(to top, rgba(0, 11, 68, 0.6) 0%, transparent 100%);
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
@endsection

<div x-data="{ 
    activeCategory: @entangle('activeCategory'),
    search: @entangle('search'),
    allPartners: @js($partners)
}">
    <div class="mb-16">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-brand-primary/5 rounded-full border border-brand-primary/10 mb-6 group cursor-default animate-on-load">
            <div class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse group-hover:scale-125 transition-transform duration-500"></div>
            <span class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em]">Verified Partners</span>
        </div>
        <h1 class="text-6xl font-bold text-brand-dark tracking-tighter mb-4 animate-on-load font-plus">
            Explore <span class="italic font-normal text-brand-primary" style="font-family: Georgia, serif;">Our Partners</span>
        </h1>
        <p class="text-slate-400 text-lg max-w-2xl animate-on-load font-medium">Temukan penyedia jasa terverifikasi yang siap membantu kebutuhan UMKM Anda.</p>
    </div>

    <div class="mb-12 animate-on-load">
        <div class="flex flex-col-reverse lg:flex-row gap-6 lg:gap-8 items-stretch lg:items-center justify-between">
            <div class="flex flex-row overflow-x-auto gap-3 lg:gap-4 pb-2 lg:pb-0 scrollbar-hide snap-x">
                @foreach($categories as $cat)
                <button wire:click="$set('activeCategory', '{{ $cat['id'] }}')"
                        :class="activeCategory === '{{ $cat['id'] }}' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/10' : 'bg-white text-slate-400 border border-slate-100 hover:border-brand-primary/20'"
                        class="px-6 lg:px-8 py-3 rounded-xl lg:rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all whitespace-nowrap snap-start flex-shrink-0">
                    {{ $cat['label'] }}
                </button>
                @endforeach
            </div>

            <div class="relative w-full lg:w-96 group flex-shrink-0">
                <div class="absolute inset-y-0 left-4 lg:left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari partner atau layanan..." 
                       class="w-full pl-10 lg:pl-14 pr-4 lg:pr-6 py-3.5 lg:py-4 bg-white border border-slate-100 rounded-xl lg:rounded-2xl text-[11px] lg:text-[13px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:border-brand-primary/30 focus:ring-4 focus:ring-brand-primary/5 transition-all shadow-sm group-hover:shadow-xl group-hover:shadow-brand-primary/5">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
        @forelse($partners as $partner)
            <div class="partner-card bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden group animate-on-load">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $partner['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 partner-img-overlay opacity-60"></div>
                    
                    @if($partner['verified'])
                    <div class="absolute top-5 right-5">
                        <div class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-2 shadow-xl">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-primary"><polyline points="20 6 9 17 4 12"/></svg>
                            <span class="text-[9px] font-black text-brand-dark uppercase tracking-widest">Verified</span>
                        </div>
                    </div>
                    @endif

                    <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between">
                        <div class="flex items-center gap-2 bg-brand-dark/30 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10 text-white">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span class="text-[10px] font-black">{{ $partner['rating'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-4">
                    <div class="space-y-1">
                        <div class="text-[9px] font-black text-brand-primary uppercase tracking-[0.2em]">{{ $partner['category'] }}</div>
                        <h4 class="text-xl font-bold text-brand-dark tracking-tight">{{ $partner['name'] }}</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-2">{{ $partner['desc'] }}</p>
                    <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400">{{ $partner['reviews'] }} Reviews</span>
                        <a href="#" class="px-6 py-2.5 bg-brand-primary/5 text-brand-primary rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-brand-primary hover:text-white transition-all shadow-sm">
                            Pilih Partner
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                <h3 class="text-lg font-bold text-brand-dark mb-2">Partner tidak ditemukan</h3>
                <p class="text-slate-400 text-sm">Coba gunakan kata kunci atau kategori lain.</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    gsap.from('.animate-on-load', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
</script>
@endpush