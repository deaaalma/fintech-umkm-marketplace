<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Monitoring Transaksi - {{ config('app.name', 'Laravel') }}</title>

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
<body class="font-sans antialiased bg-white text-foreground" x-data="{ activeTab: 'all' }">
    @php
        $user = [
            'name' => 'Admin',
            'role' => 'Superadmin'
        ];

        $navigationLinks = [
            ['name' => 'Dashboard', 'href' => route('superadmin.dashboard.preview')],
            ['name' => 'UMKM Management', 'href' => '#', 'badge' => 127],
            ['name' => 'Pengguna', 'href' => route('superadmin.users.preview')],
            ['name' => 'Transaksi', 'href' => '#', 'active' => true],
            ['name' => 'Laporan', 'href' => route('superadmin.reports.preview')],
            ['name' => 'Pengaturan', 'href' => route('superadmin.settings.preview')],
        ];

        $stats = [
            ['title' => 'TOTAL GMV', 'value' => 'Rp 125.8M', 'subtitle' => '+12.5% from last month'],
            ['title' => 'PLATFORM COMMISSION', 'value' => 'Rp 12.58M', 'subtitle' => '10% of GMV'],
            ['title' => 'PENDING PAYOUTS', 'value' => 'Rp 8.5M', 'subtitle' => '15 UMKMs waiting'],
            ['title' => 'TOTAL REFUNDS', 'value' => 'Rp 2.3M', 'subtitle' => '47 refund requests'],
        ];

        $transactions = [
            [
                'id' => 'TRX-2026-01-21-001',
                'date' => '21 Jan 2026',
                'time' => '14:35',
                'order_id' => 'ORD-001',
                'umkm' => 'BWP Cleaning',
                'customer' => 'Ahmad Fauzi',
                'amount' => 'Rp 500,000',
                'commission' => 'Rp 50,000',
                'payment' => 'Transfer Bank',
                'status' => 'SUCCESS'
            ],
            [
                'id' => 'TRX-2026-01-21-002',
                'date' => '21 Jan 2026',
                'time' => '13:20',
                'order_id' => 'ORD-002',
                'umkm' => 'Express Laundry',
                'customer' => 'Siti Nurhaliza',
                'amount' => 'Rp 150,000',
                'commission' => 'Rp 15,000',
                'payment' => 'E-Wallet',
                'status' => 'SUCCESS'
            ],
            [
                'id' => 'TRX-2026-01-21-003',
                'date' => '21 Jan 2026',
                'time' => '12:10',
                'order_id' => 'ORD-003',
                'umkm' => 'Warung Sedap Malam',
                'customer' => 'Budi Santoso',
                'amount' => 'Rp 75,000',
                'commission' => 'Rp 7,500',
                'payment' => 'Cash',
                'status' => 'PENDING'
            ],
            [
                'id' => 'TRX-2026-01-21-004',
                'date' => '21 Jan 2026',
                'time' => '11:45',
                'order_id' => 'ORD-004',
                'umkm' => 'Tukang Kebun Pro',
                'customer' => 'Rina Wijaya',
                'amount' => 'Rp 300,000',
                'commission' => 'Rp 30,000',
                'payment' => 'Transfer Bank',
                'status' => 'SUCCESS'
            ],
            [
                'id' => 'TRX-2026-01-21-005',
                'date' => '21 Jan 2026',
                'time' => '10:30',
                'order_id' => 'ORD-005',
                'umkm' => 'Service AC Jakarta',
                'customer' => 'Dedi Kurniawan',
                'amount' => 'Rp 450,000',
                'commission' => 'Rp 45,000',
                'payment' => 'Transfer Bank',
                'status' => 'REFUNDED'
            ],
            [
                'id' => 'TRX-2026-01-21-006',
                'date' => '21 Jan 2026',
                'time' => '09:15',
                'order_id' => 'ORD-006',
                'umkm' => 'BWP Cleaning',
                'customer' => 'Linda Kusuma',
                'amount' => 'Rp 250,000',
                'commission' => 'Rp 25,000',
                'payment' => 'E-Wallet',
                'status' => 'SUCCESS'
            ],
            [
                'id' => 'TRX-2026-01-20-007',
                'date' => '20 Jan 2026',
                'time' => '16:20',
                'order_id' => 'ORD-007',
                'umkm' => 'Express Laundry',
                'customer' => 'Agus Pratama',
                'amount' => 'Rp 120,000',
                'commission' => 'Rp 12,000',
                'payment' => 'E-Wallet',
                'status' => 'FAILED'
            ],
            [
                'id' => 'TRX-2026-01-20-008',
                'date' => '20 Jan 2026',
                'time' => '15:05',
                'order_id' => 'ORD-008',
                'umkm' => 'Warung Sedap Malam',
                'customer' => 'Maya Sari',
                'amount' => 'Rp 85,000',
                'commission' => 'Rp 8,500',
                'payment' => 'Cash',
                'status' => 'SUCCESS'
            ],
        ];
    @endphp

    <div class="min-h-screen">
        <!-- Navbar - Same as Superadmin -->
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
                            <div class="w-10 h-10 bg-[#003d5c] rounded-xl flex items-center justify-center">
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
                                class="w-full px-4 py-2.5 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent text-sm"
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
                            <div class="w-9 h-9 rounded-full bg-[#0078b7] flex items-center justify-center">
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
                                class="text-gray-900 hover:text-[#0078b7] p-2 rounded-md transition-colors duration-200">
                            <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Secondary Navigation -->
                <div class="hidden md:flex items-center gap-6 pb-4 border-b border-[#e5e5e5]">
                    @foreach($navigationLinks as $link)
                    <a href="{{ $link['href'] }}" 
                       class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ isset($link['active']) && $link['active'] ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                       style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                        <span>{{ $link['name'] }}</span>
                        @if(isset($link['badge']))
                        <span class="px-2 py-0.5 bg-[#003d5c] text-white text-xs font-semibold rounded-full">{{ $link['badge'] }}</span>
                        @endif
                        <div class="absolute bottom-0 left-0 {{ isset($link['active']) && $link['active'] ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-32">
            <!-- Breadcrumb -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-4">
                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('superadmin.dashboard.preview') }}" class="text-[#666666] hover:text-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                        <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Monitoring Transaksi</span>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Monitoring Transaksi</h1>
                            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Monitor dan kelola semua transaksi platform</p>
                        </div>
                        <button class="px-6 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                            Process UMKM Payouts
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats & Content -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        @foreach($stats as $stat)
                        <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                            <p class="text-xs uppercase tracking-wide mb-2 text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $stat['title'] }}</p>
                            <div class="text-3xl font-bold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                            <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $stat['subtitle'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Tabs -->
                    <div class="bg-white rounded-t-3xl border border-[#e5e5e5] border-b-0">
                        <div class="flex items-center gap-6 px-8 pt-6 border-b border-[#e5e5e5]">
                            <button 
                                @click="activeTab = 'all'"
                                :class="activeTab === 'all' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                All Transactions
                            </button>
                            <button 
                                @click="activeTab = 'payments'"
                                :class="activeTab === 'payments' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Payments
                            </button>
                            <button 
                                @click="activeTab = 'payouts'"
                                :class="activeTab === 'payouts' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Payouts
                            </button>
                            <button 
                                @click="activeTab = 'refunds'"
                                :class="activeTab === 'refunds' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Refunds
                            </button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white border border-[#e5e5e5] border-t-0 p-6">
                        <div class="mb-6">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    placeholder="Search by Transaction ID, Order ID, or UMKM..."
                                    class="w-full px-4 py-3 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent text-sm"
                                    style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Status Filter -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">STATUS</label>
                                <select class="w-full px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                    <option value="">All</option>
                                    <option>Success</option>
                                    <option>Pending</option>
                                    <option>Failed</option>
                                    <option>Refunded</option>
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">DATE RANGE</label>
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        placeholder="From: DD/MM/YYYY"
                                        class="flex-1 px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                    <input 
                                        type="text" 
                                        placeholder="To: DD/MM/YYYY"
                                        class="flex-1 px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">PAYMENT METHOD</label>
                                <select class="w-full px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                    <option value="">All</option>
                                    <option>Transfer Bank</option>
                                    <option>E-Wallet</option>
                                    <option>Cash</option>
                                    <option>Credit Card</option>
                                </select>
                            </div>

                            <!-- Amount Range -->
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">AMOUNT RANGE</label>
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        placeholder="Min"
                                        class="flex-1 px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                    <input 
                                        type="text" 
                                        placeholder="Max"
                                        class="flex-1 px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                </div>
                            </div>

                            <!-- Clear Filter -->
                            <div class="md:col-span-1 flex items-end">
                                <button class="w-full px-4 py-2.5 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium" style="font-family: 'Figtree', sans-serif;">
                                    Clear Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="bg-white rounded-b-3xl border border-[#e5e5e5] border-t-0 p-8">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e5e5e5]">
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">TRANSACTION ID</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">DATE & TIME</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ORDER ID</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">UMKM</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">CUSTOMER</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">AMOUNT</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">COMMISSION</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">PAYMENT</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">STATUS</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $trx)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-mono text-[#003d5c] font-semibold" style="font-family: 'Geist Mono', monospace;">{{ $trx['id'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $trx['date'] }}</div>
                                            <div class="text-xs text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $trx['time'] }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-mono text-[#666666]" style="font-family: 'Geist Mono', monospace;">{{ $trx['order_id'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $trx['umkm'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $trx['customer'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $trx['amount'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $trx['commission'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 rounded-md text-xs font-medium
                                                {{ $trx['payment'] === 'Transfer Bank' ? 'bg-blue-50 text-blue-700' : '' }}
                                                {{ $trx['payment'] === 'E-Wallet' ? 'bg-purple-50 text-purple-700' : '' }}
                                                {{ $trx['payment'] === 'Cash' ? 'bg-gray-100 text-gray-700' : '' }}"
                                                style="font-family: 'Figtree', sans-serif;">
                                                {{ $trx['payment'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $trx['status'] === 'SUCCESS' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $trx['status'] === 'PENDING' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $trx['status'] === 'FAILED' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ $trx['status'] === 'REFUNDED' ? 'bg-gray-100 text-gray-700' : '' }}"
                                                style="font-family: 'Figtree', sans-serif;">
                                                {{ $trx['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    View
                                                </button>
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    Receipt
                                                </button>
                                                @if($trx['status'] === 'PENDING' || $trx['status'] === 'FAILED')
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    Refund
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between">
                            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Showing 1-25 of 1,247 • Page size:</p>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1.5 bg-[#003d5c] text-white rounded-lg text-sm font-semibold">1</button>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">2</button>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">3</button>
                                <span class="px-2 text-[#999999]">...</span>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">50</button>
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Next</button>
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
