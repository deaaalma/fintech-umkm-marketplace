<aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 bg-[#000B44] text-white z-50 shadow-2xl shadow-indigo-900/40">
    <div class="p-10 pb-12">
        <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
        <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Superadmin</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar pt-2">
        <!-- Dashboard / UMKM Management -->
        <a href="{{ route('superadmin.dashboard.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.dashboard.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.dashboard.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.dashboard.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Dashboard</span>
            </div>
        </a>
        
        <!-- Users -->
        <a href="{{ route('superadmin.users.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.users.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.users.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.users.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Pengguna</span>
            </div>
            <span class="bg-[#0077B6] text-white text-[10px] font-black px-2 py-0.5 rounded-lg shadow-lg shadow-[#0077B6]/20">2</span>
        </a>

        <!-- Transactions -->
        <a href="{{ route('superadmin.transactions.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.transactions.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.transactions.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.transactions.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Transaksi</span>
            </div>
            <span class="bg-white/10 text-white/50 text-[10px] font-black px-2 py-0.5 rounded-lg">3</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('superadmin.reports.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.reports.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.reports.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.reports.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Laporan</span>
            </div>
        </a>

        <!-- Settings -->
        <a href="{{ route('superadmin.settings.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('superadmin.settings.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('superadmin.settings.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('superadmin.settings.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Settings</span>
            </div>
        </a>
    </nav>

    <!-- Logout -->
    <div class="px-8 py-10 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl bg-white/5 hover:bg-red-500/10 text-white/50 hover:text-red-400 transition-all duration-300 group">
                <svg class="w-6 h-6 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-sm font-bold tracking-wider uppercase">Logout Session</span>
            </button>
        </form>
    </div>
</aside>

