<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>UMKM Partner - JOS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
        }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 400; }
        .font-jakarta-bold { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
        .font-georgia-italic { font-family: Georgia, serif; font-style: italic; }
    </style>
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-[#0A0A0A]" x-data="{ activeCategory: 'semua' }">
    @php
        $user = [
            'name' => 'Ahmad',
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => route('customer.dashboard.preview'), 'active' => false],
            ['name' => 'Pesanan Saya', 'href' => route('customer.orders.preview'), 'active' => false],
            ['name' => 'UMKM Partner', 'href' => '#', 'active' => true],
            ['name' => 'Bantuan', 'href' => '#', 'active' => false],
        ];

        $categories = [
            ['id' => 'semua', 'label' => 'Semua'],
            ['id' => 'digital', 'label' => 'Digital'],
            ['id' => 'cleaning', 'label' => 'Cleaning'],
            ['id' => 'catering', 'label' => 'Catering'],
            ['id' => 'laundry', 'label' => 'Laundry'],
        ];

        $partners = [
            [
                'name' => 'Creative Agency JOS',
                'location' => 'Jakarta Pusat',
                'rating' => 4.9,
                'reviews' => 124,
                'services' => ['Branding', 'Social Media'],
                'priceRange' => 'Rp 500k - 5jt',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&q=80'
            ],
            [
                'name' => 'Tech Solutions JOS',
                'location' => 'Jakarta Selatan',
                'rating' => 4.8,
                'reviews' => 98,
                'services' => ['Web Dev', 'App Dev'],
                'priceRange' => 'Rp 2jt - 20jt',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80'
            ],
            [
                'name' => 'Visual JOS Studio',
                'location' => 'Bandung',
                'rating' => 4.9,
                'reviews' => 156,
                'services' => ['Photography', 'Video'],
                'priceRange' => 'Rp 800k - 8jt',
                'image' => 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?w=600&q=80'
            ]
        ];
    @endphp

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav
            x-data="{
                isMobileMenuOpen: false,
                isScrolled: false,
                init() { 
                    window.addEventListener('scroll', () => { 
                        this.isScrolled = window.scrollY > 20; 
                    }); 
                }
            }"
            class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] lg:w-fit transition-all duration-500"
        >
            <div 
                :class="isScrolled ? 'bg-black/80 border-white/10 shadow-lg' : 'bg-white/90 border-gray-200'"
                class="backdrop-blur-xl border rounded-full px-6 lg:px-10 py-3 flex items-center justify-between lg:justify-center gap-6 lg:gap-24"
            >
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-xl font-bold transition-colors duration-200" 
                       :class="isScrolled ? 'text-white hover:text-[#38bdf8]' : 'text-[#003d5c] hover:text-[#0078b7]'"
                       style="font-family: 'Figtree', sans-serif; font-weight: 800;">
                        JOS
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-8">
                    @foreach($navigationLinks as $link)
                        <a href="{{ $link['href'] }}" 
                           class="text-sm font-medium transition-colors duration-200"
                           :class="isScrolled ? '{{ $link['active'] ? 'text-white' : 'text-white/60 hover:text-white' }}' : '{{ $link['active'] ? 'text-[#0078b7]' : 'text-[#666666] hover:text-[#003d5c]' }}'"
                           style="font-family: 'Figtree', sans-serif;">
                            {{ $link['name'] }}
                        </a>
                    @endforeach
                </div>

                <div class="hidden lg:flex items-center gap-4 border-l pl-6" :class="isScrolled ? 'border-white/10' : 'border-gray-200'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#0078b7] flex items-center justify-center text-white font-bold text-xs">
                            {{ substr($user['name'], 0, 1) }}
                        </div>
                        <span class="text-sm font-medium" :class="isScrolled ? 'text-white' : 'text-[#003d5c]'">{{ $user['name'] }}</span>
                    </div>
                </div>

                <div class="lg:hidden">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" :class="isScrolled ? 'text-white' : 'text-[#003d5c]'" class="p-2">
                        <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Page Header -->
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-0.5 bg-[#0078b7]"></div>
                        <span class="text-sm font-jakarta-bold uppercase tracking-wider text-[#0078b7]">Marketplace</span>
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-jakarta-bold text-[#003d5c] mb-4 tracking-tight">
                        Partners <span class="font-georgia-italic italic text-[#0078b7]">Directory</span>
                    </h1>
                    <p class="text-[#666666] text-lg font-jakarta">Temukan mitra UMKM JOS terpercaya untuk mengakselerasi bisnis Anda.</p>
                </div>

                <!-- Filters -->
                <div class="mb-10 flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                    <div class="flex gap-3 overflow-x-auto pb-2 w-full lg:w-auto">
                        @foreach($categories as $cat)
                        <button @click="activeCategory = '{{ $cat['id'] }}'"
                                :class="activeCategory === '{{ $cat['id'] }}' ? 'bg-[#003d5c] text-white' : 'bg-white text-[#003d5c] border border-gray-100 hover:bg-gray-50'"
                                class="px-6 py-3 rounded-2xl text-sm font-jakarta-bold transition-all whitespace-nowrap">
                            {{ $cat['label'] }}
                        </button>
                        @endforeach
                    </div>
                    
                    <div class="relative w-full lg:w-[350px]">
                        <input type="text" placeholder="Cari partner..." class="w-full pl-12 pr-6 py-4 rounded-2xl border border-gray-100 focus:ring-2 focus:ring-[#0078b7] outline-none font-jakarta">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </div>
                </div>

                <!-- Partners Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($partners as $partner)
                    <div class="bg-white rounded-[32px] overflow-hidden border border-gray-100 group hover:shadow-2xl hover:shadow-[#0078b7]/5 transition-all duration-500">
                        <div class="h-56 relative overflow-hidden">
                            <img src="{{ $partner['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 flex items-center gap-2">
                                <div class="bg-[#FEF3C7] px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="#F59E0B" stroke="#F59E0B" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    <span class="text-sm font-jakarta-bold text-[#92400E]">{{ $partner['rating'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-jakarta-bold text-[#003d5c] mb-2">{{ $partner['name'] }}</h3>
                            <p class="text-sm text-[#666666] font-jakarta mb-6 flex items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $partner['location'] }}
                            </p>
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach($partner['services'] as $s)
                                <span class="bg-[#f8fafc] border border-gray-100 px-3 py-1 rounded-lg text-[11px] font-jakarta-bold text-[#666666] tracking-tight uppercase">{{ $s }}</span>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-jakarta-bold text-[#003d5c]">{{ explode(' - ', $partner['priceRange'])[0] }} <span class="text-xs text-[#999999] font-normal italic">start</span></span>
                                <button class="bg-[#0078b7] hover:bg-[#003d5c] text-white px-6 py-2.5 rounded-2xl text-sm font-jakarta-bold transition-all">
                                    Profile
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-[#020617] text-white pt-20 pb-10 px-6 lg:px-8 border-t border-white/5">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-2 md:col-span-1">
                        <h3 class="text-2xl font-jakarta-bold mb-6">JOS</h3>
                    </div>
                    <div>
                        <h4 class="text-xs font-jakarta-bold uppercase tracking-widest text-[#0078b7] mb-6">Company</h4>
                        <ul class="space-y-4 text-sm text-white/50">
                            <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-10 border-t border-white/5">
                    <p class="text-xs text-white/30">&copy; {{ date('Y') }} JOS. Mengakselerasi Potensi Lokal.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
