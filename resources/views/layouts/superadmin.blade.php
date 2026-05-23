<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Super Admin Portal' }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased text-foreground">

    <div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
        <!-- Sidebar -->
        @include('components.super-admin.sidebar')

        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
            <!-- Top Header -->
            <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight flex items-center gap-2">
                            {{ $title ?? 'System Overview' }}
                        </h1>
                    </div>
                </div>

                <!-- Global Search -->
                <div class="hidden xl:flex flex-1 items-center justify-center mx-8">
                    <div class="w-full max-w-xl">
                        <livewire:super-admin.global-search />
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center gap-6">
                    <button class="relative w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-4 pl-6 border-l border-slate-100">
                        <div class="w-12 h-12 bg-slate-100 rounded-full overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=000B44&color=fff" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-10 lg:p-12 space-y-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
