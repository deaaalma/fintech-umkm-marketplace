<x-slot:title>Laporan & Analytics</x-slot>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        @keyframes sparkPulse { 0%,100%{opacity:.5} 50%{opacity:.9} }
        .spark-line { animation: sparkPulse 2.5s ease-in-out infinite; }
        .metric-card { transition: box-shadow 0.2s ease, transform 0.2s ease; }
        .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); transform: translateY(-2px); }
        
        /* Number counter animation support */
        @property --num {
            syntax: "<integer>";
            initial-value: 0;
            inherits: false;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.initReportCharts = (dates, revenues, orders, newPct, retPct) => {
            const chartColors = {
                primary: '#0077B6',
                primaryLight: 'rgba(0, 119, 182, 0.2)',
                dark: '#000B44',
                gray: '#E5E7EB',
                grid: '#F3F4F6'
            };

            // Destroy existing charts to prevent canvas overlap issues during DOM morphs
            ['revenueChart', 'ordersChart', 'demographicsChart'].forEach(id => {
                let existingChart = Chart.getChart(id);
                if (existingChart) existingChart.destroy();
            });

            // 1. Revenue Line Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Revenue (Rp)',
                            data: revenues,
                            borderColor: chartColors.primary,
                            backgroundColor: chartColors.primaryLight,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: chartColors.primary,
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 8, pointHoverBackgroundColor: '#fff', pointHoverBorderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: chartColors.dark,
                                titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                                bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                                padding: 12,
                                cornerRadius: 12, displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: chartColors.grid, drawBorder: false },
                                ticks: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                                    color: '#6B7280',
                                    callback: function(value) {
                                        if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'M';
                                        if (value >= 1000) return 'Rp ' + (value / 1000) + 'K';
                                        return value;
                                    }
                                }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                                    color: '#6B7280',
                                    maxTicksLimit: 7
                                }
                            }
                        }
                    }
                });
            }

            // 2. Orders Bar Chart
            const ordersCtx = document.getElementById('ordersChart');
            if (ordersCtx) {
                new Chart(ordersCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Jumlah Pesanan',
                            data: orders,
                            backgroundColor: chartColors.dark,
                            borderRadius: 4,
                            maxBarThickness: 80
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: chartColors.dark,
                                padding: 12,
                                cornerRadius: 12, displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: chartColors.grid, drawBorder: false },
                                ticks: {
                                    stepSize: 1,
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                                    color: '#6B7280'
                                }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                                    color: '#6B7280',
                                    maxTicksLimit: 7
                                }
                            }
                        }
                    }
                });
            }

            // 3. Customer Donut Chart
            const donutCtx = document.getElementById('demographicsChart');
            if (donutCtx) {
                new Chart(donutCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['New Customers', 'Returning Customers'],
                        datasets: [{
                            data: [newPct, retPct],
                            backgroundColor: [chartColors.dark, chartColors.gray],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        maintainAspectRatio: false,
                        cutout: '75%',
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1000,
                            easing: 'easeOutBounce'
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: chartColors.dark,
                                padding: 12,
                                cornerRadius: 12, displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.parsed + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        };
    </script>
@endpush

<div class="pb-10 transition-all duration-500 ease-in-out" wire:loading.class="opacity-40 scale-[0.98] blur-[2px]">
    
    {{-- Dynamic Wrapper to re-trigger Alpine and CSS animations on data change --}}
    <div wire:key="report-{{ md5(json_encode($chartDates) . $totalOrders) }}" 
         class="space-y-6"
         x-data="{
             init() {
                 // Trigger charts render
                 setTimeout(() => {
                     if(typeof window.initReportCharts === 'function') {
                         window.initReportCharts(@js($chartDates), @js($chartRevenues), @js($chartOrders), @js($newPercentage), @js($returningPercentage));
                     }
                 }, 50);
             }
         }">

        {{-- Header & Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-50">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 font-plus">Laporan & Analytics</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Ringkasan performa bisnis berdasarkan periode</p>
            </div>
            
            <div class="relative" x-data="{ filterOpen: false }">
                <button @click="filterOpen = !filterOpen" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter Data
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{'rotate-180': filterOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                {{-- Popover --}}
                <div x-cloak x-show="filterOpen" 
                     @click.outside="filterOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 p-4 flex flex-col gap-4">
                     
                     <div class="space-y-3">
                         <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pilih Rentang Waktu</p>
                         <div class="flex items-center gap-2">
                            <div class="relative w-full" x-data="{ init() { if (typeof flatpickr !== 'undefined') flatpickr($refs.dateStart, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'j M Y', onChange: (d, str) => { @this.set('startDate', str) } }) } }">
                                <input type="text" x-ref="dateStart" wire:model="startDate" placeholder="Mulai" readonly class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#0077B6]/20 transition-all cursor-pointer">
                            </div>
                            <span class="text-gray-400 font-bold">-</span>
                            <div class="relative w-full" x-data="{ init() { if (typeof flatpickr !== 'undefined') flatpickr($refs.dateEnd, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'j M Y', onChange: (d, str) => { @this.set('endDate', str) } }) } }">
                                <input type="text" x-ref="dateEnd" wire:model="endDate" placeholder="Akhir" readonly class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#0077B6]/20 transition-all cursor-pointer">
                            </div>
                        </div>
                     </div>

                     <div class="border-t border-gray-100 pt-3">
                         <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Cepat</p>
                         <div class="grid grid-cols-2 gap-2">
                            <button wire:click="setDateRange('today')" @click="filterOpen = false" class="px-3 py-2 rounded-lg text-xs font-bold transition-all {{ $dateRange === 'today' ? 'bg-[#0077B6] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">Hari Ini</button>
                            <button wire:click="setDateRange('last_7_days')" @click="filterOpen = false" class="px-3 py-2 rounded-lg text-xs font-bold transition-all {{ $dateRange === 'last_7_days' ? 'bg-[#0077B6] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">7 Hari Terakhir</button>
                            <button wire:click="setDateRange('this_month')" @click="filterOpen = false" class="px-3 py-2 rounded-lg text-xs font-bold transition-all {{ $dateRange === 'this_month' ? 'bg-[#0077B6] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">Bulan Ini</button>
                            <button wire:click="setDateRange('last_month')" @click="filterOpen = false" class="px-3 py-2 rounded-lg text-xs font-bold transition-all {{ $dateRange === 'last_month' ? 'bg-[#0077B6] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">Bulan Lalu</button>
                         </div>
                     </div>
                     
                     <div class="pt-2">
                         <button @click="filterOpen = false" wire:click="$refresh" class="w-full py-2 bg-[#000B44] hover:bg-blue-900 text-white rounded-lg text-sm font-bold transition-all shadow-sm">Terapkan Filter</button>
                     </div>
                </div>
            </div>
        </div>

        {{-- Info Alert --}}
        <div class="bg-blue-50/50 border border-blue-100 p-3 rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-[11px] text-blue-800 font-medium">Analitik ini diperbarui secara real-time berdasarkan aktivitas pemesanan di aplikasi UMKM Anda.</p>
        </div>

        {{-- Top Metrics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Total Pesanan --}}
            <div class="metric-card bg-white p-6 rounded-2xl border border-gray-200 group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-20 h-20 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <h3 class="text-[11px] font-black text-gray-500 uppercase tracking-widest group-hover:text-[#0077B6] transition-colors">Total Pesanan</h3>
                </div>
                <div class="text-4xl font-black text-gray-900 mb-2 font-plus tracking-tighter"
                     x-data="{ count: 0, target: {{ $totalOrders }} }" 
                     x-init="let interval = setInterval(() => { if(count < target) { count += Math.max(1, Math.ceil(target/15)); if(count > target) count = target; } else clearInterval(interval); }, 30)" 
                     x-text="count">
                    0
                </div>
            </div>

            {{-- Total Revenue (Dark Card) --}}
            <div class="metric-card bg-[#000B44] p-6 rounded-2xl border border-[#1a3a7a] flex flex-col group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-[#0077B6]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center gap-2 mb-4 relative z-10">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                    <h3 class="text-[11px] font-black text-white/70 uppercase tracking-widest group-hover:text-white transition-colors">Total Pendapatan</h3>
                </div>
                <div class="text-3xl font-black text-white mb-4 font-plus tracking-tighter relative z-10 flex items-center gap-1">
                    <span>Rp</span>
                    <span x-data="{ count: 0, target: {{ $totalRevenue }} }" 
                          x-init="let interval = setInterval(() => { if(count < target) { count += Math.max(1000, Math.ceil(target/15)); if(count > target) count = target; } else clearInterval(interval); }, 30)" 
                          x-text="new Intl.NumberFormat('id-ID').format(Math.round(count))">0</span>
                </div>
                
                {{-- Sparkline --}}
                <div class="flex items-end gap-1 h-10 mt-auto relative z-10">
                    @foreach(array_slice($chartRevenues, -10) as $index => $h)
                        @php $height = $h > 0 ? min(100, max(20, ($h / max($chartRevenues)) * 100)) : 15; @endphp
                        <div class="flex-1 rounded-t bg-white/20 group-hover:bg-white/40 transition-colors spark-line" style="height:{{ $height }}%; animation-delay: {{ $index * 0.07 }}s"></div>
                    @endforeach
                </div>
            </div>

            {{-- Status Pesanan (Progress Bars) --}}
            <div class="metric-card bg-white p-6 rounded-2xl border border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[11px] font-black text-gray-500 uppercase tracking-widest">Status Pesanan</h3>
                </div>
                
                <div class="space-y-4">
                    {{-- Completed --}}
                    <div>
                        <div class="flex justify-between mb-1.5">
                            <span class="text-xs font-semibold text-gray-600 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-teal-500 inline-block"></span> Selesai
                            </span>
                            <span class="text-xs font-bold text-gray-700">{{ $completedCount }} · {{ $totalOrders > 0 ? round(($completedCount/$totalOrders)*100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-teal-500 rounded-full transition-all duration-1000 ease-out" style="width: {{ $totalOrders > 0 ? ($completedCount/$totalOrders)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    {{-- Active --}}
                    <div>
                        <div class="flex justify-between mb-1.5">
                            <span class="text-xs font-semibold text-gray-600 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#0077B6] inline-block"></span> Aktif
                            </span>
                            <span class="text-xs font-bold text-gray-700">{{ $activeCount }} · {{ $totalOrders > 0 ? round(($activeCount/$totalOrders)*100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#0077B6] rounded-full transition-all duration-1000 ease-out" style="width: {{ $totalOrders > 0 ? ($activeCount/$totalOrders)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Avg Order Value --}}
            <div class="metric-card bg-white p-6 rounded-2xl border border-gray-200 group relative overflow-hidden">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <h3 class="text-[11px] font-black text-gray-500 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Avg Order Value</h3>
                </div>
                <div class="text-3xl font-black text-gray-900 mb-2 font-plus tracking-tighter flex items-center gap-1">
                    <span>Rp</span>
                    <span x-data="{ count: 0, target: {{ $aov }} }" 
                          x-init="let interval = setInterval(() => { if(count < target) { count += Math.max(100, Math.ceil(target/15)); if(count > target) count = target; } else clearInterval(interval); }, 30)" 
                          x-text="new Intl.NumberFormat('id-ID').format(Math.round(count))">0</span>
                </div>
                <div class="flex items-center gap-1.5 text-gray-500 mt-auto">
                    <span class="text-[10px] font-bold">Rata-rata per transaksi selesai</span>
                </div>
            </div>
        </div>

        {{-- Main Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" wire:ignore>
            {{-- Revenue Trend --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Trend Pendapatan</h3>
                        <p class="text-[11px] text-gray-500 font-medium">Berdasarkan pesanan yang telah dibayar/selesai</p>
                    </div>
                    <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                
                <div class="relative h-64 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Pesanan per Hari --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Volume Pesanan</h3>
                        <p class="text-[11px] text-gray-500 font-medium">Jumlah pesanan masuk per hari</p>
                    </div>
                    <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                
                <div class="relative h-64 w-full">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Secondary Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" wire:ignore>
            {{-- Top Selling Services --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Layanan Terlaris</h3>
                        <p class="text-[11px] text-gray-500 font-medium">Berdasarkan total pesanan</p>
                    </div>
                </div>
                
                <div class="space-y-5">
                    @forelse($topServices as $index => $ts)
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-gray-700">{{ $ts->product->name ?? 'Layanan Terhapus' }}</span>
                            <span class="text-gray-900">{{ $ts->count }} Pesanan</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            @php 
                                $maxCount = $topServices->max('count');
                                $width = $maxCount > 0 ? ($ts->count / $maxCount) * 100 : 0;
                                $colorClass = $index === 0 ? 'bg-[#000B44]' : ($index === 1 ? 'bg-[#0077B6]' : 'bg-gray-400');
                            @endphp
                            <div class="{{ $colorClass }} h-full rounded-full transition-all duration-1000 ease-out" style="width: 0%" x-data x-init="setTimeout(() => { $el.style.width = '{{ $width }}%' }, {{ 300 + ($index * 100) }})"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-gray-400 py-10">Belum ada data layanan terjual di periode ini.</div>
                    @endforelse
                </div>
            </div>

            {{-- Customer Demographics --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Demografi Pelanggan</h3>
                        <p class="text-[11px] text-gray-500 font-medium">Pelanggan Baru vs Pelanggan Lama</p>
                    </div>
                </div>
                
                <div class="flex-1 flex items-center justify-center relative">
                    <div class="relative w-48 h-48">
                        <canvas id="demographicsChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col pointer-events-none">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total</span>
                            <span class="text-2xl font-black text-gray-900 leading-none"
                                  x-data="{ count: 0, target: {{ $totalCustomers }} }" 
                                  x-init="let interval = setInterval(() => { if(count < target) { count += Math.max(1, Math.ceil(target/15)); if(count > target) count = target; } else clearInterval(interval); }, 30)" 
                                  x-text="count">0</span>
                        </div>
                    </div>
                    
                    {{-- Labels --}}
                    <div class="absolute top-0 right-0 text-right">
                        <div class="flex items-center justify-end gap-2 mb-2">
                            <span class="text-[11px] font-bold text-gray-700">Baru ({{ $newPercentage }}%)</span>
                            <div class="w-3 h-3 bg-[#000B44] rounded-sm"></div>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <span class="text-[11px] font-bold text-gray-700">Lama ({{ $returningPercentage }}%)</span>
                            <div class="w-3 h-3 bg-[#E5E7EB] rounded-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Data Pesanan Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Detail Data Pesanan</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative w-full md:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau invoice..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#0077B6] focus:bg-white transition-all placeholder:text-gray-400">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-8 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-8 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-8 py-4 text-xs text-gray-500 font-mono">{{ $order->invoice_number ?? ('#ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600 font-medium">{{ $order->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">{{ $order->customer->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">{{ $order->product->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($order->status === 'completed' || $order->status === 'paid')
                                        <span class="inline-block px-3 py-1 bg-teal-50 text-teal-600 text-xs font-bold rounded-lg">{{ ucfirst($order->status) }}</span>
                                    @elseif(in_array($order->status, ['cancelled', 'rejected']))
                                        <span class="inline-block px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg">{{ ucfirst($order->status) }}</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-[#0077B6]/10 text-[#0077B6] text-xs font-bold rounded-lg">{{ str_replace('_', ' ', ucfirst($order->status)) }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($order->agreed_price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-sm">
                                    Tidak ada data pesanan untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-4 border-t border-gray-100 flex items-center justify-between">
                <div class="w-full">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
