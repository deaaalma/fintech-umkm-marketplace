<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .sidebar-solid {
            background: #000B44;
        }
        
        .active-nav {
            background: rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .active-nav::after {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 4px;
            background: #0077B6;
            border-radius: 0 4px 4px 0;
        }

        .sekat-border {
            border: 1px solid #E2E8F0;
        }

        @keyframes barGrow {
            from { width: 0; }
            to { width: var(--target-width); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-bar {
            animation: barGrow 1.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }
    </style>

    <!-- Sidebar -->
    <aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 sidebar-solid text-white z-50 shadow-2xl">
        <!-- Logo -->
        <div class="p-10 pb-12">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-2xl font-plus border border-white/20 shadow-lg">J</div>
                <div>
                    <h1 class="text-2xl font-black font-plus tracking-tight leading-none">JOS</h1>
                    <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-2 block">Partner Admin</span>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar">
            <!-- Home Menu -->
            <a href="/templates/umkm/dashboard" class="flex items-center justify-between px-6 py-4 rounded-2xl active-nav text-white transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <span class="text-sm font-bold tracking-wider uppercase">Home</span>
                </div>
            </a>
            
            <!-- Orders Menu -->
            <a href="/templates/umkm/orders" class="flex items-center justify-between px-6 py-4 rounded-2xl hover:bg-white/5 text-white/50 hover:text-white transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-slate-500 group-hover:text-blue-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
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
        <!-- Top Header -->
        <header class="px-8 lg:px-12 py-8 flex flex-col sm:flex-row justify-between items-center bg-[#F8FAFC]/50 backdrop-blur-xl sticky top-0 z-40 transition-all duration-300 border-b border-slate-100/50">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-3xl font-black text-[#000B44] font-plus tracking-tight">Overview</h2>
                <p class="text-slate-400 font-medium text-sm mt-1">Hello, <span class="text-[#0077B6] font-bold">Admin BWP</span></p>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Search Bar with Focus Animation -->
                <div class="relative hidden xl:block group transition-all duration-300">
                    <input type="text" wire:model.live="search" placeholder="Search orders..." class="w-72 focus:w-80 pl-12 pr-6 py-3.5 bg-white/70 border border-slate-200 rounded-2xl text-xs font-bold focus:ring-[12px] focus:ring-[#0077B6]/10 focus:border-[#0077B6]/30 focus:bg-white transition-all duration-500 placeholder:text-slate-400 outline-none shadow-sm">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div class="flex items-center gap-4">
                    <button class="w-12 h-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all group relative">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-[#000B44]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <!-- Divider -->
                    <div class="w-px h-8 bg-slate-200 mx-1"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-[#0077B6]/10 border-2 border-[#0077B6]/20 rounded-2xl flex items-center justify-center text-[#0077B6] font-black font-plus shadow-sm overflow-hidden group cursor-pointer hover:border-[#0077B6] transition-all">
                             <img src="https://ui-avatars.com/api/?name=Admin+BWP&background=0077B6&color=fff" alt="Avatar" class="group-hover:scale-110 transition-transform">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="px-8 lg:px-12 py-10 space-y-10">
            <!-- Hero Section (Top, 12-col grid for cards) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- New Orders Card -->
                <div class="bg-[#000B44] p-8 rounded-[2rem] text-white shadow-2xl shadow-[#000B44]/20 relative group transition-all hover:scale-[1.02] animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-white/70 uppercase tracking-widest leading-none">New Orders</h4>
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-5xl font-black font-plus tracking-tighter leading-none">7</h3>
                    </div>
                    <div class="flex items-center gap-2 mt-auto">
                        <span class="bg-teal-500/20 text-teal-400 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none shadow-sm shadow-black/20">
                            12% <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                        </span>
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Since last month</span>
                    </div>
                </div>

                <!-- Total Balance Card -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/10 relative group transition-all hover:scale-[1.02] animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Total Balance</h4>
                        <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none whitespace-nowrap">Rp 12,50M</h3>
                    </div>
                    <div class="flex items-center gap-2 mt-auto">
                        <span class="bg-teal-50 text-teal-600 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none">
                            8% <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                        </span>
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Since last month</span>
                    </div>
                </div>

                <!-- Active Orders Card -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/10 relative group transition-all hover:scale-[1.02] animate-fade-in-up" style="animation-delay: 0.3s">
                     <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Active Orders</h4>
                        <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none">8</h3>
                    </div>
                    <div class="flex items-center gap-2 mt-auto">
                        <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none shadow-sm shadow-blue-500/10">
                            / 15 <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </span>
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Resource Capacity</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Split Layout: Pipeline (Left) & Recent (Right) -->
            <div class="grid grid-cols-12 gap-8 items-start">
                
                <!-- Left Content: Order Pipeline -->
                <div class="col-span-12 xl:col-span-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 transition-all font-plus h-full flex flex-col">
                    <div class="flex justify-between items-center mb-14 px-2">
                        <div>
                            <h3 class="text-2xl font-black text-[#000B44] tracking-tight leading-none">Order Pipeline</h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-3">Live Process Tracking Overview</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 flex-1">
                        @php
                            $pipelines = [
                                ['label' => 'Pending Review', 'count' => 7, 'pct' => 70],
                                ['label' => 'Negotiating', 'count' => 4, 'pct' => 45],
                                ['label' => 'Waiting Payment', 'count' => 5, 'pct' => 55],
                                ['label' => 'Paid Today', 'count' => 3, 'pct' => 35],
                                ['label' => 'In Process', 'count' => 5, 'pct' => 55],
                                ['label' => 'Completed', 'count' => 12, 'pct' => 92],
                            ];
                        @endphp
                        @foreach($pipelines as $p)
                        <div class="space-y-4">
                            <div class="flex justify-between items-end px-1">
                                <span class="text-xs font-black text-[#000B44] uppercase tracking-widest">{{ $p['label'] }}</span>
                                <span class="text-sm font-black text-[#000B44] leading-none">{{ $p['count'] }} <span class="text-[10px] text-slate-400 uppercase font-bold ml-1">Orders</span></span>
                            </div>
                            <div class="w-full h-8 bg-slate-50 rounded-xl border border-slate-100 p-0 overflow-hidden shadow-inner">
                                <div class="h-full bg-[#000B44] rounded-xl animate-bar" style="--target-width: {{ $p['pct'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Content: Recent Orders (Refined for Clarity & Sync Height) -->
                <div class="col-span-12 xl:col-span-4 bg-white p-10 rounded-[2.5rem] border border-slate-100 flex flex-col font-plus shadow-sm h-full">
                    <div class="flex justify-between items-center mb-10 px-2 h-10">
                        <h3 class="text-2xl font-black text-[#000B44] tracking-tight leading-none">Recent Orders</h3>
                        <a href="#" class="text-[11px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:text-[#000B44] transition-all">All Orders</a>
                    </div>
                    
                    <div class="border border-slate-100 rounded-[2rem] overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/70 border-b border-slate-100">
                                <tr>
                                    <th class="p-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Order ID</th>
                                    <th class="p-5 text-[10px] font-black text-slate-500 uppercase tracking-widest border-l border-slate-100 text-center">Status</th>
                                    <th class="p-5 text-[10px] font-black text-slate-500 uppercase tracking-widest border-l border-slate-100 text-right">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($recentOrders as $o)
                                <tr class="hover:bg-slate-50/50 transition-all cursor-pointer group">
                                    <td class="p-5">
                                        <p class="text-[13px] font-black text-[#000B44] group-hover:text-[#0077B6] transition-colors tracking-tight">{{ $o['id'] }}</p>
                                    </td>
                                    <td class="p-5 border-l border-slate-100 text-center">
                                        <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest 
                                            @if($o['color'] == 'amber') bg-amber-50 text-amber-600 border border-amber-100 @elseif($o['color'] == 'red') bg-red-50 text-red-600 border border-red-100 @elseif($o['color'] == 'teal') bg-teal-50 text-teal-600 border border-teal-100 @elseif($o['color'] == 'blue') bg-blue-50 text-blue-600 border border-blue-100 @else bg-slate-50 text-slate-500 border border-slate-200 @endif">
                                            {{ $o['status'] }}
                                        </span>
                                    </td>
                                    <td class="p-5 border-l border-slate-100 text-right leading-none">
                                        <span class="text-[12px] font-black text-[#000B44] group-hover:text-[#0077B6] transition-colors">{{ $o['time'] }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                @if(count($recentOrders) == 0)
                                <tr>
                                    <td colspan="5" class="px-10 py-12 text-center text-slate-400 text-sm font-bold">No orders found matching your search.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <button class="w-full mt-8 py-5 bg-slate-50 hover:bg-[#000B44] hover:text-white border border-slate-100 rounded-[1.5rem] text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] transition-all duration-300">View All Orders</button>
                </div>
            </div>
        </div>
    </main>
</div>