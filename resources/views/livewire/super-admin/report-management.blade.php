<div class="min-h-screen bg-slate-50 -mx-6 -my-12 px-8 py-12 font-plus animate-fade-in text-slate-900">
    <x-slot name="title">Laporan & Analytics</x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        {{-- ── PAGE HEADER ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black font-plus text-[#000B44] tracking-tight">Laporan & Analytics</h2>
                <p class="text-slate-500 font-medium mt-1">Ringkasan performa finansial dan transaksi platform.</p>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-3 bg-white border border-slate-200 text-[#000B44] rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                    Generate Report PDF
                </button>
            </div>
        </div>

        {{-- ── SIMPLE METRIC CARDS ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm transition-all hover:border-[#000B44]/20">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Pendapatan</p>
                <h3 class="text-3xl font-black text-[#000B44] tracking-tighter">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h3>
                <div class="mt-6 flex items-center gap-3">
                    <span class="text-[10px] font-black text-teal-600 bg-teal-50 px-3 py-1 rounded-full border border-teal-100">+12.5%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Growth vs Last Month</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm transition-all hover:border-[#000B44]/20">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
                <h3 class="text-3xl font-black text-[#000B44] tracking-tighter">{{ number_format($stats['orders']) }} Pesanan</h3>
                <div class="mt-6 flex items-center gap-3">
                    <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">STABLE</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Platform Order Flow</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[32px] border border-slate-200 shadow-sm transition-all hover:border-[#000B44]/20">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">UMKM Aktif</p>
                <h3 class="text-3xl font-black text-[#000B44] tracking-tighter">{{ $stats['umkms'] }} Merchant</h3>
                <div class="mt-6 flex items-center gap-3">
                    <span class="text-[10px] font-black text-purple-600 bg-purple-50 px-3 py-1 rounded-full border border-purple-100">GROWING</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Verified Ecosystem</span>
                </div>
            </div>
        </div>

        {{-- ── ANALYTICS GRID ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Revenue Chart (Bar) --}}
            <div class="p-8 bg-white rounded-[32px] border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-[#000B44] tracking-tight">Tren Pendapatan</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Total agreed price (6 Bulan Terakhir)</p>
                    </div>
                </div>
                <div class="h-64" wire:ignore>
                    <canvas id="revenueBarChart"></canvas>
                </div>
            </div>

            {{-- Transactions Status (Pie/Doughnut) --}}
            <div class="p-8 bg-white rounded-[32px] border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-[#000B44] tracking-tight">Status Pesanan</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Distribusi status transaksi saat ini</p>
                    </div>
                </div>
                <div class="h-64" wire:ignore>
                    <canvas id="statusDonutChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ── LOWER GRID ── --}}
        <div class="flex flex-col gap-8">
            {{-- Top UMKM Performance (Now Full Width) --}}
            <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#000B44] tracking-tight">Top UMKM Performance</h3>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Based on Volume</span>
                </div>
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 uppercase tracking-widest text-[#000B44]">
                                <th class="px-8 py-5 text-sm font-black text-slate-500">UMKM Entitas</th>
                                <th class="px-6 py-5 text-sm font-black text-slate-500 text-center">Volume</th>
                                <th class="px-8 py-5 text-sm font-black text-slate-500 text-right">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($topUmkms as $top)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-8 py-6">
                                    <p class="font-bold text-[#000B44] text-base">{{ $top->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $top->category->name ?? 'UMKM Mitra' }}</p>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100 inline-block min-w-[90px]">
                                        {{ $top->valid_orders_count ?? 0 }} Transaksi
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p class="text-base font-black text-[#000B44]">Rp {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── REPORT GENERATOR ── --}}
            <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm p-8">
                <div class="mb-8 border-b border-slate-100 pb-4">
                    <h3 class="text-2xl font-black text-[#000B44] tracking-tight">Report Generator</h3>
                    <p class="text-sm text-slate-400 font-bold mt-1">Konfigurasi parameter untuk menarik data ke format file pendukung.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Row 1 --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Report Type</label>
                        <select wire:model="reportType" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors">
                            <option value="revenue">Revenue Report</option>
                            <option value="summary">Order Summary</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Date Range Preset</label>
                        <select wire:model.live="datePreset" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors">
                            <option value="30_days">Last 30 Days</option>
                            <option value="this_month">This Month</option>
                            <option value="last_quarter">Last Quarter</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>

                    {{-- Row 2 --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Custom Date From</label>
                        <input wire:model="dateFrom" type="date" class="w-full {{ $datePreset !== 'custom' ? 'bg-slate-200 text-slate-400' : 'bg-slate-50 text-slate-700' }} border border-slate-200 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors" {{ $datePreset !== 'custom' ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Custom Date To</label>
                        <input wire:model="dateTo" type="date" class="w-full {{ $datePreset !== 'custom' ? 'bg-slate-200 text-slate-400' : 'bg-slate-50 text-slate-700' }} border border-slate-200 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors" {{ $datePreset !== 'custom' ? 'disabled' : '' }}>
                    </div>

                    {{-- Row 3 --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Filter by UMKM</label>
                        <select wire:model="filterUmkm" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors">
                            <option value="">All UMKMs</option>
                            @foreach($umkmOptions as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Filter by Category</label>
                        <select wire:model="filterCategory" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors">
                            <option value="">All Categories</option>
                            @foreach($categoryOptions as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Row 4 --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Filter by Status</label>
                        <select wire:model="filterStatus" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold transition-colors">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="processing">Processing</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    {{-- Format Output --}}
                    <div class="flex flex-col justify-end">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 mt-4 md:mt-0">Output Format</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="exportFormat" type="radio" value="pdf" class="w-4 h-4 text-[#000B44] bg-slate-100 border-slate-300 focus:ring-[#000B44]">
                                <span class="text-base font-bold text-slate-600">PDF</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="exportFormat" type="radio" value="csv" class="w-4 h-4 text-green-600 bg-slate-100 border-slate-300 focus:ring-green-500">
                                <span class="text-base font-bold text-slate-600">Excel (CSV)</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Area --}}
                <div class="mt-10 flex justify-end">
                    <button wire:click="generateReport" wire:loading.attr="disabled" class="px-8 py-3.5 bg-slate-700 hover:bg-[#000B44] text-white rounded-xl font-bold text-base transition-all shadow-md flex items-center gap-2 disabled:opacity-50">
                        <svg wire:loading.remove wire:target="generateReport" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <svg wire:loading wire:target="generateReport" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── CHART JS ── --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Chart Colors
            const themeNavy = '#000B44';
            const themeBlue = '#0077B6';
            const themeTeal = '#10b981';
            const themeAmber = '#fbbf24';
            const themeRose = '#f43f5e';
            const themeGray = '#94a3b8';

            // 1. Revenue Bar Chart
            const barCtx = document.getElementById('revenueBarChart').getContext('2d');
            const trendData = @js($chartData['trend']);
            
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: trendData.map(d => d.label),
                    datasets: [{
                        label: 'Pendapatan',
                        data: trendData.map(d => d.total),
                        backgroundColor: themeNavy,
                        borderRadius: 4,
                        barPercentage: 0.75,
                        categoryPercentage: 0.9,
                        hoverBackgroundColor: themeBlue
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuint' // Animasi naik ke atas progresif
                    },
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f1f5f9' }, 
                            ticks: { 
                                font: { weight: 'bold' },
                                stepSize: 20000000,
                                callback: value => 'Rp ' + value.toLocaleString()
                            } 
                        },
                        x: { 
                            grid: { display: false }, 
                            ticks: { font: { weight: 'bold' } } 
                        }
                    }
                }
            });

            // 2. Status Donut Chart
            const donutCtx = document.getElementById('statusDonutChart').getContext('2d');
            const statusData = @js($chartData['status']);
            
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(d => d.status.toUpperCase().replace('_', ' ')),
                    datasets: [{
                        data: statusData.map(d => d.count),
                        backgroundColor: statusData.map(d => {
                            return {
                                'completed': '#000B44',       // Deep Navy
                                'paid': '#023e8a',            // Dark Blue
                                'processing': '#0077B6',      // Brand Blue
                                'waiting_payment': '#00b4d8', // Sky Blue
                                'pending_valuation': '#48cae4',// Light Blue
                                'cancelled': '#cbd5e1'        // Muted Slate for cancelled
                            }[d.status] ?? '#e2e8f0';
                        }),
                        borderWidth: 0,
                        borderRadius: 20, // Rounded caps
                        spacing: 8,       // Distance between slices
                        cutout: '72%'     // Inner hole size
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateRotate: true, // Animasi muter
                        animateScale: true,  // Animasi zoom-in
                        duration: 2000,
                        easing: 'easeOutCirc'
                    },
                    plugins: { 
                        legend: { 
                            position: 'right', 
                            labels: { 
                                usePointStyle: true, 
                                pointStyle: 'circle', 
                                padding: 25,
                                font: { weight: 'bold', size: 11, family: "'Plus Jakarta Sans', sans-serif" } 
                            } 
                        } 
                    }
                }
            });
        });
    </script>
    @endpush
</div>
