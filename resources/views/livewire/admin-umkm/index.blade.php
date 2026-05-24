<x-slot:title>Overview</x-slot>

<div class="space-y-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-[#000B44] p-8 rounded-[2rem] text-white shadow-2xl animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex justify-between items-start mb-8">
                <h4 class="text-xs font-bold font-plus text-white/70 uppercase tracking-widest leading-none">New Orders</h4>
            </div>
            <h3 class="text-5xl font-black font-plus tracking-tighter leading-none mb-4">{{ $stats['new_orders'] }}</h3>
            <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Orders waiting for approval</p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex justify-between items-start mb-8">
                <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Total Revenue</h4>
            </div>
            <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-4 whitespace-nowrap">
                Rp {{ number_format($stats['total_balance'] / 1000000, 2) }}M
            </h3>
            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Successful payments</p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl animate-fade-in-up" style="animation-delay: 0.3s">
             <div class="flex justify-between items-start mb-8">
                <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Active Orders</h4>
            </div>
            <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-4">{{ $stats['active_orders'] }}</h3>
            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Orders in progress</p>
        </div>
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