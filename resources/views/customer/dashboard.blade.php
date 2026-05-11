<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - JOS Premium</title>

    <!-- Fonts (Matched with Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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

        .premium-card-hover {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            border: 1px solid #f1f5f9;
        }

        .premium-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 11, 68, 0.08);
            border-color: var(--brand-soft);
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

        .gradient-text {
            background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card-blue {
            background-color: var(--brand-dark);
        }

        .stat-card-cyan {
            background-color: var(--brand-primary);
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #ffffff; }
        ::-webkit-scrollbar-thumb { 
            background: #e2e8f0; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-primary); }
    </style>
</head>
<body class="antialiased min-h-screen">
    @php
        $user = ['name' => 'Ahmad'];
        $navigationLinks = [
            ['name' => 'Overview', 'href' => '#', 'active' => true],
            ['name' => 'My Orders', 'href' => route('customer.orders.preview')],
            ['name' => 'Explore Partners', 'href' => route('customer.partners.preview')],
            ['name' => 'Support', 'href' => '#'],
        ];
    @endphp

    <!-- Premium Floating Navbar -->
    <nav x-data="{ isScrolled: false }" 
         x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 20)"
         class="fixed left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-6xl transition-all duration-500"
         :class="isScrolled ? 'top-4' : 'top-8'">
        <div :class="isScrolled ? 'nav-scrolled rounded-full py-3 shadow-2xl' : 'glass-nav rounded-[2.5rem] py-4 shadow-lg shadow-brand-dark/[0.015]'"
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

    <main class="pt-40 pb-20 px-6" id="main-content">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-green-50 border border-green-100 animate-on-load">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-[10px] font-bold text-green-600 uppercase tracking-[0.2em]">Online</span>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-5xl md:text-6xl text-brand-dark tracking-tighter leading-none animate-on-load">
                            <span class="font-bold">Welcome back,</span>
                        </h1>
                        <!-- Aceternity-style Typewriter Effect -->
                        <div class="flex items-center gap-2 overflow-hidden h-16 md:h-20 bg-transparent shadow-none border-none" id="typewriter-container">
                            <span class="text-5xl md:text-6xl font-georgia-italic italic font-normal text-brand-primary whitespace-nowrap" id="typewriter-text">
                                {{ $user['name'] }}
                            </span>
                            <div class="w-[4px] h-10 md:h-12 bg-brand-primary rounded-full" id="typewriter-cursor"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- Stat Card 1 -->
                <div class="premium-card-hover bg-[#f1f7ff] rounded-[2.5rem] p-10 premium-shadow flex flex-col justify-between h-[280px] animate-on-load">
                    <div class="w-14 h-14 rounded-2xl bg-[#f0f9ff] flex items-center justify-center text-brand-primary border border-brand-soft">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </div>
                    <div>
                        <div class="text-5xl font-black text-brand-dark tracking-tighter mb-1">02</div>
                        <div class="text-sm font-bold text-gray-500 uppercase tracking-widest font-jakarta">Active Orders</div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="premium-card-hover stat-card-blue rounded-[2.5rem] p-10 shadow-xl shadow-brand-dark/20 flex flex-col justify-between h-[280px] text-white animate-on-load">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-brand-cyan">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div>
                        <div class="text-5xl font-black tracking-tighter mb-1">12</div>
                        <div class="text-sm font-bold text-white/60 uppercase tracking-widest font-jakarta">Project Success</div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Active Projects -->
                <div class="lg:col-span-2 space-y-8 animate-on-scroll">
                    <div class="flex items-center justify-between">
                        <h2 class="text-3xl font-black text-brand-dark tracking-tighter">Recent Activities</h2>
                        <a href="#" class="text-xs font-bold text-brand-primary uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                            View All <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <div class="space-y-6">
                        <!-- Simplified Order Card 1 -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-primary/20 transition-all group">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest font-mono">#BWP-2026-0001</span>
                                        <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">BWP Cleaning Service</span>
                                    </div>
                                    <h4 class="text-2xl font-bold text-brand-dark tracking-tight group-hover:text-brand-primary transition-colors">Deep Cleaning Service</h4>
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Menunggu Review Admin</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-brand-dark">Rp 2.500.000</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga Total</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-8 py-8 border-t border-slate-50">
                                <div class="space-y-1">
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jadwal Pakai</div>
                                    <div class="text-sm font-bold text-brand-dark">16 Jan 2026</div>
                                    <div class="text-xs text-brand-primary font-medium">10:00 WIB</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Area Layanan</div>
                                    <div class="text-sm font-bold text-brand-dark">Denpasar, Bali</div>
                                </div>
                                <div class="col-span-2 md:col-span-1 flex items-center md:justify-end">
                                    <button class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-brand-dark hover:bg-slate-50 transition-all flex items-center gap-2">
                                        Detail Pesanan <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Simplified Order Card 2 (Active Action) -->
                        <div class="bg-white rounded-[2rem] p-8 border border-slate-100/50 hover:border-brand-primary/20 hover:shadow-xl hover:shadow-brand-primary/[0.03] hover:-translate-y-1 transition-all group">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest font-mono">#ABC-2026-0042</span>
                                        <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SecureLocal JOS</span>
                                    </div>
                                    <h4 class="text-2xl font-bold text-brand-dark tracking-tight group-hover:text-brand-primary transition-colors">Office Cleaning Service</h4>
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-brand-primary/5 rounded-full border border-brand-primary/10">
                                        <div class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></div>
                                        <span class="text-[10px] font-bold text-brand-primary uppercase tracking-wider">Perlu Tindakan Anda</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-brand-dark">Rp 3.200.000</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Belum Dibayar</div>
                                </div>
                            </div>

                            <div class="p-4 bg-slate-50 rounded-xl mb-8 flex items-center gap-4">
                                <span class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-brand-primary shadow-sm">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <p class="text-xs font-semibold text-slate-600">Admin telah mengirim pre-invoice. Silakan review sebelum melakukan pembayaran.</p>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-8 pt-8 border-t border-slate-50">
                                <div class="space-y-1">
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Target Kerja</div>
                                    <div class="text-sm font-bold text-brand-dark">18 Jan 2026</div>
                                </div>
                                <div class="space-y-1">
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi Proyek</div>
                                    <div class="text-sm font-bold text-brand-dark">Uluwatu, Bali</div>
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <button class="w-full py-3 rounded-xl bg-brand-dark text-white text-xs font-bold hover:bg-brand-primary transition-all shadow-md shadow-brand-dark/10">
                                        Review Pre-Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Content -->
                <div class="space-y-10 animate-on-scroll">
                    <div>
                        <h3 class="text-xl font-black text-brand-dark tracking-tighter mb-6">Partner Recommendations</h3>
                        <div class="space-y-4">
                            <div class="group bg-white rounded-2xl p-5 premium-shadow border border-gray-50 flex items-center gap-4 hover:bg-brand-primary transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=200&q=80" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-bold text-brand-dark text-sm truncate group-hover:text-white">Creative JOS Design</h5>
                                    <p class="text-[10px] text-gray-400 group-hover:text-white/60 font-jakarta font-bold uppercase tracking-widest">Digital Branding</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white/20 flex items-center justify-center text-brand-primary group-hover:text-white transition-all">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                            <div class="group bg-white rounded-2xl p-5 premium-shadow border border-gray-50 flex items-center gap-4 hover:bg-brand-primary transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=200&q=80" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-bold text-brand-dark text-sm truncate group-hover:text-white">Cloud JOS Infra</h5>
                                    <p class="text-[10px] text-gray-400 group-hover:text-white/60 font-jakarta font-bold uppercase tracking-widest">Server Solutions</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white/20 flex items-center justify-center text-brand-primary group-hover:text-white transition-all">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Notifications (Replaced Support Banner) -->
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-bold text-brand-dark tracking-tight">Notifikasi Terbaru</h3>
                            <span class="w-6 h-6 rounded-full bg-brand-dark text-white text-[10px] font-black flex items-center justify-center">3</span>
                        </div>

                        <div class="space-y-4">
                            <!-- Notification 1 (Unread) -->
                            <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-brand-primary mt-1.5 flex-shrink-0"></div>
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-brand-dark leading-tight">Pre-invoice dikirim untuk pesanan #BWP-2026-0001</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">5 menit lalu</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification 2 (Unread) -->
                            <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-brand-primary mt-1.5 flex-shrink-0"></div>
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-brand-dark leading-tight">Pembayaran dikonfirmasi #XYZ-2026-0033</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">2 jam lalu</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification 3 (Read) -->
                            <div class="p-5 bg-white rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-transparent border border-slate-200 mt-1.5 flex-shrink-0"></div>
                                    <div class="space-y-1">
                                        <p class="text-xs font-medium text-slate-500 leading-tight">Staff ditugaskan ke pesanan Anda</p>
                                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">1 hari lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="w-full mt-6 py-4 rounded-xl bg-slate-50 text-slate-600 text-[11px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all">
                            Lihat Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Simple Premium Footer -->
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

    <!-- GSAP Animations & Typewriter Logic -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Load Animations (Navbar, Header, Stats)
            const loadTl = gsap.timeline();
            
            // Initial hide state for on-load elements
            gsap.set('.animate-on-load', { opacity: 0, y: 30 });

            loadTl.to('.animate-on-load', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out'
            });

            // 2. Scroll Animations (Recent Activities & Sidebar)
            gsap.utils.toArray('.animate-on-scroll').forEach(section => {
                gsap.fromTo(section, 
                    { opacity: 0, y: 40 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 1,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: section,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });

            // 3. Typewriter Effect
            const container = document.getElementById('typewriter-container');
            const cursor = document.getElementById('typewriter-cursor');
            
            gsap.set(container, { width: 0 });
            gsap.set(cursor, { opacity: 0 });

            gsap.to(cursor, { 
                opacity: 1, 
                repeat: -1, 
                duration: 0.5, 
                yoyo: true, 
                ease: 'power2.inOut' 
            });

            gsap.to(container, {
                width: 'auto',
                duration: 1.5,
                ease: 'none',
                delay: 0.8,
                onStart: () => {
                    gsap.set(cursor, { opacity: 1 });
                }
            });
        });
    </script>
</body>
</html>
