<aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 bg-[#000B44] text-white z-50 shadow-2xl">
    <!-- Logo -->
    <div class="p-10 pb-12">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-2xl font-plus border border-white/20 shadow-lg">J</div>
            <div>
                <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
                <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Admin UMKM</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar">
        <!-- Home / Overview -->
        <a href="{{ route('admin-umkm.dashboard.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('admin-umkm.dashboard.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin-umkm.dashboard.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('admin-umkm.dashboard.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Overview</span>
            </div>
        </a>
        
        <!-- Orders -->
        <a href="{{ route('admin-umkm.orders.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('admin-umkm.orders.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin-umkm.orders.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('admin-umkm.orders.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Orders</span>
            </div>
            <span class="bg-[#0077B6] text-white text-[10px] font-black px-2 py-0.5 rounded-lg shadow-lg shadow-[#0077B6]/20">7</span>
        </a>

        <!-- Status Verifikasi (Waiting Screen) -->
        <a href="{{ route('admin-umkm.waiting.preview') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('admin-umkm.waiting.preview'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('admin-umkm.waiting.preview')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('admin-umkm.waiting.preview') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Verification</span>
            </div>
        </a>

        <!-- Services -->
        <a href="#" class="flex items-center justify-between px-6 py-4 rounded-2xl hover:bg-white/5 text-white/50 hover:text-white transition-all duration-300 group">
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="text-xs font-bold tracking-wider uppercase">Services</span>
            </div>
        </a>

        <!-- Settings -->
        <a href="#" class="flex items-center justify-between px-6 py-4 rounded-2xl hover:bg-white/5 text-white/50 hover:text-white transition-all duration-300 group">
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
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
