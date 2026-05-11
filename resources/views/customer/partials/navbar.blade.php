@php
    $user = ['name' => 'Ahmad'];
    $navigationLinks = [
        ['name' => 'Overview', 'href' => route('customer.dashboard.preview'), 'active' => request()->routeIs('customer.dashboard.preview')],
        ['name' => 'My Orders', 'href' => route('customer.orders.preview'), 'active' => request()->routeIs('customer.orders.preview') || request()->routeIs('customer.order-details.preview')],
        ['name' => 'Explore Partners', 'href' => route('customer.partners.preview'), 'active' => request()->routeIs('customer.partners.preview')],
    ];
@endphp

<nav x-data="{ isScrolled: false }" 
     x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 20)"
     class="fixed left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-6xl transition-all duration-500"
     :class="isScrolled ? 'top-4' : 'top-8'">
    <div :class="isScrolled ? 'nav-scrolled rounded-full py-3 shadow-2xl text-white' : 'glass-nav rounded-[2.5rem] py-4 shadow-lg shadow-brand-dark/[0.015] text-brand-dark'"
         class="px-8 flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-12">
            <a href="/" class="text-2xl font-black tracking-tighter transition-colors" :class="isScrolled ? 'text-white' : 'text-brand-dark'">JOS</a>
            <div class="hidden lg:flex items-center gap-8">
                @foreach($navigationLinks as $link)
                <a href="{{ $link['href'] }}" 
                   class="text-sm font-semibold tracking-tight transition-all duration-300 {{ ($link['active'] ?? false) ? 'text-brand-primary' : 'text-gray-400 hover:text-brand-dark' }}"
                   :class="isScrolled ? '{{ ($link['active'] ?? false) ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                    {{ $link['name'] }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-6">
            <button class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all hover:bg-white/50" :class="isScrolled ? 'text-gray-400 hover:text-white' : ''">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-12.7 8.19 8.19 0 0 1 4.9 1.5L22 3l-1.5 5.5a8.19 8.19 0 0 1 1.5 4.9z"/></svg>
            </button>
            <button class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all hover:bg-white/50" :class="isScrolled ? 'text-gray-400 hover:text-white' : ''">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-brand-primary rounded-full border-2 border-white"></span>
            </button>
            <div class="flex items-center gap-3 pl-6 border-l" :class="isScrolled ? 'border-white/10' : 'border-gray-100'">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold uppercase tracking-widest">{{ $user['name'] }}</div>
                    <div class="text-[10px] font-bold text-gray-400">MEMBER</div>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white font-bold shadow-lg shadow-brand-primary/20 text-xs">
                    {{ substr($user['name'],0,1) }}
                </div>
            </div>
        </div>
    </div>
</nav>
