<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pengaturan Platform - {{ config('app.name', 'Laravel') }}</title>

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
<body class="font-sans antialiased bg-white text-foreground" x-data="{ activeTab: 'umum', maintenanceMode: false }">
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
            ['name' => 'Laporan', 'href' => route('superadmin.reports.preview')],
            ['name' => 'Pengaturan', 'href' => '#', 'active' => true],
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
                        <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Pengaturan Platform</span>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="w-full bg-white border-b border-[#e5e5e5]">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                    <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Pengaturan Platform</h1>
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Konfigurasi dan pengaturan sistem platform UMKM</p>
                </div>
            </div>

            <!-- Content -->
            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    <!-- Tabs -->
                    <div class="bg-white rounded-t-3xl border border-[#e5e5e5] border-b-0">
                        <div class="flex items-center gap-6 px-8 pt-6 border-b border-[#e5e5e5]">
                            <button 
                                @click="activeTab = 'umum'"
                                :class="activeTab === 'umum' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Umum
                            </button>
                            <button 
                                @click="activeTab = 'komisi'"
                                :class="activeTab === 'komisi' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Komisi
                            </button>
                            <button 
                                @click="activeTab = 'payment'"
                                :class="activeTab === 'payment' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Payment
                            </button>
                            <button 
                                @click="activeTab = 'email'"
                                :class="activeTab === 'email' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Email
                            </button>
                            <button 
                                @click="activeTab = 'lainnya'"
                                :class="activeTab === 'lainnya' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                                class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200"
                                style="font-family: 'Figtree', sans-serif;">
                                Lainnya
                            </button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="bg-white rounded-b-3xl border border-[#e5e5e5] border-t-0 p-8">
                        <!-- Umum Tab -->
                        <div x-show="activeTab === 'umum'" class="space-y-8">
                            <!-- Platform Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Platform Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Platform Name -->
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">PLATFORM NAME</label>
                                        <input 
                                            type="text" 
                                            value="UMKM Connect"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>

                                    <!-- Tagline -->
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">TAGLINE</label>
                                        <input 
                                            type="text" 
                                            value="Connecting customers with local services"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                </div>

                                <!-- Platform Logo -->
                                <div class="mt-6">
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">PLATFORM LOGO</label>
                                    <div class="flex items-center gap-4">
                                        <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center border border-[#e5e5e5]">
                                            <span class="text-xs text-[#999999]" style="font-family: 'Figtree', sans-serif;">Logo Preview<br>120x120</span>
                                        </div>
                                        <div>
                                            <button class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium mb-2" style="font-family: 'Figtree', sans-serif;">
                                                Upload New Logo
                                            </button>
                                            <p class="text-xs text-[#999999]" style="font-family: 'Figtree', sans-serif;">Recommended: PNG or SVG, max 500KB, 512x512 pixels</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Regional Settings -->
                            <div class="pt-8 border-t border-[#e5e5e5]">
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Regional Settings</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Timezone -->
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">TIMEZONE</label>
                                        <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                            <option>Asia/Jakarta (GMT+7)</option>
                                            <option>Asia/Makassar (GMT+8)</option>
                                            <option>Asia/Jayapura (GMT+9)</option>
                                        </select>
                                    </div>

                                    <!-- Currency -->
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">CURRENCY</label>
                                        <select class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                                            <option>IDR (Indonesian Rupiah)</option>
                                            <option>USD (US Dollar)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Hours -->
                            <div class="pt-8 border-t border-[#e5e5e5]">
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Business Hours</h3>
                                
                                <!-- Operating Days -->
                                <div class="mb-6">
                                    <label class="block text-xs font-semibold text-[#999999] uppercase mb-3" style="font-family: 'Figtree', sans-serif;">OPERATING DAYS</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Monday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Tuesday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Wednesday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Thursday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" checked class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Friday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Saturday</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" class="w-4 h-4 text-[#0078b7] rounded focus:ring-[#0078b7]">
                                            <span class="text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Sunday</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Opening & Closing Time -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">OPENING TIME</label>
                                        <input 
                                            type="text" 
                                            value="09:00"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">CLOSING TIME</label>
                                        <input 
                                            type="text" 
                                            value="18:00"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                </div>
                            </div>

                            <!-- Maintenance Mode -->
                            <div class="pt-8 border-t border-[#e5e5e5]">
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Maintenance Mode</h3>
                                
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                    <div>
                                        <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable Maintenance Mode</p>
                                        <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Platform akan ditutup sementara untuk maintenance</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" x-model="maintenanceMode" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                    </label>
                                </div>
                                <p class="text-xs text-[#999999] mt-2" style="font-family: 'Figtree', sans-serif;">Status: <span x-text="maintenanceMode ? 'Enabled' : 'Disabled'" :class="maintenanceMode ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold'"></span></p>
                            </div>
                        </div>

                        <!-- Komisi Tab -->
                        <div x-show="activeTab === 'komisi'" class="space-y-8" x-cloak>
                            <div>
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Commission Settings</h3>
                                <p class="text-sm text-[#666666] mb-6" style="font-family: 'Figtree', sans-serif;">Atur persentase komisi platform untuk setiap transaksi</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">Default Commission Rate (%)</label>
                                        <input 
                                            type="number" 
                                            value="10"
                                            min="0"
                                            max="100"
                                            step="0.1"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                        <p class="text-xs text-[#666666] mt-2" style="font-family: 'Figtree', sans-serif;">Komisi default untuk semua kategori</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">Minimum Transaction Fee (Rp)</label>
                                        <input 
                                            type="number" 
                                            value="5000"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                        <p class="text-xs text-[#666666] mt-2" style="font-family: 'Figtree', sans-serif;">Fee minimum untuk transaksi kecil</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Tab -->
                        <div x-show="activeTab === 'payment'" class="space-y-8" x-cloak>
                            <div>
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Payment Methods</h3>
                                <p class="text-sm text-[#666666] mb-6" style="font-family: 'Figtree', sans-serif;">Kelola metode pembayaran yang tersedia</p>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Transfer Bank</p>
                                                <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">BCA, Mandiri, BNI, BRI</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
                                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">E-Wallet</p>
                                                <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">GoPay, OVO, DANA, ShopeePay</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Cash</p>
                                                <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Pembayaran tunai</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Tab -->
                        <div x-show="activeTab === 'email'" class="space-y-8" x-cloak>
                            <div>
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Email Configuration</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">SMTP Host</label>
                                        <input 
                                            type="text" 
                                            value="smtp.gmail.com"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">SMTP Port</label>
                                        <input 
                                            type="text" 
                                            value="587"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">From Email</label>
                                        <input 
                                            type="email" 
                                            value="noreply@umkmconnect.id"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-[#999999] uppercase mb-2" style="font-family: 'Figtree', sans-serif;">From Name</label>
                                        <input 
                                            type="text" 
                                            value="UMKM Connect"
                                            class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm"
                                            style="font-family: 'Figtree', sans-serif;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lainnya Tab -->
                        <div x-show="activeTab === 'lainnya'" class="space-y-8" x-cloak>
                            <div>
                                <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Other Settings</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div>
                                            <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable User Registration</p>
                                            <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Izinkan pengguna baru mendaftar</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div>
                                            <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Email Verification Required</p>
                                            <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Wajibkan verifikasi email untuk pengguna baru</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                        <div>
                                            <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable Review System</p>
                                            <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Izinkan customer memberikan review</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" checked class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-8 pt-8 border-t border-[#e5e5e5] flex justify-end">
                            <button class="px-8 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                Save Settings
                            </button>
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
