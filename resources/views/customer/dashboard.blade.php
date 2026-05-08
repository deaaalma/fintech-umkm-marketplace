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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#fafafa]" x-data="{ showNotification: false }">
    @php
        // Sample data - nanti bisa diganti dengan data dari database
        $user = [
            'name' => 'Ahmad',
            'lastActivity' => 'Senin, 15 Januari 2026'
        ];

        $stats = [
            ['icon' => 'package', 'count' => 2, 'label' => 'Pesanan Aktif'],
            ['icon' => 'alert', 'count' => 1, 'label' => 'Perlu Tindakan'],
            ['icon' => 'check', 'count' => 8, 'label' => 'Selesai']
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
                'canReview' => false
            ],
            [
                'id' => 'UMKM-2026-0002',
                'service' => 'Office Cleaning Service',
                'provider' => 'ABC Cleaning Co',
                'status' => 'Perlu Tindakan Anda',
                'statusBadge' => true,
                'date' => '18 Januari 2026',
                'time' => '14:00 WIB',
                'location' => 'Jakarta Selatan',
                'price' => 'Rp 3.200.000',
                'adminNote' => 'Admin telah mengajukan pre-invoice. Status: review',
                'canReview' => true
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
                'canPay' => true
            ]
        ];

        $quickActions = [
            ['icon' => 'search', 'label' => 'Cari Admin', 'href' => '#'],
            ['icon' => 'bell', 'label' => 'Notifikasi', 'href' => '#', 'badge' => 3],
            ['icon' => 'help', 'label' => 'Hubungi Kami', 'href' => '#']
        ];

        $notifications = [
            [
                'title' => 'Pre-invoice silahnay untuk periksa',
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
        <!-- Header/Navbar -->
        <nav class="bg-white border-b border-[#e5e5e5] sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo/Brand -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#167E6C] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">Platform Name</span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#" class="text-[#064E3B] font-medium hover:text-[#167E6C] transition-colors border-b-2 border-[#167E6C] pb-1" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                        <a href="#" class="text-[#666666] font-medium hover:text-[#167E6C] transition-colors" style="font-family: 'Figtree', sans-serif;">Pesanan Saya</a>
                        <a href="#" class="text-[#666666] font-medium hover:text-[#167E6C] transition-colors" style="font-family: 'Figtree', sans-serif;">UMKM Partner</a>
                        <a href="#" class="text-[#666666] font-medium hover:text-[#167E6C] transition-colors" style="font-family: 'Figtree', sans-serif;">Bantuan</a>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-4">
                        <!-- Notification Bell -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#666666]">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3 pl-4 border-l border-[#e5e5e5]">
                            <div class="w-9 h-9 rounded-full bg-[#167E6C]/10 flex items-center justify-center">
                                <span class="text-[#167E6C] font-semibold text-sm">A</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-[#064E3B] mb-1" style="font-family: 'Figtree', sans-serif;">Halo, {{ $user['name'] }}</h1>
                <p class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Berikut ringkasan pesanan Anda</p>
                <p class="text-sm text-[#999999] mt-1" style="font-family: 'Figtree', sans-serif;">{{ $user['lastActivity'] }}</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($stats as $stat)
                <div class="bg-white rounded-2xl p-6 border border-[#e5e5e5] hover:shadow-lg transition-shadow duration-300 {{ $loop->index === 1 ? 'bg-[#064E3B] text-white' : '' }}">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-4xl font-bold mb-2 {{ $loop->index === 1 ? 'text-white' : 'text-[#064E3B]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['count'] }}</div>
                            <div class="text-sm {{ $loop->index === 1 ? 'text-white/80' : 'text-[#666666]' }}" style="font-family: 'Figtree', sans-serif;">{{ $stat['label'] }}</div>
                            @if($loop->index === 1)
                            <div class="mt-3 text-xs text-white/70">Ada pesanan yang memerlukan perhatian Anda</div>
                            @endif
                        </div>
                        <div class="w-12 h-12 rounded-full {{ $loop->index === 1 ? 'bg-white/20' : 'bg-[#167E6C]/10' }} flex items-center justify-center">
                            @if($stat['icon'] === 'package')
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $loop->index === 1 ? 'text-white' : 'text-[#167E6C]' }}">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            @elseif($stat['icon'] === 'alert')
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $loop->index === 1 ? 'text-white' : 'text-[#167E6C]' }}">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $loop->index === 1 ? 'text-white' : 'text-[#167E6C]' }}">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Active Orders -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Section Header -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">Pesanan Aktif</h2>
                        <a href="#" class="text-sm text-[#167E6C] hover:text-[#064E3B] font-medium transition-colors" style="font-family: 'Figtree', sans-serif;">Lihat Semua →</a>
                    </div>

                    <!-- Order Cards -->
                    @foreach($activeOrders as $order)
                    <div class="bg-white rounded-2xl p-6 border border-[#e5e5e5] hover:shadow-lg transition-all duration-300">
                        <!-- Order Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="text-xs text-[#999999] mb-1" style="font-family: 'Figtree', sans-serif;">Nomor Pesanan: {{ $order['id'] }}</div>
                                <h3 class="text-xl font-semibold text-[#064E3B] mb-1" style="font-family: 'Figtree', sans-serif;">{{ $order['service'] }}</h3>
                                <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $order['provider'] }}</p>
                            </div>
                            @if(isset($order['statusBadge']) && $order['statusBadge'])
                            <span class="px-3 py-1 bg-[#064E3B] text-white text-xs font-medium rounded-full" style="font-family: 'Figtree', sans-serif;">Perlu Tindakan Anda</span>
                            @endif
                        </div>

                        <!-- Admin Note (if exists) -->
                        @if(isset($order['adminNote']))
                        <div class="mb-4 p-3 bg-[#FEF3C7] border border-[#FDE68A] rounded-lg">
                            <p class="text-sm text-[#92400E]" style="font-family: 'Figtree', sans-serif;">{{ $order['adminNote'] }}</p>
                        </div>
                        @endif

                        <!-- Order Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center gap-3 text-sm text-[#666666]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span style="font-family: 'Figtree', sans-serif;">{{ $order['date'] }}</span>
                                <span class="text-[#999999]">{{ $order['time'] }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-[#666666]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-family: 'Figtree', sans-serif;">{{ $order['location'] }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-[#666666]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span class="font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $order['price'] }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            @if(isset($order['canReview']) && $order['canReview'])
                            <button class="flex-1 bg-[#064E3B] text-white px-4 py-3 rounded-xl font-medium hover:bg-[#167E6C] transition-colors duration-200" style="font-family: 'Figtree', sans-serif;">
                                Review Pre-Invoice →
                            </button>
                            @elseif(isset($order['canPay']) && $order['canPay'])
                            <button class="flex-1 bg-[#064E3B] text-white px-4 py-3 rounded-xl font-medium hover:bg-[#167E6C] transition-colors duration-200" style="font-family: 'Figtree', sans-serif;">
                                Bayar Sekarang →
                            </button>
                            @else
                            <button class="flex-1 bg-white border border-[#e5e5e5] text-[#064E3B] px-4 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors duration-200" style="font-family: 'Figtree', sans-serif;">
                                Lihat Detail →
                            </button>
                            @endif
                        </div>

                        <!-- Provider Info -->
                        <div class="mt-4 pt-4 border-t border-[#e5e5e5]">
                            <p class="text-xs text-[#999999]" style="font-family: 'Figtree', sans-serif;">Penyedia Jasa:</p>
                            <p class="text-sm text-[#666666] font-medium" style="font-family: 'Figtree', sans-serif;">{{ $order['provider'] }}</p>
                        </div>
                    </div>
                    @endforeach

                    <!-- View All Button -->
                    <div class="text-center pt-4">
                        <button class="text-[#167E6C] hover:text-[#064E3B] font-medium transition-colors" style="font-family: 'Figtree', sans-serif;">
                            Lihat Semua Pesanan →
                        </button>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl p-6 border border-[#e5e5e5]">
                        <h3 class="text-lg font-semibold text-[#064E3B] mb-4" style="font-family: 'Figtree', sans-serif;">Menu Cepat</h3>
                        <div class="space-y-3">
                            @foreach($quickActions as $action)
                            <a href="{{ $action['href'] }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#167E6C]/10 flex items-center justify-center group-hover:bg-[#167E6C] transition-colors">
                                        @if($action['icon'] === 'search')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#167E6C] group-hover:text-white">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                        @elseif($action['icon'] === 'bell')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#167E6C] group-hover:text-white">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#167E6C] group-hover:text-white">
                                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                        </svg>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">{{ $action['label'] }}</span>
                                </div>
                                @if(isset($action['badge']))
                                <span class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-semibold">{{ $action['badge'] }}</span>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Notifications -->
                    <div class="bg-white rounded-2xl p-6 border border-[#e5e5e5]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-[#064E3B]" style="font-family: 'Figtree', sans-serif;">Notifikasi Terbaru</h3>
                            <span class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-semibold">{{ count($notifications) }}</span>
                        </div>
                        <div class="space-y-4">
                            @foreach($notifications as $notif)
                            <div class="pb-4 border-b border-[#e5e5e5] last:border-b-0 last:pb-0">
                                <p class="text-sm text-[#064E3B] font-medium mb-1" style="font-family: 'Figtree', sans-serif;">• {{ $notif['title'] }}</p>
                                <p class="text-xs text-[#666666] mb-1" style="font-family: 'Figtree', sans-serif;">{{ $notif['order'] }}</p>
                                <p class="text-xs text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $notif['time'] }}</p>
                            </div>
                            @endforeach
                        </div>
                        <button class="w-full mt-4 text-sm text-[#167E6C] hover:text-[#064E3B] font-medium transition-colors" style="font-family: 'Figtree', sans-serif;">
                            Lihat Semua
                        </button>
                    </div>

                    <!-- Help Section -->
                    <div class="bg-gradient-to-br from-[#167E6C] to-[#064E3B] rounded-2xl p-6 text-white">
                        <h3 class="text-lg font-semibold mb-2" style="font-family: 'Figtree', sans-serif;">Butuh Bantuan?</h3>
                        <p class="text-sm text-white/80 mb-4" style="font-family: 'Figtree', sans-serif;">Kami siap membantu Anda 24/7</p>
                        <button class="w-full bg-white text-[#064E3B] px-4 py-3 rounded-xl font-medium hover:bg-gray-100 transition-colors duration-200" style="font-family: 'Figtree', sans-serif;">
                            Hubungi Support
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
