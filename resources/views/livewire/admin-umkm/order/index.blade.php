<x-slot:title>Order Lists</x-slot>

<div class="space-y-10">
    <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
        <div class="relative w-full lg:w-96 group">
            <input type="text" wire:model.live="search" placeholder="Search invoice or customer..." 
                   class="w-full pl-12 pr-6 py-4 bg-white border border-slate-100 rounded-[1.5rem] text-xs font-bold text-[#000B44] focus:ring-8 focus:ring-[#0077B6]/5 focus:border-[#0077B6]/20 transition-all placeholder:text-slate-300 outline-none shadow-sm">
            <svg class="w-4 h-4 text-slate-300 absolute left-5 top-1/2 -translate-y-1/2 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <div class="flex items-center justify-between lg:justify-end gap-4 w-full lg:w-auto relative">
            <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pb-1">
                <button wire:click="$set('category', 'All')" 
                    class="px-8 py-3.5 rounded-[1.2rem] text-[11px] font-black uppercase tracking-widest transition-all 
                    {{ $category == 'All' ? 'bg-white text-[#0077B6] border border-[#0077B6]/10 shadow-sm' : 'text-slate-400 hover:text-[#000B44]' }} whitespace-nowrap">
                    All
                </button>
                <button wire:click="$set('category', 'Active')" 
                    class="px-8 py-3.5 rounded-[1.2rem] text-[11px] font-black uppercase tracking-widest transition-all 
                    {{ $category == 'Active' ? 'bg-white text-[#0077B6] border border-[#0077B6]/10 shadow-sm' : 'text-slate-400 hover:text-[#000B44]' }} whitespace-nowrap">
                    Active
                </button>
                <button wire:click="$set('category', 'History')" 
                    class="px-8 py-3.5 rounded-[1.2rem] text-[11px] font-black uppercase tracking-widest transition-all 
                    {{ $category == 'History' ? 'bg-white text-[#0077B6] border border-[#0077B6]/10 shadow-sm' : 'text-slate-400 hover:text-[#000B44]' }} whitespace-nowrap">
                    History
                </button>
            </div>

            <div class="w-px h-6 bg-slate-200 mx-1 hidden sm:block"></div>
            
            <div class="relative pb-1" x-data="{ open: @entangle('showFilters') }">
                <button @click="open = !open" 
                    class="w-12 h-12 flex items-center justify-center rounded-[1.2rem] transition-all shadow-sm border
                    {{ $showFilters ? 'bg-[#0077B6] text-white border-[#0077B6]' : 'bg-white text-slate-400 border-slate-100 hover:text-[#000B44]' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-4 w-[400px] bg-white rounded-[2rem] shadow-[0_30px_60px_rgba(0,0,0,0.12)] border border-slate-100 z-50 p-8 origin-top-right backdrop-blur-2xl" x-cloak>
                    
                    <div class="absolute -top-2 right-6 w-4 h-4 bg-white border-l border-t border-slate-100 rotate-45"></div>

                    <div class="space-y-7">
                        <div class="space-y-1">
                            <h4 class="text-[15px] font-black text-[#000B44] uppercase tracking-[0.2em]">Filter Options</h4>
                            <p class="text-[10px] font-bold text-slate-400">Refine your results with specific criteria</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-5">
                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-700 uppercase tracking-widest ml-1">Status</label>
                                <select wire:model.live="status" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-[#000B44] outline-none focus:bg-white transition-all cursor-pointer">
                                    <option value="All">All Statuses</option>
                                    <option value="pending_valuation">Pending Valuation</option>
                                    <option value="waiting_payment">Waiting Payment</option>
                                    <option value="paid">Paid</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <button wire:click="resetFilters" class="text-[12px] font-black text-slate-400 uppercase tracking-widest hover:text-red-500 transition-colors">
                                Reset All
                            </button>
                            <button @click="open = false" class="px-10 py-4 bg-[#000B44] text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden font-plus">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Order ID</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Customer</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Price</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/50 text-[#000B44]">
                @forelse($orders as $o)
                <tr class="hover:bg-slate-50/50 transition-all cursor-pointer group">
                    <td class="px-10 py-6">
                        <span class="text-[13px] font-black group-hover:text-[#0077B6] transition-colors">{{ $o['id'] }}</span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="text-xs font-bold">{{ $o['client'] }}</span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-tighter">{{ $o['price'] }}</span>
                    </td>
                    <td class="px-6 py-6 text-center">
                        <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border
                            @if($o['color'] == 'amber') bg-amber-50 text-amber-600 border-amber-100 
                            @elseif($o['color'] == 'orange') bg-orange-50 text-orange-600 border-orange-100
                            @elseif($o['color'] == 'teal') bg-teal-50 text-teal-600 border-teal-100 
                            @elseif($o['color'] == 'blue') bg-blue-50 text-blue-600 border-blue-100 
                            @elseif($o['color'] == 'green') bg-green-50 text-green-600 border-green-100
                            @elseif($o['color'] == 'red') bg-red-50 text-red-600 border-red-100
                            @else bg-slate-50 text-slate-500 border-slate-100 @endif">
                            {{ $o['status'] }}
                        </span>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <span class="text-[11px] font-black text-slate-300">{{ $o['time'] }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-10 py-12 text-center text-slate-400 text-sm font-bold">No orders found matching your criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-4">
        {{ $orders_pagination->links() }}
    </div>
</div>