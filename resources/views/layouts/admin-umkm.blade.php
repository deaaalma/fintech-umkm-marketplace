<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UMKM System') }} - Admin Mitra</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .active-nav { background: rgba(255, 255, 255, 0.05); position: relative; }
        .active-nav::after { content: ''; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #0077B6; border-radius: 0 4px 4px 0; }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F8FAFC] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    
    <div class="min-h-screen flex relative">
        <x-admin-umkm.sidebar />

        <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
            <x-admin-umkm.header :title="$title ?? 'Overview'" />

            <div class="px-8 lg:px-12 py-10">
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-auth.register-choice-modal />
</body>
</html>