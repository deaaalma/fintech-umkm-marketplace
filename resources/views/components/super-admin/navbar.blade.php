<nav
    x-data="{
        isMobileMenuOpen: false,
        isScrolled: false,
        init() { 
            window.addEventListener('scroll', () => { 
                this.isScrolled = window.scrollY > 20; 
            }); 
        }
    }"
    :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-sm text-gray-900' : 'bg-white text-gray-900'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-[#e5e5e5]"
>
    <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#000B44] rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-black text-[#000B44] font-plus" style="font-family: 'Plus Jakarta Sans', sans-serif;">Superadmin Portal</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" style="font-family: 'Plus Jakarta Sans', sans-serif;">Platform Management</p>
                    </div>
                </div>
            </div>

            <div class="hidden md:block flex-1 max-w-md mx-8">
                <div class="relative group">
                    <input 
                        type="text" 
                        placeholder="Cari transaksi, merchant, atau user..."
                        class="w-full px-4 py-2.5 pl-10 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 transition-all text-sm font-bold text-slate-700"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <button class="relative p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-slate-400 hover:text-[#000B44] hover:bg-white transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                
               <div class="relative" x-data="{ open: false }">
                    <div @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 pl-4 border-l border-slate-100 cursor-pointer hover:opacity-80 transition-opacity">
                        <div class="w-10 h-10 rounded-xl bg-[#000B44] flex items-center justify-center overflow-hidden shadow-sm">
                            @if(auth()->user()->profile_picture_url)
                                <img src="{{ auth()->user()->profile_picture_url }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white font-black text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                        <div class="text-left hidden md:block">
                            <div class="text-sm font-black text-[#000B44] font-plus" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest font-plus" style="font-family: 'Plus Jakarta Sans', sans-serif;">Superadmin</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-4 w-52 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-[60]"
                        x-cloak>
                        
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Lihat Profil
                        </a>

                        <hr class="my-2 border-slate-50">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out System
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="md:hidden">
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                        class="text-gray-900 border border-slate-200 p-2 rounded-xl bg-slate-50">
                    <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-8 pb-4 border-b border-slate-100/50">
            
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">Dashboard</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('admin.dashboard.umkm') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard.umkm*') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">UMKM Management</span>
                <span class="px-2 py-0.5 bg-[#000B44] text-white text-[9px] font-black rounded-lg">127</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard.umkm*') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('admin.dashboard.users') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard.users*') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">Pengguna</span>
                <span class="px-2 py-0.5 bg-[#000B44] text-white text-[9px] font-black rounded-lg">2</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard.users*') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('admin.dashboard.transactions') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard.transactions*') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">Transaksi</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard.transactions*') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('admin.dashboard.reports') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard.reports*') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">Laporan</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard.reports*') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('admin.dashboard.settings') }}" 
                class="flex items-center gap-2 px-1 py-2 text-sm font-black transition-all duration-200 relative group {{ request()->routeIs('admin.dashboard.settings*') ? 'text-[#000B44]' : 'text-slate-400 hover:text-[#000B44]' }}" 
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <span class="uppercase tracking-widest text-[11px]">Pengaturan</span>
                <div class="absolute -bottom-4 left-0 {{ request()->routeIs('admin.dashboard.settings*') ? 'w-full' : 'w-0' }} h-1 bg-[#000B44] rounded-full transition-all duration-300 group-hover:w-full"></div>
            </a>

        </div>
    </div>
</nav>