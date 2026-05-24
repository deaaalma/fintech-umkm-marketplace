@php
    // Gunakan dummy data khusus untuk halaman template
    if (request()->is('templates/*')) {
        $user = (object)[
            'name' => 'Ahmad',
            'role' => 'Customer'
        ];
    } else {
        $user = auth()->user() ?? (object)['name' => 'Guest', 'role' => 'Visitor'];
    }
@endphp

<nav x-data="{ isScrolled: false, openProfile: false }" 
     x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 20)"
     class="fixed left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-6xl transition-all duration-500"
     :class="isScrolled ? 'top-4' : 'top-8'">
     
    <div :class="isScrolled ? 'nav-scrolled rounded-full py-3 shadow-2xl text-white' : 'glass-nav rounded-[2.5rem] py-4 shadow-lg shadow-brand-dark/[0.015] text-brand-dark'"
         class="px-8 flex items-center justify-between transition-all duration-500">
        
        <div class="flex items-center gap-12">
            <a href="/" class="text-2xl font-black tracking-tighter transition-colors" :class="isScrolled ? 'text-white' : 'text-brand-dark'">JOS</a>
            
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('customer.dashboard') }}" 
                   class="text-sm font-semibold tracking-tight transition-all duration-300 {{ request()->routeIs('customer.dashboard') ? 'text-brand-primary' : 'text-gray-400 hover:text-brand-dark' }}"
                   :class="isScrolled ? '{{ request()->routeIs('customer.dashboard') ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                    Overview
                </a>

                <a href="{{ route('customer.orders') }}" {{-- Ganti ke route orders asli nanti --}}
                   class="text-sm font-semibold tracking-tight transition-all duration-300 {{ (request()->routeIs('customer.orders.*') || request()->routeIs('customer.order-details.*')) ? 'text-brand-primary' : 'text-gray-400 hover:text-brand-dark' }}"
                   :class="isScrolled ? '{{ (request()->routeIs('customer.orders.*') || request()->routeIs('customer.order-details.*')) ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                    My Orders
                </a>

                <a href="{{ route('customer.dashboard') }}" {{-- Ganti ke route partners asli nanti --}}
                   class="text-sm font-semibold tracking-tight transition-all duration-300 {{ request()->routeIs('customer.partners.*') ? 'text-brand-primary' : 'text-gray-400 hover:text-brand-dark' }}"
                   :class="isScrolled ? '{{ request()->routeIs('customer.partners.*') ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                    Explore Partners
                </a>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <a href="#" class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all hover:bg-white/10 {{ request()->routeIs('customer.chat.*') ? 'text-brand-primary' : '' }}" 
               :class="isScrolled ? '{{ request()->routeIs('customer.chat.*') ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-12.7 8.19 8.19 0 0 1 4.9 1.5L22 3l-1.5 5.5a8.19 8.19 0 0 1 1.5 4.9z"/></svg>
            </a>

            <a href="#" class="relative w-10 h-10 flex items-center justify-center rounded-xl transition-all hover:bg-white/10 {{ request()->routeIs('customer.notifications.*') ? 'text-brand-primary' : '' }}" 
               :class="isScrolled ? '{{ request()->routeIs('customer.notifications.*') ? 'text-brand-cyan' : 'text-gray-400 hover:text-white' }}' : ''">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-brand-primary rounded-full border-2 border-white shadow-sm"></span>
            </a>

            <div class="relative flex items-center gap-3 pl-6 border-l transition-colors" 
                 :class="isScrolled ? 'border-white/10' : 'border-gray-100'">
                
                <div @click="openProfile = !openProfile" @click.outside="openProfile = false" 
                     class="flex items-center gap-3 cursor-pointer group">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold uppercase tracking-widest transition-colors" :class="isScrolled ? 'text-white' : 'text-brand-dark'">{{ $user->name }}</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase">{{ $user->role }}</div>
                    </div>
                    
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white font-bold shadow-lg shadow-brand-primary/20 text-xs transition-transform group-hover:scale-105">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>

                <div x-show="openProfile" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     class="absolute right-0 top-14 w-56 bg-white rounded-3xl shadow-2xl border border-gray-50 py-3 z-[60] text-brand-dark">
                    
                    <div class="px-6 py-2 mb-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Account</p>
                    </div>
                    
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition-colors text-sm font-semibold">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                        Edit Profile
                    </a>

                    <div class="h-px bg-gray-50 my-2 mx-4"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-6 py-3 hover:bg-red-50 transition-colors text-sm font-bold text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2"/></svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>