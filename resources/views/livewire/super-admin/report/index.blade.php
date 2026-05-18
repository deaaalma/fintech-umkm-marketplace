<div class="min-h-screen">
    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-6">
            <div class="flex items-center gap-2 text-sm mb-4">
                <a href="{{ route('superadmin.dashboard.preview') }}" class="text-[#666666] hover:text-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]"><polyline points="9 18 15 12 9 6"></polyline></svg>
                <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Laporan & Analytics</span>
            </div>
            <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-family: 'Figtree', sans-serif;">Laporan & Analytics</h1>
            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Analisis performa platform dan generate laporan</p>
        </div>
    </div>

    <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Analytics Overview</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    @foreach(['Revenue Trend (Last 30 Days)' => 'Line chart showing revenue trend', 'Order Volume (Last 30 Days)' => 'Bar chart showing order volume'] as $title => $desc)
                    <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                        <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">{{ $title }}</h3>
                        <div class="h-64 bg-gradient-to-br from-[#0078b7]/5 to-[#003d5c]/5 rounded-xl flex items-center justify-center">
                            <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Chart: {{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                        <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Top 10 UMKMs by Revenue</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#e5e5e5]">
                                        <th class="text-left py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">Rank</th>
                                        <th class="text-left py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">UMKM Name</th>
                                        <th class="text-right py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">Revenue</th>
                                        <th class="text-right py-3 px-2 text-xs font-semibold text-[#999999] uppercase" style="font-family: 'Figtree', sans-serif;">Orders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topUMKMs ?? [] as $umkm)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2 text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">#{{ $umkm['rank'] }}</td>
                                        <td class="py-3 px-2 text-sm text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['name'] }}</td>
                                        <td class="py-3 px-2 text-right text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['revenue'] }}</td>
                                        <td class="py-3 px-2 text-right text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $umkm['orders'] }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="py-4 text-center text-sm text-[#999999]">Data tidak tersedia</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5]">
                        <h3 class="text-base font-semibold text-[#003d5c] mb-4" style="font-family: 'Figtree', sans-serif;">Top Service Categories</h3>
                        <div class="h-80 flex items-center justify-center">
                            <div class="text-center w-full">
                                <div class="w-48 h-48 mx-auto bg-gradient-to-br from-[#0078b7]/10 to-[#003d5c]/10 rounded-full flex items-center justify-center mb-6">
                                    <p class="text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">Pie Chart Area</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3 text-xs justify-items-center">
                                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-[#003d5c] rounded-sm"></div><span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Cleaning (28%)</span></div>
                                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-[#0078b7] rounded-sm"></div><span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Laundry (23%)</span></div>
                                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-gray-400 rounded-sm"></div><span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Catering (18%)</span></div>
                                    <div class="flex items-center gap-2"><div class="w-3 h-3 bg-gray-300 rounded-sm"></div><span class="text-[#666666]" style="font-family: 'Figtree', sans-serif;">Repair (15%)</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] mb-8">
                <h2 class="text-xl font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Report Generator</h2>
                
                @php 
                    $labelClass = "block text-xs font-semibold text-[#999999] uppercase mb-2";
                    $inputClass = "w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm";
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-6">
                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Report Type</label>
                            <select wire:model="reportType" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                <option value="revenue">Revenue Report</option>
                                <option value="transaction">Transaction Report</option>
                                <option value="umkm">UMKM Performance</option>
                            </select>
                        </div>

                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Custom Date From</label>
                            <input type="date" wire:model="dateFrom" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                        </div>

                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Filter By UMKM</label>
                            <select wire:model="filterUmkm" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                <option value="">All UMKMs</option>
                                @foreach($availableUmkms ?? [] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Date Range Preset</label>
                            <select wire:model.live="datePreset" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                <option value="7days">Last 7 Days</option>
                                <option value="30days">Last 30 Days</option>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="this_year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>

                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Custom Date To</label>
                            <input type="date" wire:model="dateTo" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                        </div>

                        <div>
                            <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Output Format</label>
                            <div class="flex gap-6 mt-3">
                                @foreach(['pdf' => 'PDF', 'excel' => 'Excel', 'csv' => 'CSV'] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="format" value="{{ $val }}" class="w-4 h-4 text-[#0078b7] focus:ring-[#0078b7]">
                                    <span class="text-sm text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button wire:click="generateReport" class="px-8 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <span wire:loading.remove wire:target="generateReport">Generate Report</span>
                        <span wire:loading wire:target="generateReport">Generating...</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">Scheduled Reports</h2>
                    <button wire:click="addSchedule" class="px-4 py-2 bg-[#003d5c] text-white rounded-lg hover:bg-[#0078b7] transition-colors font-semibold text-sm flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add Schedule
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-[#e5e5e5] text-xs font-semibold text-[#999999] uppercase">
                                <th class="py-4 px-4" style="font-family: 'Figtree', sans-serif;">Report Name</th>
                                <th class="py-4 px-4" style="font-family: 'Figtree', sans-serif;">Frequency</th>
                                <th class="py-4 px-4" style="font-family: 'Figtree', sans-serif;">Next Run</th>
                                <th class="py-4 px-4" style="font-family: 'Figtree', sans-serif;">Format</th>
                                <th class="py-4 px-4" style="font-family: 'Figtree', sans-serif;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scheduledReports ?? [] as $report)
                            <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $report['name'] }}</td>
                                <td class="py-4 px-4 text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $report['frequency'] }}</td>
                                <td class="py-4 px-4 text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $report['next_run'] }}</td>
                                <td class="py-4 px-4"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700" style="font-family: 'Figtree', sans-serif;">{{ strtoupper($report['format']) }}</span></td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <button wire:click="editSchedule('{{ $report['id'] ?? '' }}')" class="px-3 py-1 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50">Edit</button>
                                        <button wire:click="deleteSchedule('{{ $report['id'] ?? '' }}')" class="px-3 py-1 bg-white border border-red-200 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-8 text-center text-sm text-[#999999]">Belum ada jadwal laporan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>