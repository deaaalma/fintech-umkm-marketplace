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
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js & GSAP -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
            --brand-dark: #000B44;
            --brand-primary: #0077B6;
            --brand-cyan: #00B4D8;
            --brand-soft: #ADE8F4;
            --premium-white: #ffffff;
            --premium-gray: #f1f5f9;
        }

        body {
            font-family: var(--font-figtree);
            background-color: var(--premium-gray);
            color: var(--brand-dark);
            letter-spacing: -0.01em;
        }

        /* Dashboard specific Layout */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: var(--premium-white);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 40;
            overflow-y: auto;
        }

        /* Main Content Styling */
        .main-content {
            flex-grow: 1;
            padding: 1.5rem 2.5rem;
            min-width: 0;
            overflow-y: auto;
            position: relative;
        }

        /* Card System (from Customer Dashboard) */
        .premium-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 11, 68, 0.03);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .premium-card:hover {
            box-shadow: 0 20px 40px -10px rgba(0, 11, 68, 0.06);
            transform: translateY(-2px);
        }

        /* Sidebar Navigation Items */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: #64748b;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            margin-bottom: 0.25rem;
            text-decoration: none;
        }

        .nav-item svg {
            color: #94a3b8;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background-color: var(--premium-gray);
            color: var(--brand-dark);
        }

        .nav-item:hover svg {
            color: var(--brand-dark);
        }

        .nav-item.active {
            color: var(--brand-dark);
            font-weight: 700;
            background-color: var(--premium-gray);
            position: relative;
        }

        .nav-item.active svg {
            color: var(--brand-primary);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
            background-color: var(--brand-primary);
            border-radius: 0 4px 4px 0;
        }

        /* Typography Utilities */
        .font-jakarta { font-family: var(--font-accent); }
        .font-mono { font-family: var(--font-geist-mono); }
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-primary); }
    </style>
</head>
<body class="antialiased">
    <div class="dashboard-layout">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3 px-3 mb-8">
                <div class="w-8 h-8 rounded-lg bg-[var(--brand-dark)] flex items-center justify-center shadow-lg shadow-[var(--brand-dark)]/20">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                        <line x1="4" y1="22" x2="4" y2="15"/>
                    </svg>
                </div>
                <span class="font-bold text-lg text-[var(--brand-dark)] tracking-tight">UMKMConnect</span>
            </div>

            <!-- User Profile Box -->
            <div class="mb-8 px-2">
                <div class="bg-gray-50/80 border border-gray-100 rounded-2xl p-3 flex items-center justify-between cursor-pointer hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=0077B6&color=fff&rounded=true&bold=true" alt="Admin" class="w-9 h-9 rounded-full">
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[var(--brand-dark)] leading-tight">Admin System</div>
                            <div class="text-[10px] text-gray-400 font-medium">Superadmin</div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-3">Main Menu</div>
                <nav class="space-y-1 mb-8">
                    <a href="#" class="nav-item active">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('superadmin.users.preview') }}" class="nav-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-sm">Pengguna</span>
                        <span class="ml-auto bg-[var(--brand-primary)] text-white text-[9px] font-bold px-1.5 py-0.5 rounded">2</span>
                    </a>
                    <a href="{{ route('superadmin.transactions.preview') }}" class="nav-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="text-sm">Transaksi</span>
                    </a>
                    <a href="{{ route('superadmin.reports.preview') }}" class="nav-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-sm">Laporan</span>
                    </a>
                </nav>

                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-3">Preference</div>
                <nav class="space-y-1">
                    <a href="{{ route('superadmin.settings.preview') }}" class="nav-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-sm">Pengaturan</span>
                    </a>
                    <a href="#" class="nav-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm">Help Center</span>
                    </a>
                </nav>
            </div>
            
            <!-- Bottom Promotion Box -->
            <div class="mt-8 bg-[var(--brand-dark)] rounded-2xl p-5 text-white text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent to-white/10"></div>
                <!-- Box icon -->
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-white/10 rounded-xl mx-auto flex items-center justify-center mb-3 backdrop-blur-sm border border-white/10">
                        <svg class="w-5 h-5 text-[var(--brand-cyan)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h4 class="font-bold text-sm mb-1">Upgrade Plan</h4>
                    <p class="text-[10px] text-white/70 mb-4 leading-tight">"Upgrade sistem hari ini untuk membuka insight pintar."</p>
                    <button class="w-full py-2.5 bg-gradient-to-r from-[var(--brand-primary)] to-[var(--brand-cyan)] text-white text-xs font-bold rounded-xl hover:shadow-lg hover:shadow-[var(--brand-cyan)]/20 transition-all duration-300">Upgrade Plan ↗</button>
                </div>
            </div>
        </aside>

        <!-- MAIN LAYOUT SECITON -->
        <main class="main-content">
            
            <!-- Topbar Header -->
            <header class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-xl font-bold text-[var(--brand-dark)]">Home</h1>
                    <p class="text-sm text-gray-500 italic mt-0.5">"Track UMKM performance easily with AI insights."</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Search Bar -->
                    <div class="relative hidden md:block">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" placeholder="Search anything" class="pl-10 pr-20 py-2.5 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand-primary)] focus:border-transparent shadow-sm w-[300px] transition-all">
                        <div class="absolute inset-y-0 right-3 flex items-center gap-1">
                            <span class="px-1.5 py-0.5 text-[10px] font-bold bg-gray-100 border border-gray-200 text-gray-500 rounded">⌘</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold bg-gray-100 border border-gray-200 text-gray-500 rounded">F</span>
                        </div>
                    </div>
                    
                    <!-- Topbar Icons -->
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 shadow-sm border border-gray-200 hover:text-[var(--brand-primary)] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 shadow-sm border border-gray-200 hover:text-[var(--brand-primary)] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                    
                    <!-- Tiny Avatar Profile Dropdown Replacement -->
                    <div class="relative ml-2">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=000B44&color=fff&rounded=true" alt="Admin" class="w-9 h-9 rounded-full ring-2 ring-white shadow-sm cursor-pointer">
                    </div>
                </div>
            </header>

            <!-- Dashboard Grid Area -->
            
            <!-- ROW 1: High Level Stats -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                
                <!-- Main Highlight Card (Total Balance equivalent) -->
                <div class="col-span-1 md:col-span-4 lg:col-span-3">
                    <div class="premium-card h-full p-5 relative overflow-hidden bg-gradient-to-br from-[var(--brand-dark)] to-[#00176b] text-white">
                        <!-- Abstract Shapes matching image green gradients -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[var(--brand-cyan)] rounded-full mix-blend-screen filter blur-[50px] opacity-40"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[var(--brand-soft)] rounded-full mix-blend-screen filter blur-[40px] opacity-20"></div>
                        
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div>
                                <div class="flex items-center justify-between xl:mb-2">
                                    <span class="text-xs font-medium text-white/80">Total UMKM Aktif</span>
                                    <button class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                                
                                <div class="font-jakarta text-3xl xl:text-4xl font-extrabold mt-1 xl:mt-2">
                                    3,247
                                    <span class="text-xs font-normal text-white/70 ml-1">Toko</span>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-6">
                                <button class="flex-1 py-2 bg-white text-[var(--brand-dark)] rounded-xl text-[11px] font-bold flex items-center justify-center gap-1 hover:bg-gray-100 transition shadow-sm">
                                    Approved <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button class="flex-1 py-2 bg-white/10 border border-white/20 text-white rounded-xl text-[11px] font-bold flex items-center justify-center gap-1 hover:bg-white/20 transition">
                                    Pending ↗
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Three Stat Cards Group (AI Enhancements equivalent) -->
                <div class="col-span-1 md:col-span-8 lg:col-span-6 flex flex-col">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <h2 class="text-sm font-bold text-[var(--brand-dark)] border-l-3 border-[var(--brand-primary)] pl-2">Status Metrik</h2>
                        <button class="text-[10px] text-gray-400 font-bold uppercase tracking-wider flex items-center gap-1 hover:text-[var(--brand-primary)] border border-gray-200 px-2 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Tambah Filter
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 xl:gap-6 flex-1">
                        <!-- Stat 1 -->
                        <div class="premium-card p-4 flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-md bg-green-50 border border-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500">Berhasil</span>
                            </div>
                            <div class="flex items-end justify-between">
                                <span class="text-lg xl:text-xl font-extrabold text-[var(--brand-dark)] font-jakarta">2,891</span>
                                <span class="text-[9px] font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5"><svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg> 12.5%</span>
                            </div>
                        </div>

                        <!-- Stat 2 -->
                        <div class="premium-card p-4 flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-md bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500">Pending</span>
                            </div>
                            <div class="flex items-end justify-between">
                                <span class="text-lg xl:text-xl font-extrabold text-[var(--brand-dark)] font-jakarta">127</span>
                                <span class="text-[9px] font-bold text-amber-500 bg-amber-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5"><svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg> 2.1%</span>
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="premium-card p-4 flex flex-col justify-center">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 rounded-md bg-red-50 border border-red-100 flex items-center justify-center text-red-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500">Suspended</span>
                            </div>
                            <div class="flex items-end justify-between">
                                <span class="text-lg xl:text-xl font-extrabold text-[var(--brand-dark)] font-jakarta">189</span>
                                <span class="text-[9px] font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5"><svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg> 4.5%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Health Card (Finance Score equivalent) -->
                <div class="col-span-1 md:col-span-12 lg:col-span-3">
                    <div class="premium-card p-5 h-full relative flex flex-col">
                        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                        </button>
                        
                        <h2 class="text-sm font-bold text-[var(--brand-dark)] mb-6">Skor Sistem</h2>
                        
                        <div class="flex-1 flex flex-col justify-end pb-2">
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Kualitas Server</span>
                            <div class="flex items-end justify-between mb-3">
                                <span class="text-xl font-bold text-[var(--brand-dark)]">Excellent</span>
                                <span class="text-2xl font-extrabold text-[var(--brand-primary)] font-jakarta">92%</span>
                            </div>
                            <!-- Custom Progress Bar -->
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden border border-gray-200">
                                <div class="bg-gradient-to-r from-[var(--brand-dark)] to-[var(--brand-primary)] h-full rounded-full w-[92%] relative">
                                    <div class="absolute inset-0 bg-white/20 w-full animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ROW 2: Charts and Assistants -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                
                <!-- Main Activity Chart (Cashflow equivalent) -->
                <div class="col-span-1 md:col-span-7 lg:col-span-8">
                    <div class="premium-card p-6 h-full flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-[15px] font-bold text-[var(--brand-dark)]">Aktivitas Pendaftaran UMKM</h2>
                            <select class="text-xs font-semibold bg-gray-50 border border-gray-100 text-[var(--brand-dark)] rounded-lg px-3 py-1.5 outline-none hover:border-[var(--brand-primary)] cursor-pointer transition">
                                <option>Tahun Ini ▼</option>
                                <option>Tahun Lalu ▼</option>
                            </select>
                        </div>

                        <div class="flex items-end gap-12 mb-8">
                            <div>
                                <span class="text-xs text-gray-500 font-medium block mb-1">Total Pendaftaran</span>
                                <div class="text-3xl font-extrabold text-[var(--brand-dark)] font-jakarta flex items-baseline gap-2">
                                    5,620 <span class="text-sm font-semibold text-gray-400">Merchant</span>
                                </div>
                            </div>
                            
                            <!-- Legend -->
                            <div class="flex items-center gap-5 text-xs font-bold mb-1">
                                <div class="flex items-center gap-2 text-[var(--brand-dark)]">
                                    <span class="w-3 h-3 rounded bg-[var(--brand-dark)]"></span> Diterima
                                </div>
                                <div class="flex items-center gap-2 text-[var(--brand-cyan)]">
                                    <span class="w-3 h-3 rounded bg-[var(--brand-cyan)]"></span> Ditolak
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart Placeholder with CSS -->
                        <div class="flex-1 flex items-end justify-between gap-1 xl:gap-2 h-48 relative pt-6 border-b border-gray-100 pb-2">
                            <!-- Background Grid Lines -->
                            <div class="absolute inset-x-0 top-0 border-t border-dashed border-gray-200"></div>
                            <div class="absolute inset-x-0 top-1/4 border-t border-dashed border-gray-200"></div>
                            <div class="absolute inset-x-0 top-2/4 border-t border-dashed border-gray-200"></div>
                            <div class="absolute inset-x-0 top-3/4 border-t border-dashed border-gray-200"></div>
                            
                            <!-- Axis Labels Y -->
                            <div class="absolute -left-6 top-0 text-[9px] font-bold text-gray-400 -translate-y-1/2">8K</div>
                            <div class="absolute -left-6 top-1/4 text-[9px] font-bold text-gray-400 -translate-y-1/2">6K</div>
                            <div class="absolute -left-6 top-2/4 text-[9px] font-bold text-gray-400 -translate-y-1/2">4K</div>
                            <div class="absolute -left-6 top-3/4 text-[9px] font-bold text-gray-400 -translate-y-1/2">2K</div>
                            <div class="absolute -left-6 bottom-0 text-[9px] font-bold text-gray-400 translate-y-1/2">0</div>

                            @php
                                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                // Height data for Approved and Rejected (in percentage of total height)
                                $chartData = [
                                    [40, -20], [60, -30], [80, -40], [45, -15], [75, -25], [90, -30], 
                                    [50, -20], [65, -35], [85, -45], [55, -25], [70, -30], [45, -15]
                                ];
                            @endphp

                            @foreach($months as $i => $m)
                            <div class="flex flex-col items-center gap-1 group relative z-10 w-full h-[150%] translate-y-[25%]">
                                
                                <div class="flex flex-col w-3 xl:w-4 justify-center items-center h-full">
                                    <!-- Positive bar (Up) -->
                                    <div class="w-full bg-[var(--brand-dark)] rounded-t-sm hover:opacity-80 transition-opacity mt-auto origin-bottom transform duration-300" style="height: {{ $chartData[$i][0]/2 }}%;"></div>
                                    <!-- Negative bar (Down) -->
                                    <div class="w-full bg-[var(--brand-cyan)] rounded-b-sm hover:opacity-80 transition-opacity mb-auto origin-top transform duration-300" style="height: {{ abs($chartData[$i][1])/2 }}%;"></div>
                                </div>
                                <span class="text-[9px] xl:text-[10px] text-gray-400 font-bold mt-2 pt-2">{{ $m }}</span>
                                
                                <!-- Hover Tooltip -->
                                <div class="absolute top-[30%] opacity-0 group-hover:opacity-100 transition-opacity bg-[var(--brand-dark)] shadow-xl rounded-lg px-3 py-2 text-[10px] text-white font-bold text-center z-20 whitespace-nowrap pointer-events-none transform -translate-x-1/2 left-1/2 border border-white/10">
                                    {{ $m }} 2026<br>
                                    <div class="flex justify-between gap-3 mt-1 text-[9px]">
                                        <span class="text-green-400">Diterima: {{ $chartData[$i][0] * 100 }}</span>
                                        <span class="text-red-400">Ditolak: {{ abs($chartData[$i][1]) * 100 }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- AI Assistant Right Panel -->
                <div class="col-span-1 md:col-span-5 lg:col-span-4">
                    <div class="premium-card p-6 h-full flex flex-col relative bg-white">
                        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                        
                        <h2 class="text-[15px] font-bold text-[var(--brand-dark)] mb-auto">AI Assistant</h2>
                        
                        <div class="flex flex-col items-center text-center mt-6 z-10">
                            <!-- Orb shape -->
                            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-[var(--brand-primary)] to-[var(--brand-soft)] p-0.5 mb-6 shadow-xl shadow-[var(--brand-primary)]/20 animate-pulse">
                                <div class="w-full h-full bg-white rounded-full flex items-center justify-center relative overflow-hidden">
                                     <div class="absolute inset-0 bg-gradient-to-tr from-[var(--brand-dark)]/10 to-transparent"></div>
                                     <svg class="w-10 h-10 text-[var(--brand-primary)] relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                            </div>

                            <h3 class="font-extrabold text-[var(--brand-dark)] mb-3 text-lg tracking-tight">Apa yang bisa dibantu?</h3>
                            
                            <!-- Prompt Pill items -->
                            <div class="flex flex-wrap gap-2 justify-center mb-6 w-[90%]">
                                <span class="bg-gray-50 border border-gray-100 hover:border-gray-300 text-[9px] px-2.5 py-1.5 rounded-full text-gray-500 font-semibold cursor-pointer transition">Analisa UMKM</span>
                                <span class="bg-gray-50 border border-gray-100 hover:border-gray-300 text-[9px] px-2.5 py-1.5 rounded-full text-gray-500 font-semibold cursor-pointer transition">Bantu saya susun report pendaftaran</span>
                                <span class="bg-gray-50 border border-gray-100 hover:border-gray-300 text-[9px] px-2.5 py-1.5 rounded-full text-gray-500 font-semibold cursor-pointer transition">Deteksi UMKM fraud</span>
                                <span class="bg-gray-50 border border-gray-100 hover:border-gray-300 text-[9px] px-2.5 py-1.5 rounded-full text-gray-500 font-semibold cursor-pointer transition">Lainnya</span>
                            </div>
                        </div>

                        <!-- Input field -->
                        <div class="w-full mt-auto bg-white border border-gray-200 rounded-2xl p-1.5 pl-4 flex items-center shadow-sm focus-within:ring-2 focus-within:ring-[var(--brand-primary)] focus-within:border-transparent transition-all">
                            <svg class="w-4 h-4 text-[var(--brand-primary)] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <input type="text" placeholder="Tanya apapun..." class="flex-1 bg-transparent border-none text-xs text-[var(--brand-dark)] focus:outline-none focus:ring-0 px-2 py-2">
                            
                            <div class="flex items-center gap-1 right-1 relative">
                                <button class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                </button>
                                <button class="bg-[var(--brand-primary)] text-white text-[11px] font-bold px-4 py-2 rounded-xl flex items-center gap-1 hover:bg-[var(--brand-dark)] transition shadow-md shadow-[var(--brand-primary)]/30">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> Kirim
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ROW 3: Table and Bottom Stats -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 pb-10">
                
                <!-- Table (Recent Transactions) -->
                <div class="col-span-1 md:col-span-7 lg:col-span-7">
                    <div class="premium-card p-6 h-full flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-[15px] font-bold text-[var(--brand-dark)]">Aplikasi Terbaru</h2>
                            <div class="flex items-center gap-2">
                                <select class="text-[11px] font-semibold bg-gray-50 border border-gray-100 text-gray-600 rounded-lg px-3 py-1.5 outline-none hover:bg-gray-100 cursor-pointer">
                                    <option>Bulan Ini ▼</option>
                                    <option>Bulan Lalu ▼</option>
                                </select>
                                <button class="w-7 h-7 bg-gray-50 rounded border border-gray-100 flex items-center justify-center text-gray-500 hover:text-[var(--brand-primary)] hover:border-[var(--brand-primary)] transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-[10px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100">
                                        <th class="pb-3 px-2 flex items-center gap-1 cursor-pointer hover:text-gray-600">Nama Bisnis <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg></th>
                                        <th class="pb-3 px-2">Kategori</th>
                                        <th class="pb-3 px-2">Waktu Apply</th>
                                        <th class="pb-3 px-2 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $apps = [
                                            ['name' => 'Warung Sedap Malam', 'cat' => 'Kuliner', 'date' => '2026-09-25', 'time' => '10:00', 'status' => 'Diterima', 'color' => 'green'],
                                            ['name' => 'Konveksi Makmur', 'cat' => 'Fashion', 'date' => '2026-09-24', 'time' => '14:30', 'status' => 'Review', 'color' => 'amber'],
                                            ['name' => 'Bengkel Motor Jaya', 'cat' => 'Otomotif', 'date' => '2026-09-23', 'time' => '15:00', 'status' => 'Diterima', 'color' => 'green'],
                                            ['name' => 'Toko Kue Bunda', 'cat' => 'Kuliner', 'date' => '2026-09-22', 'time' => '09:15', 'status' => 'Pending', 'color' => 'red'],
                                        ];
                                    @endphp
                                    @foreach($apps as $app)
                                    <tr class="group hover:bg-gray-50/50 transition-colors border-b border-gray-50 last:border-b-0">
                                        <td class="py-3.5 px-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-{{ $app['color'] }}-500"></div>
                                                <span class="font-bold text-[var(--brand-dark)] text-xs group-hover:text-[var(--brand-primary)] transition">{{ $app['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-2">
                                            <span class="text-xs text-gray-600 font-medium">{{ $app['cat'] }}</span>
                                        </td>
                                        <td class="py-3.5 px-2">
                                            <div class="text-[11px] font-bold text-[var(--brand-dark)]">{{ $app['date'] }}</div>
                                            <div class="text-[9px] font-semibold text-gray-400">{{ $app['time'] }}</div>
                                        </td>
                                        <td class="py-3.5 px-2 text-right">
                                            <span class="inline-block px-2.5 py-1 text-[9px] font-bold rounded {{ $app['status'] == 'Diterima' ? 'bg-green-50 text-green-600' : ($app['status'] == 'Review' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-500') }}">
                                                {{ $app['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Splitted Cards Group -->
                <div class="col-span-1 md:col-span-5 lg:col-span-5 flex gap-6">
                    
                    <!-- Statistic Donut Chart -->
                    <div class="premium-card p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-[15px] font-bold text-[var(--brand-dark)]">Kategori</h2>
                            <select class="text-[10px] font-bold text-gray-500 bg-transparent outline-none cursor-pointer">
                                <option>Top ▼</option>
                            </select>
                        </div>

                        <!-- CSS Donut setup -->
                        <div class="flex-1 flex flex-col items-center justify-center my-4">
                            <div class="w-32 h-32 rounded-full border-[14px] border-[var(--brand-dark)] relative flex items-center justify-center shadow-lg shadow-[var(--brand-dark)]/10">
                                <!-- Donut Segments using clip-path overlays -->
                                <div class="absolute inset-[-14px] rounded-full border-[14px] border-[var(--brand-primary)] transition-all hover:scale-[1.02]" style="clip-path: polygon(0 0, 100% 0, 100% 65%, 0 65%); transform: rotate(20deg);"></div>
                                <div class="absolute inset-[-14px] rounded-full border-[14px] border-[var(--brand-soft)] transition-all hover:scale-[1.02]" style="clip-path: polygon(60% 60%, 100% 0, 100% 100%, 60% 100%);"></div>
                                
                                <div class="bg-white rounded-full w-full h-full flex flex-col items-center justify-center z-10">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Total</span>
                                    <span class="font-extrabold text-xl text-[var(--brand-dark)] font-jakarta leading-none">$3.5M</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mt-auto w-full pt-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded bg-[var(--brand-dark)] text-[8px] text-white flex items-center justify-center font-bold">60%</span>
                                    <span class="text-[11px] text-gray-600 font-bold">Kuliner</span>
                                </div>
                                <span class="text-xs font-bold text-[var(--brand-dark)]">1.948</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded bg-[var(--brand-primary)] text-[8px] text-white flex items-center justify-center font-bold">25%</span>
                                    <span class="text-[11px] text-gray-600 font-bold">Fashion</span>
                                </div>
                                <span class="text-xs font-bold text-[var(--brand-dark)]">811</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded bg-[var(--brand-soft)] text-[8px] text-[var(--brand-dark)] flex items-center justify-center font-bold">15%</span>
                                    <span class="text-[11px] text-gray-600 font-bold">Jasa</span>
                                </div>
                                <span class="text-xs font-bold text-[var(--brand-dark)]">487</span>
                            </div>
                        </div>
                    </div>

                    <!-- Exchange/Currency (Replace with Quick Settings/Roles) -->
                    <div class="premium-card p-6 flex-1 flex flex-col bg-white">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-[15px] font-bold text-[var(--brand-dark)]">Performa</h2>
                            <div class="bg-gray-50 text-[10px] text-gray-500 font-bold px-2 py-1 rounded cursor-pointer border border-gray-100">Bulan Ini</div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center">
                            
                            <!-- Conversion Visualizer -->
                            <div class="flex items-center justify-between mb-4 px-2">
                                <div class="flex items-center gap-1.5 font-bold text-[11px] text-gray-500 border border-gray-200 px-2 py-1 rounded-md">
                                    Visitors
                                </div>
                                <button class="w-6 h-6 rounded-full bg-[var(--brand-soft)] text-[var(--brand-primary)] flex items-center justify-center hover:bg-[var(--brand-primary)] hover:text-white transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                </button>
                                <div class="flex items-center gap-1.5 font-bold text-[11px] text-gray-500 border border-gray-200 px-2 py-1 rounded-md">
                                    Join
                                </div>
                            </div>

                            <div class="text-center mb-6">
                                <div class="font-jakarta text-3xl font-black text-[var(--brand-dark)]">64%</div>
                                <span class="text-[10px] font-bold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">Conversion Rate Naik</span>
                            </div>

                            <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4">
                                <div class="text-center">
                                    <div class="text-[9px] font-bold text-gray-400 uppercase mb-1">Visit</div>
                                    <div class="text-[11px] font-extrabold text-[var(--brand-dark)]">12.5K</div>
                                </div>
                                <div class="text-center border-l border-r border-gray-100">
                                    <div class="text-[9px] font-bold text-gray-400 uppercase mb-1">Daftar</div>
                                    <div class="text-[11px] font-extrabold text-[var(--brand-dark)]">8.0K</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-[9px] font-bold text-gray-400 uppercase mb-1">Aktif</div>
                                    <div class="text-[11px] font-extrabold text-[var(--brand-dark)]">7.8K</div>
                                </div>
                            </div>
                        </div>

                        <button class="w-full mt-auto py-2.5 bg-[var(--brand-primary)] text-white text-xs font-bold rounded-xl hover:bg-[var(--brand-dark)] transition shadow-md shadow-[var(--brand-primary)]/20">
                            Download Report
                        </button>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Initialization Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.from('.premium-card', {
                    opacity: 0,
                    y: 20,
                    duration: 0.8,
                    stagger: 0.05,
                    ease: 'power3.out',
                    clearProps: 'all'
                });
                
                // Sidebar items animation
                gsap.from('.nav-item', {
                    opacity: 0,
                    x: -10,
                    duration: 0.5,
                    stagger: 0.05,
                    ease: 'power2.out',
                    delay: 0.2
                });
            }
        });
    </script>
</body>
</html>
