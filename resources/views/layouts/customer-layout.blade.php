<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    @yield('extra-head')

    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
            --brand-dark: #000B44;
            --brand-primary: #0077B6;
            --premium-gray: #f8fafc;
        }

        body {
            font-family: var(--font-figtree);
            background-color: var(--premium-gray);
            color: var(--brand-dark);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">
    
    <x-customer.navbar />

    <main class="flex-grow pt-32 pb-20">
         @yield('content')
         {{ $slot ?? '' }}
    </main>

    <x-customer.footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.from('.animate-on-load', {
                    opacity: 0,
                    y: 30,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power2.out'
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>