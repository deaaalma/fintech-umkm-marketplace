@props(['links' => null])

    @php
        // Jika tidak ada links yang dikirim dari luar, gunakan default ini
        $links = $links ?? [
            ['name' => 'Home', 'href' => '#home'],
            ['name' => 'Service', 'href' => '#service'],
            ['name' => 'Process', 'href' => '#workflow'],
            ['name' => 'Help', 'href' => '#faq'],
            ['name' => 'Contact', 'href' => '#contact'],
        ];
    @endphp

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
            if (href.startsWith('#')) {
                const element = document.querySelector(href);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                window.location.href = href;
            }
        }
    }"
    class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] lg:w-fit transition-all duration-500"
>
    <div 
        :class="isScrolled ? 'bg-black/60 border-white/20 shadow-2xl' : 'bg-white/5 border-white/10'"
        class="backdrop-blur-xl border rounded-full px-6 lg:px-10 py-3 flex items-center justify-between lg:justify-center gap-6 lg:gap-24 transition-all duration-300"
    >
        <div class="flex-shrink-0 flex items-center">
            <button @click="handleLinkClick('#home')" 
                    class="text-2xl font-black text-white hover:text-sky-400 transition-colors duration-200 tracking-tighter">
                JOS
            </button>
        </div>

        <div class="hidden lg:flex items-center space-x-10">
            @foreach($links as $link)
                <button @click="handleLinkClick('{{ $link['href'] }}')" 
                        class="text-sm font-medium text-white/70 hover:text-white transition-colors duration-200 font-jakarta">
                    {{ $link['name'] }}
                </button>
            @endforeach
        </div>

        <div class="hidden lg:flex items-center gap-6">
            <a href="{{ route('login') }}" 
               class="text-sm font-medium text-white/70 hover:text-white transition-colors font-jakarta" 
               wire:navigate>Masuk</a>
            
            <a href="{{ route('register') }}"
               class="text-white px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-500 group flex items-center gap-0 hover:gap-3 border border-white/20 hover:bg-white/10 hover:border-white/30 backdrop-blur-sm shadow-lg"
               wire:navigate>
                <span class="font-jakarta">Daftar</span>
                <div class="w-0 opacity-0 group-hover:w-6 group-hover:opacity-100 transition-all duration-500 overflow-hidden">
                    <div class="w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        </div>

        <div class="lg:hidden">
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                    class="text-white hover:text-sky-400 p-2 transition-colors duration-200">
                <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div x-show="isMobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-full left-0 right-0 mt-4 mx-0 bg-[#0A0A0A]/90 backdrop-blur-2xl border border-white/10 rounded-3xl overflow-hidden lg:hidden shadow-2xl"
    >
        <div class="px-6 py-8 space-y-6">
            @foreach($links as $link)
                <button @click="handleLinkClick('{{ $link['href'] }}')" class="block w-full text-left text-white/70 hover:text-white py-2 text-xl font-bold transition-colors duration-200 font-jakarta">
                    {{ $link['name'] }}
                </button>
            @endforeach
            
            <div class="pt-6 border-t border-white/10 flex flex-col gap-4">
                <a href="{{ route('login') }}" class="block w-full text-center text-white/70 font-medium hover:text-white py-3 text-lg font-jakarta" wire:navigate>Masuk</a>
                <a href="{{ route('register') }}" class="w-full bg-sky-600 text-white px-6 py-4 rounded-2xl text-lg font-bold hover:bg-sky-500 transition-all duration-200 flex items-center justify-center gap-3 shadow-lg shadow-sky-900/20" wire:navigate>
                    <span>Daftar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</nav>