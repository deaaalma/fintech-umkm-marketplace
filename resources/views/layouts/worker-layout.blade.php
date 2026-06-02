<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Worker Portal' }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@500..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-plus: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        .sidebar-item-active {
            background: #2D2D2D;
            color: white;
            border-radius: 12px;
        }
    </style>
</head>
<body class="font-figtree antialiased bg-[#F8F9FA] text-[#1A1A1A]">
    
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed h-full z-50">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-[#2D2D2D] rounded-xl flex items-center justify-center text-white font-black">
                        BWP
                    </div>
                    <div>
                        <h1 class="text-sm font-black tracking-tight">BWP Cleaning</h1>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Worker Portal</p>
                    </div>
                </div>

                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-4">Menu Staff</p>
                <nav class="space-y-1">
                    <a href="{{ route('worker.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold {{ request()->routeIs('worker.dashboard') ? 'sidebar-item-active' : 'text-gray-400 hover:text-gray-900 transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Home
                    </a>
                    <a href="{{ route('worker.sop') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold {{ request()->routeIs('worker.sop') ? 'sidebar-item-active' : 'text-gray-400 hover:text-gray-900 transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        SOP & Panduan
                    </a>
                    <a href="{{ route('worker.tasks') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold {{ request()->routeIs('worker.tasks') ? 'sidebar-item-active' : 'text-gray-400 hover:text-gray-900 transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Tugas Saya
                    </a>
                    <a href="{{ route('worker.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold {{ request()->routeIs('worker.profile') ? 'sidebar-item-active' : 'text-gray-400 hover:text-gray-900 transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-6 border-t border-gray-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-400 hover:text-red-600 transition-colors w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 ml-64 flex flex-col">
            {{-- Topbar --}}
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-40">
                <div class="flex items-center gap-4 text-xs font-bold text-gray-400">
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>

                <div class="flex items-center gap-4">
                    <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-100">
                        <div class="text-right">
                            <p class="text-sm font-black text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Staff Service</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2D2D2D&color=fff" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-10">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
