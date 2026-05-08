<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Superadmin - {{ config('app.name', 'Laravel') }}</title>

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
        $user = [
            'name' => 'Admin',
            'role' => 'Superadmin'
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => '#', 'active' => true],
            ['name' => 'UMKM Management', 'href' => '#', 'badge' => 127],
            ['name' => 'Pengguna', 'href' => route('superadmin.users.preview'), 'badge' => 2],
            ['name' => 'Transaksi', 'href' => route('superadmin.transactions.preview')],
            ['name' => 'Laporan', 'href' => route('superadmin.reports.preview')],
            ['name' => 'Pengaturan', 'href' => route('superadmin.settings.preview')],
        ];

        $stats = [
            [
                'title' => 'TOTAL UMKM TERDAFTAR',
                'value' => '3,247',
                'details' => [
                    ['label' => 'Aktif', 'value' => '2,891'],
                    ['label' => 'Pending', 'value' => '127'],
                    ['label' => 'Suspended', 'value' => '189'],
                    ['label' => 'Ditolak', 'value' => '40'],
                ],
                'change' => '+12.5%',
                'changeLabel' => '30 hari ini'
            ],
            [
                'title' => 'APPROVAL PENDING',
                'value' => '127',
                'highlight' => true,
                'details' => [
                    ['label' => 'High risk auto-reject', 'value' => '12 hari'],
                    ['label' => 'Avg approval (30 d)', 'value' => '2.4 hari'],
                ],
                'action' => 'Review Sekarang'
            ],
            [
                'title' => 'TOTAL TRANSAKSI',
                'value' => '2,891',
                'details' => [
                    ['label' => '% dari total', 'value' => '89.0%'],
                    ['label' => 'Sukses transaksi', 'value' => '2,567'],
                    ['label' => 'X-Sell', 'value' => '987'],
                    ['label' => 'Refund', 'value' => '654'],
                ],
                'change' => '-0.2%',
                'changeLabel' => '7 minggu ini'
            ],
            [
                'title' => 'KEPUASAN PELANGGAN',
                'value' => '189',
                'details' => [
                    ['label' => 'Resolusi tiketnya', 'value' => '78'],
                    ['label' => 'Pengguna - policy', 'value' => '45'],
                    ['label' => 'Masalah pembayaran', 'value' => '34'],
                    ['label' => 'Lainnya', 'value' => '32'],
                ]
            ],
            [
                'title' => 'RATING RATA-RATA',
                'value' => '4.7',
                'rating' => true,
                'ratingBars' => [
                    ['stars' => 5, 'count' => 892],
                    ['stars' => 4, 'count' => 456],
                    ['stars' => 3, 'count' => 123],
                    ['stars' => 2, 'count' => 45],
                    ['stars' => 1, 'count' => 12],
                ]
            ]
        ];

        $pendingApplications = [
            [
                'id' => 'APP-2547',
                'name' => 'Warung Sedap Malam',
                'category' => 'Kuliner',
                'date' => '2 jam lalu',
                'completeness' => 95,
                'priority' => 'TINGGI',
                'status' => 'Review'
            ],
            [
                'id' => 'APP-2546',
                'name' => 'Konveksi Makmur',
                'category' => 'Fashion',
                'date' => '4 jam lalu',
                'completeness' => 100,
                'priority' => 'TINGGI',
                'status' => 'Review'
            ],
            [
                'id' => 'APP-2545',
                'name' => 'Bengkel Motor Jaya',
                'category' => 'Otomotif',
                'date' => '5 jam lalu',
                'completeness' => 88,
                'priority' => 'NORMAL',
                'status' => 'Pending'
            ],
            [
                'id' => 'APP-2544',
                'name' => 'Toko Kue Bunda',
                'category' => 'Kuliner',
                'date' => '1 hari lalu',
                'completeness' => 92,
                'priority' => 'NORMAL',
                'status' => 'Tinggi'
            ],
            [
                'id' => 'APP-2543',
                'name' => 'Laundry Express 24',
                'category' => 'Jasa',
                'date' => '1 hari lalu',
                'completeness' => 100,
                'priority' => 'TINGGI',
                'status' => 'Review'
            ],
            [
                'id' => 'APP-2542',
                'name' => 'Sablon Kilat',
                'category' => 'Printing',
                'date' => '2 hari lalu',
                'completeness' => 78,
                'priority' => 'RENDAH',
                'status' => 'Review'
            ],
        ];

        $recentUMKM = [
            ['name' => 'Warung Pak Budi', 'category' => 'Kuliner - Catering', 'time' => '5 menit lalu'],
            ['name' => 'Fashion Butik Elegan', 'category' => 'Fashion', 'time' => '15 menit lalu'],
            ['name' => 'Bengkel Express', 'category' => 'Otomotif - Servis', 'time' => '1 jam lalu'],
            ['name' => 'Catering Nusantara', 'category' => 'Kuliner', 'time' => '2 hari lalu'],
            ['name' => 'Printing Pro', 'category' => 'Printing - Percetakan', 'time' => '3 hari lalu'],
        ];
    @endphp

    <div class="min-h-screen">
        <!-- Navbar - Superadmin Style -->
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
            :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-sm text-gray-900' : 'bg-white text-gray-900'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-[#e5e5e5]"
        >
            <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo & Brand -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#064E3B] rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="3" y1="9" x2="21" y2="9"></line>
                                    <line x1="9" y1="21" x2="9" y2="9"></line>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold text-gray-900" style="font-family: 'Figtree', sans-serif;">Superadmin Portal</h1>
                                <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">UMKM Management</p>
                            </div>
                        </div>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:block flex-1 max-w-md mx-8">
                        <div class="relative">
                            <input 
                                type="text" 
                                placeholder="Search UMKMs, users, orders..."
                                class="w-full px-4 py-2.5 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] focus:border-transparent text-sm"
                                style="font-family: 'Figtree', sans-serif;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Right Actions -->
                    <div class="hidden md:flex items-center gap-4">
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <div class="flex items-center gap-3 pl-4 border-l border-[#e5e5e5]">
                            <div class="w-9 h-9 rounded-full bg-[#167E6C] flex items-center justify-center">
                                <span class="text-white font-semibold text-sm" style="font-family: 'Figtree', sans-serif;">A</span>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-semibold text-gray-900" style="font-family: 'Figtree', sans-serif;">{{ $user['name'] }}</div>
                                <div class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $user['role'] }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>

                    <div class="md:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                                class="text-gray-900 hover:text-[#167E6C] p-2 rounded-md transition-colors duration-200">
                            <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Secondary Navigation -->
                <div class="hidden md:flex items-center gap-6 pb-4 border-b border-[#e5e5e5]">
                    @foreach($navigationLinks as $link)
                    <a href="{{ $link['href'] }}" 
                       class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ isset($link['active']) && $link['active'] ? 'text-[#167E6C]' : 'text-gray-900 hover:text-[#167E6C]' }}" 
                       style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                        <span>{{ $link['name'] }}</span>
                        @if(isset($link['badge']))
                        <span class="px-2 py-0.5 bg-[#064E3B] text-white text-xs font-semibold rounded-full">{{ $link['badge'] }}</span>
                        @endif
                        <div class="absolute bottom-0 left-0 {{ isset($link['active']) && $link['active'] ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-32">
            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-[32px] leading-tight font-normal text-[#064E3B] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Dashboard UMKM Management</h1>
                            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Monitor dan kelola semua mitra bisnis Anda</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                </svg>
                                Refresh
                            </button>
                            <select class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium" style="font-family: 'Figtree', sans-serif;">
                                <option>7 Hari Terakhir</option>
                                <option>30 Hari Terakhir</option>
                                <option>90 Hari Terakhir</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#167E6C]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                        @foreach($stats as $stat)
                        <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] hover:shadow-md transition-all duration-300 {{ isset($stat['highlight']) && $stat['highlight'] ? 'bg-[#064E3B] text-white border-[#064E3B]' : '' }}">
                            <p class="text-xs uppercase tracking-wide mb-3 {{ isset($stat['highlight']) && $stat['highlight'] ? 'text-white/80' : 'text-[#999999]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['title'] }}</p>
                            
                            @if(isset($stat['rating']) && $stat['rating'])
                            <div class="text-4xl font-bold mb-4 text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                            <div class="space-y-2">
                                @foreach($stat['ratingBars'] as $bar)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-[#666666] w-3" style="font-family: 'Figtree', sans-serif;">{{ $bar['stars'] }}</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#F59E0B] rounded-full" style="width: {{ ($bar['count'] / 1528) * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs text-[#666666] w-8 text-right" style="font-family: 'Figtree', sans-serif;">{{ $bar['count'] }}</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-4xl font-bold mb-4 {{ isset($stat['highlight']) && $stat['highlight'] ? 'text-white' : 'text-[#064E3B]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                            
                            <div class="space-y-2 mb-4">
                                @foreach($stat['details'] as $detail)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="{{ isset($stat['highlight']) && $stat['highlight'] ? 'text-white/70' : 'text-[#666666]' }}" style="font-family: 'Figtree', sans-serif;">{{ $detail['label'] }}</span>
                                    <span class="{{ isset($stat['highlight']) && $stat['highlight'] ? 'text-white font-semibold' : 'text-[#064E3B] font-semibold' }}" style="font-family: 'Figtree', sans-serif;">{{ $detail['value'] }}</span>
                                </div>
                                @endforeach
                            </div>

                            @if(isset($stat['action']))
                            <button class="w-full bg-white text-[#064E3B] px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-100 transition-all duration-200" style="font-family: 'Figtree', sans-serif;">
                                {{ $stat['action'] }}
                            </button>
                            @endif

                            @if(isset($stat['change']))
                            <div class="pt-3 border-t {{ isset($stat['highlight']) && $stat['highlight'] ? 'border-white/20' : 'border-[#e5e5e5]' }}">
                                <p class="text-xs {{ isset($stat['highlight']) && $stat['highlight'] ? 'text-white/70' : 'text-[#666666]' }}" style="font-family: 'Figtree', sans-serif;">
                                    <span class="{{ strpos($stat['change'], '+') !== false ? 'text-green-600' : 'text-red-600' }} font-semibold">{{ $stat['change'] }}</span> {{ $stat['changeLabel'] }}
                                </p>
                            </div>
                            @endif
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Pending Applications Table -->
                    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-semibold text-[#064E3B] mb-1" style="font-family: 'Figtree', sans-serif;">Pending UMKM Applications</h2>
                                <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">
                                    <span class="font-semibold text-[#064E3B]">127</span> aplikasi menunggu review • 
                                    <span class="text-[#F59E0B] font-semibold">15 PRIORITY TINGGI</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        placeholder="Cari nama atau kategori..."
                                        class="px-4 py-2 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </div>
                                <button class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    Filter
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e5e5e5]">
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ID Aplikasi</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Nama Bisnis</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Kategori</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Tanggal Apply</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Kelengkapan</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Prioritas</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingApplications as $app)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-mono text-[#999999]" style="font-family: 'Geist Mono', monospace;">{{ $app['id'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $app['name'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $app['category'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $app['date'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden max-w-[100px]">
                                                    <div class="h-full bg-[#167E6C] rounded-full" style="width: {{ $app['completeness'] }}%"></div>
                                                </div>
                                                <span class="text-xs font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $app['completeness'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $app['priority'] === 'TINGGI' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ $app['priority'] === 'NORMAL' ? 'bg-gray-100 text-gray-700' : '' }}
                                                {{ $app['priority'] === 'RENDAH' ? 'bg-blue-100 text-blue-700' : '' }}"
                                                style="font-family: 'Figtree', sans-serif;">
                                                {{ $app['priority'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <button class="px-4 py-2 bg-[#064E3B] text-white rounded-lg text-xs font-semibold hover:bg-[#167E6C] transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    {{ $app['status'] }}
                                                </button>
                                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                </button>
                                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#666666]">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between">
                            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Menampilkan 1-6 dari 127 +</p>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 bg-[#064E3B] text-white rounded-lg text-sm font-semibold">1</button>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">2</button>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">3</button>
                                <span class="px-2 text-[#999999]">...</span>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid: Recent UMKM & Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- UMKM Terbaru Onboard -->
                        <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">UMKM Terbaru Onboard</h3>
                            </div>
                            <div class="space-y-4">
                                @foreach($recentUMKM as $umkm)
                                <div class="flex items-start justify-between py-3 border-b border-[#e5e5e5] last:border-b-0">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-[#064E3B] mb-1" style="font-family: 'Figtree', sans-serif;">{{ $umkm['name'] }}</h4>
                                        <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['category'] }}</p>
                                        <p class="text-xs text-[#999999] mt-1" style="font-family: 'Figtree', sans-serif;">{{ $umkm['time'] }}</p>
                                    </div>
                                    <button class="text-xs text-[#167E6C] font-semibold hover:text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">Lihat</button>
                                </div>
                                @endforeach
                            </div>
                            <button class="w-full mt-4 text-sm text-[#167E6C] hover:text-[#064E3B] font-medium transition-colors flex items-center justify-center gap-1" style="font-family: 'Figtree', sans-serif;">
                                Lihat Semua Terbaru →
                            </button>
                        </div>

                        <!-- Placeholder Charts -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-lg font-semibold text-[#064E3B] mb-4" style="font-family: 'Figtree', sans-serif;">Pertumbuhan UMKM</h3>
                                <div class="h-64 bg-gradient-to-br from-[#167E6C]/5 to-[#064E3B]/5 rounded-xl flex items-center justify-center">
                                    <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Chart: Pertumbuhan UMKM per Bulan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
            <div class="max-w-[1400px] mx-auto px-8 py-8">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">&copy; {{ date('Y') }} UMKM Connect. All rights reserved.</p>
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Superadmin Portal v1.0</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
