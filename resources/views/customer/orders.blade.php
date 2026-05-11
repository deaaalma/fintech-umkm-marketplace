<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Orders - JOS Premium</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Flatpickr (Premium Calendar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
            --brand-dark: #000B44;
            --brand-primary: #0077B6;
            --brand-cyan: #00B4D8;
            --brand-soft: #ADE8F4;
        }

        body {
            font-family: var(--font-figtree);
            background-color: #ffffff;
            color: var(--brand-dark);
        }

        .font-jakarta { font-family: var(--font-accent); }
        .font-mono { font-family: var(--font-geist-mono); }
        .font-georgia-italic { font-family: Georgia, serif; font-style: italic; }

        .premium-shadow {
            box-shadow: 0 4px 20px -1px rgba(0, 11, 68, 0.02);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid #f1f5f9;
        }

        .nav-scrolled {
            background: #18181b !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }

        .order-item {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .order-item:hover {
            transform: translateY(-8px) scale(1.01);
            border-color: rgba(0, 119, 182, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 11, 68, 0.05);
        }

        /* Interactive Breath Animation */
        @keyframes subtleBreath {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.005); }
        }

        .breath-active {
            animation: subtleBreath 3s ease-in-out infinite;
        }

        /* Flatpickr Custom Styling */
        .flatpickr-calendar {
            border-radius: 1.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 11, 68, 0.1) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 10px !important;
            font-family: var(--font-figtree) !important;
        }
        .flatpickr-day.selected {
            background: var(--brand-dark) !important;
            border-color: var(--brand-dark) !important;
        }
        .flatpickr-day:hover { background: #f8fafc !important; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #ffffff; }
        ::-webkit-scrollbar-thumb { 
            background: #e2e8f0; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-primary); }
    </style>
</head>
    @php
        $user = ['name' => 'Ahmad'];
        $navigationLinks = [
            ['name' => 'Overview', 'href' => route('customer.dashboard.preview')],
            ['name' => 'My Orders', 'href' => '#', 'active' => true],
            ['name' => 'Explore Partners', 'href' => route('customer.partners.preview')],
            ['name' => 'Support', 'href' => '#'],
        ];

        $tabs = [
            ['id' => 'semua', 'label' => 'Semua', 'count' => 15],
            ['id' => 'menunggu', 'label' => 'Menunggu', 'count' => 3],
            ['id' => 'diproses', 'label' => 'Proses', 'count' => 2],
            ['id' => 'selesai', 'label' => 'Selesai', 'count' => 10],
        ];

        $orders = [
            [
                'id' => 'ABC-2026-0042', 
                'service' => 'Office Cleaning Service', 
                'provider' => 'ABC Cleaning Co', 
                'status' => 'Review Admin', 
                'type' => 'action_required', 
                'date' => '14 Jan 2026', 
                'price' => 'Rp 3.200.000', 
                'location' => 'Jakarta Selatan', 
                'time' => '14:00 WIB',
                'target_date' => '18 Januari 2026',
                'tab' => 'menunggu',
                'alert' => 'Admin telah mengirim pre-invoice. Silakan review sebelum melanjutkan.'
            ],
            [
                'id' => 'SKR-2026-0088', 
                'service' => 'Jasa Bimbingan & Olah Data Skripsi', 
                'provider' => 'Akademika JOS Center', 
                'status' => 'Dalam Proses', 
                'type' => 'in_progress', 
                'date' => '22 Feb 2026', 
                'price' => 'Rp 1.500.000', 
                'location' => 'Online / Zoom Meet', 
                'time' => '10:00 WIB',
                'target_date' => '25 Februari 2026',
                'tab' => 'diproses',
                'progress' => 60,
                'staff' => 'Dr. Bambang S.',
                'staffStatus' => 'Sedang mereview Bab 3 & 4 Anda'
            ],
            [
                'id' => 'MUA-2026-0120', 
                'service' => 'Makeup Artist (MUA) Wedding', 
                'provider' => 'GlowUp JOS Studio', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '10 Jan 2026', 
                'price' => 'Rp 5.500.000', 
                'location' => 'Uluwatu, Bali', 
                'time' => '05:00 WIB',
                'target_date' => '10 Januari 2026',
                'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0055', 
                'service' => 'Website Development (E-Commerce)', 
                'provider' => 'Tech Solutions JOS', 
                'status' => 'Review Admin', 
                'type' => 'action_required', 
                'date' => '24 Feb 2026', 
                'price' => 'Rp 12.000.000', 
                'location' => 'Remote / Cloud', 
                'time' => '09:00 WIB',
                'target_date' => '28 Februari 2026', 
                'tab' => 'menunggu',
                'alert' => 'Menunggu persetujuan desain layout homepage dari Anda.'
            ],
            [
                'id' => 'DEF-2026-0028', 
                'service' => 'Deep Cleaning Service (Apartment)', 
                'provider' => 'DEF Cleaning', 
                'status' => 'Dalam Proses', 
                'type' => 'in_progress', 
                'date' => '12 Jan 2026', 
                'price' => 'Rp 2.500.000', 
                'location' => 'Jakarta Barat', 
                'time' => '08:00 WIB',
                'target_date' => '15 Januari 2026',
                'tab' => 'diproses',
                'progress' => 85,
                'staff' => 'John Doe',
                'staffStatus' => 'Dalam perjalanan ke lokasi'
            ],
            [
                'id' => 'SKR-2026-0090', 
                'service' => 'Analisis Statistik Skripsi (SPSS)', 
                'provider' => 'Akademika JOS Center', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '15 Feb 2026', 
                'price' => 'Rp 850.000', 
                'location' => 'Online', 
                'time' => '13:00 WIB', 
                'target_date' => '15 Feb 2026', 
                'tab' => 'selesai'
            ],
            [
                'id' => 'MUA-2026-0125', 
                'service' => 'MUA Graduation / Wisuda', 
                'provider' => 'GlowUp JOS Studio', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '20 Feb 2026', 
                'price' => 'Rp 750.000', 
                'location' => 'Denpasar, Bali', 
                'time' => '04:00 WIB', 
                'target_date' => '20 Feb 2026', 
                'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0060', 
                'service' => 'Company Profile Website', 
                'provider' => 'Tech Solutions JOS', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '05 Feb 2026', 
                'price' => 'Rp 4.500.000', 
                'location' => 'Remote', 
                'time' => '10:00 WIB', 
                'target_date' => '05 Feb 2026', 
                'tab' => 'selesai'
            ],
            [
                'id' => 'CLN-2026-0010', 'service' => 'Tungau Cleaning Service', 'provider' => 'ABC Cleaning Co', 'status' => 'Selesai', 'type' => 'completed', 'date' => '10 Feb 2026', 'price' => 'Rp 500.000', 'location' => 'Jakarta Timur', 'time' => '09:00 WIB', 'target_date' => '10 Feb 2026', 'tab' => 'selesai'],
            [
                'id' => 'SKR-2026-0102', 'service' => 'Cek Plagiat (Turnitin)', 'provider' => 'Akademika JOS Center', 'status' => 'Selesai', 'type' => 'completed', 'date' => '18 Feb 2026', 'price' => 'Rp 50.000', 'location' => 'Online', 'time' => '11:00 WIB', 'target_date' => '18 Feb 2026', 'tab' => 'selesai'
            ],
            [
                'id' => 'MUA-2026-0130', 'service' => 'Party Makeup Service', 'provider' => 'GlowUp JOS Studio', 'status' => 'Review Admin', 'type' => 'action_required', 'date' => '27 Feb 2026', 'price' => 'Rp 450.000', 'location' => 'Sanur, Bali', 'time' => '16:00 WIB', 'target_date' => '27 Feb 2026', 'tab' => 'menunggu', 'alert' => 'Silakan lampirkan foto referensi makeup Anda.'
            ],
            [
                'id' => 'WEB-2026-0075', 'service' => 'Landing Page UMKM', 'provider' => 'Tech Solutions JOS', 'status' => 'Selesai', 'type' => 'completed', 'date' => '01 Feb 2026', 'price' => 'Rp 1.500.000', 'location' => 'Remote', 'time' => '14:00 WIB', 'target_date' => '01 Feb 2026', 'tab' => 'selesai'
            ],
            [
                'id' => 'CLN-2026-0015', 'service' => 'Fogging Disinfectant', 'provider' => 'ABC Cleaning Co', 'status' => 'Selesai', 'type' => 'completed', 'date' => '28 Jan 2026', 'price' => 'Rp 1.000.000', 'location' => 'Jakarta Pusat', 'time' => '13:00 WIB', 'target_date' => '28 Jan 2026', 'tab' => 'selesai'
            ],
            [
                'id' => 'SKR-2026-0110', 'service' => 'Transkrip Wawancara', 'provider' => 'Akademika JOS Center', 'status' => 'Selesai', 'type' => 'completed', 'date' => '25 Jan 2026', 'price' => 'Rp 250.000', 'location' => 'Online', 'time' => '15:00 WIB', 'target_date' => '25 Jan 2026', 'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0080', 'service' => 'Custom ERP System', 'provider' => 'Tech Solutions JOS', 'status' => 'Selesai', 'type' => 'completed', 'date' => '20 Jan 2026', 'price' => 'Rp 25.000.000', 'location' => 'Remote', 'time' => '09:00 WIB', 'target_date' => '20 Jan 2026', 'tab' => 'selesai'
            ],
        ];
    @endphp

    <!-- Premium Floating Navbar (Consistent with Dashboard) -->
    <nav x-data="{ isScrolled: false }" 
         x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 20)"
         class="fixed left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-6xl transition-all duration-500"
         :class="isScrolled ? 'top-4' : 'top-8'">
        <div :class="isScrolled ? 'nav-scrolled rounded-full py-3' : 'glass-nav rounded-[2.5rem] py-4 shadow-lg shadow-brand-dark/[0.015]'"
             class="px-8 flex items-center justify-between transition-all duration-500">
            <div class="flex items-center gap-12">
                <a href="/" :class="isScrolled ? 'text-white' : 'text-brand-dark'" class="text-2xl font-black tracking-tighter transition-colors">JOS</a>
                
                <div class="hidden lg:flex items-center gap-8">
                    @foreach($navigationLinks as $link)
                    <a href="{{ $link['href'] }}" 
                       :class="isScrolled ? ({{ ($link['active'] ?? false) ? 'true' : 'false' }} ? 'text-brand-cyan' : 'text-gray-400 hover:text-white') : ({{ ($link['active'] ?? false) ? 'true' : 'false' }} ? 'text-brand-primary' : 'text-gray-500 hover:text-brand-dark')"
                       class="text-sm font-semibold tracking-tight transition-all duration-300">
                        {{ $link['name'] }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- Chat -->
                <button :class="isScrolled ? 'text-gray-400 hover:text-white' : 'text-brand-dark hover:bg-white/50'" 
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-12.7 8.19 8.19 0 0 1 4.9 1.5L22 3l-1.5 5.5a8.19 8.19 0 0 1 1.5 4.9z"/></svg>
                </button>

                <!-- Notifications -->
                <button :class="isScrolled ? 'text-gray-400 hover:text-white' : 'text-brand-dark hover:bg-white/50'"
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-brand-primary rounded-full border-2 border-white"></span>
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 pl-6 border-l" :class="isScrolled ? 'border-white/10' : 'border-gray-100'">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold uppercase tracking-widest transition-colors" :class="isScrolled ? 'text-white' : 'text-brand-dark'">{{ $user['name'] }}</div>
                        <div class="text-[10px] font-jakarta font-bold transition-colors" :class="isScrolled ? 'text-gray-500' : 'text-gray-400'">MEMBER</div>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white font-bold shadow-lg shadow-brand-primary/20">
                        {{ substr($user['name'],0,1) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @php
        $user = ['name' => 'Ahmad'];
        $navigationLinks = [
            ['name' => 'Overview', 'href' => route('customer.dashboard.preview')],
            ['name' => 'My Orders', 'href' => '#', 'active' => true],
            ['name' => 'Explore Partners', 'href' => route('customer.partners.preview')],
            ['name' => 'Support', 'href' => '#'],
        ];

        $tabs = [
            ['id' => 'semua', 'label' => 'Semua', 'count' => 15],
            ['id' => 'menunggu', 'label' => 'Menunggu', 'count' => 3],
            ['id' => 'diproses', 'label' => 'Proses', 'count' => 2],
            ['id' => 'selesai', 'label' => 'Selesai', 'count' => 10],
        ];

        $orders = [
            [
                'id' => 'ABC-2026-0042', 
                'service' => 'Office Cleaning Service', 
                'provider' => 'ABC Cleaning Co', 
                'status' => 'Review Admin', 
                'type' => 'action_required', 
                'date' => '14 Jan 2026', 
                'price' => 'Rp 3.200.000', 
                'location' => 'Jakarta Selatan', 
                'time' => '14:00 WIB',
                'target_date' => '18 Januari 2026',
                'timestamp' => '2026-01-14',
                'tab' => 'menunggu',
                'alert' => 'Admin telah mengirim pre-invoice. Silakan review sebelum melanjutkan.'
            ],
            [
                'id' => 'SKR-2026-0088', 
                'service' => 'Jasa Bimbingan & Olah Data Skripsi', 
                'provider' => 'Akademika JOS Center', 
                'status' => 'Dalam Proses', 
                'type' => 'in_progress', 
                'date' => '22 Feb 2026', 
                'price' => 'Rp 1.500.000', 
                'location' => 'Online / Zoom Meet', 
                'time' => '10:00 WIB',
                'target_date' => '25 Februari 2026',
                'timestamp' => '2026-02-22',
                'tab' => 'diproses',
                'progress' => 60,
                'staff' => 'Dr. Bambang S.',
                'staffStatus' => 'Sedang mereview Bab 3 & 4 Anda'
            ],
            [
                'id' => 'MUA-2026-0120', 
                'service' => 'Makeup Artist (MUA) Wedding', 
                'provider' => 'GlowUp JOS Studio', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '10 Jan 2026', 
                'price' => 'Rp 5.500.000', 
                'location' => 'Uluwatu, Bali', 
                'time' => '05:00 WIB',
                'target_date' => '10 Januari 2026',
                'timestamp' => '2026-01-10',
                'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0055', 
                'service' => 'Website Development (E-Commerce)', 
                'provider' => 'Tech Solutions JOS', 
                'status' => 'Review Admin', 
                'type' => 'action_required', 
                'date' => '24 Feb 2026', 
                'price' => 'Rp 12.000.000', 
                'location' => 'Remote / Cloud', 
                'time' => '09:00 WIB',
                'target_date' => '28 Februari 2026', 
                'timestamp' => '2026-02-24',
                'tab' => 'menunggu',
                'alert' => 'Menunggu persetujuan desain layout homepage dari Anda.'
            ],
            [
                'id' => 'DEF-2026-0028', 
                'service' => 'Deep Cleaning Service (Apartment)', 
                'provider' => 'DEF Cleaning', 
                'status' => 'Dalam Proses', 
                'type' => 'in_progress', 
                'date' => '12 Jan 2026', 
                'price' => 'Rp 2.500.000', 
                'location' => 'Jakarta Barat', 
                'time' => '08:00 WIB',
                'target_date' => '15 Januari 2026',
                'timestamp' => '2026-01-12',
                'tab' => 'diproses',
                'progress' => 85,
                'staff' => 'John Doe',
                'staffStatus' => 'Dalam perjalanan ke lokasi'
            ],
            [
                'id' => 'SKR-2026-0090', 
                'service' => 'Analisis Statistik Skripsi (SPSS)', 
                'provider' => 'Akademika JOS Center', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '15 Feb 2026', 
                'price' => 'Rp 850.000', 
                'location' => 'Online', 
                'time' => '13:00 WIB', 
                'target_date' => '15 Feb 2026', 
                'timestamp' => '2026-02-15',
                'tab' => 'selesai'
            ],
            [
                'id' => 'MUA-2026-0125', 
                'service' => 'MUA Graduation / Wisuda', 
                'provider' => 'GlowUp JOS Studio', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '20 Feb 2026', 
                'price' => 'Rp 750.000', 
                'location' => 'Denpasar, Bali', 
                'time' => '04:00 WIB', 
                'target_date' => '20 Feb 2026', 
                'timestamp' => '2026-02-20',
                'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0060', 
                'service' => 'Company Profile Website', 
                'provider' => 'Tech Solutions JOS', 
                'status' => 'Selesai', 
                'type' => 'completed', 
                'date' => '05 Feb 2026', 
                'price' => 'Rp 4.500.000', 
                'location' => 'Remote', 
                'time' => '10:00 WIB', 
                'target_date' => '05 Feb 2026', 
                'timestamp' => '2026-02-05',
                'tab' => 'selesai'
            ],
            [
                'id' => 'CLN-2026-0010', 'service' => 'Tungau Cleaning Service', 'provider' => 'ABC Cleaning Co', 'status' => 'Selesai', 'type' => 'completed', 'date' => '10 Feb 2026', 'price' => 'Rp 500.000', 'location' => 'Jakarta Timur', 'time' => '09:00 WIB', 'target_date' => '10 Feb 2026', 'timestamp' => '2026-02-10', 'tab' => 'selesai'],
            [
                'id' => 'SKR-2026-0102', 'service' => 'Cek Plagiat (Turnitin)', 'provider' => 'Akademika JOS Center', 'status' => 'Selesai', 'type' => 'completed', 'date' => '18 Feb 2026', 'price' => 'Rp 50.000', 'location' => 'Online', 'time' => '11:00 WIB', 'target_date' => '18 Feb 2026', 'timestamp' => '2026-02-18', 'tab' => 'selesai'
            ],
            [
                'id' => 'MUA-2026-0130', 'service' => 'Party Makeup Service', 'provider' => 'GlowUp JOS Studio', 'status' => 'Review Admin', 'type' => 'action_required', 'date' => '27 Feb 2026', 'price' => 'Rp 450.000', 'location' => 'Sanur, Bali', 'time' => '16:00 WIB', 'target_date' => '27 Feb 2026', 'timestamp' => '2026-02-27', 'tab' => 'menunggu', 'alert' => 'Silakan lampirkan foto referensi makeup Anda.'
            ],
            [
                'id' => 'WEB-2026-0075', 'service' => 'Landing Page UMKM', 'provider' => 'Tech Solutions JOS', 'status' => 'Selesai', 'type' => 'completed', 'date' => '01 Feb 2026', 'price' => 'Rp 1.500.000', 'location' => 'Remote', 'time' => '14:00 WIB', 'target_date' => '01 Feb 2026', 'timestamp' => '2026-02-01', 'tab' => 'selesai'
            ],
            [
                'id' => 'CLN-2026-0015', 'service' => 'Fogging Disinfectant', 'provider' => 'ABC Cleaning Co', 'status' => 'Selesai', 'type' => 'completed', 'date' => '28 Jan 2026', 'price' => 'Rp 1.000.000', 'location' => 'Jakarta Pusat', 'time' => '13:00 WIB', 'target_date' => '28 Jan 2026', 'timestamp' => '2026-01-28', 'tab' => 'selesai'
            ],
            [
                'id' => 'SKR-2026-0110', 'service' => 'Transkrip Wawancara', 'provider' => 'Akademika JOS Center', 'status' => 'Selesai', 'type' => 'completed', 'date' => '25 Jan 2026', 'price' => 'Rp 250.000', 'location' => 'Online', 'time' => '15:00 WIB', 'target_date' => '25 Jan 2026', 'timestamp' => '2026-01-25', 'tab' => 'selesai'
            ],
            [
                'id' => 'WEB-2026-0080', 'service' => 'Custom ERP System', 'provider' => 'Tech Solutions JOS', 'status' => 'Selesai', 'type' => 'completed', 'date' => '20 Jan 2026', 'price' => 'Rp 25.000.000', 'location' => 'Remote', 'time' => '09:00 WIB', 'target_date' => '20 Jan 2026', 'timestamp' => '2026-01-20', 'tab' => 'selesai'
            ],
        ];
    @endphp

    <!-- Container Wrap with Alpine.js -->
    <main class="pt-40 pb-20 px-6" x-data="{ 
        activeTab: 'semua', 
        search: '', 
        dateRange: '',
        startDate: null,
        endDate: null,
        statusFilter: '',
        showFilterMenu: false,
        currentPage: 1, 
        itemsPerPage: 6,
        allOrders: @js($orders),
        init() {
            flatpickr($refs.dateInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j M Y',
                onChange: (selectedDates) => {
                    if (selectedDates.length === 2) {
                        this.startDate = selectedDates[0];
                        this.endDate = selectedDates[1];
                        this.currentPage = 1;
                        this.$nextTick(() => animateTabs());
                    } else if (selectedDates.length === 0) {
                        this.startDate = null;
                        this.endDate = null;
                        this.currentPage = 1;
                        this.$nextTick(() => animateTabs());
                    }
                }
            });
        },
        get filteredOrders() {
            return this.allOrders.filter(o => {
                const matchesTab = this.activeTab === 'semua' || o.tab === this.activeTab;
                const matchesSearch = o.service.toLowerCase().includes(this.search.toLowerCase()) || 
                                     o.id.toLowerCase().includes(this.search.toLowerCase());
                const matchesStatus = this.statusFilter === '' || o.status.toLowerCase().includes(this.statusFilter.toLowerCase());
                
                // Date Range Logic
                let matchesDate = true;
                if (this.startDate && this.endDate) {
                    const orderTime = new Date(o.timestamp).getTime();
                    matchesDate = orderTime >= this.startDate.getTime() && orderTime <= this.endDate.getTime();
                }
                
                return matchesTab && matchesSearch && matchesStatus && matchesDate;
            });
        },
        get paginatedOrders() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredOrders.slice(start, start + this.itemsPerPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
        },
        get activeFilters() {
            let filters = [];
            if (this.startDate && this.endDate) {
                const fmt = (d) => d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                filters.push({ id: 'date', label: 'Rentang: ' + fmt(this.startDate) + ' - ' + fmt(this.endDate) });
            }
            if (this.statusFilter) filters.push({ id: 'status', label: 'Status: ' + this.statusFilter });
            return filters;
        },
        clearFilter(id) {
            if (id === 'date') {
                this.startDate = null;
                this.endDate = null;
                this.$refs.dateInput._flatpickr.clear();
            }
            if (id === 'status') this.statusFilter = '';
            this.currentPage = 1;
            this.$nextTick(() => animateTabs());
        },
        changeTab(id) {
            this.activeTab = id;
            this.currentPage = 1;
            this.$nextTick(() => animateTabs());
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.$nextTick(() => animateTabs());
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.$nextTick(() => animateTabs());
            }
        }
    }">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section (Removed Dash) -->
            <div class="mb-12">
                <div class="mb-2 animate-on-load">
                    <span class="text-[10px] font-black text-brand-primary uppercase tracking-[0.3em]">History</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-brand-dark tracking-tighter mb-4 animate-on-load">
                    Pesanan <span class="font-georgia-italic italic font-normal text-brand-primary">Saya</span>
                </h1>
                <p class="text-slate-400 text-lg max-w-2xl animate-on-load">Pantau status dan riwayat lengkap layanan Anda.</p>
            </div>

            <!-- Advanced Search & Filter Section (Stabilized) -->
            <div class="mb-12 animate-on-load relative z-30">
                <div class="flex flex-col lg:flex-row gap-4 mb-6 items-start lg:items-stretch">
                    <!-- Interactive Search Input -->
                    <div class="relative w-full transition-all duration-700 ease-in-out group order-1"
                         :class="(showFilterMenu || search.length > 0) ? 'lg:w-full' : 'lg:w-[480px] hover:lg:w-[520px]'">
                        <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        </div>
                        <input type="text" 
                               x-model="search"
                               @focus="currentPage = 1"
                               @input="currentPage = 1; $nextTick(() => animateTabs())"
                               placeholder="Cari berdasarkan nomor pesanan atau nama layanan..." 
                               class="w-full pl-14 pr-6 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:border-brand-primary/30 focus:ring-4 focus:ring-brand-primary/5 transition-all group-hover:shadow-xl group-hover:shadow-brand-primary/5">
                    </div>

                    <!-- Filter Button & Dropdown (Stabilized) -->
                    <div class="relative order-2 flex-shrink-0" @click.away="showFilterMenu = false">
                        <button @click="showFilterMenu = !showFilterMenu"
                                class="h-full px-8 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-black text-brand-dark hover:bg-slate-50 transition-all flex items-center gap-3">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            <span>Filter</span>
                        </button>

                        <!-- Popover Menu -->
                        <div x-show="showFilterMenu" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-3 w-72 bg-white border border-slate-100 rounded-[2.2rem] shadow-2xl p-8 z-50">
                            
                            <!-- Date Range Section Inside Filter -->
                            <div class="mb-8">
                                <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Rentang Tanggal</div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors z-10">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                                    </div>
                                    <input type="text" 
                                           x-ref="dateInput"
                                           placeholder="Pilih Tanggal"
                                           class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-transparent rounded-xl text-[12px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:bg-white focus:border-brand-primary/20 transition-all cursor-pointer">
                                </div>
                            </div>

                            <!-- Status Section -->
                            <div class="mb-2">
                                <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Urutkan Status</div>
                                <div class="space-y-1.5">
                                    <template x-for="status in ['Review Admin', 'Dalam Proses', 'Selesai']">
                                        <button @click="statusFilter = status; showFilterMenu = false; $nextTick(() => animateTabs())"
                                                class="w-full text-left px-4 py-3 rounded-xl text-[12px] font-bold transition-all"
                                                :class="statusFilter === status ? 'bg-brand-primary/5 text-brand-primary' : 'text-slate-400 hover:bg-slate-50 hover:text-brand-dark'"
                                                x-text="status"></button>
                                    </template>
                                    <button @click="statusFilter = ''; showFilterMenu = false; $nextTick(() => animateTabs())"
                                            class="w-full text-left px-4 py-3 rounded-xl text-[12px] font-bold text-slate-300 hover:bg-slate-50 transition-all italic">Reset Status</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Filter Badges (Image Reference) -->
                <div class="flex flex-wrap gap-3 mt-4" x-show="activeFilters.length > 0">
                    <template x-for="filter in activeFilters" :key="filter.id">
                        <div class="flex items-center gap-2 px-6 py-3 bg-slate-50 border border-slate-100 rounded-full text-[13px] font-bold text-slate-500">
                            <span x-text="filter.label"></span>
                            <button @click="clearFilter(filter.id)" class="hover:text-brand-dark transition-colors">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </template>
                    <button @click="clearFilter('date'); statusFilter = ''; search = ''; $nextTick(() => animateTabs())" 
                            class="px-6 py-3 text-[13px] font-bold text-brand-primary hover:underline transition-all active:scale-95">Reset Semua</button>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-12 flex flex-wrap gap-3 animate-on-load">
                @foreach($tabs as $tab)
                <button @click="changeTab('{{ $tab['id'] }}')"
                        :class="activeTab === '{{ $tab['id'] }}' ? 'bg-brand-dark text-white border-brand-dark shadow-xl shadow-brand-dark/10' : 'bg-white text-slate-400 border-slate-100 hover:border-brand-primary/20'"
                        class="px-6 py-4 rounded-2xl border font-bold text-xs transition-all flex items-center gap-3">
                    <span>{{ $tab['label'] }}</span>
                    <span :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white/20 text-white' : 'bg-slate-50 text-slate-400'" class="px-2.5 py-0.5 rounded-full text-[10px] font-black">
                        {{ $tab['count'] }}
                    </span>
                </button>
                @endforeach
            </div>

            <!-- Orders Grid (Varied Based on Type) -->
            <div class="space-y-6 min-h-[600px]" id="orders-container">
                <template x-for="order in paginatedOrders" :key="order.id">
                    <div class="order-item bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-primary/15 transition-all group overflow-hidden">
                        <!-- Card Header -->
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest font-mono" x-text="'Nomor Pesanan: #' + order.id"></span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest" x-text="order.date"></span>
                        </div>

                        <!-- Card Body -->
                        <div class="mb-6">
                            <h4 class="text-3xl font-bold text-brand-dark tracking-tight mb-2 group-hover:text-brand-primary transition-colors" x-text="order.service"></h4>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="order.status"></p>
                        </div>

                        <!-- Status Badge (Action Needed) -->
                        <template x-if="order.type === 'action_required'">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-dark text-white rounded-full text-[10px] font-black uppercase tracking-widest mb-6">
                                Perlu Tindakan Anda
                            </div>
                        </template>

                        <!-- Alert Box (Action Needed) -->
                        <template x-if="order.type === 'action_required'">
                            <div class="mb-8 p-6 bg-slate-50 border border-slate-100 rounded-[1.5rem] flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-dark"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500 leading-relaxed" x-text="order.alert"></p>
                            </div>
                        </template>

                        <!-- Progress Bar (In Progress) -->
                        <template x-if="order.type === 'in_progress'">
                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center gap-2 text-xs font-black text-brand-dark uppercase tracking-widest">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-primary"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Pembayaran dikonfirmasi
                                    </div>
                                    <span class="text-xs font-black text-slate-400" x-text="order.progress + '%'"></span>
                                </div>
                                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-dark rounded-full transition-all duration-1000" :style="'width: ' + order.progress + '%'"></div>
                                </div>
                            </div>
                        </template>

                        <!-- Staff Info (In Progress) -->
                        <template x-if="order.type === 'in_progress'">
                            <div class="mb-8 p-5 bg-slate-50 border border-slate-100 rounded-[1.5rem] flex items-center gap-5">
                                <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center flex-shrink-0 bg-white shadow-sm">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-400"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-brand-dark" x-text="'Staff: ' + order.staff"></div>
                                    <div class="text-xs font-medium text-slate-400" x-text="order.staffStatus"></div>
                                </div>
                            </div>
                        </template>

                        <!-- Rating Area (Completed) -->
                        <template x-if="order.type === 'completed'">
                            <div class="mb-8 p-6 bg-slate-50 border border-slate-100 rounded-[1.5rem]">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-slate-500">Beri rating untuk layanan ini:</span>
                                    <div class="flex gap-1">
                                        <template x-for="i in 5">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-200 hover:text-yellow-400 transition-colors cursor-pointer"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Details Grid (Date & Location) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-10 border-b border-slate-50">
                            <!-- Date -->
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal & Waktu</div>
                                    <div class="text-sm font-bold text-brand-dark" x-text="order.target_date"></div>
                                    <div class="text-xs font-bold text-slate-400" x-text="order.time"></div>
                                </div>
                            </div>
                            <!-- Location -->
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</div>
                                    <div class="text-sm font-bold text-brand-dark" x-text="order.location"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div class="text-[11px] font-medium text-slate-400">
                                Penyedia Jasa: <span class="text-brand-dark font-black" x-text="order.provider"></span>
                            </div>
                            
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <template x-if="order.type === 'action_required'">
                                    <div class="flex gap-3 w-full sm:w-auto">
                                        <button class="flex-1 sm:flex-none px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                                            Review Pre-Invoice
                                        </button>
                                        <button class="flex-1 sm:flex-none px-8 py-4 border border-slate-100 text-brand-dark rounded-[1rem] text-xs font-bold hover:bg-slate-50 transition-all">
                                            Chat Admin
                                        </button>
                                    </div>
                                </template>

                                <template x-if="order.type === 'in_progress'">
                                    <div class="flex gap-3 w-full sm:w-auto">
                                        <button class="flex-1 sm:flex-none px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                                            Track Progress
                                        </button>
                                        <button class="flex-1 sm:flex-none px-8 py-4 border border-slate-100 text-brand-dark rounded-[1rem] text-xs font-bold hover:bg-slate-50 transition-all">
                                            Hubungi Staff
                                        </button>
                                    </div>
                                </template>

                                <template x-if="order.type === 'completed'">
                                    <div class="flex items-center gap-6 w-full sm:w-auto">
                                        <button class="px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                                            Tulis Review
                                        </button>
                                        <button class="px-8 py-4 border border-slate-100 text-brand-dark rounded-[1rem] text-xs font-bold hover:bg-slate-50 transition-all">
                                            Pesan Lagi
                                        </button>
                                        <a href="#" class="hidden lg:block text-xs font-bold text-slate-400 hover:text-brand-primary underline transition-colors">Lihat Receipt</a>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Bottom Provider Footer (Ref Image Style) -->
                        <div class="mt-8 pt-6 border-t border-slate-50 flex justify-between items-center text-[10px] font-bold text-slate-300 tracking-widest uppercase">
                            <span x-text="'Penyedia Jasa: ' + order.provider"></span>
                            <div class="flex items-center gap-1.5" x-show="order.type === 'in_progress'">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Staff sedang menuju lokasi Anda
                            </div>
                            <div class="flex items-center gap-1.5" x-show="order.type === 'completed'">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Layanan telah selesai dengan baik
                            </div>
                        </div>
                    </div>
                </template>

                <!-- No Results State -->
                <div x-show="filteredOrders.length === 0" class="py-20 text-center animate-on-load">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-300"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-brand-dark mb-2">Tidak ada pesanan ditemukan</h3>
                    <p class="text-slate-400 text-sm">Coba cari dengan kata kunci lain atau filter berbeda.</p>
                </div>
            </div>


            <!-- Premium Pagination (Ref Image Style) -->
            <div x-show="totalPages > 1" class="mt-16 flex items-center justify-center gap-2 animate-on-load">
                <!-- Prev Button -->
                <button @click="prevPage()" 
                        :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:border-brand-primary/20 hover:bg-slate-50'"
                        class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <!-- Page Numbers -->
                <div class="flex items-center gap-2">
                    <template x-for="p in totalPages" :key="p">
                        <button @click="currentPage = p; animateTabs()"
                                :class="currentPage === p ? 'bg-brand-dark text-white border-brand-dark shadow-lg shadow-brand-dark/20' : 'bg-white text-brand-dark border-slate-100 hover:bg-slate-50'"
                                class="w-12 h-12 rounded-2xl border font-bold text-xs transition-all"
                                x-text="p">
                        </button>
                    </template>
                </div>

                <!-- Next Button -->
                <button @click="nextPage()" 
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:border-brand-primary/20 hover:bg-slate-50'"
                        class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </main>

    <!-- Simple Premium Footer (Consistent with Dashboard) -->
    <footer class="py-12 px-6 border-t border-gray-100">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-brand-dark font-black tracking-tighter text-xl">JOS</div>
            <div class="flex items-center gap-8 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] font-jakarta">
                <a href="#" class="hover:text-brand-primary transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-brand-primary transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-brand-primary transition-colors">Contact Support</a>
            </div>
            <div class="text-[10px] text-gray-300 uppercase tracking-widest">© 2026 JOS Ecosystem. All rights reserved.</div>
        </div>
    </footer>

    <!-- GSAP Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Load Animations
            gsap.from('.animate-on-load', {
                y: 30,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out'
            });

            // Initial Scroll Animations
            initScrollAnimations();
        });

        function initScrollAnimations() {
            gsap.utils.toArray('.animate-on-scroll').forEach(item => {
                gsap.from(item, {
                    opacity: 0,
                    y: 40,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 90%',
                        toggleActions: 'play none none none'
                    }
                });
            });
        }

        function animateTabs() {
            // Kill existing animations on order items to avoid conflicts
            gsap.killTweensOf('.order-item');
            
            // Premium Emerging Upwards Animation
            gsap.fromTo('.order-item', 
                { 
                    opacity: 0, 
                    y: 40,
                    scale: 0.98,
                    filter: 'blur(10px)'
                },
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    filter: 'blur(0px)',
                    duration: 0.7,
                    stagger: {
                        amount: 0.3,
                        from: "start"
                    },
                    ease: 'power4.out',
                    clearProps: 'all' 
                }
            );
        }
    </script>
</body>
</html>
