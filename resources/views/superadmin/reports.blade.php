<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laporan & Analytics - {{ config('app.name', 'Laravel') }}</title>

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
            ['name' => 'Dashboard', 'href' => route('superadmin.dashboard.preview')],
            ['name' => 'UMKM Management', 'href' => '#', 'badge' => 127],
            ['name' => 'Pengguna', 'href' => route('superadmin.users.preview')],
            ['name' => 'Transaksi', 'href' => route('superadmin.transactions.preview')],
            ['name' => 'Laporan', 'href' => '#', 'active' => true],
            ['name' => 'Pengaturan', 'href' => route('superadmin.settings.preview')],
        ];

        $topUMKMs = [
            ['rank' => 1, 'name' => 'BWP Cleaning', 'revenue' => 'Rp 35,400,000', 'orders' => 267],
            ['rank' => 2, 'name' => 'Express Laundry', 'revenue' => 'Rp 32,800,000', 'orders' => 245],
            ['rank' => 3, 'name' => 'Warung Sedap Malam', 'revenue' => 'Rp 30,200,000', 'orders' => 893],
            ['rank' => 4, 'name' => 'Tukang Kebun Pro', 'revenue' => 'Rp 8,900,000', 'orders' => 178],
            ['rank' => 5, 'name' => 'Service AC Jakarta', 'revenue' => 'Rp 7,650,000', 'orders' => 145],
            ['rank' => 6, 'name' => 'Catering Nusantara', 'revenue' => 'Rp 6,300,000', 'orders' => 234],
            ['rank' => 7, 'name' => 'Beauty Express 24', 'revenue' => 'Rp 5,800,000', 'orders' => 189],
            ['rank' => 8, 'name' => 'Cleaning Service Pro', 'revenue' => 'Rp 4,900,000', 'orders' => 156],
            ['rank' => 9, 'name' => 'Tukang Listrik Ahli', 'revenue' => 'Rp 4,200,000', 'orders' => 87],
            ['rank' => 10, 'name' => 'Bengkel Motor Cepat', 'revenue' => 'Rp 3,750,000', 'orders' => 134],
        ];

        $scheduledReports = [
            [
                'name' => 'Weekly Revenue Report',
                'frequency' => 'Every Monday, 9:00 AM',
                'next_run' => '27 Jan 2026, 09:00',
                'format' => 'PDF'
            ],
            [
                'name' => 'Monthly UMKM Performance',
                'frequency' => 'First day of month, 10:00 AM',
                'next_run' => '01 Feb 2026, 10:00',
                'format' => 'Excel'
            ],
            [
                'name' => 'Daily Transaction Summary',
                'frequency' => 'Every day, 23:00',
                'next_run' => '21 Jan 2026, 23:00',
                'format' => 'CSV'
            ],
            [
                'name' => 'Quarterly Analytics Report',
                'frequency' => 'Every 3 months, 1st day, 09:00',
                'next_run' => '01 Apr 2026, 09:00',
                'format' => 'PDF'
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
                        <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Laporan & Analytics</span>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                    <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Laporan & Analytics</h1>
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Analisis performa platform dan generate laporan</p>
                </div>
            </div>

            <!-- Content -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    <!-- Analytics Overview -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Analytics Overview</h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Revenue Trend Chart -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Revenue Trend (Last 30 Days)</h3>
                                <div class="h-64 bg-gradient-to-br from-[#0078b7]/5 to-[#003d5c]/5 rounded-xl flex items-center justify-center">
                                    <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Chart: Line chart showing revenue trend</p>
                                </div>
                            </div>

                            <!-- Order Volume Chart -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Order Volume (Last 30 Days)</h3>
                                <div class="h-64 bg-gradient-to-br from-[#0078b7]/5 to-[#003d5c]/5 rounded-xl flex items-center justify-center">
                                    <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Chart: Bar chart showing order volume</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Top UMKMs by Revenue -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Top 10 UMKMs by Revenue</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-[#e5e5e5]">
                                                <th class="text-left py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">RANK</th>
                                                <th class="text-left py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">UMKM NAME</th>
                                                <th class="text-right py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">REVENUE</th>
                                                <th class="text-right py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">ORDERS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topUMKMs as $umkm)
                                            <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                                <td class="py-3 px-2">
                                                    <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['rank'] }}</span>
                                                </td>
                                                <td class="py-3 px-2">
                                                    <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['name'] }}</span>
                                                </td>
                                                <td class="py-3 px-2 text-right">
                                                    <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['revenue'] }}</span>
                                                </td>
                                                <td class="py-3 px-2 text-right">
                                                    <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['orders'] }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Top Service Categories -->
                            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                                <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Top Service Categories</h3>
                                <div class="h-80 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-64 h-64 bg-gradient-to-br from-[#0078b7]/10 to-[#003d5c]/10 rounded-full flex items-center justify-center mb-4">
                                            <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Pie Chart</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-[#003d5c] rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Cleaning (28%)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-[#0078b7] rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Laundry (23%)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-gray-400 rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Catering (18%)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-gray-300 rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Repair (15%)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-gray-200 rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Garden (10%)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 bg-gray-100 rounded-sm"></div>
                                                <span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Others (6%)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Generator -->
                    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] mb-8">
                        <h2 class="text-xl font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Report Generator</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Report Type -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">REPORT TYPE</label>
                                    <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                        <option>Revenue Report</option>
                                        <option>Transaction Report</option>
                                        <option>UMKM Performance</option>
                                        <option>Customer Analytics</option>
                                        <option>Commission Report</option>
                                    </select>
                                </div>

                                <!-- Custom Date From -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">CUSTOM DATE FROM</label>
                                    <input 
                                        type="text" 
                                        placeholder="DD/MM/YYYY"
                                        class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                </div>

                                <!-- Filter by UMKM -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">FILTER BY UMKM</label>
                                    <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                        <option>All UMKMs</option>
                                        <option>BWP Cleaning</option>
                                        <option>Express Laundry</option>
                                        <option>Warung Sedap Malam</option>
                                    </select>
                                </div>

                                <!-- Filter by Status -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">FILTER BY STATUS</label>
                                    <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                        <option>All Status</option>
                                        <option>Success</option>
                                        <option>Pending</option>
                                        <option>Failed</option>
                                        <option>Refunded</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Date Range Preset -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">DATE RANGE PRESET</label>
                                    <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                        <option>Last 30 Days</option>
                                        <option>Last 7 Days</option>
                                        <option>Last 90 Days</option>
                                        <option>This Month</option>
                                        <option>Last Month</option>
                                        <option>This Year</option>
                                        <option>Custom Range</option>
                                    </select>
                                </div>

                                <!-- Custom Date To -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">CUSTOM DATE TO</label>
                                    <input 
                                        type="text" 
                                        placeholder="DD/MM/YYYY"
                                        class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                </div>

                                <!-- Filter by Category -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">FILTER BY CATEGORY</label>
                                    <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                        <option>All Categories</option>
                                        <option>Cleaning</option>
                                        <option>Laundry</option>
                                        <option>Catering</option>
                                        <option>Repair</option>
                                    </select>
                                </div>

                                <!-- Output Format -->
                                <div>
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">OUTPUT FORMAT</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="format" value="pdf" checked class="w-4 h-4 text-[#0078b7] focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">PDF</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="format" value="excel" class="w-4 h-4 text-[#0078b7] focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Excel</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="format" value="csv" class="w-4 h-4 text-[#0078b7] focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">CSV</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Button -->
                        <div class="mt-8 flex justify-end">
                            <button class="px-8 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Generate Report
                            </button>
                        </div>
                    </div>

                    <!-- Scheduled Reports -->
                    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5]">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Scheduled Reports</h2>
                            <button class="px-4 py-2 bg-[#003d5c] text-white rounded-lg hover:bg-[#0078b7] transition-colors font-semibold text-sm flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add New Schedule
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e5e5e5]">
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">REPORT NAME</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">FREQUENCY</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">NEXT RUN</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">FORMAT</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scheduledReports as $report)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $report['name'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $report['frequency'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $report['next_run'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700" style="font-family: 'Figtree', sans-serif;">{{ $report['format'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    Edit
                                                </button>
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors text-red-600" style="font-family: 'Figtree', sans-serif;">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
