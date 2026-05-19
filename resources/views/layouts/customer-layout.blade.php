<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@500..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <style>
        :root {
            --brand-dark: #000B44;
            --brand-primary: #0077B6;
            --brand-soft: #CAF0F8;
        }
        .font-figtree { font-family: 'Figtree', sans-serif; }
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .premium-card-hover {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .premium-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 11, 68, 0.08);
        }
    </style>
</head>
<body class="font-figtree antialiased bg-[#F8FAFC] text-slate-900">
    
    <div class="min-h-screen flex flex-col">
        <x-customer.navbar />

        <main class="flex-1 pt-28 pb-12">
            <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <footer class="bg-white border-t border-[#e5e5e5] py-8">
            <div class="max-w-[1400px] mx-auto px-8 flex justify-between items-center">
                <p class="text-sm text-slate-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="text-sm text-slate-400 font-bold">Customer Portal v1.0</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>