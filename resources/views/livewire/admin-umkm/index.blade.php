<x-slot:title>Home</x-slot>

<div class="space-y-10">
    <style>
        .metric-card { transition: box-shadow 0.2s ease; }
        .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
        {{-- New Orders --}}
        <a href="{{ route('umkm.orders') }}" class="metric-card block bg-[#000B44] rounded-2xl border border-[#1a3a7a] flex flex-col group relative overflow-hidden hover:opacity-90 transition-opacity animate-fade-in-up" style="animation-delay: 0.1s">
            @if($stats['new_orders'] > 0)
                <div class="absolute top-4 right-4 w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></div>
            @endif
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-white/15">
                <span class="text-base font-bold text-white/90 flex-1">New Orders</span>
                <div class="text-white/30 group-hover:text-white/60 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-4 flex-1">
                <h3 class="text-5xl font-black text-white font-plus tracking-tighter leading-none">{{ $stats['new_orders'] }}</h3>
            </div>
            <div class="px-6 pb-6 pt-3 border-t border-white/15 flex items-center justify-between">
                <span class="text-white/70 text-xs font-medium">Orders waiting for approval</span>
            </div>
        </a>

        {{-- Total Revenue --}}
        <div class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-emerald-500 transition-all duration-300 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-emerald-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-emerald-600 transition-colors">Total Revenue</span>
                <div class="text-slate-400 group-hover:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-emerald-50/30 transition-colors">
                <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left whitespace-nowrap">Rp {{ number_format($stats['total_balance'] / 1000000, 2) }}M</h3>
            </div>
        </div>

        {{-- Active Orders --}}
        <a href="{{ route('umkm.orders') }}" class="metric-card group block bg-white rounded-2xl border border-slate-300 hover:border-[#0077B6] transition-all duration-300 overflow-hidden shadow-sm animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-blue-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-[#0077B6] transition-colors">Active Orders</span>
                <div class="text-slate-400 group-hover:text-[#0077B6] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                </div>
            </div>
            <div class="px-6 pt-5 pb-6 group-hover:bg-blue-50/30 transition-colors">
                <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left">{{ $stats['active_orders'] }}</h3>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-12 gap-8 items-start">
        <div class="col-span-12 xl:col-span-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm font-plus">
            <h3 class="text-2xl font-black text-[#000B44] tracking-tight mb-10">Live Pipeline</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                @foreach($pipeline as $label => $count)
                <div class="space-y-4">
                    <div class="flex justify-between items-end px-1">
                        <span class="text-xs font-black text-[#000B44] uppercase tracking-widest">{{ $label }}</span>
                        <span class="text-sm font-black text-[#000B44]">{{ $count }} <span class="text-[10px] text-slate-400 uppercase">Orders</span></span>
                    </div>
                    <div class="w-full h-8 bg-slate-50 rounded-xl border border-slate-100 overflow-hidden shadow-inner">
                        <div class="h-full bg-[#000B44] rounded-xl" style="width: {{ $count > 0 ? min($count * 10, 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-span-12 xl:col-span-4 bg-white p-10 rounded-[2.5rem] border border-slate-100 flex flex-col font-plus shadow-sm">
            <h3 class="text-2xl font-black text-[#000B44] tracking-tight mb-10">Recent Orders</h3>
            <div class="border border-slate-100 rounded-[2rem] overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/70 border-b border-slate-100">
                        <tr>
                            <th class="p-5 text-[10px] font-black text-slate-500 uppercase">ID</th>
                            <th class="p-5 text-center border-l border-slate-100 text-[10px] font-black text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentOrders as $o)
                        <tr class="hover:bg-slate-50/50 transition-all cursor-pointer">
                            <td class="p-5"><p class="text-[13px] font-black text-[#000B44] tracking-tight">{{ $o['id'] }}</p></td>
                            <td class="p-5 border-l border-slate-100 text-center">
                                <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-{{ $o['color'] }}-50 text-{{ $o['color'] }}-600 border border-{{ $o['color'] }}-100">
                                    {{ $o['status'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="p-5 text-center text-slate-400 text-xs">No recent orders.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin-umkm.orders.preview') }}" class="w-full mt-8 py-5 bg-slate-50 hover:bg-[#000B44] hover:text-white text-center border border-slate-100 rounded-[1.5rem] text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] transition-all duration-300">View All Orders</a>
        </div>
    </div>
</div>