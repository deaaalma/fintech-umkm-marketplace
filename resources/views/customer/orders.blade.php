<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pesanan Saya - {{ config('app.name', 'Laravel') }}</title>

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
<body class="font-sans antialiased bg-white text-foreground" x-data="{ activeTab: 'semua' }">
    @php
        $user = [
            'name' => 'Ahmad',
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => route('customer.dashboard.preview')],
            ['name' => 'Pesanan Saya', 'href' => '#', 'active' => true],
            ['name' => 'UMKM Partner', 'href' => route('customer.partners.preview')],
            ['name' => 'Bantuan', 'href' => '#'],
        ];

        $tabs = [
            ['id' => 'semua', 'label' => 'Semua', 'count' => 15],
            ['id' => 'menunggu', 'label' => 'Menunggu Konfirmasi', 'count' => 3],
            ['id' => 'diproses', 'label' => 'Diproses', 'count' => 2],
            ['id' => 'selesai', 'label' => 'Selesai', 'count' => 8],
            ['id' => 'dibatalkan', 'label' => 'Dibatalkan', 'count' => 2],
        ];

        $orders = [
            [
                'id' => 'UMKM-2026-0001',
                'service' => 'Deep Cleaning Service',
                'provider' => 'Bersih Cleaning Service',
                'status' => 'Menunggu Konfirmasi',
                'statusColor' => 'yellow',
                'date' => '16 Januari 2026',
                'time' => '10:00 WIB',
                'location' => 'Jakarta Pusat',
                'price' => 'Rp 2.500.000',
                'rating' => null,
                'action' => 'detail'
            ],
            [
                'id' => 'UMKM-2026-0002',
                'service' => 'Office Cleaning Service',
                'provider' => 'ABC Cleaning Co',
                'status' => 'Perlu Tindakan Anda',
                'statusColor' => 'red',
                'statusHighlight' => true,
                'date' => '18 Januari 2026',
                'time' => '14:00 WIB',
                'location' => 'Jakarta Selatan',
                'price' => 'Rp 3.200.000',
                'adminNote' => 'Admin telah mengajukan pre-invoice. Status: review',
                'rating' => null,
                'action' => 'review'
            ],
            [
                'id' => 'UMKM-2026-0003',
                'service' => 'Regular Cleaning',
                'provider' => 'Pro Clean Jasa',
                'status' => 'Menunggu Pembayaran',
                'statusColor' => 'yellow',
                'date' => '17 Januari 2026',
                'time' => '09:00 WIB',
                'location' => 'Tangerang',
                'price' => 'Rp 1.500.000',
                'rating' => null,
                'action' => 'pay'
            ],
            [
                'id' => 'UMKM-2026-0004',
                'service' => 'Deep Cleaning Service',
                'provider' => 'Clean Master ID',
                'status' => 'Selesai',
                'statusColor' => 'green',
                'date' => '12 Januari 2026',
                'time' => '08:00 WIB',
                'location' => 'Jakarta Barat',
                'price' => 'Rp 2.800.000',
                'rating' => 5,
                'action' => 'review-service'
            ],
            [
                'id' => 'UMKM-2026-0005',
                'service' => 'Deep Cleaning',
                'provider' => 'Sparkle Clean',
                'status' => 'Selesai',
                'statusColor' => 'green',
                'date' => '10 Januari 2026',
                'time' => '13:00 WIB',
                'location' => 'Jakarta Timur',
                'price' => 'Rp 2.200.000',
                'rating' => 4,
                'action' => 'done'
            ],
            [
                'id' => 'UMKM-2026-0006',
                'service' => 'Office Cleaning',
                'provider' => 'Pro Services',
                'status' => 'Selesai',
                'statusColor' => 'green',
                'date' => '8 Januari 2026',
                'time' => '10:00 WIB',
                'location' => 'Bekasi',
                'price' => 'Rp 3.500.000',
                'rating' => 5,
                'action' => 'done'
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
                    <h1 class="text-[40px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Pesanan Saya</h1>
                    <p class="text-base text-[#666666]" style="font-family: 'Figtree', sans-serif;">Total: {{ count($orders) }} pesanan</p>
                </div>
            </div>

            <!-- Filters & Content -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <!-- Tabs -->
                    <div class="mb-8 overflow-x-auto">
                        <div class="flex gap-3 min-w-max">
                            @foreach($tabs as $tab)
                            <button 
                                @click="activeTab = '{{ $tab['id'] }}'"
                                :class="activeTab === '{{ $tab['id'] }}' ? 'bg-[#003d5c] text-white' : 'bg-white text-[#003d5c] hover:bg-gray-50'"
                                class="px-6 py-3 rounded-xl font-medium transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                                style="font-family: 'Figtree', sans-serif;">
                                <span>{{ $tab['label'] }}</span>
                                <span :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white/20 text-white' : 'bg-[#003d5c]/10 text-[#003d5c]'" class="px-2 py-0.5 rounded-full text-xs font-semibold">{{ $tab['count'] }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter & Search Bar -->
                    <div class="mb-8 flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input 
                                type="text" 
                                placeholder="Cari pesanan berdasarkan nama layanan atau ID pesanan..."
                                class="w-full px-5 py-4 pl-12 rounded-xl border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent"
                                style="font-family: 'Figtree', sans-serif;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#999999]">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                        <button class="px-6 py-4 bg-white border border-[#e5e5e5] rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="21" x2="4" y2="14"></line>
                                <line x1="4" y1="10" x2="4" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12" y2="3"></line>
                                <line x1="20" y1="21" x2="20" y2="16"></line>
                                <line x1="20" y1="12" x2="20" y2="3"></line>
                                <line x1="1" y1="14" x2="7" y2="14"></line>
                                <line x1="9" y1="8" x2="15" y2="8"></line>
                                <line x1="17" y1="16" x2="23" y2="16"></line>
                            </svg>
                            <span class="font-medium text-[#003d5c]">Filter Lainnya</span>
                        </button>
                    </div>

                    <!-- Orders List -->
                    <div class="space-y-6">
                        @foreach($orders as $order)
                        <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                            <!-- Order Header -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1">
                                    <div class="text-xs text-[#999999] mb-2 font-mono" style="font-family: 'Geist Mono', monospace;">{{ $order['id'] }}</div>
                                    <h3 class="text-2xl font-semibold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif;">{{ $order['service'] }}</h3>
                                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $order['provider'] }}</p>
                                </div>
                                <span class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap
                                    {{ $order['statusColor'] === 'green' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $order['statusColor'] === 'yellow' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $order['statusColor'] === 'red' ? 'bg-[#003d5c] text-white' : '' }}"
                                    style="font-family: 'Figtree', sans-serif;">
                                    {{ $order['status'] }}
                                </span>
                            </div>

                            <!-- Admin Note -->
                            @if(isset($order['adminNote']))
                            <div class="mb-6 p-4 bg-[#FEF3C7] border-l-4 border-[#F59E0B] rounded-lg">
                                <p class="text-sm text-[#92400E]" style="font-family: 'Figtree', sans-serif;">{{ $order['adminNote'] }}</p>
                            </div>
                            @endif

                            <!-- Order Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-3 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7]">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">{{ $order['date'] }}</span>
                                    <span class="text-[#999999]">{{ $order['time'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7]">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">{{ $order['location'] }}</span>
                                </div>
                            </div>

                            <!-- Price & Rating -->
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-[#e5e5e5]">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7]">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                    <span class="text-[#003d5c] font-semibold text-lg" style="font-family: 'Figtree', sans-serif;">{{ $order['price'] }}</span>
                                </div>
                                @if($order['rating'])
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= $order['rating'] ? '#F59E0B' : 'none' }}" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    @endfor
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                @if($order['action'] === 'review')
                                <button class="flex-1 bg-[#0078b7] text-white px-6 py-4 rounded-xl text-base font-semibold hover:bg-[#003d5c] transition-all duration-200 hover:shadow-sm flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Review Pre-Invoice
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @elseif($order['action'] === 'pay')
                                <button class="flex-1 bg-[#0078b7] text-white px-6 py-4 rounded-xl text-base font-semibold hover:bg-[#003d5c] transition-all duration-200 hover:shadow-sm flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Bayar Sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @elseif($order['action'] === 'review-service')
                                <button class="flex-1 bg-white border-2 border-[#e5e5e5] text-[#003d5c] px-6 py-4 rounded-xl text-base font-semibold hover:border-[#0078b7] hover:text-[#0078b7] transition-all duration-200 flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Beri Review
                                </button>
                                <button class="px-6 py-4 bg-white border-2 border-[#e5e5e5] text-[#003d5c] rounded-xl font-semibold hover:border-[#0078b7] hover:text-[#0078b7] transition-all duration-200" style="font-family: 'Figtree', sans-serif;">
                                    Lihat Detail
                                </button>
                                @else
                                <button class="flex-1 bg-white border-2 border-[#e5e5e5] text-[#003d5c] px-6 py-4 rounded-xl text-base font-semibold hover:border-[#0078b7] hover:text-[#0078b7] transition-all duration-200 flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Lihat Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @endif
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
