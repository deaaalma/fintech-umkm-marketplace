<div>

    {{-- SEO & Layout Title --}}
    <x-slot:title>Dashboard Superadmin 2</x-slot>

    {{-- Header Section --}}
    <x-slot:header>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2 font-figtree">
                    Dashboard UMKM Management
                </h1>
                <p class="text-sm text-[#666666] font-figtree">Monitor dan kelola semua mitra bisnis Anda secara real-time</p>
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="$refresh" class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 text-sm font-medium flex items-center gap-2 font-figtree transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                        <polyline points="23 4 23 10 17 10"></polyline>
                    </svg>
                    Refresh Data
                </button>
                <select class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium font-figtree focus:ring-2 focus:ring-[#0078b7] outline-none">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>
        </div>
    </x-slot>

    {{-- Stats Grid Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
        @foreach($stats as $stat)
            <x-super-admin.stat-card :stat="$stat" />
        @endforeach
    </div>

    {{-- Main Table Section --}}
    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5] mb-12 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-xl font-bold text-[#003d5c] mb-1 font-figtree">Pending UMKM Applications</h2>
                <p class="text-xs text-[#666666]">
                    Total <span class="font-bold text-[#003d5c]">127</span> aplikasi menunggu tinjauan manual
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Cari UMKM..." class="pl-10 pr-4 py-2 border border-[#e5e5e5] rounded-xl text-sm focus:ring-2 focus:ring-[#0078b7] outline-none w-64">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button class="p-2 border border-[#e5e5e5] rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#e5e5e5]">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ID Aplikasi</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Nama Bisnis</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Kategori</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Tanggal Apply</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Kelengkapan</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Prioritas</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingApplications as $app)
                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4">
                            <span class="text-sm font-mono text-[#999999]" style="font-family: 'Geist Mono', monospace;">{{ $app->application_code }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $app->name }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $app->category->name ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $app->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden max-w-[100px]">
                                    <div class="h-full bg-[#0078b7] rounded-full" style="width: {{ $app->completeness ?? 100 }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $app->completeness ?? 100 }}%</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $app->priority === 'TINGGI' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $app->priority === 'NORMAL' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ $app->priority === 'RENDAH' ? 'bg-blue-100 text-blue-700' : '' }}"
                                style="font-family: 'Figtree', sans-serif;">
                                {{ $app->priority ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-2 bg-[#003d5c] text-white rounded-lg text-xs font-semibold hover:bg-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">
                                    {{ $app->status }}
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#666666]">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bottom Grid: Recent Activities & Growth Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- List Onboard Terbaru --}}
        <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] shadow-sm">
            <h3 class="text-sm font-bold text-[#003d5c] mb-6 uppercase tracking-widest font-figtree">UMKM Terbaru Onboard</h3>
            <div class="space-y-4">
                @foreach($recentUMKM as $umkm)
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-[#0078b7] group-hover:bg-[#003d5c] group-hover:text-white transition-colors font-bold text-xs">
                                {{ substr($umkm->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#003d5c]">{{ $umkm->name }}</h4>
                                <p class="text-[10px] text-gray-400">{{ $umkm->category->name }}</p>
                            </div>
                        </div>
                        <span class="text-[9px] text-gray-300 font-medium">{{ $umkm->time }}</span>
                    </div>
                @endforeach
            </div>
            <button class="w-full mt-8 py-3 text-[10px] font-bold text-[#0078b7] border border-[#0078b7]/20 rounded-xl hover:bg-[#0078b7] hover:text-white transition-all uppercase tracking-widest">
                Lihat Semua Database →
            </button>
        </div>

        {{-- Pertumbuhan Chart Placeholder --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-[#e5e5e5] shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-bold text-[#003d5c] uppercase tracking-widest font-figtree">Trend Pertumbuhan UMKM</h3>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-[#0078b7] rounded-full"></span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase">Tahun 2026</span>
                </div>
            </div>
            <div class="flex-1 min-h-[250px] bg-gradient-to-t from-gray-50 to-white rounded-2xl border border-dashed border-gray-200 flex flex-col items-center justify-center relative overflow-hidden">
                {{-- Decorative Chart Lines --}}
                <div class="absolute inset-0 opacity-10 flex items-end justify-around px-8">
                    @for($i=0; $i<12; $i++)
                        <div class="w-4 bg-[#003d5c] rounded-t-sm" style="height: {{ rand(30, 90) }}%"></div>
                    @endfor
                </div>
                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                <p class="text-xs text-gray-400 font-medium">Data visualisasi sedang disiapkan...</p>
            </div>
        </div>
    </div>
</div>