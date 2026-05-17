@props(['partners' => []])

<div {{ $attributes->merge(['class' => 'animate-on-scroll']) }}>
    <h3 class="text-xl font-black text-brand-dark tracking-tighter mb-6">Partner Recommendations</h3>
    
    <div class="space-y-4">
        @forelse($partners as $partner)
            {{-- Mengarahkan ke detail partner jika route sudah siap --}}
            <a href="#" class="group bg-white rounded-2xl p-5 premium-shadow border border-gray-50 flex items-center gap-4 hover:bg-brand-primary transition-all duration-300 block">
                <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                    @if(isset($partner->logo_url))
                        <img src="{{ $partner->logo_url }}" class="w-full h-full object-cover" alt="{{ $partner->name }}">
                    @else
                        {{-- Placeholder jika tidak ada logo --}}
                        <div class="w-full h-full flex items-center justify-center bg-brand-primary/10 text-brand-primary font-bold">
                            {{ substr($partner->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <h5 class="font-bold text-brand-dark text-sm truncate group-hover:text-white transition-colors">
                        {{ $partner->name }}
                    </h5>
                    <p class="text-[10px] text-gray-400 group-hover:text-white/60 font-jakarta font-bold uppercase tracking-widest transition-colors">
                        {{-- Mengambil kategori (jika ada) atau fallback ke deskripsi singkat --}}
                        {{ $partner->category ?? 'Partner UMKM' }}
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white/20 flex items-center justify-center text-brand-primary group-hover:text-white transition-all">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        @empty
            {{-- State jika tidak ada rekomendasi --}}
            <div class="p-8 text-center border-2 border-dashed border-gray-100 rounded-3xl">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">No recommendations yet</p>
            </div>
        @endforelse
    </div>
</div>