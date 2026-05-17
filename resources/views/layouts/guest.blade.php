<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UMKM System') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
        }
        .font-circular-medium { font-family: var(--font-accent); font-weight: 500; }
        .font-circular-book { font-family: var(--font-accent); font-weight: 400; }
        .font-circular-bold { font-family: var(--font-accent); font-weight: 700; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 400; }
        .font-jakarta-bold { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
        .font-georgia-italic { font-family: Georgia, serif; font-style: italic; }
        
        .faq-grid-transition {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            opacity: 0;
        }
        .faq-grid-transition.open {
            grid-template-rows: 1fr;
            opacity: 1;
        }
        .faq-grid-content {
            overflow: hidden;
        }
        .logo-hover-blue:hover {
            filter: invert(31%) sepia(97%) saturate(1478%) hue-rotate(181deg) brightness(94%) contrast(101%) !important;
            opacity: 1 !important;
        }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-scroll { animation: scroll 30s linear infinite; }
        .animate-scroll-reverse { animation: scroll 30s linear infinite reverse; }
    </style>
</head>
<body class="font-sans antialiased bg-background text-foreground">
    
    <div class="min-h-screen">
        {{ $slot }}
    </div>

    @includeIf('landing-page.scripts')

</body>
</html>