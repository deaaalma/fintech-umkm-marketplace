<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Geist Mono CDN (Simulated/Fallback) -->
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js (for interactivity) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Fallback for Geist Mono if CDN fails or if we want specific overrides */
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
        }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-scroll { animation: scroll 30s linear infinite; }
        .animate-scroll-reverse { animation: scroll 30s linear infinite reverse; }
    </style>
</head>
<body class="font-sans antialiased bg-background text-foreground">
    <div class="min-h-screen">
        @php
            // Navbar Data
            $navigationLinks = [
                ['name' => 'Features', 'href' => '#features'],
                ['name' => 'Pricing', 'href' => '#pricing'],
                ['name' => 'Solutions', 'href' => '#solutions'],
                ['name' => 'Resources', 'href' => '#resources'],
            ];

            // Hero Data
            $stats = [
                ['value' => '1B+', 'description' => "Messages analyzed\ndaily", 'delay' => 0],
                ['value' => '99.9%', 'description' => "Accuracy in tone\ndetection", 'delay' => 0.2],
                ['value' => '50+', 'description' => "Languages supported\nworldwide", 'delay' => 0.4],
                ['value' => '1000+', 'description' => "Organizations using\nAuralink", 'delay' => 0.6],
            ];
            $dataPoints = [];
            $baseLeft = 1;
            $spacing = 32;
            for ($i = 0; $i < 50; $i++) {
                $direction = $i % 2 === 0 ? "down" : "up";
                $height = rand(88, 208);
                $top = $direction === "down" ? rand(250, 400) : rand(-80, 20);
                $dataPoints[] = [
                    'id' => $i,
                    'left' => $baseLeft + $i * $spacing,
                    'top' => $top,
                    'height' => $height,
                    'direction' => $direction,
                    'delay' => $i * 0.035,
                ];
            }

            // Product Teaser Data
            $teaser = [
                'dailyVolume' => "1,430,992,688",
                'dailyVolumeLabel' => "DAILY ANALYZED MESSAGES",
                'headline' => "The Intelligence Layer for Modern Communication",
                'subheadline' => "Auralink connects every call, chat, and meeting into a unified AI layer — delivering real-time insights, tone analysis, and team alignment across your favorite tools.",
                'videoSrc' => "https://cdn.sanity.io/files/1t8iva7t/production/a2cbbed7c998cf93e7ecb6dae75bab42b13139c2.mp4",
                'posterSrc' => "/images/design-mode/9ad78a5534a46e77bafe116ce1c38172c60dc21a-1069x1068.png",
                'primaryButtonText' => "Start analyzing",
                'primaryButtonHref' => "#",
                'secondaryButtonText' => "View API Docs",
                'secondaryButtonHref' => "#",
            ];

            // Case Studies Data
            $caseStudies = [
                [
                    'id' => 'notion', 'company' => 'Clandestine',
                    'logo' => '<svg fill="none" height="48" viewBox="0 0 38 48" width="38" xmlns="http://www.w3.org/2000/svg"><path d="m14.25 5c0 7.8701-6.37994 14.25-14.25 14.25v9.5h14.25v14.25h9.5c0-7.8701 6.3799-14.25 14.25-14.25v-9.5h-14.25v-14.25z" fill="#16b364"/></svg>',
                    'title' => "Clandestine uses Auralink to understand how their teams collaborate in real-time.",
                    'features' => ["Slack Calls", "Meeting Transcripts", "Sentiment Reports"],
                    'quote' => "Auralink gives us clarity on team alignment we never had before.",
                    'attribution' => "Marie Chen, Head of Operations, Clandestine",
                    'accentColor' => "#16b364",
                ],
                [
                    'id' => 'cloudwatch', 'company' => 'Cloudwatch',
                    'logo' => '<svg fill="none" height="48" viewBox="0 0 192 48" width="192" xmlns="http://www.w3.org/2000/svg"><text fill="currentColor" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="600" x="58" y="32">Cloudwatch</text><rect fill="#3b82f6" height="48" rx="12" width="48"/><path d="m23.9995 14.25c5.3848 0 9.7505 4.3658 9.7505 9.7506s-4.3657 9.7505-9.7505 9.7505-9.7506-4.3657-9.7506-9.7505 4.3658-9.7506 9.7506-9.7506z" fill="#fff" x="0" y="0"/></svg>',
                    'title' => "Cloudwatch leverages Auralink to monitor cross-functional team dynamics across global offices.",
                    'features' => ["Slack Calls", "Meeting Transcripts", "Sentiment Reports"],
                    'quote' => "With Auralink, we can see collaboration patterns that directly impact our product velocity.",
                    'attribution' => "Sarah Chen, VP Engineering, Cloudwatch",
                    'accentColor' => "#3b82f6",
                ],
                [
                    'id' => 'eightball', 'company' => 'EightBall',
                    'logo' => '<svg fill="none" height="48" viewBox="0 0 151 48" width="151" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="m20 44c11.0457 0 20-8.9543 20-20s-8.9543-20-20-20-20 8.9543-20 20 8.9543 20 20 20zm5-16c4.9706 0 9-4.0294 9-9s-4.0294-9-9-9-9 4.0294-9 9 4.0294 9 9 9z" fill="#0A0D12" fill-rule="evenodd"/><text fill="#0A0D12" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="bold" x="50" y="32">EightBall</text></svg>',
                    'title' => "EightBall relies on Auralink to track team health metrics and async communication quality.",
                    'features' => ["Slack Calls", "Sentiment Reports"],
                    'quote' => "Auralink transformed how we understand our remote-first culture.",
                    'attribution' => "Karri Saarinen, Co-founder, EightBall",
                    'accentColor' => "#0A0D12",
                ],
                [
                    'id' => 'coreos', 'company' => 'CoreOS',
                    'logo' => '<svg fill="none" height="48" viewBox="0 0 155 48" width="155" xmlns="http://www.w3.org/2000/svg"><rect fill="#101828" height="48" rx="12" width="48"/><text fill="#101828" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="bold" x="60" y="32">CoreOS</text></svg>',
                    'title' => "CoreOS uses Auralink to ensure design and engineering teams stay in sync during sprints.",
                    'features' => ["Meeting Transcripts", "Sentiment Reports"],
                    'quote' => "The sentiment analysis helps us identify friction points before they become blockers.",
                    'attribution' => "Noah Levin, VP Engineering, CoreOS",
                    'accentColor' => "#155eef",
                ]
            ];

            // Integration Data
            $apps = [
                ['name' => 'Integration 1', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-389-Hc8XBOUI8vkVmIwWQZs33kxMF353Xj.png'],
                ['name' => 'Integration 2', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-407-eyikTTM6ccO0f4I7ZmNk5LpFI4EKOG.png'],
                ['name' => 'Integration 3', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-379-5hDaxwIw4LzjwXzWuorEXi7ESrGYl1.png'],
                ['name' => 'Integration 4', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-374-bp0RaoVnQI1JMqR9fjessWI8v33kLV.png'],
                ['name' => 'Integration 5', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-381-eKw7vkCp2Wq9hivZJaN1ERJdjCqR0d.png'],
                ['name' => 'Integration 6', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-401-F6mjMLGEZt4HAohKA889Z8Gf5fMzIw.png'],
                ['name' => 'Integration 1-dup', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-389-Hc8XBOUI8vkVmIwWQZs33kxMF353Xj.png'],
                ['name' => 'Integration 2-dup', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-407-eyikTTM6ccO0f4I7ZmNk5LpFI4EKOG.png'],
            ];

            // Pricing Data
            $plans = [
                ['name' => 'Starter', 'level' => 'starter', 'price' => ['monthly' => 29, 'yearly' => 290], 'popular' => false],
                ['name' => 'Pro', 'level' => 'pro', 'price' => ['monthly' => 99, 'yearly' => 990], 'popular' => true],
                ['name' => 'Enterprise', 'level' => 'enterprise', 'price' => ['monthly' => 299, 'yearly' => 2990], 'popular' => false],
            ];
            $pricingFeatures = [
                ['name' => "Real-time conversation analysis", 'included' => "starter"],
                ['name' => "Up to 10,000 messages/month", 'included' => "starter"],
                ['name' => "Basic sentiment detection", 'included' => "starter"],
                ['name' => "Email support", 'included' => "starter"],
                ['name' => "Advanced emotional intelligence", 'included' => "pro"],
                ['name' => "Up to 100,000 messages/month", 'included' => "pro"],
                ['name' => "Multi-language support (50+ languages)", 'included' => "pro"],
                ['name' => "Priority support", 'included' => "pro"],
                ['name' => "Custom AI model training", 'included' => "enterprise"],
                ['name' => "Unlimited messages", 'included' => "enterprise"],
                ['name' => "Dedicated account manager", 'included' => "enterprise"],
                ['name' => "24/7 phone support", 'included' => "enterprise"],
                ['name' => "API access", 'included' => "all"],
                ['name' => "Team collaboration tools", 'included' => "all"],
            ];
            // Helper closure for pricing logic
            $shouldShowCheck = function($included, $level) {
                if ($included === 'all') return true;
                if ($included === 'enterprise' && $level === 'enterprise') return true;
                if ($included === 'pro' && ($level === 'pro' || $level === 'enterprise')) return true;
                if ($included === 'starter') return true; 
                return false;
            };

            // FAQ Data
            $faqs = [
                ['question' => "What is Auralink and how does it work?", 'answer' => "Auralink is an AI-powered intelligence layer that connects all your communication tools—calls, chats, and meetings—into a unified system."],
                ['question' => "How does Auralink use my data to build a custom AI chat?", 'answer' => "Auralink processes your communication data using advanced natural language processing and machine learning models. All data is encrypted end-to-end."],
                ['question' => "How do I get started with Auralink and what are the pricing options?", 'answer' => "Getting started is simple: sign up for a free trial, connect your communication tools, and start analyzing within minutes."],
            ];

            // Footer Data
            $footerSections = [
                ['title' => "Product", 'links' => [['label' => "Features", 'href' => "#"], ['label' => "Pricing", 'href' => "#"]]],
                ['title' => "Company", 'links' => [['label' => "About", 'href' => "#"], ['label' => "Contact", 'href' => "#"]]],
                ['title' => "Resources", 'links' => [['label' => "Documentation", 'href' => "#"], ['label' => "Help Center", 'href' => "#"]]],
                ['title' => "Legal", 'links' => [['label' => "Privacy", 'href' => "#"], ['label' => "Terms", 'href' => "#"]]],
            ];
        @endphp

        <!-- Navbar -->
        <nav
            x-data="{
                isMobileMenuOpen: false,
                isScrolled: false,
                init() { window.addEventListener('scroll', () => { this.isScrolled = window.scrollY > 20; }); },
                handleLinkClick(href) {
                    this.isMobileMenuOpen = false;
                    const element = document.querySelector(href);
                    if (element) element.scrollIntoView({ behavior: 'smooth' });
                }
            }"
            :class="isScrolled ? 'bg-background/95 backdrop-blur-md shadow-sm' : 'bg-transparent'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        >
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0">
                        <button @click="handleLinkClick('#home')" class="text-2xl font-bold text-foreground hover:text-primary transition-colors duration-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span style="font-family: 'Figtree', sans-serif; font-weight: 800;">Auralink</span>
                        </button>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            @foreach($navigationLinks as $link)
                                <button @click="handleLinkClick('{{ $link['href'] }}')" class="text-foreground hover:text-primary px-3 py-2 text-base font-medium transition-colors duration-200 relative group" style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                                    <span>{{ $link['name'] }}</span>
                                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <button @click="handleLinkClick('#contact')" class="bg-[#156d95] text-white px-[18px] rounded-full text-base font-semibold hover:bg-[#156d95]/90 transition-all duration-200 hover:rounded-2xl shadow-sm hover:shadow-md whitespace-nowrap leading-4 py-[15px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span style="font-family: 'Figtree', sans-serif; font-weight: 500;">Start Free Trial</span>
                        </button>
                    </div>
                    <div class="md:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-foreground hover:text-primary p-2 rounded-md transition-colors duration-200" aria-label="Toggle mobile menu">
                            <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 h-0" x-transition:enter-end="opacity-100 h-auto" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 h-auto" x-transition:leave-end="opacity-0 h-0" class="md:hidden bg-background/95 backdrop-blur-md border-t border-border overflow-hidden">
                <div class="px-6 py-6 space-y-4">
                    @foreach($navigationLinks as $link)
                        <button @click="handleLinkClick('{{ $link['href'] }}')" class="block w-full text-left text-foreground hover:text-primary py-3 text-lg font-medium transition-colors duration-200" style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                            <span>{{ $link['name'] }}</span>
                        </button>
                    @endforeach
                    <div class="pt-4 border-t border-border">
                        <button @click="handleLinkClick('#contact')" class="w-full bg-[#156d95] text-white px-[18px] py-[15px] rounded-full text-base font-semibold hover:bg-[#156d95]/90 transition-all duration-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span>Start Free Trial</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="w-full overflow-hidden bg-white" x-data="{ isVisible: false }" x-init="setTimeout(() => isVisible = true, 100)">
            <div class="mx-auto max-w-7xl px-8 py-24 pt-16">
                <div class="grid grid-cols-12 gap-5 gap-y-16">
                    <div class="col-span-12 md:col-span-6 relative z-10">
                        <div class="relative h-6 inline-flex items-center font-mono uppercase text-xs text-[#167E6C] mb-12 px-2" style="font-family: 'Geist Mono', monospace;">
                            <div class="flex items-center gap-0.5 overflow-hidden">
                                <span class="block whitespace-nowrap overflow-hidden text-[#167E6C] relative z-10 transition-all duration-800 ease-out" style="color: #146e96;" :style="isVisible ? 'width: auto' : 'width: 0'">Trusted at scale</span>
                                <span class="block w-1.5 h-3 bg-[#167E6C] ml-0.5 relative z-10 rounded-sm animate-pulse" style="color: #146e96;"></span>
                            </div>
                        </div>
                        <h2 class="text-[40px] font-normal leading-tight tracking-tight text-[#111A4A] mb-6" style="font-family: 'Figtree', sans-serif;">
                            Analyzing billions of conversations daily <span class="opacity-40">for the world's most sophisticated teams and enterprises.</span>
                        </h2>
                        <p class="text-lg leading-6 text-[#111A4A] opacity-60 mt-0 mb-6" style="font-family: 'Figtree', sans-serif;">As the intelligence layer for modern communication, we provide real-time insights and emotional detection through our advanced AI-powered platform.</p>
                        <button class="relative inline-flex justify-center items-center leading-4 text-center cursor-pointer whitespace-nowrap outline-none font-medium h-9 text-[#232730] bg-white/50 backdrop-blur-sm shadow-[0_1px_1px_0_rgba(255,255,255,0),0_0_0_1px_rgba(87,90,100,0.12)] transition-all duration-200 ease-in-out rounded-lg px-4 mt-5 text-sm group hover:shadow-[0_1px_2px_0_rgba(0,0,0,0.05),0_0_0_1px_rgba(87,90,100,0.18)]">
                            <span class="relative z-10 flex items-center gap-1">Learn about our platform <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 -mr-1 transition-transform duration-150 group-hover:translate-x-1"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <div class="relative w-full h-[416px] -ml-[200px]">
                            <div class="absolute top-0 left-[302px] w-[680px] h-[416px] pointer-events-none">
                                <div class="relative w-full h-full">
                                    @foreach($dataPoints as $point)
                                        <div class="absolute w-1.5 rounded-[3px] transition-all duration-[2000ms] ease-[cubic-bezier(0.5,0,0.01,1)]" style="left: {{ $point['left'] }}px; top: {{ $point['top'] }}px; background: {{ $point['direction'] === 'down' ? 'linear-gradient(rgb(176, 200, 196) 0%, rgb(176, 200, 196) 10%, rgba(156, 217, 93, 0.1) 40%, rgba(113, 210, 240, 0) 75%)' : 'linear-gradient(to top, rgb(176, 200, 196) 0%, rgb(176, 200, 196) 10%, rgba(156, 217, 93, 0.1) 40%, rgba(113, 210, 240, 0) 75%)' }}; background-color: rgba(22, 126, 108, 0.01); transition-delay: {{ $point['delay'] * 1000 }}ms;" :style="isVisible ? 'opacity: 1; height: {{ $point['height'] }}px' : 'opacity: 0; height: 0'">
                                            <div class="absolute -left-[1px] w-2 h-2 bg-[#167E6C] rounded-full transition-opacity duration-300" style="top: {{ $point['direction'] === 'down' ? '0px' : ($point['height'] - 8) . 'px' }}; transition-delay: {{ ($point['delay'] + 1.7) * 1000 }}ms;" :style="isVisible ? 'opacity: 1' : 'opacity: 0'"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="overflow-visible pb-5">
                            <div class="grid grid-cols-12 gap-5 relative z-10">
                                @foreach($stats as $stat)
                                    <div class="col-span-6 md:col-span-3">
                                        <div class="flex flex-col gap-2 transition-all duration-[1500ms] ease-[cubic-bezier(0.1,0,0.1,1)]" style="transition-delay: {{ $stat['delay'] * 1000 }}ms;" :style="isVisible ? 'opacity: 1; transform: translateY(0); filter: blur(0px)' : 'opacity: 0; transform: translateY(20px); filter: blur(4px)'">
                                            <span class="text-2xl font-medium leading-[26.4px] tracking-tight text-[#167E6C]" style="color: #146e96;">{{ $stat['value'] }}</span>
                                            <p class="text-xs leading-[13.2px] text-[#7C7F88] m-0 whitespace-pre-line">{{ $stat['description'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Teaser -->
        <section class="w-full px-8 pt-32 pb-16">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-12 gap-2">
                    <div x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown ? 'opacity-100' : 'opacity-0'" class="col-span-12 lg:col-span-6 bg-[#e9e9e9] rounded-[40px] p-12 lg:p-16 flex flex-col justify-end aspect-square overflow-hidden transition-opacity duration-1000 ease-out">
                        <div class="flex flex-col gap-1 text-[#9a9a9a]">
                            <span class="text-sm uppercase tracking-tight font-mono flex items-center gap-1" style="font-family: 'Geist Mono', monospace;">
                                {{ $teaser['dailyVolumeLabel'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-[0.71em] h-[0.71em]"><path d="M7 7h10v10"/><path d="M7 17L17 7"/></svg>
                            </span>
                            <span class="text-[32px] leading-[160px] tracking-tight bg-gradient-to-r from-[#202020] via-[#00517f] via-[#52aee3] to-[#9ed2fc] bg-clip-text text-transparent" style="font-feature-settings: 'clig' 0, 'liga' 0; height: 98px; display: none;">{{ $teaser['dailyVolume'] }}</span>
                        </div>
                        <h1 class="text-[56px] leading-[60px] tracking-tight text-[#202020] max-w-[520px] mb-6" style="font-weight: 500; font-family: 'Figtree', sans-serif;">{{ $teaser['headline'] }}</h1>
                        <p class="text-lg leading-7 text-[#404040] max-w-[520px] mb-6" style="font-family: 'Figtree', sans-serif;">{{ $teaser['subheadline'] }}</p>
                        <ul class="flex gap-1.5 flex-wrap mt-10">
                            <li><a href="{{ $teaser['primaryButtonHref'] }}" class="block cursor-pointer text-white bg-[#156d95] rounded-full px-[18px] py-[15px] text-base leading-4 whitespace-nowrap transition-all duration-150 ease-out hover:rounded-2xl">{{ $teaser['primaryButtonText'] }}</a></li>
                            <li><a href="{{ $teaser['secondaryButtonHref'] }}" class="block cursor-pointer text-[#202020] border border-[#202020] rounded-full px-[18px] py-[15px] text-base leading-4 whitespace-nowrap transition-all duration-150 ease-out hover:rounded-2xl">{{ $teaser['secondaryButtonText'] }}</a></li>
                        </ul>
                    </div>
                    <div x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" :class="shown ? 'opacity-100' : 'opacity-0'" class="col-span-12 lg:col-span-6 bg-white rounded-[40px] flex justify-center items-center aspect-square overflow-hidden transition-opacity duration-1000 ease-out" style="background-image: url('https://storage.googleapis.com/storage.magicpath.ai/user/282171029206482944/assets/882ef3dd-3459-4fd8-a939-52ceada51d5c.png'); background-size: cover; background-position: center;">
                        <video src="{{ $teaser['videoSrc'] }}" autoplay muted loop playsinline poster="{{ $teaser['posterSrc'] }}" class="block w-full h-full object-cover"></video>
                    </div>
                </div>
            </div>
        </section>

        <!-- Case Studies -->
        <div class="w-full min-h-screen bg-gradient-to-br from-background via-background to-muted/20 flex items-center justify-center py-24 px-8" x-data="{ currentIndex: 0, direction: 1, isAutoPlaying: true, timer: null, caseStudies: {{ json_encode($caseStudies) }}, init() { this.startAutoPlay(); }, startAutoPlay() { this.stopAutoPlay(); this.timer = setInterval(() => { this.nextSlide(); }, 5000); }, stopAutoPlay() { if (this.timer) { clearInterval(this.timer); this.timer = null; } }, nextSlide() { this.direction = 1; this.currentIndex = (this.currentIndex + 1) % this.caseStudies.length; }, prevSlide() { this.direction = -1; this.currentIndex = (this.currentIndex - 1 + this.caseStudies.length) % this.caseStudies.length; }, goToSlide(index) { this.direction = index > this.currentIndex ? 1 : -1; this.currentIndex = index; } }" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()">
            <div class="max-w-7xl w-full">
                <div class="text-center mb-16">
                    <h1 class="text-[40px] leading-tight font-normal text-foreground mb-6 tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Customer Success Stories</h1>
                    <p class="text-lg leading-7 text-muted-foreground max-w-2xl mx-auto" style="font-family: 'Figtree', sans-serif;">See how leading teams use Auralink to gain clarity on collaboration and team alignment.</p>
                </div>
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8 min-h-[400px]">
                        <template x-for="(study, index) in caseStudies" :key="study.id">
                            <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200 transform absolute" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-8" class="space-y-6 w-full">
                                <div class="text-foreground/60" x-html="study.logo"></div>
                                <h2 class="text-4xl font-bold text-foreground leading-tight tracking-tight" style="font-family: 'Figtree', sans-serif; font-weight: 400; font-size: 32px;"><span x-text="study.title"></span></h2>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="feature in study.features">
                                        <span class="flex items-center gap-2 bg-white/75 shadow-sm border border-black/5 rounded-lg px-2 py-1 text-sm font-medium text-foreground"><span x-text="feature"></span></span>
                                    </template>
                                </div>
                                <blockquote class="border-l-4 border-primary pl-6 py-2">
                                    <p class="text-lg leading-7 text-foreground/80 italic mb-3" style="font-family: 'Figtree', sans-serif;">"<span x-text="study.quote"></span>"</p>
                                    <footer class="text-sm text-muted-foreground" style="font-family: 'Inter', sans-serif;"><span x-text="study.attribution"></span></footer>
                                </blockquote>
                            </div>
                        </template>
                        <div class="flex items-center gap-6 mt-8 relative z-10">
                            <div class="flex gap-2">
                                <template x-for="(study, index) in caseStudies" :key="index">
                                    <button @click="goToSlide(index)" class="h-2 rounded-full transition-all duration-300" :class="index === currentIndex ? 'w-8 bg-primary' : 'w-2 bg-muted-foreground/30 hover:bg-muted-foreground/50'" :aria-label="'Go to slide ' + (index + 1)"></button>
                                </template>
                            </div>
                            <div class="flex gap-2">
                                <button @click="prevSlide()" class="p-2 rounded-lg border border-border hover:bg-accent transition-colors"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                <button @click="nextSlide()" class="p-2 rounded-lg border border-border hover:bg-accent transition-colors"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            </div>
                        </div>
                    </div>
                    <!-- Right Content (Generic Card) -->
                    <div class="relative h-[500px] flex items-center justify-center">
                        <div class="relative w-full h-full flex items-center justify-center">
                            <template x-for="(study, index) in caseStudies" :key="study.id + '-card'">
                                <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-300 absolute" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95" class="absolute w-[380px] rounded-xl p-6 backdrop-blur-xl bg-white/85 shadow-2xl border border-white/80" style="box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12);">
                                    <div class="flex flex-col space-y-5">
                                        <div class="flex items-center justify-between"><h4 class="text-sm font-semibold text-foreground">Team Alignment</h4><span class="text-xs text-muted-foreground">Real-time</span></div>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between p-3 bg-muted/30 rounded-lg"><div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-green-500"></div><span class="text-sm text-foreground">Design Team</span></div><span class="text-sm font-semibold text-green-600">96%</span></div>
                                            <div class="flex items-center justify-between p-3 bg-muted/30 rounded-lg"><div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full" :style="'background-color: ' + study.accentColor"></div><span class="text-sm text-foreground">Engineering</span></div><span class="text-sm font-semibold" :style="'color: ' + study.accentColor">94%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integrations -->
        <div class="w-full py-24 bg-white overflow-hidden">
            <div class="max-w-[680px] mx-auto text-center mb-20 px-4">
                <h2 class="text-[40px] leading-tight font-normal text-[#222222] tracking-tight mb-4" style="font-family: 'Figtree', sans-serif;">Integrates with your entire collaboration stack.</h2>
                <p class="text-lg leading-7 text-[#666666] max-w-[600px] mx-auto" style="font-family: 'Figtree', sans-serif;">Connect Auralink to Slack, Zoom, Notion, Google Meet, and dozens of others to analyze communication seamlessly.</p>
                <div class="mt-8"><a href="#" class="inline-block px-5 py-2.5 rounded-full bg-white text-[#222222] text-[15px] font-medium transition-all duration-75 hover:shadow-lg border border-[#e3e3e3]">Explore Integrations</a></div>
            </div>
            <div class="relative h-[268px] -mt-6">
                <div class="flex items-start gap-6 absolute top-6 whitespace-nowrap animate-scroll w-max">
                    @foreach($apps as $app)<div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]"><img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy"></div>@endforeach
                    @foreach($apps as $app)<div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]"><img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy"></div>@endforeach
                </div>
                <div class="flex items-start gap-6 absolute top-[148px] whitespace-nowrap animate-scroll-reverse w-max">
                    @foreach(array_reverse($apps) as $app)<div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]"><img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy"></div>@endforeach
                    @foreach(array_reverse($apps) as $app)<div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]"><img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy"></div>@endforeach
                </div>
                <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
            </div>
        </div>

        <!-- Pricing -->
        <section class="py-24 bg-background" x-data="{ isYearly: false, selectedPlan: 'pro' }" id="pricing">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-sans text-[40px] font-normal leading-tight mb-4" style="font-family: 'Figtree', sans-serif;">Choose Your Plan</h2>
                    <p class="font-sans text-lg text-muted-foreground max-w-2xl mx-auto" style="font-family: 'Figtree', sans-serif;">Get started with Auralink's communication intelligence platform. All plans include API access and team collaboration.</p>
                </div>
                <div class="flex justify-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-secondary rounded-full p-1">
                        <button type="button" @click="isYearly = false" :class="!isYearly ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'" class="px-6 py-2 rounded-full font-sans text-lg transition-all" style="font-family: 'Figtree', sans-serif;">Monthly</button>
                        <button type="button" @click="isYearly = true" :class="isYearly ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'" class="px-6 py-2 rounded-full font-sans text-lg transition-all " style="font-family: 'Figtree', sans-serif;">Yearly<span class="ml-2 text-sm text-[#156d95]">Save 17%</span></button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @foreach($plans as $plan)
                        <button type="button" @click="selectedPlan = '{{ $plan['level'] }}'" :class="selectedPlan === '{{ $plan['level'] }}' ? 'border-[#156d95] bg-[#156d95]/5' : 'border-border hover:border-[#156d95]/50'" class="relative p-8 rounded-2xl text-left transition-all border-2">
                            @if($plan['popular']) <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#156d95] text-white px-4 py-1 rounded-full text-sm font-sans" style="font-family: 'Figtree', sans-serif;">Most Popular</span> @endif
                            <div class="mb-6"><h3 class="font-sans text-2xl font-medium mb-2" style="font-family: 'Figtree', sans-serif;">{{ $plan['name'] }}</h3><div class="flex items-baseline gap-1"><span class="font-sans text-4xl font-medium" style="font-family: 'Figtree', sans-serif;" x-text="isYearly ? '${{ $plan['price']['yearly'] }}' : '${{ $plan['price']['monthly'] }}'"></span><span class="font-sans text-lg text-muted-foreground" style="font-family: 'Figtree', sans-serif;" x-text="isYearly ? '/year' : '/month'"></span></div></div>
                            <div :class="selectedPlan === '{{ $plan['level'] }}' ? 'bg-[#156d95] text-white' : 'bg-secondary text-foreground'" class="w-full py-3 px-6 rounded-full font-sans text-lg transition-all text-center" style="font-family: 'Figtree', sans-serif;"><span x-text="selectedPlan === '{{ $plan['level'] }}' ? 'Selected' : 'Select Plan'"></span></div>
                        </button>
                    @endforeach
                </div>
                <div class="border border-border rounded-2xl overflow-hidden bg-white">
                    <div class="overflow-x-auto">
                        <div class="min-w-[768px]">
                            <div class="flex items-center p-6 bg-secondary border-b border-border"><div class="flex-1"><h3 class="font-sans text-xl font-medium" style="font-family: 'Figtree', sans-serif;">Features</h3></div><div class="flex items-center gap-8">@foreach($plans as $plan)<div class="w-24 text-center font-sans text-lg font-medium" style="font-family: 'Figtree', sans-serif;">{{ $plan['name'] }}</div>@endforeach</div></div>
                            @foreach($pricingFeatures as $index => $feature)
                                <div :class="{ 'bg-background': {{ $index % 2 === 0 ? 'true' : 'false' }}, 'bg-secondary/30': {{ $index % 2 !== 0 ? 'true' : 'false' }}, 'bg-[#156d95]/5': '{{ $feature['included'] }}' === selectedPlan }" class="flex items-center p-6 transition-colors">
                                    <div class="flex-1"><span class="font-sans text-lg" style="font-family: 'Figtree', sans-serif;">{{ $feature['name'] }}</span></div>
                                    <div class="flex items-center gap-8">@foreach($plans as $plan)<div class="w-24 flex justify-center">@if($shouldShowCheck($feature['included'], $plan['level']))<div class="w-6 h-6 rounded-full bg-[#156d95] flex items-center justify-center"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white"><path d="M11.4669 3.72684C11.7558 3.91574 11.8369 4.30308 11.648 4.59198L7.39799 11.092C7.29783 11.2452 7.13556 11.3467 6.95402 11.3699C6.77247 11.3931 6.58989 11.3355 6.45446 11.2124L3.70446 8.71241C3.44905 8.48022 3.43023 8.08494 3.66242 7.82953C3.89461 7.57412 4.28989 7.55529 4.5453 7.78749L6.75292 9.79441L10.6018 3.90792C10.7907 3.61902 11.178 3.53795 11.4669 3.72684Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg></div>@else<span class="text-muted-foreground">-</span>@endif</div>@endforeach</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center"><button class="bg-[#156d95] text-white px-[18px] py-[15px] rounded-full font-sans text-lg hover:rounded-2xl transition-all" style="font-family: 'Figtree', sans-serif;">Get started with <span x-text="selectedPlan === 'starter' ? 'Starter' : (selectedPlan === 'pro' ? 'Pro' : 'Enterprise')"></span></button></div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="w-full py-24 px-8 bg-white" x-data="{ openIndex: null }">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-12 gap-16">
                    <div class="lg:col-span-4"><h2 class="text-[40px] leading-tight font-normal text-[#202020] tracking-tight sticky top-24" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Frequently asked questions</h2></div>
                    <div class="lg:col-span-8"><div class="space-y-0">@foreach($faqs as $index => $faq)<div class="border-b border-[#e5e5e5] last:border-b-0"><button @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150" :aria-expanded="openIndex === {{ $index }}"><span class="text-lg leading-7 text-[#202020] pr-8" style="font-family: 'Figtree', sans-serif; font-weight: 400;">{{ $faq['question'] }}</span><div class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]" :class="openIndex === {{ $index }} ? 'rotate-45' : 'rotate-0'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg></div></button><div x-show="openIndex === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="height-0 opacity-0" x-transition:enter-end="height-auto opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="height-auto opacity-100" x-transition:leave-end="height-0 opacity-0" class="overflow-hidden"><div class="pb-6 pr-12"><p class="text-lg leading-6 text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $faq['answer'] }}</p></div></div></div>@endforeach</div></div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
            <div class="max-w-[1200px] mx-auto px-8 py-16">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-8 mb-12">
                    <div class="col-span-2">
                        <div class="mb-4"><h3 class="text-2xl font-semibold text-[#202020] mb-2" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Auralink</h3><p class="text-sm leading-5 text-[#666666] max-w-xs" style="font-family: 'Figtree', sans-serif;">The Intelligence Layer for Modern Communication</p></div>
                        <div class="flex items-center gap-3 mt-6"><a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#202020] hover:border-[#202020] transition-colors duration-150"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-12.7 16.4S.2 17.5 3 16c-1.7-.9-2.7-2-2.7-2 .4.1.8.1 1.1 0C.5 13.9.5 9 .5 9c.1.6 1 .9 1.4 1C1 8.8.6 3.4 3.9 4.3 6.1 6.6 8.5 7.8 11.2 7.7c-.6-2.5 1.5-5.4 4.1-5.4 1.3 0 2.5.6 3.3 1.5 1-.2 2-.8 2.8-1.5-.3 1.1-1.1 2-1.9 2.5 1-.1 1.9-.4 2.8-.8z"/></svg></a></div>
                    </div>
                    @foreach($footerSections as $section)<div class="col-span-1"><h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">{{ $section['title'] }}</h4><ul class="space-y-3">@foreach($section['links'] as $link)<li><a href="{{ $link['href'] }}" class="text-sm text-[#666666] hover:text-[#202020] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">{{ $link['label'] }}</a></li>@endforeach</ul></div>@endforeach
                </div>
                <div class="pt-8 border-t border-[#e5e5e5]"><div class="flex flex-col md:flex-row justify-between items-center gap-4"><p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">&copy; {{ date('Y') }} Auralink. All rights reserved.</p></div></div>
            </div>
        </footer>
    </div>
</body>
</html>