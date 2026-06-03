<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Worker Portal' }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .active-nav { position: relative; }
        .active-nav::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 3px;
            background: #0077B6;
            border-radius: 0 4px 4px 0;
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased text-foreground">

    <div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
        {{-- Sidebar --}}
        <x-worker.sidebar />

        {{-- Main Content --}}
        <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
            {{-- Top Header --}}
            <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight">
                            {{ $title ?? 'Worker Portal' }}
                        </h1>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>

                {{-- User Actions --}}
                <div class="flex items-center gap-6">
                    @php
                        $unreadNotifications = \App\Models\UserNotification::where('user_id', auth()->id())->whereNull('read_at')->count();
                    @endphp
                    <a href="{{ route('worker.notifications') }}" class="relative w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all group" title="Notifikasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($unreadNotifications > 0)
                            <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                        @endif
                    </a>

                    <div class="flex items-center gap-4 pl-6 border-l border-slate-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-black text-[#000B44] font-plus">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Staff Service</p>
                        </div>
                        <div class="w-12 h-12 bg-[#000B44] rounded-full flex items-center justify-center overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                            <span class="text-white font-black text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content Area --}}
            <div class="p-10 lg:p-12 space-y-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
