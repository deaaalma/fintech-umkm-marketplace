<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manajemen Pengguna - {{ config('app.name', 'Laravel') }}</title>

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
            ['name' => 'Pengguna', 'href' => '#', 'active' => true],
            ['name' => 'Transaksi', 'href' => route('superadmin.transactions.preview')],
            ['name' => 'Laporan', 'href' => route('superadmin.reports.preview')],
            ['name' => 'Pengaturan', 'href' => route('superadmin.settings.preview')],
        ];

        $stats = [
            ['title' => 'TOTAL PENGGUNA', 'value' => '1,247 users'],
            ['title' => 'CUSTOMER', 'value' => '1,150'],
            ['title' => 'UMKM ADMIN', 'value' => '85'],
            ['title' => 'STAFF', 'value' => '12'],
        ];

        $users = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@email.com',
                'phone' => '08123456789',
                'role' => 'Customer',
                'status' => 'ACTIVE',
                'date' => '15 Jan 2026'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nur@email.com',
                'phone' => '08234567890',
                'role' => 'Customer',
                'status' => 'ACTIVE',
                'date' => '20 Jan 2026'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@bwpcleaning.com',
                'phone' => '08111222333',
                'role' => 'UMKM Admin',
                'status' => 'ACTIVE',
                'date' => '05 Jan 2026'
            ],
            [
                'name' => 'Rina Wijaya',
                'email' => 'rina.wj@email.com',
                'phone' => '08345678901',
                'role' => 'Customer',
                'status' => 'SUSPENDED',
                'date' => '12 Jan 2026'
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi@expresslaundry.com',
                'phone' => '08222333444',
                'role' => 'UMKM Admin',
                'status' => 'ACTIVE',
                'date' => '18 Jan 2026'
            ],
            [
                'name' => 'Linda Kusuma',
                'email' => 'linda.k@email.com',
                'phone' => '08456789012',
                'role' => 'Staff',
                'status' => 'ACTIVE',
                'date' => '01 Jan 2026'
            ],
            [
                'name' => 'Agus Pratama',
                'email' => 'agus.p@email.com',
                'phone' => '08567890123',
                'role' => 'Customer',
                'status' => 'ACTIVE',
                'date' => '25 Dec 2025'
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya@bwpcleaning.com',
                'phone' => '08333444555',
                'role' => 'Staff',
                'status' => 'ACTIVE',
                'date' => '22 Dec 2025'
            ],
        ];
    @endphp

    <div class="min-h-screen">
        <!-- Navbar - Same as Superadmin Dashboard -->
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
            <!-- Breadcrumb -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-4">
                    <div class="flex items-center gap-2 text-sm">
                        <a href="{{ route('superadmin.dashboard.preview') }}" class="text-[#666666] hover:text-[#167E6C] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                        <span class="text-[#064E3B] font-medium" style="font-family: 'Figtree', sans-serif;">Manajemen Pengguna</span>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                    <h1 class="text-[32px] leading-tight font-normal text-[#064E3B] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Manajemen Pengguna</h1>
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Kelola seluruh pengguna platform</p>
                </div>
            </div>

            <!-- Stats & Content -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#167E6C]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        @foreach($stats as $stat)
                        <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                            <p class="text-xs uppercase tracking-wide mb-2 text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $stat['title'] }}</p>
                            <div class="text-3xl font-bold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Filters & Search -->
                    <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-4">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        placeholder="Cari nama, email, phone..."
                                        class="w-full px-4 py-3 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] focus:border-transparent text-sm"
                                        style="font-family: 'Figtree', sans-serif;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Role Filter -->
                            <div class="md:col-span-2">
                                <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] text-sm" style="font-family: 'Figtree', sans-serif;">
                                    <option value="">ROLE</option>
                                    <option>Customer</option>
                                    <option>UMKM Admin</option>
                                    <option>Staff</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="md:col-span-2">
                                <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] text-sm" style="font-family: 'Figtree', sans-serif;">
                                    <option value="">STATUS</option>
                                    <option>Active</option>
                                    <option>Suspended</option>
                                    <option>Inactive</option>
                                </select>
                            </div>

                            <!-- Date Filter -->
                            <div class="md:col-span-3">
                                <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#167E6C] text-sm" style="font-family: 'Figtree', sans-serif;">
                                    <option value="">TANGGAL DAFTAR</option>
                                    <option>Hari Ini</option>
                                    <option>7 Hari Terakhir</option>
                                    <option>30 Hari Terakhir</option>
                                    <option>Custom Range</option>
                                </select>
                            </div>

                            <!-- Clear Filter -->
                            <div class="md:col-span-1">
                                <button class="w-full px-4 py-3 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium" style="font-family: 'Figtree', sans-serif;">
                                    Clear Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5]">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e5e5e5]">
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">NAMA</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">EMAIL</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">PHONE</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ROLE</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">STATUS</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">TANGGAL DAFTAR</th>
                                        <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $userData)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <span class="text-sm font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $userData['name'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['email'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['phone'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $userData['role'] === 'Customer' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $userData['role'] === 'UMKM Admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                                {{ $userData['role'] === 'Staff' ? 'bg-green-100 text-green-700' : '' }}"
                                                style="font-family: 'Figtree', sans-serif;">
                                                {{ $userData['role'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $userData['status'] === 'ACTIVE' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $userData['status'] === 'SUSPENDED' ? 'bg-red-100 text-red-700' : '' }}"
                                                style="font-family: 'Figtree', sans-serif;">
                                                {{ $userData['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['date'] }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    View Details
                                                </button>
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    {{ $userData['status'] === 'ACTIVE' ? 'Suspend' : 'Activate' }}
                                                </button>
                                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                    Reset Password
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
                            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Showing 1-25 of 1,247 • Page size:</p>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1.5 bg-[#064E3B] text-white rounded-lg text-sm font-semibold">1</button>
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
