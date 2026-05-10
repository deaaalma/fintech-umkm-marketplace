<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>UMKM Partner - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-foreground" x-data="{ activeCategory: 'semua' }">
    @php
        $user = [
            'name' => 'Ahmad',
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => route('customer.dashboard.preview')],
            ['name' => 'Pesanan Saya', 'href' => route('customer.orders.preview')],
            ['name' => 'UMKM Partner', 'href' => '#', 'active' => true],
            ['name' => 'Bantuan', 'href' => '#'],
        ];

        $categories = [
            ['id' => 'semua', 'label' => 'Semua'],
            ['id' => 'cleaning', 'label' => 'Cleaning Service'],
            ['id' => 'catering', 'label' => 'Catering'],
            ['id' => 'laundry', 'label' => 'Laundry'],
            ['id' => 'elektronik', 'label' => 'Elektronik'],
            ['id' => 'konstruksi', 'label' => 'Konstruksi'],
        ];

        $partners = [
            [
                'name' => 'Merrys Cleaning Service',
                'location' => 'Jakarta Pusat',
                'rating' => 4.8,
                'reviews' => 124,
                'services' => ['Deep Cleaning', 'Office Cleaning', 'Home Cleaning'],
                'priceRange' => 'Rp 150.000 - Rp 2.500.000',
                'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=600&q=80'
            ],
            [
                'name' => 'BWP Cleaning Service',
                'location' => 'Jakarta Selatan',
                'rating' => 4.9,
                'reviews' => 98,
                'services' => ['General Cleaning', 'Window Cleaning', 'Carpet Cleaning'],
                'priceRange' => 'Rp 100.000 - Rp 2.000.000',
                'image' => 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=600&q=80'
            ],
            [
                'name' => 'ABC Cleaning Co.',
                'location' => 'Tangerang',
                'rating' => 4.7,
                'reviews' => 156,
                'services' => ['Regular Cleaning', 'AC Cleaning', 'Sofa Cleaning'],
                'priceRange' => 'Rp 75.000 - Rp 1.500.000',
                'image' => 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=600&q=80'
            ],
            [
                'name' => 'XYZ Services',
                'location' => 'Bali',
                'rating' => 4.6,
                'reviews' => 87,
                'services' => ['House Cleaning', 'Office Cleaning'],
                'priceRange' => 'Rp 40.000 - Rp 1.000.000',
                'image' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&q=80'
            ],
            [
                'name' => 'Clean & Fresh',
                'location' => 'Bekasi',
                'rating' => 4.8,
                'reviews' => 203,
                'services' => ['Deep Cleaning', 'Move-in/out Cleaning'],
                'priceRange' => 'Rp 200.000 - Rp 3.000.000',
                'image' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=600&q=80'
            ],
            [
                'name' => 'Sparkle Cleaning',
                'location' => 'Bandung',
                'rating' => 4.9,
                'reviews' => 142,
                'services' => ['Commercial Cleaning', 'Residential Cleaning'],
                'priceRange' => 'Rp 150.000 - Rp 2.500.000',
                'image' => 'https://images.unsplash.com/photo-1585421514738-01798e348b17?w=600&q=80'
            ],
        ];
    @endphp

    <div class="min-h-screen">
        <!-- Navbar - EXACT SAME as Dashboard -->
        <nav
            x-data="{
                isMobileMenuOpen: false,
                isScrolled: false,
                init() { 
                    window.addEventListener('scroll', () => { 
                        this.isScrolled = window.scrollY > 20; 
                    }); 
                },
                handleLinkClick(href) {
                    this.isMobileMenuOpen = false;
                    if (href.startsWith('#')) {
                        const element = document.querySelector(href);
                        if (element) element.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        window.location.href = href;
                    }
                }
            }"
            :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-sm text-gray-900' : 'bg-white text-gray-900'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-[#e5e5e5]"
        >
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <a href="/" class="text-2xl font-bold text-gray-900 hover:text-[#0078b7] transition-colors duration-200" style="font-family: 'Figtree', sans-serif; font-weight: 800;">
                            JOS
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            @foreach($navigationLinks as $link)
                                <a href="{{ $link['href'] }}" 
                                   class="px-3 py-2 text-base font-medium transition-colors duration-200 relative group {{ isset($link['active']) && $link['active'] ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                                   style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                                    <span>{{ $link['name'] }}</span>
                                    <div class="absolute bottom-0 left-0 {{ isset($link['active']) && $link['active'] ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center gap-4">
                            <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <div class="flex items-center gap-3 pl-4 border-l border-[#e5e5e5]">
                                <div class="w-9 h-9 rounded-full bg-[#0078b7]/10 flex items-center justify-center">
                                    <span class="text-[#0078b7] font-semibold text-sm" style="font-family: 'Figtree', sans-serif;">A</span>
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-gray-900" style="font-family: 'Figtree', sans-serif;">{{ $user['name'] }}</div>
                                    <div class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Customer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                                class="text-gray-900 hover:text-[#0078b7] p-2 rounded-md transition-colors duration-200" 
                                aria-label="Toggle mobile menu">
                            <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="isMobileMenuOpen" x-transition class="md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200 overflow-hidden">
                <div class="px-6 py-6 space-y-4">
                    @foreach($navigationLinks as $link)
                        <a href="{{ $link['href'] }}" class="block w-full text-left text-gray-900 hover:text-[#0078b7] py-3 text-lg font-medium transition-colors duration-200 {{ isset($link['active']) && $link['active'] ? 'text-[#0078b7]' : '' }}" style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                            <span>{{ $link['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-20">
            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
                    <h1 class="text-[40px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">UMKM Partner</h1>
                    <p class="text-base text-[#666666]" style="font-family: 'Figtree', sans-serif;">Temukan mitra UMKM terbaik untuk kebutuhan Anda</p>
                </div>
            </div>

            <!-- Search & Filters -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <!-- Search Bar -->
                    <div class="mb-8">
                        <div class="flex gap-3">
                            <div class="flex-1 relative">
                                <input 
                                    type="text" 
                                    placeholder="Cari UMKM atau layanan..."
                                    class="w-full px-5 py-4 pl-12 rounded-xl border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent"
                                    style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#999999]">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </div>
                            <button class="px-8 py-4 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>

                    <!-- Category Tabs -->
                    <div class="mb-8 overflow-x-auto">
                        <div class="flex gap-3 min-w-max">
                            @foreach($categories as $category)
                            <button 
                                @click="activeCategory = '{{ $category['id'] }}'"
                                :class="activeCategory === '{{ $category['id'] }}' ? 'bg-[#003d5c] text-white' : 'bg-white text-[#003d5c] hover:bg-gray-50'"
                                class="px-6 py-3 rounded-xl font-medium transition-all duration-200 whitespace-nowrap"
                                style="font-family: 'Figtree', sans-serif;">
                                {{ $category['label'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Results Count -->
                    <div class="mb-6">
                        <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">
                            Menampilkan <span class="font-semibold text-[#003d5c]">{{ count($partners) }} UMKM</span>
                        </p>
                    </div>

                    <!-- Partners Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($partners as $partner)
                        <div class="bg-white rounded-3xl overflow-hidden border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                            <!-- Partner Image -->
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                <img src="{{ $partner['image'] }}" alt="{{ $partner['name'] }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <div class="flex items-center justify-center w-12 h-12 bg-white rounded-xl shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#003d5c]">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Partner Info -->
                            <div class="p-6">
                                <!-- Name & Rating -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">{{ $partner['name'] }}</h3>
                                        <div class="flex items-center gap-2 text-sm text-[#666666]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7]">
                                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <span style="font-family: 'Figtree', sans-serif;">{{ $partner['location'] }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 bg-[#FEF3C7] px-3 py-1.5 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#F59E0B" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span class="text-sm font-semibold text-[#92400E]" style="font-family: 'Figtree', sans-serif;">{{ $partner['rating'] }}</span>
                                        <span class="text-xs text-[#92400E]" style="font-family: 'Figtree', sans-serif;">({{ $partner['reviews'] }})</span>
                                    </div>
                                </div>

                                <!-- Services Tags -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($partner['services'] as $service)
                                    <span class="px-3 py-1 bg-[#0078b7]/10 text-[#003d5c] text-xs font-medium rounded-full" style="font-family: 'Figtree', sans-serif;">{{ $service }}</span>
                                    @endforeach
                                </div>

                                <!-- Price Range -->
                                <div class="mb-4 pb-4 border-b border-[#e5e5e5]">
                                    <p class="text-xs text-[#999999] mb-1" style="font-family: 'Figtree', sans-serif;">Kisaran Harga</p>
                                    <p class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $partner['priceRange'] }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <button class="flex-1 bg-[#003d5c] text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-[#0078b7] transition-all duration-200 hover:shadow-sm flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                        Lihat Detail
                                    </button>
                                    <button class="p-3 bg-white border-2 border-[#e5e5e5] text-[#003d5c] rounded-xl hover:border-[#0078b7] hover:text-[#0078b7] transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex items-center justify-center gap-2">
                        <button class="w-10 h-10 rounded-lg bg-white border border-[#e5e5e5] flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="w-10 h-10 rounded-lg bg-[#003d5c] text-white flex items-center justify-center font-semibold">1</button>
                        <button class="w-10 h-10 rounded-lg bg-white border border-[#e5e5e5] flex items-center justify-center hover:bg-gray-50 transition-colors font-medium">2</button>
                        <button class="w-10 h-10 rounded-lg bg-white border border-[#e5e5e5] flex items-center justify-center hover:bg-gray-50 transition-colors font-medium">3</button>
                        <span class="px-2 text-[#999999]">...</span>
                        <button class="w-10 h-10 rounded-lg bg-white border border-[#e5e5e5] flex items-center justify-center hover:bg-gray-50 transition-colors font-medium">8</button>
                        <button class="w-10 h-10 rounded-lg bg-white border border-[#e5e5e5] flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer - Same as Dashboard -->
        <footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
            <div class="max-w-[1200px] mx-auto px-8 py-16">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-8 mb-12">
                    <div class="col-span-2">
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif; font-weight: 500;">UMKM Connect</h3>
                            <p class="text-sm leading-5 text-[#666666] max-w-xs" style="font-family: 'Figtree', sans-serif;">Platform digital untuk memajukan UMKM Indonesia.</p>
                        </div>
                        <div class="flex items-center gap-3 mt-6">
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#003d5c] hover:border-[#003d5c] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#003d5c] hover:border-[#003d5c] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Perusahaan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Tentang Kami</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Karir</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Blog</a></li>
                        </ul>
                    </div>

                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Bantuan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Kebijakan Privasi</a></li>
                        </ul>
                    </div>

                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Hubungi Kami</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">support@umkmconnect.id</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">+62 812 3456 7890</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t border-[#e5e5e5]">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">&copy; {{ date('Y') }} UMKM Connect. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
