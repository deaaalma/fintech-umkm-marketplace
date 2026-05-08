@php
    $navigationLinks = [
        ['name' => 'Features', 'href' => '#features'],
        ['name' => 'Pricing', 'href' => '#pricing'],
        ['name' => 'Solutions', 'href' => '#solutions'],
        ['name' => 'Resources', 'href' => '#resources'],
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
            const element = document.querySelector(href);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }"
    :class="isScrolled ? 'bg-background/95 backdrop-blur-md shadow-sm' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex-shrink-0">
                <button
                    @click="handleLinkClick('#home')"
                    class="text-2xl font-bold text-foreground hover:text-primary transition-colors duration-200"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;"
                >
                    <span style="font-family: 'Figtree', sans-serif; font-weight: 800;">
                        Auralink
                    </span>
                </button>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    @foreach($navigationLinks as $link)
                        <button
                            @click="handleLinkClick('{{ $link['href'] }}')"
                            class="text-foreground hover:text-primary px-3 py-2 text-base font-medium transition-colors duration-200 relative group"
                            style="font-family: 'Figtree', sans-serif; font-weight: 400;"
                        >
                            <span>{{ $link['name'] }}</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:block">
                <button
                    @click="handleLinkClick('#contact')"
                    class="bg-[#156d95] text-white px-[18px] rounded-full text-base font-semibold hover:bg-[#156d95]/90 transition-all duration-200 hover:rounded-2xl shadow-sm hover:shadow-md whitespace-nowrap leading-4 py-[15px]"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;"
                >
                    <span style="font-family: 'Figtree', sans-serif; font-weight: 500;">
                        Start Free Trial
                    </span>
                </button>
            </div>

            <div class="md:hidden">
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="text-foreground hover:text-primary p-2 rounded-md transition-colors duration-200"
                    aria-label="Toggle mobile menu"
                >
                    <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        x-show="isMobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 h-0"
        x-transition:enter-end="opacity-100 h-auto"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 h-auto"
        x-transition:leave-end="opacity-0 h-0"
        class="md:hidden bg-background/95 backdrop-blur-md border-t border-border overflow-hidden"
    >
        <div class="px-6 py-6 space-y-4">
            @foreach($navigationLinks as $link)
                <button
                    @click="handleLinkClick('{{ $link['href'] }}')"
                    class="block w-full text-left text-foreground hover:text-primary py-3 text-lg font-medium transition-colors duration-200"
                    style="font-family: 'Figtree', sans-serif; font-weight: 400;"
                >
                    <span>{{ $link['name'] }}</span>
                </button>
            @endforeach
            <div class="pt-4 border-t border-border">
                <button
                    @click="handleLinkClick('#contact')"
                    class="w-full bg-[#156d95] text-white px-[18px] py-[15px] rounded-full text-base font-semibold hover:bg-[#156d95]/90 transition-all duration-200"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;"
                >
                    <span>Start Free Trial</span>
                </button>
            </div>
        </div>
    </div>
</nav>
