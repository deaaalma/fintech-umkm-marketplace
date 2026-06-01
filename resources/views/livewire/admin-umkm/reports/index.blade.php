<x-slot:title>Laporan & Analytics</x-slot>

<div class="space-y-6 pb-10 animate-fade-in-up">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan & Analytics</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">Ringkasan performa bisnis berdasarkan periode</p>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <input type="date" wire:model="startDate" class="pl-10 pr-4 py-2 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-black/5 transition-all w-40">
            </div>
            <span class="text-gray-400 font-bold">-</span>
            <div class="relative">
                <input type="date" wire:model="endDate" class="px-4 py-2 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-black/5 transition-all w-40">
            </div>
        </div>
        
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
            <button wire:click="setDateRange('today')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $dateRange === 'today' ? 'bg-[#2D2D2D] text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Today</button>
            <button wire:click="setDateRange('last_7_days')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $dateRange === 'last_7_days' ? 'bg-[#2D2D2D] text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Last 7 Days</button>
            <button wire:click="setDateRange('this_month')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $dateRange === 'this_month' ? 'bg-[#2D2D2D] text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">This Month</button>
            <button wire:click="setDateRange('last_month')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $dateRange === 'last_month' ? 'bg-[#2D2D2D] text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">Last Month</button>
            <button wire:click="applyFilter" class="px-6 py-2 bg-[#2D2D2D] hover:bg-black text-white rounded-xl text-xs font-bold transition-all shadow-sm ml-2">Apply</button>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div class="bg-[#F8FAFC] border border-gray-100 p-3 rounded-xl flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-[11px] text-gray-500 font-medium">Analitik ini diperbarui secara real-time berdasarkan aktivitas pemesanan di aplikasi UMKM Anda.</p>
    </div>

    {{-- Top Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Total Pesanan --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pesanan</h3>
            </div>
            <div class="text-3xl font-black text-gray-900 mb-1 font-plus">{{ number_format($totalOrders) }}</div>
            <div class="flex items-center gap-1.5 text-green-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span class="text-[10px] font-bold">+12% dari periode sebelumnya</span>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Revenue</h3>
            </div>
            <div class="text-2xl xl:text-3xl font-black text-gray-900 mb-1 font-plus">Rp {{ number_format($totalRevenue / 1000000, 1) }}M</div>
            <div class="flex items-center gap-1.5 text-green-500">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span class="text-[10px] font-bold">+8% dari periode sebelumnya</span>
            </div>
        </div>

        {{-- Conversion Rate --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Conversion Rate</h3>
            </div>
            <div class="text-3xl font-black text-gray-900 mb-1 font-plus">32%</div>
            <div class="flex items-center gap-1.5 text-gray-500">
                <span class="text-[10px] font-bold">Inquiry &rarr; Order</span>
            </div>
        </div>

        {{-- Avg Order Value --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Avg Order Value</h3>
            </div>
            <div class="text-2xl xl:text-3xl font-black text-gray-900 mb-1 font-plus">Rp {{ number_format($aov / 1000, 0) }}K</div>
            <div class="flex items-center gap-1.5 text-gray-500">
                <span class="text-[10px] font-bold">Per Transaksi</span>
            </div>
        </div>

        {{-- Retention Rate --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Retention Rate</h3>
            </div>
            <div class="text-3xl font-black text-gray-900 mb-1 font-plus">41%</div>
            <div class="flex items-center gap-1.5 text-gray-500">
                <span class="text-[10px] font-bold">Repeat customers</span>
            </div>
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="bg-[#F8FAFC] border border-gray-100 p-3 rounded-xl flex items-center gap-2">
        <p class="text-[11px] text-gray-500 font-medium">Data di atas merefleksikan performa dari aktivitas di aplikasi Anda. Fitur analitik lebih mendalam sedang dalam pengembangan.</p>
    </div>

    {{-- Main Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Revenue Trend --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Revenue Trend</h3>
                    <p class="text-[10px] text-gray-500 font-medium">Daily revenue overview</p>
                </div>
                <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>
            </div>
            
            {{-- Mock Line Chart (CSS representation) --}}
            <div class="relative h-48 w-full mt-4 flex items-end">
                {{-- Y-Axis Labels --}}
                <div class="absolute left-0 top-0 bottom-6 flex flex-col justify-between text-[9px] text-gray-400 font-bold">
                    <span>6M</span>
                    <span>4M</span>
                    <span>2M</span>
                    <span>0M</span>
                </div>
                
                {{-- Grid Lines --}}
                <div class="absolute left-6 right-0 top-2 bottom-6 flex flex-col justify-between">
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                </div>
                
                {{-- Mock SVG Line Chart --}}
                <div class="absolute left-6 right-0 top-2 bottom-6">
                    <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                        {{-- Previous period (dashed) --}}
                        <path d="M0,60 L20,58 L40,65 L60,55 L80,50 L100,45" fill="none" stroke="#93C5FD" stroke-width="1.5" stroke-dasharray="4,4" />
                        {{-- Current period (solid black) --}}
                        <path d="M0,45 L20,40 L40,35 L60,30 L80,25 L100,20" fill="none" stroke="#111827" stroke-width="2" />
                        
                        {{-- Data points (current) --}}
                        <circle cx="0" cy="45" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                        <circle cx="20" cy="40" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                        <circle cx="40" cy="35" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                        <circle cx="60" cy="30" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                        <circle cx="80" cy="25" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                        <circle cx="100" cy="20" r="2" fill="white" stroke="#111827" stroke-width="1.5" />
                    </svg>
                </div>
                
                {{-- X-Axis Labels --}}
                <div class="absolute left-6 right-0 bottom-0 flex justify-between text-[9px] text-gray-400 font-bold px-1">
                    <span>5</span>
                    <span>10</span>
                    <span>15</span>
                    <span>20</span>
                    <span>25</span>
                    <span>30</span>
                </div>
            </div>
            
            {{-- Legend --}}
            <div class="flex justify-center gap-6 mt-6 pt-4 border-t border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-0.5 bg-black"></div>
                    <span class="text-[10px] font-bold text-gray-700">Current period</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-0.5 border-t border-dashed border-blue-300"></div>
                    <span class="text-[10px] font-bold text-gray-400">Previous period</span>
                </div>
            </div>
        </div>

        {{-- Pesanan per Hari --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Pesanan per Hari</h3>
                    <p class="text-[10px] text-gray-500 font-medium">Daily order volume</p>
                </div>
                <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>
            </div>
            
            {{-- Mock Bar Chart --}}
            <div class="relative h-48 w-full mt-4 flex items-end">
                {{-- Y-Axis Labels --}}
                <div class="absolute left-0 top-0 bottom-6 flex flex-col justify-between text-[9px] text-gray-400 font-bold">
                    <span>12</span>
                    <span>9</span>
                    <span>6</span>
                    <span>0</span>
                </div>
                
                {{-- Grid Lines --}}
                <div class="absolute left-6 right-0 top-2 bottom-6 flex flex-col justify-between">
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                    <div class="w-full border-t border-dashed border-gray-200"></div>
                </div>
                
                {{-- Bars --}}
                <div class="absolute left-6 right-0 top-2 bottom-6 flex items-end justify-between px-2">
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 40%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 65%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 50%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 85%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 100%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 75%"></div>
                    <div class="w-10 bg-[#2D2D2D] rounded-t-sm hover:opacity-80 transition-opacity" style="height: 90%"></div>
                </div>
                
                {{-- X-Axis Labels --}}
                <div class="absolute left-6 right-0 bottom-0 flex justify-between text-[9px] text-gray-400 font-bold px-5">
                    <span>1</span>
                    <span>5</span>
                    <span>10</span>
                    <span>15</span>
                    <span>20</span>
                    <span>25</span>
                    <span>30</span>
                </div>
            </div>
            
            {{-- Legend --}}
            <div class="flex justify-center gap-6 mt-6 pt-4 border-t border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 bg-[#2D2D2D] rounded-sm"></div>
                    <span class="text-[10px] font-bold text-gray-700">Jumlah Pesanan</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Secondary Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Selling Services --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Top Selling Services</h3>
                    <p class="text-[10px] text-gray-500 font-medium">By total orders</p>
                </div>
                <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>
            </div>
            
            <div class="space-y-5">
                {{-- Service 1 --}}
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Deep Cleaning</span>
                        <span class="text-gray-900">89</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-[#2D2D2D] h-2 rounded-full" style="width: 89%"></div>
                    </div>
                </div>
                {{-- Service 2 --}}
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Office Cleaning</span>
                        <span class="text-gray-900">62</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: 62%"></div>
                    </div>
                </div>
                {{-- Service 3 --}}
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Sofa Cleaning</span>
                        <span class="text-gray-900">45</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
                {{-- Service 4 --}}
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Carpet Cleaning</span>
                        <span class="text-gray-900">24</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gray-300 h-2 rounded-full" style="width: 24%"></div>
                    </div>
                </div>
                {{-- Service 5 --}}
                <div>
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span class="text-gray-700">Window Cleaning</span>
                        <span class="text-gray-900">18</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gray-300 h-2 rounded-full" style="width: 18%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-50">
                <p class="text-[10px] text-gray-400 font-medium italic">Menampilkan layanan yang paling laku dipesan.</p>
            </div>
        </div>

        {{-- Customer Demographics --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Customer Demographics</h3>
                    <p class="text-[10px] text-gray-500 font-medium">New vs Returning</p>
                </div>
                <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
            </div>
            
            <div class="flex-1 flex items-center justify-center relative">
                {{-- Mock Donut Chart --}}
                <div class="relative w-40 h-40">
                    <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                        {{-- Background/Returning (41%) --}}
                        <circle cx="50" cy="50" r="35" fill="none" stroke="#E5E7EB" stroke-width="20" />
                        {{-- New (59%) --}}
                        <circle cx="50" cy="50" r="35" fill="none" stroke="#2D2D2D" stroke-width="20" stroke-dasharray="129.7" stroke-dashoffset="0" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center flex-col bg-white rounded-full m-8">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total</span>
                        <span class="text-xl font-black text-gray-900 leading-none">324</span>
                    </div>
                </div>
                
                {{-- Labels --}}
                <div class="absolute top-4 left-4">
                    <div class="flex items-center gap-1.5 mb-1">
                        <div class="w-2.5 h-2.5 bg-[#2D2D2D] rounded-full"></div>
                        <span class="text-[10px] font-bold text-gray-700">New 59%</span>
                    </div>
                </div>
                <div class="absolute bottom-4 right-4">
                    <div class="flex items-center gap-1.5 mb-1">
                        <div class="w-2.5 h-2.5 bg-gray-200 rounded-full"></div>
                        <span class="text-[10px] font-bold text-gray-700">Returning 41%</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-50">
                <p class="text-[10px] text-gray-400 font-medium italic">Data pelanggan yang melakukan pesanan di periode ini.</p>
            </div>
        </div>
    </div>

    {{-- Detail Data Pesanan Table --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Detail Data Pesanan</h2>
                <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest mt-1">Comprehensive order details</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search orders..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-black/5 transition-all">
                </div>
                <button class="p-2 border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Order ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Customer</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Layanan</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Total (Rp)</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Payment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-gray-900">{{ $order->invoice_number ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-500 font-medium">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-gray-700">{{ $order->customer->name ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-600 font-medium">{{ $order->product->name ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status === 'completed')
                                    <span class="px-2 py-1 bg-[#2D2D2D] text-white text-[9px] font-black rounded uppercase tracking-wider">Completed</span>
                                @elseif($order->status === 'processing')
                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 text-[9px] font-black rounded uppercase tracking-wider">Processing</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[9px] font-black rounded uppercase tracking-wider">{{ str_replace('_', ' ', $order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-gray-900">{{ number_format($order->agreed_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(in_array($order->status, ['paid', 'processing', 'completed']))
                                    <span class="px-2 py-1 bg-[#2D2D2D] text-white text-[9px] font-black rounded uppercase tracking-wider">Paid</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[9px] font-black rounded uppercase tracking-wider">{{ str_replace('_', ' ', $order->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-sm font-medium">
                                Tidak ada data pesanan untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between text-xs text-gray-400 font-medium">
                <span>Showing {{ $orders->count() }} of {{ $orders->total() }} orders</span>
                <div class="flex gap-1">
                    <span class="px-2 py-1 border border-gray-200 rounded text-gray-300">Previous</span>
                    <span class="px-2.5 py-1 bg-black text-white rounded font-bold">1</span>
                    <span class="px-2 py-1 border border-gray-200 rounded text-gray-300">Next</span>
                </div>
            </div>
        @endif
    </div>

</div>
