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
                ['name' => 'Home', 'href' => '#'],
                ['name' => 'Tentang Kami', 'href' => '#about'],
                ['name' => 'UMKM Partner', 'href' => '#partners'],
                ['name' => 'Kontak', 'href' => '#contact'],
            ];

            // Hero Visualization Data (Graph) - Keep graph only
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
                'videoSrc' => asset('storage/videos/hero.mp4'),
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
                init() { 
                    window.addEventListener('scroll', () => { 
                        this.isScrolled = window.scrollY > 20; 
                    }); 
                },
                handleLinkClick(href) {
                    this.isMobileMenuOpen = false;
                    const element = document.querySelector(href);
                    if (element) element.scrollIntoView({ behavior: 'smooth' });
                }
            }"
            :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-sm text-gray-900' : 'bg-transparent text-white'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        >
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <!-- Branding: JOS (Logo removed) -->
                        <button @click="handleLinkClick('#home')" 
                                :class="isScrolled ? 'text-gray-900' : 'text-white'"
                                class="text-2xl font-bold hover:text-[#167E6C] transition-colors duration-200" 
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span style="font-family: 'Figtree', sans-serif; font-weight: 800;">JOS</span>
                        </button>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            @foreach($navigationLinks as $link)
                                <button @click="handleLinkClick('{{ $link['href'] }}')" 
                                        :class="isScrolled ? 'text-gray-900 hover:text-[#167E6C]' : 'text-white hover:text-white/80'"
                                        class="px-3 py-2 text-base font-medium transition-colors duration-200 relative group" 
                                        style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                                    <span>{{ $link['name'] }}</span>
                                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('customer.dashboard.preview') }}" 
                               :class="isScrolled ? 'text-gray-900 hover:text-[#167E6C]' : 'text-white hover:text-white/80'"
                               class="font-medium transition-colors px-3 py-2" 
                               style="font-family: 'Figtree', sans-serif;">Masuk</a>
                            <button class="bg-[#167E6C] text-white px-[18px] rounded-full text-base font-semibold hover:bg-[#167E6C]/90 transition-all duration-200 hover:rounded-2xl shadow-sm hover:shadow-md whitespace-nowrap leading-4 py-[15px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <span style="font-family: 'Figtree', sans-serif; font-weight: 500;">Daftar</span>
                            </button>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                                :class="isScrolled ? 'text-gray-900' : 'text-white'"
                                class="hover:text-[#167E6C] p-2 rounded-md transition-colors duration-200" 
                                aria-label="Toggle mobile menu">
                            <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 h-0" x-transition:enter-end="opacity-100 h-auto" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 h-auto" x-transition:leave-end="opacity-0 h-0" class="md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200 overflow-hidden">
                <div class="px-6 py-6 space-y-4">
                    @foreach($navigationLinks as $link)
                        <button @click="handleLinkClick('{{ $link['href'] }}')" class="block w-full text-left text-gray-900 hover:text-[#167E6C] py-3 text-lg font-medium transition-colors duration-200" style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                            <span>{{ $link['name'] }}</span>
                        </button>
                    @endforeach
                    <div class="pt-4 border-t border-gray-200 flex flex-col gap-3">
                         <a href="{{ route('customer.dashboard.preview') }}" class="block w-full text-center text-gray-900 font-medium hover:text-[#167E6C] transition-colors py-2" style="font-family: 'Figtree', sans-serif;">Masuk</a>
                        <button class="w-full bg-[#167E6C] text-white px-[18px] py-[15px] rounded-full text-base font-semibold hover:bg-[#167E6C]/90 transition-all duration-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span>Daftar</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Full Screen Video Hero Section -->
        <section id="home" class="relative w-full min-h-screen flex items-end justify-start overflow-hidden">
            <!-- Video Background -->
            <div class="absolute inset-0 w-full h-full">
                <video autoplay muted loop playsinline class="w-full h-full object-cover">
                    <source src="{{ asset('storage/videos/hero.mp4') }}" type="video/mp4">
                    <!-- Fallback if needed, possibly an image -->
                </video>
                <!-- Opaque Overlay to ensure text readability -->
                <div class="absolute inset-0 bg-black/40"></div>
            </div>

            <!-- Content Container (Bottom Left) -->
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8 pb-24 lg:pb-32">
                <div class="max-w-3xl">
                    <div class="col-span-12 lg:col-span-6 flex flex-col justify-end">
                        <div class="flex flex-col gap-1 text-[#4ade80] mb-6 hero-text-anim">
                            <span class="text-sm uppercase tracking-tight font-mono flex items-center gap-1" style="font-family: 'Geist Mono', monospace;">
                                SOLUSI UMKM TERDEPAN
                                <span class="w-1.5 h-3 bg-[#4ade80] ml-1 rounded-sm animate-pulse"></span>
                            </span>
                        </div>
                        <h1 class="text-[56px] leading-[1.1] tracking-tight text-white mb-6 hero-text-anim" style="font-weight: 500; font-family: 'Figtree', sans-serif;">
                            Bangun <span class="relative inline-block text-[#4ade80]" 
                                x-data="{
                                    words: ['Identitas Digital', 'Bisnis Modern', 'Relasi Kuat', 'Pasar Luas'],
                                    current: 0,
                                    init() {
                                        setInterval(() => {
                                            this.current = (this.current + 1) % this.words.length;
                                        }, 2000);
                                    }
                                }">
                                <template x-for="(word, index) in words" :key="index">
                                    <span x-text="word" 
                                          class="absolute top-0 left-0 transition-all duration-500 transform whitespace-nowrap"
                                          :class="{
                                              'opacity-100 translate-y-0': current === index,
                                              'opacity-0 translate-y-4': current !== index
                                          }"
                                    ></span>
                                </template>
                                <span class="opacity-0">Identitas Digital</span>
                            </span><br>
                            dan Tingkatkan Daya Saing <span class="opacity-80 text-white">UMKM Anda.</span>
                        </h1>
                        <p class="text-lg leading-7 text-gray-200 max-w-[520px] mb-8 hero-text-anim" style="font-family: 'Figtree', sans-serif;">
                            Platform terintegrasi yang menghubungkan UMKM dengan peluang pasar yang lebih luas, teknologi terkini, dan komunitas yang mendukung pertumbuhan bisnis Anda.
                        </p>
                        <ul class="flex gap-1.5 flex-wrap mt-2 hero-text-anim">
                            <li>
                                <button class="relative inline-flex justify-center items-center leading-4 text-center cursor-pointer whitespace-nowrap outline-none font-medium h-12 text-[#064E3B] bg-white transition-all duration-200 ease-in-out rounded-lg px-6 text-base group hover:bg-gray-100 hover:shadow-lg">
                                    <span class="relative z-10 flex items-center gap-2">Mulai Sekarang <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 transition-transform duration-150 group-hover:translate-x-1"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="w-full py-12 bg-white overflow-hidden">
            <div class="max-w-[680px] mx-auto text-center mb-10 px-4 partner-header-section">
                <h2 class="text-[40px] leading-tight font-normal text-[#064E3B] tracking-tight mb-4 partner-header-anim" style="font-family: 'Figtree', sans-serif;">Pilih UMKM Partner Anda</h2>
                <p class="text-lg leading-7 text-[#666666] max-w-[600px] mx-auto partner-header-anim" style="font-family: 'Figtree', sans-serif;">Temukan dan berkolaborasi dengan UMKM terbaik dari berbagai industri untuk mendukung pertumbuhan bisnis Anda.</p>
                <div class="mt-8 partner-header-anim"><a href="#" class="inline-block px-5 py-2.5 rounded-full bg-white text-[#064E3B] text-[15px] font-medium transition-all duration-75 hover:shadow-lg border border-[#e3e3e3]">Lihat Semua UMKM Partner</a></div>
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

        <!-- Why Choose Us (Section 3) -->
        <div class="w-full bg-gradient-to-br from-background via-background to-[#167E6C]/5 py-24 px-8 features-section">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-[40px] leading-tight font-normal text-[#064E3B] mb-6 tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Mengapa Memilih Platform Kami</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#167E6C]/10 flex items-center justify-center mb-6 group-hover:bg-[#167E6C] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#167E6C] group-hover:text-white transition-colors duration-300"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#064E3B] mb-3" style="font-family: 'Figtree', sans-serif;">Mudah & Cepat</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Akses ribuan UMKM dalam satu platform dengan navigasi yang mudah.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#167E6C]/10 flex items-center justify-center mb-6 group-hover:bg-[#167E6C] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#167E6C] group-hover:text-white transition-colors duration-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#064E3B] mb-3" style="font-family: 'Figtree', sans-serif;">Terpercaya</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Semua UMKM partner terverifikasi dan terpercaya.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#167E6C]/10 flex items-center justify-center mb-6 group-hover:bg-[#167E6C] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#167E6C] group-hover:text-white transition-colors duration-300"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#064E3B] mb-3" style="font-family: 'Figtree', sans-serif;">Harga Transparan</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Lihat harga jelas tanpa biaya tersembunyi.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#167E6C]/10 flex items-center justify-center mb-6 group-hover:bg-[#167E6C] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#167E6C] group-hover:text-white transition-colors duration-300"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#064E3B] mb-3" style="font-family: 'Figtree', sans-serif;">Dukungan 24/7</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Tim support siap membantu kapanpun Anda butuhkan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works (Section 4) -->
        <div class="w-full bg-white py-24 px-8 steps-section" x-data="{ activeStep: null }">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20">
                    <h2 class="text-[40px] leading-tight font-normal text-[#064E3B] tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Cara Kerja</h2>
                </div>
                
                <div class="relative">
                    <!-- Connecting Line (Desktop) -->
                    <div class="hidden lg:block absolute top-12 left-0 w-full h-0.5 bg-gray-200 -z-10"></div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 1" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 1 ? 'border-[#167E6C] text-[#167E6C] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                1
                            </div>
                            <h3 class="text-xl font-bold text-[#064E3B] mb-3 transition-colors duration-300" 
                                :class="activeStep === 1 ? 'text-[#167E6C]' : 'text-[#064E3B]'"
                                style="font-family: 'Figtree', sans-serif;">Pilih UMKM</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Jelajahi dan pilih UMKM partner sesuai kebutuhan</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 2" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 2 ? 'border-[#167E6C] text-[#167E6C] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                2
                            </div>
                            <h3 class="text-xl font-bold text-[#064E3B] mb-3 transition-colors duration-300"
                                :class="activeStep === 2 ? 'text-[#167E6C]' : 'text-[#064E3B]'"
                                style="font-family: 'Figtree', sans-serif;">Lihat Produk</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Telusuri produk atau layanan yang ditawarkan</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 3" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 3 ? 'border-[#167E6C] text-[#167E6C] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                3
                            </div>
                            <h3 class="text-xl font-bold text-[#064E3B] mb-3 transition-colors duration-300"
                                :class="activeStep === 3 ? 'text-[#167E6C]' : 'text-[#064E3B]'"
                                style="font-family: 'Figtree', sans-serif;">Pesan & Bayar</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Lakukan pemesanan dan pembayaran digital</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 4" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 4 ? 'border-[#167E6C] text-[#167E6C] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                4
                            </div>
                            <h3 class="text-xl font-bold text-[#064E3B] mb-3 transition-colors duration-300"
                                :class="activeStep === 4 ? 'text-[#167E6C]' : 'text-[#064E3B]'"
                                style="font-family: 'Figtree', sans-serif;">Enjoy & Review</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Nikmati produk/layanan dan berikan review</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <section class="w-full py-24 px-8 bg-white faq-section" x-data="{ openIndex: null }">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-12 gap-16">
                    <div class="lg:col-span-4"><h2 class="text-[40px] leading-tight font-normal text-[#064E3B] tracking-tight sticky top-24" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Pertanyaan yang Sering Diajukan</h2></div>
                    <div class="lg:col-span-8">
                        <div class="space-y-0">
                            <!-- FAQ Item 1 -->
                            <div class="border-b border-[#e5e5e5] last:border-b-0 faq-item">
                                <button @click="openIndex = openIndex === 0 ? null : 0" class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150" :aria-expanded="openIndex === 0">
                                    <span class="text-lg leading-7 text-[#202020] pr-8" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Bagaimana cara mendaftar sebagai partner UMKM?</span>
                                    <div class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]" :class="openIndex === 0 ? 'rotate-45' : 'rotate-0'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </div>
                                </button>
                                <div x-show="openIndex === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="height-0 opacity-0" x-transition:enter-end="height-auto opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="height-auto opacity-100" x-transition:leave-end="height-0 opacity-0" class="overflow-hidden">
                                    <div class="pb-6 pr-12"><p class="text-lg leading-6 text-[#666666]" style="font-family: 'Figtree', sans-serif;">Klik tombol 'Gabung Sekarang', isi formulir pendaftaran dengan data usaha Anda, dan tim kami akan memverifikasi dalam 1x24 jam.</p></div>
                                </div>
                            </div>
                            <!-- FAQ Item 2 -->
                            <div class="border-b border-[#e5e5e5] last:border-b-0 faq-item">
                                <button @click="openIndex = openIndex === 1 ? null : 1" class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150" :aria-expanded="openIndex === 1">
                                    <span class="text-lg leading-7 text-[#202020] pr-8" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Apakah ada biaya pendaftaran?</span>
                                    <div class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]" :class="openIndex === 1 ? 'rotate-45' : 'rotate-0'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </div>
                                </button>
                                <div x-show="openIndex === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="height-0 opacity-0" x-transition:enter-end="height-auto opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="height-auto opacity-100" x-transition:leave-end="height-0 opacity-0" class="overflow-hidden">
                                    <div class="pb-6 pr-12"><p class="text-lg leading-6 text-[#666666]" style="font-family: 'Figtree', sans-serif;">Pendaftaran gratis! Kami hanya mengenakan komisi kecil untuk setiap transaksi yang berhasil.</p></div>
                                </div>
                            </div>
                            <!-- FAQ Item 3 -->
                            <div class="border-b border-[#e5e5e5] last:border-b-0 faq-item">
                                <button @click="openIndex = openIndex === 2 ? null : 2" class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150" :aria-expanded="openIndex === 2">
                                    <span class="text-lg leading-7 text-[#202020] pr-8" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Bagaimana sistem pembayarannya?</span>
                                    <div class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]" :class="openIndex === 2 ? 'rotate-45' : 'rotate-0'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </div>
                                </button>
                                <div x-show="openIndex === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="height-0 opacity-0" x-transition:enter-end="height-auto opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="height-auto opacity-100" x-transition:leave-end="height-0 opacity-0" class="overflow-hidden">
                                    <div class="pb-6 pr-12"><p class="text-lg leading-6 text-[#666666]" style="font-family: 'Figtree', sans-serif;">Kami mendukung berbagai metode pembayaran digital (e-wallet, transfer bank, QRIS) yang aman dan otomatis terverifikasi.</p></div>
                                </div>
                            </div>
                            <!-- FAQ Item 4 -->
                            <div class="border-b border-[#e5e5e5] last:border-b-0 faq-item">
                                <button @click="openIndex = openIndex === 3 ? null : 3" class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150" :aria-expanded="openIndex === 3">
                                    <span class="text-lg leading-7 text-[#202020] pr-8" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Apakah pengiriman mencakup seluruh Indonesia?</span>
                                    <div class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]" :class="openIndex === 3 ? 'rotate-45' : 'rotate-0'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </div>
                                </button>
                                <div x-show="openIndex === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="height-0 opacity-0" x-transition:enter-end="height-auto opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="height-auto opacity-100" x-transition:leave-end="height-0 opacity-0" class="overflow-hidden">
                                    <div class="pb-6 pr-12"><p class="text-lg leading-6 text-[#666666]" style="font-family: 'Figtree', sans-serif;">Ya, kami bekerja sama dengan berbagai logistik terpercaya untuk memastikan produk Anda dapat menjangkau pelanggan di seluruh Indonesia.</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
            <div class="max-w-[1200px] mx-auto px-8 py-16">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-8 mb-12">
                    <div class="col-span-2">
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-[#064E3B] mb-2" style="font-family: 'Figtree', sans-serif; font-weight: 500;">UMKM Connect</h3>
                            <p class="text-sm leading-5 text-[#666666] max-w-xs" style="font-family: 'Figtree', sans-serif;">Platform digital untuk memajukan UMKM Indonesia.</p>
                        </div>
                        <div class="flex items-center gap-3 mt-6">
                            <!-- Social Icons (Placeholder) -->
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#064E3B] hover:border-[#064E3B] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#064E3B] hover:border-[#064E3B] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Static Links Column 1 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Perusahaan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Tentang Kami</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Karir</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Static Links Column 2 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Bantuan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Kebijakan Privasi</a></li>
                        </ul>
                    </div>

                    <!-- Static Links Column 3 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Hubungi Kami</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">support@umkmconnect.id</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#064E3B] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">+62 812 3456 7890</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t border-[#e5e5e5]">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">&copy; {{ date('Y') }} UMKM Connect. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const initAnimations = () => {
                if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                    setTimeout(initAnimations, 100);
                    return;
                }

                gsap.registerPlugin(ScrollTrigger);

                // 1. Hero Text Reveal (On Load)
                gsap.fromTo(".hero-text-anim", 
                    { y: 50, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: "power3.out" }
                );

                // 2. Partner Header (Staggered Reveal)
                gsap.fromTo(".partner-header-anim", 
                    { y: 40, opacity: 0 },
                    {
                        y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: "power3.out",
                        scrollTrigger: {
                            trigger: ".partner-header-section",
                            start: "top 80%",
                        }
                    }
                );

                // 3. Feature Cards (ScrollTrigger Batch/Stagger)
                gsap.fromTo(".feature-card", 
                    { y: 50, opacity: 0 },
                    {
                        y: 0, opacity: 1, duration: 0.8, stagger: 0.2, ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".features-section",
                            start: "top 80%", // Trigger when top of section hits 80% viewport height
                        }
                    }
                );

                // 3. How It Works Steps
                gsap.utils.toArray(".step-item").forEach((step, i) => {
                    gsap.fromTo(step,
                        { y: 50, opacity: 0 },
                        {
                            y: 0, opacity: 1, duration: 0.8, ease: "back.out(1.7)", delay: i * 0.1,
                            scrollTrigger: {
                                trigger: step,
                                start: "top 85%", // Trigger each step individually
                            }
                        }
                    );
                });

                // 4. FAQ Items
                gsap.utils.toArray(".faq-item").forEach((item, i) => {
                    gsap.fromTo(item,
                        { x: -30, opacity: 0 },
                        {
                            x: 0, opacity: 1, duration: 0.6, ease: "power2.out", delay: i * 0.1,
                            scrollTrigger: {
                                trigger: item,
                                start: "top 90%", // Trigger each item individually
                            }
                        }
                    );
                });
            };
            
            initAnimations();
        });
    </script>
</body>
</html>