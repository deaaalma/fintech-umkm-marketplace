<x-slot:title>{{ $partner->name }} - Detail Partner</x-slot:title>

<div class="max-w-[1200px] mx-auto pb-20">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-bold text-gray-400 mb-8">
        <a href="{{ route('customer.dashboard') }}" class="hover:text-gray-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.partners') }}" class="hover:text-gray-900 transition-colors">Partners</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900">{{ $partner->name }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left: Partner Info & Products --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Partner Hero --}}
            <div class="bg-white rounded-[32px] overflow-hidden border border-gray-100 shadow-sm">
                <div class="h-64 relative">
                    <img src="{{ $partner->logo_url ?? 'https://images.unsplash.com/photo-1581578731548-c64695cc6958?w=1200&q=80' }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-8 left-8">
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/30 mb-3 inline-block">
                            {{ $partner->category->name }}
                        </span>
                        <h1 class="text-3xl font-black text-white font-plus tracking-tight">{{ $partner->name }}</h1>
                    </div>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $partner->description ?? 'Tidak ada deskripsi.' }}</p>
                    <div class="flex flex-wrap gap-6 text-sm font-bold text-gray-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $partner->city ?? 'Lokasi tidak diatur' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            4.8 <span class="text-gray-400">({{ $partner->reviews->count() }} Reviews)</span>
                        </div>
                        @if($partner->is_verified)
                        <div class="flex items-center gap-2 text-blue-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.25.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Partner
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Products Section --}}
            <div>
                <h2 class="text-xl font-black text-gray-900 font-plus mb-6">Layanan Tersedia</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($partner->products as $product)
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $product->category->name ?? $partner->category->name }}</span>
                        </div>
                        <h3 class="text-lg font-black text-gray-900 font-plus mb-2">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">{{ $product->description ?? 'Deskripsi layanan tidak tersedia.' }}</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Mulai dari</p>
                                <p class="text-base font-black text-[#2D2D2D]">Rp {{ number_format($product->estimated_price ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <button 
                                wire:click="pesanSekarang({{ $product->id }})"
                                class="px-5 py-2.5 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors"
                            >
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-gray-50 rounded-[32px] border border-dashed border-gray-200">
                        <p class="text-gray-400 font-bold text-sm">Belum ada layanan yang ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right: Reviews & Contact --}}
        <div class="lg:col-span-4 space-y-8">
            {{-- Quick Stats --}}
            <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus mb-6">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-gray-400 border border-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">WhatsApp</p>
                            <p class="text-xs font-bold text-gray-900">{{ $partner->owner->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-gray-400 border border-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</p>
                            <p class="text-xs font-bold text-gray-900">{{ $partner->owner->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <button class="w-full mt-6 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                    Chat Admin
                </button>
            </div>

            {{-- Reviews --}}
            <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-black text-gray-900 font-plus">Reviews</h3>
                    <span class="text-xs font-bold text-yellow-600">{{ $partner->reviews->count() }} Total</span>
                </div>
                <div class="space-y-6">
                    @forelse($partner->reviews->take(3) as $review)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400">
                                    {{ substr($review->customer->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-gray-900">{{ $review->customer->name }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 0; $i < $review->rating; $i++)
                                <svg class="w-2.5 h-2.5 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed italic">"{{ $review->comment }}"</p>
                    </div>
                    @empty
                    <p class="text-center text-xs text-gray-400 py-4">Belum ada review.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
