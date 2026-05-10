<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

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
<body class="font-sans antialiased bg-white text-foreground">
    @php
        // Sample data
        $user = [
            'name' => 'Ahmad',
            'lastActivity' => 'Senin, 15 Januari 2026'
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => '#', 'active' => true],
            ['name' => 'Pesanan Saya', 'href' => route('customer.orders.preview')],
            ['name' => 'UMKM Partner', 'href' => route('customer.partners.preview')],
            ['name' => 'Bantuan', 'href' => '#'],
        ];

        $stats = [
            ['count' => 2, 'label' => 'Pesanan Aktif', 'color' => 'default'],
            ['count' => 8, 'label' => 'Selesai', 'color' => 'default']
        ];

        $activeOrders = [
            [
                'id' => 'UMKM-2026-0001',
                'service' => 'Deep Cleaning Service',
                'provider' => 'Bersih Cleaning Service',
                'status' => 'Menunggu Review Admin',
                'date' => '16 Januari 2026',
                'time' => '10:00 WIB',
                'location' => 'Jakarta Pusat',
                'price' => 'Rp 2.500.000',
                'action' => 'detail'
            ],
            [
                'id' => 'UMKM-2026-0002',
                'service' => 'Office Cleaning Service',
                'provider' => 'ABC Cleaning Co',
                'status' => 'Perlu Tindakan Anda',
                'statusHighlight' => true,
                'date' => '18 Januari 2026',
                'time' => '14:00 WIB',
                'location' => 'Jakarta Selatan',
                'price' => 'Rp 3.200.000',
                'adminNote' => 'Admin telah mengajukan pre-invoice. Status: review',
                'action' => 'review'
            ],
            [
                'id' => 'UMKM-2026-0003',
                'service' => 'Regular Cleaning',
                'provider' => 'Pro Clean Jasa',
                'status' => 'Menunggu Pembayaran',
                'date' => '17 Januari 2026',
                'time' => '09:00 WIB',
                'location' => 'Tangerang',
                'price' => 'Rp 1.500.000',
                'action' => 'pay'
            ]
        ];

        $notifications = [
            [
                'title' => 'Pre-invoice silahkan untuk periksa',
                'order' => 'pesanan UMKM-2026-0001',
                'time' => '2 menit lalu'
            ],
            [
                'title' => 'Pembayaran dikonfirmasi!',
                'order' => 'ID LP-2026-0003',
                'time' => '1 hari lalu'
            ]
        ];
    @endphp

    <div class="min-h-screen">
        <!-- Navbar - EXACT SAME as Landing Page -->
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
                        <!-- Branding: JOS -->
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
                            <!-- Notification Bell -->
                            <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- User Profile -->
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
            <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 h-0" x-transition:enter-end="opacity-100 h-auto" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 h-auto" x-transition:leave-end="opacity-0 h-0" class="md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200 overflow-hidden">
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
            <!-- Hero Section with Greeting -->
            <div class="w-full relative overflow-hidden border-b border-[#e5e5e5]">
                <!-- Background Image with Blur and Dark Overlay -->
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&q=80" 
                         alt="Background" 
                         class="w-full h-full object-cover blur-sm scale-105">
                    <div class="absolute inset-0 bg-black/60"></div>
                </div>
                
                <!-- Content -->
                <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16">
                    <div class="flex flex-col gap-1 text-[#38bdf8] mb-4">
                        <span class="text-sm uppercase tracking-tight font-mono flex items-center gap-1" style="font-family: 'Geist Mono', monospace;">
                            DASHBOARD CUSTOMER
                            <span class="w-1.5 h-3 bg-[#38bdf8] ml-1 rounded-sm animate-pulse"></span>
                        </span>
                    </div>
                    <h1 class="text-[56px] leading-[1.1] tracking-tight text-white mb-4" style="font-weight: 500; font-family: 'Figtree', sans-serif;">
                        Halo, <span class="text-[#38bdf8]">{{ $user['name'] }}</span>
                    </h1>
                    <p class="text-lg leading-7 text-gray-200 max-w-[520px]" style="font-family: 'Figtree', sans-serif;">
                        Berikut ringkasan pesanan Anda
                    </p>
                    <p class="text-sm text-gray-400 mt-2" style="font-family: 'Figtree', sans-serif;">{{ $user['lastActivity'] }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="w-full bg-white py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($stats as $index => $stat)
                        <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] hover:shadow-md hover:-translate-y-1 transition-all duration-300 {{ $stat['color'] === 'highlight' ? 'bg-[#003d5c] text-white border-[#003d5c]' : '' }}">
                            <div class="text-5xl font-bold mb-3 {{ $stat['color'] === 'highlight' ? 'text-white' : 'text-[#003d5c]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['count'] }}</div>
                            <div class="text-base {{ $stat['color'] === 'highlight' ? 'text-white/90' : 'text-[#666666]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['label'] }}</div>
                            @if($stat['color'] === 'highlight')
                            <div class="mt-4 pt-4 border-t border-white/20">
                                <p class="text-sm text-white/80" style="font-family: 'Figtree', sans-serif;">Ada pesanan yang memerlukan perhatian Anda</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Active Orders -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Section Header -->
                            <div class="flex items-center justify-between">
                                <h2 class="text-[40px] leading-tight font-normal text-[#003d5c] tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Pesanan Aktif</h2>
                                <a href="#" class="text-sm text-[#0078b7] hover:text-[#003d5c] font-medium transition-colors flex items-center gap-1" style="font-family: 'Figtree', sans-serif;">
                                    Lihat Semua
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>

                            <!-- Order Cards -->
                            @foreach($activeOrders as $order)
                            <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                                <!-- Order Header -->
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex-1">
                                        <div class="text-xs text-[#999999] mb-2 font-mono" style="font-family: 'Geist Mono', monospace;">{{ $order['id'] }}</div>
                                        <h3 class="text-2xl font-semibold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif;">{{ $order['service'] }}</h3>
                                        <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $order['provider'] }}</p>
                                    </div>
                                    @if(isset($order['statusHighlight']) && $order['statusHighlight'])
                                    <span class="px-4 py-2 bg-[#003d5c] text-white text-xs font-semibold rounded-full whitespace-nowrap" style="font-family: 'Figtree', sans-serif;">{{ $order['status'] }}</span>
                                    @endif
                                </div>

                                <!-- Admin Note (if exists) -->
                                @if(isset($order['adminNote']))
                                <div class="mb-6 p-4 bg-[#FEF3C7] border-l-4 border-[#F59E0B] rounded-lg">
                                    <p class="text-sm text-[#92400E]" style="font-family: 'Figtree', sans-serif;">{{ $order['adminNote'] }}</p>
                                </div>
                                @endif

                                <!-- Order Details -->
                                <div class="space-y-4 mb-6">
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
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7]">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                        <span class="text-[#003d5c] font-semibold text-lg" style="font-family: 'Figtree', sans-serif;">{{ $order['price'] }}</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                @if($order['action'] === 'review')
                                <button class="w-full bg-[#0078b7] text-white px-6 py-4 rounded-xl text-base font-semibold hover:bg-[#003d5c] transition-all duration-200 hover:shadow-sm flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Review Pre-Invoice
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @elseif($order['action'] === 'pay')
                                <button class="w-full bg-[#0078b7] text-white px-6 py-4 rounded-xl text-base font-semibold hover:bg-[#003d5c] transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Bayar Sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @else
                                <button class="w-full bg-white border-2 border-[#e5e5e5] text-[#003d5c] px-6 py-4 rounded-xl text-base font-semibold hover:border-[#0078b7] hover:text-[#0078b7] transition-all duration-200 flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Lihat Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Right Column - Sidebar -->
                        <div class="space-y-6">
                            <!-- Quick Actions -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-xl font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Menu Cepat</h3>
                                <div class="space-y-3">
                                    <a href="#" class="flex items-center justify-between p-4 rounded-xl hover:bg-[#0078b7]/5 transition-all duration-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#0078b7]/10 flex items-center justify-center group-hover:bg-[#0078b7] transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7] group-hover:text-white">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="m21 21-4.35-4.35"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Cari Admin</span>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                    <a href="#" class="flex items-center justify-between p-4 rounded-xl hover:bg-[#0078b7]/5 transition-all duration-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#0078b7]/10 flex items-center justify-center group-hover:bg-[#0078b7] transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7] group-hover:text-white">
                                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Notifikasi</span>
                                        </div>
                                        <span class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-semibold">3</span>
                                    </a>
                                    <a href="#" class="flex items-center justify-between p-4 rounded-xl hover:bg-[#0078b7]/5 transition-all duration-200 group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-[#0078b7]/10 flex items-center justify-center group-hover:bg-[#0078b7] transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#0078b7] group-hover:text-white">
                                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Hubungi Kami</span>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Recent Notifications -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Notifikasi Terbaru</h3>
                                    <span class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-semibold">{{ count($notifications) }}</span>
                                </div>
                                <div class="space-y-4">
                                    @foreach($notifications as $notif)
                                    <div class="pb-4 border-b border-[#e5e5e5] last:border-b-0 last:pb-0">
                                        <p class="text-sm text-[#003d5c] font-medium mb-1 flex items-start gap-2" style="font-family: 'Figtree', sans-serif;">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#38bdf8] mt-1.5 flex-shrink-0"></span>
                                            {{ $notif['title'] }}
                                        </p>
                                        <p class="text-xs text-[#666666] mb-1 ml-3.5" style="font-family: 'Figtree', sans-serif;">{{ $notif['order'] }}</p>
                                        <p class="text-xs text-[#999999] ml-3.5" style="font-family: 'Figtree', sans-serif;">{{ $notif['time'] }}</p>
                                    </div>
                                    @endforeach
                                </div>
                                <button class="w-full mt-6 text-sm text-[#0078b7] hover:text-[#003d5c] font-medium transition-colors flex items-center justify-center gap-1" style="font-family: 'Figtree', sans-serif;">
                                    Lihat Semua
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                            </div>

                            <!-- Help Section -->
                            <div class="bg-gradient-to-br from-[#0078b7] to-[#003d5c] rounded-3xl p-8 text-white shadow-md">
                                <h3 class="text-xl font-semibold mb-2" style="font-family: 'Figtree', sans-serif;">Butuh Bantuan?</h3>
                                <p class="text-sm text-white/80 mb-6" style="font-family: 'Figtree', sans-serif;">Kami siap membantu Anda 24/7</p>
                                <button class="w-full bg-white text-[#003d5c] px-6 py-4 rounded-xl text-base font-semibold hover:bg-gray-100 transition-all duration-200 hover:shadow-sm flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    Hubungi Support
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer - Same as Landing Page -->
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
