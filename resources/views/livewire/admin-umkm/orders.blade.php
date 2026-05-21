<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .sidebar-solid { background: #000B44; }
        .active-nav { background: rgba(255, 255, 255, 0.05); position: relative; }
        .active-nav::after {
            content: ''; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #0077B6; border-radius: 0 4px 4px 0;
        }
    </style>

    <!-- Sidebar (Consistent) -->
    <aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 sidebar-solid text-white z-50 shadow-2xl">
        <div class="p-10 pb-12">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-2xl font-plus border border-white/20 shadow-lg">J</div>
                <div>
                    <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
                    <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Partner Admin</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar">
            <!-- Home Menu -->
            <a href="/templates/umkm/dashboard" class="flex items-center justify-between px-6 py-4 rounded-2xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Home</span>
                </div>
            </a>
            
            <!-- Orders Menu -->
            <a href="/templates/umkm/orders" class="flex items-center justify-between px-6 py-4 rounded-2xl active-nav text-white transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Orders</span>
                </div>
                <span class="bg-[#0077B6] text-white text-[10px] font-black px-2 py-0.5 rounded-lg shadow-lg shadow-[#0077B6]/20">7</span>
            </a>

            <!-- Services Menu -->
            <a href="#" class="flex items-center justify-between px-6 py-4 rounded-2xl hover:bg-white/5 text-white/50 hover:text-white transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Services</span>
                </div>
            </a>

            <!-- Settings Menu -->
            <a href="#" class="flex items-center justify-between px-6 py-4 rounded-2xl hover:bg-white/5 text-white/50 hover:text-white transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Settings</span>
                </div>
            </a>
        </nav>
        <!-- Logout -->
        <div class="px-8 py-10 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl bg-white/5 hover:bg-red-500/10 text-white/50 hover:text-red-400 transition-all duration-300 group">
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <header class="px-8 lg:px-12 py-8 flex flex-col sm:flex-row justify-between items-end bg-[#F8FAFC]/50 backdrop-blur-xl sticky top-0 z-40 border-b border-slate-100/50">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[#0077B6] text-[10px] font-black uppercase tracking-widest">Management</span>
                    <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Active Orders</span>
                </div>
                <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tight">Order Lists</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="px-8 py-4 bg-[#000B44] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    New Order
                </button>
            </div>
        </header>

        <div class="px-8 lg:px-12 py-10 space-y-10">
            <!-- Simplified Toolbar -->
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <!-- Simple Search -->
                <div class="relative w-full lg:w-96 group">
                    <input type="text" wire:model.live="search" placeholder="Search orders..." class="w-full pl-12 pr-6 py-4 bg-white border border-slate-100 rounded-[1.5rem] text-xs font-bold text-[#000B44] focus:ring-8 focus:ring-[#0077B6]/5 focus:border-[#0077B6]/20 transition-all placeholder:text-slate-300 outline-none shadow-sm">
                    <svg class="w-4 h-4 text-slate-300 absolute left-5 top-1/2 -translate-y-1/2 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Functional Tabs + Filter -->
                <div class="flex items-center justify-between lg:justify-end gap-4 w-full lg:w-auto relative">
                    <!-- Scrollable Tabs Area -->
                    <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pb-1">
                        @foreach(['All', 'Active', 'History'] as $cat)
                        <button wire:click="setCategory('{{ $cat }}')" 
                            class="px-8 py-3.5 rounded-[1.2rem] text-[11px] font-black uppercase tracking-widest transition-all 
                            @if($category==$cat) bg-white text-[#0077B6] border border-[#0077B6]/10 shadow-sm @else text-slate-400 hover:text-[#000B44] @endif whitespace-nowrap">
                            {{ $cat }}
                        </button>
                        @endforeach
                    </div>

                    <div class="w-px h-6 bg-slate-200 mx-1 hidden sm:block"></div>
                    
                    <!-- Filter Button Container (Must have overflow visible) -->
                    <div class="relative pb-1">
                        <button wire:click="toggleFilters" 
                            class="w-12 h-12 flex items-center justify-center rounded-[1.2rem] transition-all shadow-sm border
                            {{ $showFilters ? 'bg-[#0077B6] text-white border-[#0077B6]' : 'bg-white text-slate-400 border-slate-100 hover:text-[#000B44]' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>

                        <!-- Popover Dropdown (Matching Reference) -->
                        @if($showFilters)
                        <div x-data x-show="true" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            class="absolute right-0 mt-4 w-[480px] bg-white rounded-[2rem] shadow-[0_30px_60px_rgba(0,0,0,0.12)] border border-slate-100 z-50 p-8 origin-top-right backdrop-blur-2xl">
                            
                            <!-- Arrow / Caret -->
                            <div class="absolute -top-2 right-6 w-4 h-4 bg-white border-l border-t border-slate-100 rotate-45"></div>

                            <div class="space-y-7">
                                <div class="space-y-1">
                                    <h4 class="text-[15px] font-black text-[#000B44] uppercase tracking-[0.2em]">Filter Options</h4>
                                    <p class="text-[10px] font-bold text-slate-400">Refine your results with specific criteria</p>
                                </div>
                                
                                <!-- Dropdowns Row -->
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-700 uppercase tracking-widest ml-1">Service Type</label>
                                        <div class="relative group">
                                            <select wire:model.live="service" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-slate-400 outline-none focus:bg-white focus:text-[#000B44] focus:border-[#0077B6]/30 focus:ring-[12px] focus:ring-[#0077B6]/5 transition-all cursor-pointer">
                                                <option value="All">Show All Services</option>
                                                <option value="Deep Cleaning">Deep Cleaning</option>
                                                <option value="Office Clean">Office Clean</option>
                                                <option value="Regular Clean">Regular Clean</option>
                                                <option value="Vehicle Clean">Vehicle Clean</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-700 uppercase tracking-widest ml-1">Order Status</label>
                                        <div class="relative group">
                                            <select wire:model.live="status" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-slate-400 outline-none focus:bg-white focus:text-[#000B44] focus:border-[#0077B6]/30 focus:ring-[12px] focus:ring-[#0077B6]/5 transition-all cursor-pointer">
                                                <option value="All">All Active Statuses</option>
                                                <option value="Pending">Pending</option>
                                                <option value="In Process">In Process</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date Range Row -->
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-700 uppercase tracking-widest ml-1">Start Date</label>
                                        <input type="date" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-slate-400 outline-none focus:bg-white focus:text-[#000B44] focus:border-[#0077B6]/30 focus:ring-[12px] focus:ring-[#0077B6]/5 transition-all">
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-700 uppercase tracking-widest ml-1">End Date</label>
                                        <input type="date" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-slate-400 outline-none focus:bg-white focus:text-[#000B44] focus:border-[#0077B6]/30 focus:ring-[12px] focus:ring-[#0077B6]/5 transition-all">
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <button wire:click="resetFilters" class="text-[12px] font-black text-slate-400 uppercase tracking-widest hover:text-red-500 transition-colors">
                                        Reset All
                                    </button>
                                    <button wire:click="toggleFilters" class="px-10 py-4 bg-[#000B44] text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] hover:shadow-xl hover:shadow-[#0077B6]/20 transition-all active:scale-95">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Simplified Clean Table -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden font-plus">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Order ID</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Customer</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Service</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/50 text-[#000B44]">
                        @foreach($orders as $o)
                        <tr class="hover:bg-slate-50/50 transition-all cursor-pointer group">
                            <td class="px-10 py-6">
                                <span class="text-[13px] font-black group-hover:text-[#0077B6] transition-colors">{{ $o['id'] }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-xs font-bold">{{ $o['client'] }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-xs text-slate-400 font-bold uppercase tracking-tighter">{{ $o['item'] }}</span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border
                                    @if($o['color'] == 'amber') bg-amber-50 text-amber-600 border-amber-100 
                                    @elseif($o['color'] == 'teal') bg-teal-50 text-teal-600 border-teal-100 
                                    @elseif($o['color'] == 'blue') bg-blue-50 text-blue-600 border-blue-100 
                                    @elseif($o['color'] == 'red') bg-red-50 text-red-600 border-red-100
                                    @else bg-slate-50 text-slate-500 border-slate-100 @endif">
                                    {{ $o['status'] }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <span class="text-[11px] font-black text-slate-300">10:30 AM</span>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($orders) == 0)
                        <tr>
                            <td colspan="5" class="px-10 py-12 text-center text-slate-400 text-sm font-bold">No orders found matching your search.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Simple Pagination -->
            <div class="flex justify-center items-center gap-4 pt-4">
                <button class="w-11 h-11 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-[#000B44] transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
                <div class="flex items-center gap-1">
                    <span class="w-11 h-11 flex items-center justify-center bg-[#000B44] text-white rounded-xl text-xs font-black">1</span>
                    <span class="w-11 h-11 flex items-center justify-center text-slate-400 text-xs font-black">2</span>
                    <span class="w-11 h-11 flex items-center justify-center text-slate-400 text-xs font-black">3</span>
                </div>
                <button class="w-11 h-11 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-[#000B44] transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
            </div>
        </div>
    </main>
</div>
