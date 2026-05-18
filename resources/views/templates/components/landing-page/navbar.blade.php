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
        :class="isScrolled ? 'bg-white/95 border-[#000066]/30 shadow-lg' : 'bg-white/40 border-[#000066]/10'"
        class="backdrop-blur-2xl border rounded-full px-6 lg:px-10 py-3 flex items-center justify-between lg:justify-center gap-6 lg:gap-32 shadow-sm"
    >
        <div class="flex-shrink-0 flex items-center">
            <button @click="handleLinkClick('#home')" 
                    class="text-xl font-bold text-[#000066] hover:text-[#0072BB] transition-colors duration-200" 
                    style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; letter-spacing: -0.02em;">
                JOS
            </button>
        </div>

        <div class="hidden lg:flex items-center space-x-10">
            @foreach($navigationLinks as $link)
                <button @click="handleLinkClick('{{ $link['href'] }}')" 
                        class="text-sm font-medium text-[#000066]/70 hover:text-[#000066] transition-colors duration-200" 
                        style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $link['name'] }}
                </button>
            @endforeach
        </div>

        <div class="hidden lg:flex items-center gap-6">
            <a href="#" 
               class="text-sm font-medium text-[#000066]/70 hover:text-[#000066] transition-colors" 
               style="font-family: 'Plus Jakarta Sans', sans-serif;">Masuk</a>
            <button class="bg-[#000066] text-white px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-500 group flex items-center gap-0 hover:gap-4 border border-[#000066]/20 hover:bg-[#000066]/90 backdrop-blur-sm">
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;">Daftar</span>
                <div class="w-0 opacity-0 group-hover:w-8 group-hover:opacity-100 transition-all duration-500 overflow-hidden">
                    <div class="w-8 h-8 bg-[#00ADEF] rounded-full flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </button>
        </div>

        <div class="lg:hidden">
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                    class="text-[#000066] hover:text-[#0072BB] p-2 rounded-md transition-colors duration-200">
                <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div x-show="isMobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-full left-0 right-0 mt-4 mx-4 bg-[#F0F9FF]/95 backdrop-blur-xl border border-[#000066]/10 rounded-3xl overflow-hidden lg:hidden"
    >
        <div class="px-6 py-8 space-y-6">
            @foreach($navigationLinks as $link)
                <button @click="handleLinkClick('{{ $link['href'] }}')" class="block w-full text-left text-[#000066]/70 hover:text-[#000066] py-2 text-xl font-medium transition-colors duration-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $link['name'] }}
                </button>
            @endforeach
            <div class="pt-6 border-t border-[#000066]/10 flex flex-col gap-4">
                 <a href="#" class="block w-full text-center text-[#000066]/70 font-medium hover:text-[#000066] transition-colors py-2 text-lg" style="font-family: 'Plus Jakarta Sans', sans-serif;">Masuk</a>
                <button class="w-full bg-[#000066] text-white px-6 py-5 rounded-2xl text-lg font-semibold hover:bg-[#000066]/90 transition-all duration-200 flex items-center justify-center gap-3">
                    <span>Daftar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</nav>