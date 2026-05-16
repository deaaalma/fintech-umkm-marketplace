<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Portal' }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-white text-foreground">
    
    <div class="min-h-screen">
        <x-super-admin.navbar />

        <main class="pt-32">
            @if (isset($header))
                <div class="w-full bg-white border-b border-[#e5e5e5]">
                    <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
                        {{ $header }}
                    </div>
                </div>
            @endif

            <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
            <div class="max-w-[1400px] mx-auto px-8 py-8">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#666666] font-figtree">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                    <p class="text-sm text-[#666666] font-figtree">Superadmin Portal v1.0</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>