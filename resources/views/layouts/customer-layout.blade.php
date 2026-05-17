<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Customer Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    @yield('extra-head')

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

        .font-jakarta { font-family: var(--font-accent); }
        .font-mono { font-family: var(--font-geist-mono); }
        .font-georgia-italic { font-family: Georgia, serif; font-style: italic; }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }

        .premium-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: 3rem;
            box-shadow: 0 15px 35px -10px rgba(0, 11, 68, 0.05);
        }

        @yield('extra-styles')
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">
    @include('customer.partials.navbar')

    <main class="flex-grow pt-40 pb-28 lg:pb-20">
        @yield('content')
    </main>

    @include('customer.partials.footer')

    @stack('scripts')
</body>
</html>
