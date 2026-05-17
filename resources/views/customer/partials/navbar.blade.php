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
    class="fixed left-1/2 -translate-x-1/2 z-[100] w-[92%] sm:w-[94%] max-w-6xl transition-all duration-500 lg:top-8"
     :class="isScrolled ? 'top-2 sm:top-4 lg:top-4' : 'top-4 lg:top-8'">
    <div :class="isScrolled ? 'nav-scrolled rounded-full py-2 sm:py-3 shadow-2xl text-white' : 'glass-nav rounded-full lg:rounded-[2.5rem] py-3 lg:py-4 shadow-lg shadow-brand-dark/[0.015] text-brand-dark'"
         class="px-8 flex items-center justify-between transition-all duration-500">
        <div class="flex items-center gap-12">
    <a href="/" wire:navigate class="text-xl sm:text-2xl font-black tracking-tighter transition-colors pl-2 sm:pl-0" :class="isScrolled ? 'text-white' : 'text-brand-dark'">JOS</a>
            <div class="hidden lg:flex items-center gap-8">
                @foreach($navigationLinks as $link)
                <a href="{{ $link['href'] }}" wire:navigate
                   class="text-sm font-semibold tracking-tight transition-all duration-300 {{ ($link['active'] ?? false) ? 'text-brand-primary' : 'text-gray-400 hover:text-brand-dark' }}"
                   :class="isScrolled ? '{{ ($link['active'] ?? false) ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                    {{ $link['name'] }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-6">
            <a href="{{ route('customer.notifications.preview') }}" wire:navigate class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all hover:bg-white/50 {{ request()->routeIs('customer.notifications.preview') ? 'text-brand-primary' : '' }}" :class="isScrolled ? '{{ request()->routeIs('customer.notifications.preview') ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-brand-primary rounded-full border-2 border-white"></span>
            </a>
            <div class="flex items-center gap-3 pl-2 sm:pl-6 border-l" :class="isScrolled ? 'border-white/10' : 'border-gray-100'">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold uppercase tracking-widest text-[#000066]" :class="isScrolled ? 'text-white' : 'text-[#000066]'">{{ $user['name'] }}</div>
                    <div class="text-[10px] font-bold text-gray-400">CUSTOMER</div>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full sm:rounded-2xl bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white font-bold shadow-lg shadow-brand-primary/20 text-xs mr-1 sm:mr-0 cursor-pointer hover:opacity-90 transition-opacity">
                    {{ substr($user['name'],0,1) }}
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Bottom PWA Navigation -->
<div class="lg:hidden fixed bottom-0 left-0 z-[100] w-full bg-white/90 backdrop-blur-lg border-t border-gray-100 shadow-[0_-8px_25px_-5px_rgba(0,0,0,0.05)]" style="padding-bottom: env(safe-area-inset-bottom);">
    <div class="flex items-center justify-between h-16 max-w-sm px-4 mx-auto font-medium">
        <a href="{{ route('customer.dashboard.preview') }}" wire:navigate class="inline-flex flex-col items-center justify-center w-full px-2 hover:bg-gray-50/50 group transition-colors rounded-xl {{ request()->routeIs('customer.dashboard.preview') ? 'text-brand-primary' : 'text-brand-dark/40' }}">
            <svg class="w-6 h-6 mb-1 transition-transform group-hover:scale-110 {{ request()->routeIs('customer.dashboard.preview') ? 'fill-brand-primary/20' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('customer.dashboard.preview') ? '2.5' : '2' }}"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"/></svg>
            <span class="text-[10px] font-bold tracking-wider">Home</span>
        </a>
        <a href="{{ route('customer.orders.preview') }}" wire:navigate class="inline-flex flex-col items-center justify-center w-full px-2 hover:bg-gray-50/50 group transition-colors rounded-xl {{ (request()->routeIs('customer.orders.preview') || request()->routeIs('customer.order-details.preview')) ? 'text-brand-primary' : 'text-brand-dark/40' }}">
            <svg class="w-6 h-6 mb-1 transition-transform group-hover:scale-110 {{ (request()->routeIs('customer.orders.preview') || request()->routeIs('customer.order-details.preview')) ? 'fill-brand-primary/20' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ (request()->routeIs('customer.orders.preview') || request()->routeIs('customer.order-details.preview')) ? '2.5' : '2' }}"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span class="text-[10px] font-bold tracking-wider">Orders</span>
        </a>
        <a href="{{ route('customer.partners.preview') }}" wire:navigate class="inline-flex flex-col items-center justify-center w-full px-2 hover:bg-gray-50/50 group transition-colors rounded-xl {{ request()->routeIs('customer.partners.preview') ? 'text-brand-primary' : 'text-brand-dark/40' }}">
            <svg class="w-6 h-6 mb-1 transition-transform group-hover:scale-110 {{ request()->routeIs('customer.partners.preview') ? 'fill-brand-primary/20' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('customer.partners.preview') ? '2.5' : '2' }}"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a14.5 14.5 0 000 20 14.5 14.5 0 000-20"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20"/></svg>
            <span class="text-[10px] font-bold tracking-wider">Explore</span>
        </a>
    </div>
</div>
