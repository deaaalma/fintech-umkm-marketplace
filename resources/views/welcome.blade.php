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
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Inter:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Geist Mono CDN (Simulated/Fallback) -->
    <link href="https://cdn.jsdelivr.net/npm/geist-mono@1.0.1/dist/geist-mono.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js (for interactivity) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Fallback for Geist Mono if CDN fails or if we want specific overrides */
        /* Font Face removed for commercial safety */
        :root {
            --font-figtree: 'Figtree', sans-serif;
            --font-geist-mono: 'Geist Mono', monospace;
            --font-accent: 'Plus Jakarta Sans', sans-serif;
        }
        .font-circular-medium { font-family: var(--font-accent); font-weight: 500; }
        .font-circular-book { font-family: var(--font-accent); font-weight: 400; }
        .font-circular-bold { font-family: var(--font-accent); font-weight: 700; }
        .font-georgia-italic { font-family: Georgia, serif; font-style: italic; }
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
                    if (element) {
                        element.scrollIntoView({ behavior: 'smooth' });
                    } else if (!href.startsWith('#')) {
                        window.location.href = href;
                    }
                }
            }"
            class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] lg:w-fit transition-all duration-500"
        >
            <div 
                :class="isScrolled ? 'bg-black/40 border-white/10' : 'bg-white/5 border-white/10'"
                class="backdrop-blur-xl border rounded-full px-6 lg:px-10 py-3 flex items-center justify-between lg:justify-center gap-6 lg:gap-32"
            >
                <div class="flex-shrink-0 flex items-center">
                    <button @click="handleLinkClick('#home')" 
                            class="text-xl font-bold text-white hover:text-[#38bdf8] transition-colors duration-200" 
                            style="font-family: 'Figtree', sans-serif; font-weight: 800; letter-spacing: -0.02em;">
                        JOS
                    </button>
                </div>

                <!-- Links (Desktop) -->
                <div class="hidden lg:flex items-center space-x-10">
                    @foreach($navigationLinks as $link)
                        <button @click="handleLinkClick('{{ $link['href'] }}')" 
                                class="text-sm font-medium text-white/70 hover:text-white transition-colors duration-200" 
                                style="font-family: 'Figtree', sans-serif;">
                            {{ $link['name'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('customer.dashboard.preview') }}" 
                       class="text-sm font-medium text-white/70 hover:text-white transition-colors" 
                       style="font-family: 'Figtree', sans-serif;">Masuk</a>
                    <button class="bg-white/10 text-white pl-5 pr-1 py-1 rounded-full text-sm font-semibold hover:bg-white transition-all duration-300 hover:text-gray-900 group flex items-center gap-4">
                        <span style="font-family: 'Figtree', sans-serif; font-weight: 600;">Daftar</span>
                        <div class="w-8 h-8 bg-[#0078b7] rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                        </div>
                    </button>
                </div>

                <!-- Mobile Toggle -->
                <div class="lg:hidden">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                            class="text-white hover:text-[#38bdf8] p-2 rounded-md transition-colors duration-200">
                        <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="isMobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="absolute top-full left-0 right-0 mt-4 mx-4 bg-[#0A0A0A]/95 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden lg:hidden"
            >
                <div class="px-6 py-8 space-y-6">
                    @foreach($navigationLinks as $link)
                        <button @click="handleLinkClick('{{ $link['href'] }}')" class="block w-full text-left text-white/70 hover:text-white py-2 text-xl font-medium transition-colors duration-200" style="font-family: 'Figtree', sans-serif;">
                            {{ $link['name'] }}
                        </button>
                    @endforeach
                    <div class="pt-6 border-t border-white/10 flex flex-col gap-4">
                         <a href="{{ route('customer.dashboard.preview') }}" class="block w-full text-center text-white/70 font-medium hover:text-white transition-colors py-2 text-lg" style="font-family: 'Figtree', sans-serif;">Masuk</a>
                        <button class="w-full bg-[#0078b7] text-white px-6 py-5 rounded-2xl text-lg font-semibold hover:bg-[#0078b7]/90 transition-all duration-200 flex items-center justify-center gap-3">
                            <span>Daftar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Full Screen Video Hero Section -->
        <section id="home" class="relative w-full min-h-screen flex items-center justify-start overflow-hidden pt-20">
            <!-- Video Background -->
            <div class="absolute inset-0 w-full h-full">
                <video autoplay muted loop playsinline class="w-full h-full object-cover">
                    <source src="{{ asset('storage/videos/hero.mp4') }}" type="video/mp4">
                    <!-- Fallback if needed, possibly an image -->
                </video>
                <!-- Dark Overlay to ensure text readability -->
                <div class="absolute inset-0 bg-black/50"></div>
                <!-- Gradient Bottom Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-[#0A0A0A]/20 to-transparent"></div>
            </div>

            <!-- Content Container -->
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-4xl">
                    <div class="flex flex-col gap-1 text-white mb-8 hero-text-anim">
                        <span class="text-sm flex items-center gap-3 opacity-90 font-circular-bold">
                            <div class="w-6 h-6 bg-white/10 backdrop-blur-md rounded-md flex items-center justify-center border border-white/10">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#38bdf8]"><path d="M12 2v20"/><path d="m17 7-5-5-5 5"/><path d="m17 17-5 5-5-5"/></svg>
                            </div>
                            Solusi UMKM Digital
                        </span>
                    </div>
                    
                    <h1 class="text-[64px] lg:text-[110px] leading-[0.9] tracking-tight text-white mb-10 hero-text-anim" style="font-weight: 500; font-family: 'Figtree', sans-serif;">
                        Ubah Tantangan<br>
                        Jadi <span class="relative inline-block text-white" 
                            x-data="{
                                words: ['Peluang Baru', 'Ekosistem Digital', 'Pasar Global', 'Bisnis Modern'],
                                current: 0,
                                init() {
                                    setInterval(() => {
                                        this.current = (this.current + 1) % this.words.length;
                                    }, 3000);
                                }
                            }">
                            <template x-for="(word, index) in words" :key="index">
                                <span x-text="word" 
                                      class="absolute top-0 left-0 transition-all duration-700 transform whitespace-nowrap font-georgia-italic"
                                      :class="{
                                          'opacity-100 translate-y-0': current === index,
                                          'opacity-0 translate-y-12': current !== index
                                      }"
                                ></span>
                            </template>
                            <span class="opacity-0 font-georgia-italic">Peluang Baru</span>
                        </span>
                    </h1>

                    <p class="text-lg leading-relaxed text-gray-300 max-w-[650px] mb-12 hero-text-anim font-circular-book">
                        Kami membantu UMKM Indonesia bertransformasi ke era digital. Dari strategi hingga eksekusi, kami membangun ekosistem yang mendorong pertumbuhan bisnis Anda ke level berikutnya.
                    </p>

                    <div class="flex flex-wrap items-center gap-6 hero-text-anim">
                        <a href="{{ route('register') }}" class="bg-black/20 backdrop-blur-xl border border-white/10 text-white pl-8 pr-2 py-2 rounded-2xl text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-500 flex items-center gap-8 group shadow-2xl">
                            <span class="font-circular-book">Mulai Sekarang</span>
                            <div class="w-12 h-12 bg-[#0078b7] rounded-xl flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rounded-full shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Absolute Bottom Elements (Scroll Indicator) -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 hero-text-anim">
                <span class="text-[10px] uppercase tracking-widest text-white font-medium" style="font-family: 'Figtree', sans-serif;">Scroll for more</span>
                <div class="w-[1px] h-12 bg-gradient-to-b from-white to-transparent"></div>
            </div>

            <!-- Floating Badge (Right) -->
            <div class="absolute bottom-10 right-10 z-20 hero-text-anim hidden lg:block">
                <div class="relative w-28 h-28 flex items-center justify-center">
                    <div class="absolute inset-0 border border-white/20 rounded-full animate-[spin_10s_linear_infinite]">
                         <svg class="w-full h-full" viewBox="0 0 100 100">
                            <defs>
                                <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                            </defs>
                            <text class="text-[9.5px] uppercase tracking-[0.25em] fill-white opacity-40">
                                <textPath xlink:href="#circlePath">
                                    Jasa Order Service &nbsp;&bull;&nbsp; Jasa Order Service &nbsp;&bull;&nbsp;
                                </textPath>
                            </text>
                        </svg>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                    </div>
                </div>
            </div>
        </section>

        <div class="w-full py-12 bg-[#0A0A0A] overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Trusted By Section -->
                <div class="partners-animate-container flex flex-col lg:flex-row items-center justify-between gap-12 mb-12 border-b border-white/5 pb-8">
                    <div class="text-white text-lg lg:text-xl max-w-md leading-tight font-circular-bold">
                        Dipercaya oleh berbagai <span class="font-georgia-italic italic text-white">mitra UMKM</span> di seluruh Indonesia
                    </div>
                    <div class="flex-1 w-full relative overflow-hidden">
                        <div class="flex items-center gap-16 animate-scroll whitespace-nowrap">
                            @foreach($apps as $app)
                                <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain brightness-0 invert opacity-40 logo-hover-blue transition-all duration-300">
                            @endforeach
                            @foreach($apps as $app)
                                <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain brightness-0 invert opacity-40 logo-hover-blue transition-all duration-300">
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content Header -->
                <div class="flex flex-col gap-4 mb-12 max-w-3xl">
                    <div class="flex items-center gap-3">
                         <div class="w-10 h-0.5 bg-[#0078b7]"></div>
                         <h2 class="text-4xl lg:text-5xl font-medium text-white tracking-tight" style="font-family: 'Figtree', sans-serif;">
                            Built for Serious <span class="font-georgia-italic italic">Growth</span>
                         </h2>
                    </div>
                    <p class="text-[#666666] text-lg leading-relaxed font-circular-book">
                        Tingkatkan kredibilitas usaha dengan sistem manajemen website dan pesanan berstandar profesional.
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Card 1 -->
                    <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden">
                        <div class="z-10">
                            <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Website Builder</h3>
                            <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                                Setiap UMKM memiliki landing page profesional sendiri yang dapat dikustomisasi secara fleksibel sesuai kebutuhan bisnis.
                            </p>
                        </div>
                        <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                             <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                             </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden">
                        <div class="z-10">
                            <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Order Management</h3>
                            <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                                Kelola setiap pesanan masuk dengan sistem yang terorganisir dan efisien untuk meningkatkan produktivitas.
                            </p>
                        </div>
                        <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                             <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                             </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden">
                        <div class="z-10">
                            <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Sales Reports</h3>
                            <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                                Pantau pertumbuhan bisnis Anda melalui laporan penjualan otomatis yang akurat dan mudah dipahami.
                            </p>
                        </div>
                        <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                             <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Card 4 -->
                    <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden">
                        <div class="z-10">
                            <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Tracking</h3>
                            <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                                Lacak status pengiriman dan pesanan secara real-time untuk memberikan transparansi penuh kepada pelanggan.
                            </p>
                        </div>
                        <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                             <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                             </div>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden">
                        <div class="z-10">
                            <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Chat</h3>
                            <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                                Terhubung langsung dengan pelanggan melalui integrasi pesan instan yang cepat, mudah, dan terintegrasi.
                            </p>
                        </div>
                        <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                             <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us (Section 3) -->
        <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-24 px-8 features-section">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-[40px] leading-tight font-normal text-[#003d5c] mb-6 tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Mengapa Memilih Platform Kami</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#0078b7]/10 flex items-center justify-center mb-6 group-hover:bg-[#0078b7] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#0078b7] group-hover:text-white transition-colors duration-300"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#003d5c] mb-3" style="font-family: 'Figtree', sans-serif;">Mudah & Cepat</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Akses ribuan UMKM dalam satu platform dengan navigasi yang mudah.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#0078b7]/10 flex items-center justify-center mb-6 group-hover:bg-[#0078b7] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#0078b7] group-hover:text-white transition-colors duration-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#003d5c] mb-3" style="font-family: 'Figtree', sans-serif;">Terpercaya</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Semua UMKM partner terverifikasi dan terpercaya.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#0078b7]/10 flex items-center justify-center mb-6 group-hover:bg-[#0078b7] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#0078b7] group-hover:text-white transition-colors duration-300"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#003d5c] mb-3" style="font-family: 'Figtree', sans-serif;">Harga Transparan</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Lihat harga jelas tanpa biaya tersembunyi.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-[#e5e5e5]/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group feature-card">
                        <div class="w-14 h-14 rounded-full bg-[#0078b7]/10 flex items-center justify-center mb-6 group-hover:bg-[#0078b7] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#0078b7] group-hover:text-white transition-colors duration-300"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#003d5c] mb-3" style="font-family: 'Figtree', sans-serif;">Dukungan 24/7</h3>
                        <p class="text-[#666666] leading-relaxed text-sm" style="font-family: 'Figtree', sans-serif;">Tim support siap membantu kapanpun Anda butuhkan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works (Section 4) -->
        <div class="w-full bg-white py-24 px-8 steps-section" x-data="{ activeStep: null }">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20">
                    <h2 class="text-[40px] leading-tight font-normal text-[#003d5c] tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Cara Kerja</h2>
                </div>
                
                <div class="relative">
                    <!-- Connecting Line (Desktop) -->
                    <div class="hidden lg:block absolute top-12 left-0 w-full h-0.5 bg-gray-200 -z-10"></div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 1" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 1 ? 'border-[#0078b7] text-[#0078b7] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                1
                            </div>
                            <h3 class="text-xl font-bold text-[#003d5c] mb-3 transition-colors duration-300" 
                                :class="activeStep === 1 ? 'text-[#0078b7]' : 'text-[#003d5c]'"
                                style="font-family: 'Figtree', sans-serif;">Pilih UMKM</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Jelajahi dan pilih UMKM partner sesuai kebutuhan</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 2" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 2 ? 'border-[#0078b7] text-[#0078b7] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                2
                            </div>
                            <h3 class="text-xl font-bold text-[#003d5c] mb-3 transition-colors duration-300"
                                :class="activeStep === 2 ? 'text-[#0078b7]' : 'text-[#003d5c]'"
                                style="font-family: 'Figtree', sans-serif;">Lihat Produk</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Telusuri produk atau layanan yang ditawarkan</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 3" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 3 ? 'border-[#0078b7] text-[#0078b7] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                3
                            </div>
                            <h3 class="text-xl font-bold text-[#003d5c] mb-3 transition-colors duration-300"
                                :class="activeStep === 3 ? 'text-[#0078b7]' : 'text-[#003d5c]'"
                                style="font-family: 'Figtree', sans-serif;">Pesan & Bayar</h3>
                            <p class="text-[#666666] text-sm leading-relaxed" style="font-family: 'Figtree', sans-serif;">Lakukan pemesanan dan pembayaran digital</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex flex-col items-center text-center group cursor-pointer step-item" @mouseenter="activeStep = 4" @mouseleave="activeStep = null">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-2xl font-bold mb-6 transition-all duration-300 relative bg-white border-4" 
                                :class="activeStep === 4 ? 'border-[#0078b7] text-[#0078b7] scale-110 shadow-lg' : 'border-gray-900 text-gray-900'">
                                4
                            </div>
                            <h3 class="text-xl font-bold text-[#003d5c] mb-3 transition-colors duration-300"
                                :class="activeStep === 4 ? 'text-[#0078b7]' : 'text-[#003d5c]'"
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
                    <div class="lg:col-span-4"><h2 class="text-[40px] leading-tight font-normal text-[#003d5c] tracking-tight sticky top-24" style="font-family: 'Figtree', sans-serif; font-weight: 400;">Pertanyaan yang Sering Diajukan</h2></div>
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
                            <h3 class="text-2xl font-semibold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif; font-weight: 500;">UMKM Connect</h3>
                            <p class="text-sm leading-5 text-[#666666] max-w-xs" style="font-family: 'Figtree', sans-serif;">Platform digital untuk memajukan UMKM Indonesia.</p>
                        </div>
                        <div class="flex items-center gap-3 mt-6">
                            <!-- Social Icons (Placeholder) -->
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#003d5c] hover:border-[#003d5c] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#003d5c] hover:border-[#003d5c] transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Static Links Column 1 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Perusahaan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Tentang Kami</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Karir</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Static Links Column 2 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Bantuan</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">Kebijakan Privasi</a></li>
                        </ul>
                    </div>

                    <!-- Static Links Column 3 -->
                    <div class="col-span-1">
                        <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">Hubungi Kami</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">support@umkmconnect.id</a></li>
                            <li><a href="#" class="text-sm text-[#666666] hover:text-[#003d5c] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">+62 812 3456 7890</a></li>
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

                // 0. Hero Section "Breathing" (Scroll Reactive) - INTENSIFIED
                gsap.to(".hero-text-anim", {
                    y: -200,
                    opacity: 0,
                    scale: 0.8,
                    filter: "blur(10px)",
                    scrollTrigger: {
                        trigger: ".hero-section",
                        start: "top top",
                        end: "bottom top",
                        scrub: 1
                    }
                });

                // 1. Hero Content Entrance (Initial load)
                gsap.from(".hero-text-anim", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                    ease: "power3.out"
                });

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

                // 1. Partners Section Entry (Slide from Left)
                gsap.fromTo(".partners-animate-container",
                    { x: -100, opacity: 0 },
                    {
                        x: 0, opacity: 1, duration: 1.2, ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".partners-animate-container",
                            start: "top 90%",
                            end: "top 60%",
                            scrub: 1, // Makes it move with scroll in both directions
                        }
                    }
                );

                // 2. Feature Cards (ScrollTrigger Batch/Stagger)
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