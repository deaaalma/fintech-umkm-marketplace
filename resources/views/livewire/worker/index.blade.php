<div>

    {{-- SEO & Layout Title --}}
    <x-slot:title>Dashboard Worker</x-slot>

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
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-[#999999] border-b border-gray-100">
                        <th class="pb-4 font-bold">ID Aplikasi</th>
                        <th class="pb-4 font-bold">Nama Bisnis</th>
                        <th class="pb-4 font-bold">Kategori</th>
                        <th class="pb-4 font-bold">Tanggal</th>
                        <th class="pb-4 font-bold">Kelengkapan</th>
                        <th class="pb-4 font-bold">Prioritas</th>
                        <th class="pb-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($pendingApplications as $app)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 text-xs font-mono text-gray-400">{{ $app['id'] }}</td>
                            <td class="py-5">
                                <span class="text-sm font-bold text-[#003d5c]">{{ $app['name'] }}</span>
                            </td>
                            <td class="py-5 text-xs text-gray-600">{{ $app['category'] }}</td>
                            <td class="py-5 text-xs text-gray-500">{{ $app['date'] }}</td>
                            <td class="py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#0078b7]" style="width: {{ $app['completeness'] }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold">{{ $app['completeness'] }}%</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <span @class([
                                    'px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider',
                                    'bg-red-50 text-red-600' => $app['priority'] === 'TINGGI',
                                    'bg-blue-50 text-blue-600' => $app['priority'] === 'NORMAL',
                                    'bg-gray-100 text-gray-600' => $app['priority'] === 'RENDAH',
                                ])>
                                    {{ $app['priority'] }}
                                </span>
                            </td>
                            <td class="py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="bg-[#003d5c] text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-[#0078b7] transition-colors">REVIEW</button>
                                    <button class="p-1.5 text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
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
                                {{ substr($umkm['name'], 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#003d5c]">{{ $umkm['name'] }}</h4>
                                <p class="text-[10px] text-gray-400">{{ $umkm['category'] }}</p>
                            </div>
                        </div>
                        <span class="text-[9px] text-gray-300 font-medium">{{ $umkm['time'] }}</span>
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