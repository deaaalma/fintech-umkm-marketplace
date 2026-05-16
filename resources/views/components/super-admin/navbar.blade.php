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
            <!-- Logo & Brand -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#003d5c] rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900" style="font-family: 'Figtree', sans-serif;">Superadmin Portal</h1>
                        <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">UMKM Management</p>
                    </div>
                </div>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:block flex-1 max-w-md mx-8">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search UMKMs, users, orders..."
                        class="w-full px-4 py-2.5 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent text-sm"
                        style="font-family: 'Figtree', sans-serif;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="hidden md:flex items-center gap-4">
                <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <div class="flex items-center gap-3 pl-4 border-l border-[#e5e5e5]">
                    <div class="w-9 h-9 rounded-full bg-[#0078b7] flex items-center justify-center">
                        <span class="text-white font-semibold text-sm" style="font-family: 'Figtree', sans-serif;">A</span>
                    </div>
                    <div class="text-left">
                        <div class="text-sm font-semibold text-gray-900" style="font-family: 'Figtree', sans-serif;">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ auth()->user()->role }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <div class="md:hidden">
                <button @click="isMobileMenuOpen = !isMobileMenuOpen" 
                        class="text-gray-900 hover:text-[#0078b7] p-2 rounded-md transition-colors duration-200">
                    <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Secondary Navigation -->
       <div class="hidden md:flex items-center gap-6 pb-4 border-b border-[#e5e5e5]">
            
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('admin.dashboard') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>Dashboard</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('admin.dashboard') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="#" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('superadmin.umkm.*') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>UMKM Management</span>
                <span class="px-2 py-0.5 bg-[#003d5c] text-white text-xs font-semibold rounded-full">127</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('superadmin.umkm.*') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('superadmin.users.preview') }}" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('superadmin.users.*') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>Pengguna</span>
                <span class="px-2 py-0.5 bg-[#003d5c] text-white text-xs font-semibold rounded-full">2</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('superadmin.users.*') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('superadmin.transactions.preview') }}" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('superadmin.transactions.*') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>Transaksi</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('superadmin.transactions.*') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('superadmin.reports.preview') }}" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('superadmin.reports.*') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>Laporan</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('superadmin.reports.*') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

            <a href="{{ route('superadmin.settings.preview') }}" 
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition-colors duration-200 relative group {{ request()->routeIs('superadmin.settings.*') ? 'text-[#0078b7]' : 'text-gray-900 hover:text-[#0078b7]' }}" 
                style="font-family: 'Figtree', sans-serif; font-weight: 400;">
                <span>Pengaturan</span>
                <div class="absolute bottom-0 left-0 {{ request()->routeIs('superadmin.settings.*') ? 'w-full' : 'w-0' }} h-0.5 bg-current transition-all duration-300 group-hover:w-full"></div>
            </a>

        </div>
    </div>
</nav>