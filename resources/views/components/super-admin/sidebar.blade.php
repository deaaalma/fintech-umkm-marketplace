<aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 bg-[#000B44] text-white z-50 shadow-2xl shadow-indigo-900/40">
    <div class="p-10 pb-12">
        <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
        <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Superadmin</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar pt-2">
        <!-- Dashboard / UMKM Management -->
        <a href="{{ route('superadmin.dashboard') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Dashboard</span>
            </div>
        </a>
        
        <!-- Users -->
        <a href="{{ route('superadmin.dashboard.users') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard.users'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard.users')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard.users') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Pengguna</span>
            </div>
            <span class="bg-[#0077B6]/10 text-[#0077B6] text-[10px] font-black px-2 py-0.5 rounded-lg border border-[#0077B6]/20">168</span>
        </a>

        <!-- UMKM Management -->
        <a href="{{ route('superadmin.dashboard.umkm') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard.umkm'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard.umkm')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard.umkm') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615 3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615m-15 0-1.44-2.16A1.5 1.5 0 0 1 2.25 5.385V4.5b1.125-1.125 0 0 1 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v.885a1.5 1.5 0 0 1-.06 1.18l-1.44 2.16"/></svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Manajemen UMKM</span>
            </div>
        </a>

        <!-- Transactions -->
        <a href="{{ route('superadmin.dashboard.transactions') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard.transactions'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard.transactions')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard.transactions') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Transaksi</span>
            </div>
        </a>

        <!-- Laporan -->
        <a href="{{ route('superadmin.dashboard.reports') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard.reports'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard.reports')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard.reports') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Laporan</span>
            </div>
        </a>
    </nav>
</aside>
