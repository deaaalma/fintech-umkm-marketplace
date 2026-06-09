<aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 bg-[#000B44] text-white z-50 shadow-2xl shadow-indigo-900/40">
    <div class="p-10 pb-12">
        <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
        <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Customer Portal</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar pt-2">
        <!-- Dashboard -->
        <a href="{{ route('customer.dashboard') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('customer.dashboard'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('customer.dashboard')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('customer.dashboard') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Dashboard</span>
            </div>
        </a>
        
        <!-- Pesanan Saya -->
        <a href="{{ route('customer.orders') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('customer.orders', 'customer.order-details'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('customer.orders', 'customer.order-details')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('customer.orders', 'customer.order-details') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Pesanan Saya</span>
            </div>
        </a>

        <!-- Mitra Jasa -->
        <a href="{{ route('customer.partners') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('customer.partners', 'customer.partner-detail'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('customer.partners', 'customer.partner-detail')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('customer.partners', 'customer.partner-detail') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615 3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615m-15 0-1.44-2.16A1.5 1.5 0 0 1 2.25 5.385V4.5b1.125-1.125 0 0 1 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v.885a1.5 1.5 0 0 1-.06 1.18l-1.44 2.16"/>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Mitra Jasa</span>
            </div>
        </a>
    </nav>
</aside>
