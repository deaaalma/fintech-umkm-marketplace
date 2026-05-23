<div>
    <style>
        @keyframes sparkPulse { 0%,100%{opacity:.5} 50%{opacity:.9} }
        .spark-line { animation: sparkPulse 2.5s ease-in-out infinite; }
        .metric-card { transition: box-shadow 0.2s ease; }
        .metric-card:hover { box-shadow: 0 8px 24px -4px rgba(0,11,68,0.10); }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- ── Card 1: Total Pengguna ── --}}
        <a href="{{ route('admin.dashboard.users') }}" wire:navigate class="metric-card group bg-white rounded-2xl border border-slate-300 animate-fade-in-up hover:border-[#0077B6] hover:scale-[1.01] transition-all duration-300 overflow-hidden shadow-sm" style="animation-delay: 0.08s">
            {{-- Top row: label + dots --}}
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200 group-hover:bg-blue-50/50 transition-colors">
                <span class="text-base font-bold text-slate-700 flex-1 group-hover:text-[#0077B6] transition-colors">Total Pengguna</span>
                <div class="text-slate-400 group-hover:text-[#0077B6] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </div>

            {{-- Main number --}}
            <div class="px-6 pt-5 pb-4 group-hover:bg-blue-50/30 transition-colors">
                <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500 origin-left">{{ number_format($stats['user_stats']['total_users'] ?? 0) }}</h3>
            </div>

            {{-- Role breakdown --}}
            <div class="px-6 pb-6 space-y-3 border-t border-slate-200 pt-4 bg-slate-50/30 group-hover:bg-white transition-colors">
                <div class="flex h-2.5 rounded-full overflow-hidden bg-slate-100">
                    <div class="bg-[#0077B6]" style="width:{{ ($stats['user_stats']['total_users'] ?? 0) > 0 ? ($stats['user_stats']['customer']/$stats['user_stats']['total_users'])*100 : 0 }}%"></div>
                    <div class="bg-indigo-400" style="width:{{ ($stats['user_stats']['total_users'] ?? 0) > 0 ? ($stats['user_stats']['admin_umkm']/$stats['user_stats']['total_users'])*100 : 0 }}%"></div>
                    <div class="bg-teal-400" style="width:{{ ($stats['user_stats']['total_users'] ?? 0) > 0 ? ($stats['user_stats']['staff']/$stats['user_stats']['total_users'])*100 : 0 }}%"></div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0077B6] flex-shrink-0"></span>
                            <span class="text-xs text-slate-500 font-semibold">Customer</span>
                        </div>
                        <span class="text-base font-black text-[#000B44] pl-4">{{ number_format($stats['user_stats']['customer'] ?? 0) }}</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-400 flex-shrink-0"></span>
                            <span class="text-xs text-slate-500 font-semibold">Admin</span>
                        </div>
                        <span class="text-base font-black text-[#000B44] pl-4">{{ number_format($stats['user_stats']['admin_umkm'] ?? 0) }}</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-400 flex-shrink-0"></span>
                            <span class="text-xs text-slate-500 font-semibold">Staff</span>
                        </div>
                        <span class="text-base font-black text-[#000B44] pl-4">{{ number_format($stats['user_stats']['staff'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </a>

        {{-- ── Card 2: UMKM Terdaftar ── --}}
        <div class="metric-card bg-white rounded-2xl border border-slate-300 animate-fade-in-up" style="animation-delay: 0.16s">
            {{-- Top row --}}
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-slate-200">
                <span class="text-base font-bold text-slate-700 flex-1">UMKM Terdaftar</span>
                <button class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                </button>
            </div>

        {{-- Main number --}}
        <div class="px-6 pt-5 pb-4">
            <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none">{{ number_format($stats['umkm_stats']['total_umkm'] ?? 0) }}</h3>
        </div>

        {{-- Aktif vs Pending --}}
        <div class="px-6 pb-6 space-y-3 border-t border-slate-200 pt-4">
            <div>
                <div class="flex justify-between mb-1.5">
                    <span class="text-xs font-semibold text-slate-600 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 inline-block"></span> Aktif
                    </span>
                    <span class="text-xs font-bold text-slate-700">{{ $stats['umkm_stats']['active'] }} · {{ ($stats['umkm_stats']['total_umkm'] ?? 0) > 0 ? round(($stats['umkm_stats']['active']/$stats['umkm_stats']['total_umkm'])*100) : 0 }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 rounded-full" style="width:{{ ($stats['umkm_stats']['total_umkm'] ?? 0) > 0 ? ($stats['umkm_stats']['active']/$stats['umkm_stats']['total_umkm'])*100 : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1.5">
                    <span class="text-xs font-semibold text-slate-600 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span> Pending
                    </span>
                    <span class="text-xs font-bold text-slate-700">{{ $stats['umkm_stats']['pending'] }} · {{ ($stats['umkm_stats']['total_umkm'] ?? 0) > 0 ? round(($stats['umkm_stats']['pending']/$stats['umkm_stats']['total_umkm'])*100) : 0 }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-400 rounded-full" style="width:{{ ($stats['umkm_stats']['total_umkm'] ?? 0) > 0 ? ($stats['umkm_stats']['pending']/$stats['umkm_stats']['total_umkm'])*100 : 0 }}%"></div>
                </div>
            </div>
                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <span class="text-xs text-slate-500 font-medium">6 menunggu persetujuan</span>
                    <span class="bg-red-100 text-red-500 text-xs font-semibold px-4 py-1.5 rounded-full">Perlu Review</span>
                </div>
            </div>
        </div>

        {{-- ── Card 3: Total Transaksi ── --}}
        <div class="metric-card bg-[#000B44] rounded-2xl border border-[#1a3a7a] animate-fade-in-up flex flex-col group" style="animation-delay: 0.24s">
            {{-- Top row --}}
            <div class="flex items-center px-6 pt-6 pb-4 border-b border-white/15">
                <span class="text-base font-bold text-white/80 flex-1">Total Transaksi</span>
                <button class="text-white/30 hover:text-white/60 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                </button>
            </div>

            {{-- Main number --}}
            <div class="px-6 pt-5 pb-4">
                <h3 class="text-5xl font-black text-white font-plus tracking-tighter leading-none">312</h3>
            </div>

            {{-- Mini bar sparkline --}}
            <div class="px-6 pb-3 flex items-end gap-1 h-14 flex-1">
                @foreach([35, 52, 41, 68, 50, 78, 62, 85, 71, 100] as $h)
                <div class="flex-1 rounded-t bg-white/20 group-hover:bg-white/35 transition-colors spark-line" style="height:{{ $h }}%; animation-delay: {{ $loop->index * 0.07 }}s"></div>
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6 pt-3 border-t border-white/15 flex items-center justify-between">
                <span class="text-white/60 text-xs font-medium">Rata-rata harian</span>
                <span class="text-white text-xs font-bold">~10 transaksi/hari</span>
            </div>
        </div>
    </div>

    <!-- Pending UMKM Applications Table -->
    <div class="mt-8 bg-white rounded-2xl border border-slate-300 overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">
        {{-- Header --}}
        <div class="px-8 py-5 flex items-center justify-between border-b border-slate-200">
            <div class="flex items-center gap-3">
                <h3 class="text-base font-bold text-slate-800">Pending UMKM Applications</h3>
                <span class="bg-slate-800 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">{{ count($pendingApplications) }}</span>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau kategori..." class="pl-9 pr-4 py-2 text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-xl w-60 focus:outline-none focus:border-[#0077B6] focus:bg-white transition-all placeholder:text-slate-400">
                </div>
                {{-- Filter --}}
                <button class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:border-slate-300 hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID Aplikasi</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Bisnis</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Apply</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelengkapan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingApplications as $app)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-4 text-xs text-slate-400 font-mono">{{ $app->application_code ?? 'APP-'.rand(1000, 9999) }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-800">{{ $app->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 text-xs font-medium rounded-lg">{{ $app->category->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $app->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-slate-700 rounded-full" style="width: {{ $app->completeness ?? 100 }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-600">{{ $app->completeness ?? 100 }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-block px-3 py-1 text-xs font-bold rounded-lg',
                                'bg-slate-800 text-white'     => ($app->priority ?? 'NORMAL') === 'TINGGI',
                                'bg-slate-200 text-slate-600' => ($app->priority ?? 'NORMAL') === 'NORMAL',
                                'bg-slate-100 text-slate-400' => ($app->priority ?? 'NORMAL') === 'RENDAH',
                            ])>{{ $app->priority ?? 'NORMAL' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="openReview({{ $app->id }})" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition-colors">Review</button>
                                <button wire:click="approveUmkm({{ $app->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button wire:click="rejectUmkm({{ $app->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:text-slate-600 hover:border-slate-300 hover:bg-slate-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500 text-sm">Tidak ada aplikasi UMKM yang menunggu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-8 py-4 border-t border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-700">{{ count($pendingApplications) }}</span> data
            </div>
        </div>
    </div>

    {{-- Review Modal --}}
    @if($showReviewModal && $selectedUmkmLoad)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-6 lg:p-12 overflow-y-auto overflow-x-hidden">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('showReviewModal', false)"></div>

        <div class="relative w-full max-w-4xl bg-white rounded-[32px] shadow-2xl overflow-hidden animate-fade-in-up">
            {{-- Header --}}
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black font-plus text-[#000B44]">Review Application</h2>
                    <p class="text-slate-500 text-sm mt-1">Sila periksa kelengkapan data UMKM sebelum menyetujui.</p>
                </div>
                <button wire:click="$set('showReviewModal', false)" class="w-12 h-12 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-10 max-h-[60vh] overflow-y-auto no-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- Left Col: Basic Info --}}
                    <div class="space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Bisnis</h4>
                            <div class="space-y-4">
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-xs text-slate-400 font-bold mb-1">Nama UMKM</p>
                                    <p class="text-base font-bold text-slate-800">{{ $selectedUmkmLoad->name }}</p>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-xs text-slate-400 font-bold mb-1">Kategori</p>
                                    <p class="text-base font-bold text-slate-800">{{ $selectedUmkmLoad->category->name ?? '-' }}</p>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-xs text-slate-400 font-bold mb-1">Alamat Lengkap</p>
                                    <p class="text-sm font-medium text-slate-600 leading-relaxed">{{ $selectedUmkmLoad->address ?? 'Alamat belum diatur.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Col: Owner & Verification --}}
                    <div class="space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Pemilik & Verifikasi</h4>
                            <div class="space-y-4">
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedUmkmLoad->owner->name) }}&background=000B44&color=fff" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-bold">{{ $selectedUmkmLoad->owner->name }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $selectedUmkmLoad->owner->email }}</p>
                                    </div>
                                </div>
                                <div class="p-5 bg-teal-50/50 rounded-2xl border border-teal-100">
                                    <p class="text-xs text-teal-600 font-bold mb-1">No. Telepon Owner</p>
                                    <p class="text-base font-bold text-teal-900">{{ $selectedUmkmLoad->owner->phone ?? '-' }}</p>
                                </div>
                                <div class="p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                    <p class="text-xs text-indigo-600 font-bold mb-4">Dokumen Legalitas</p>
                                    <div class="space-y-4">
                                        {{-- NIB --}}
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-indigo-900 leading-none">NIB (Nomor Induk Berusaha)</p>
                                                <p class="text-[10px] text-indigo-500 mt-1 truncate max-w-[150px]">{{ $selectedUmkmLoad->detail->nib_file_path ?? 'Belum diunggah' }}</p>
                                            </div>
                                            @if($selectedUmkmLoad->detail->nib_file_path)
                                                <a href="{{ Storage::url($selectedUmkmLoad->detail->nib_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a>
                                            @endif
                                        </div>
                                        {{-- KTP --}}
                                        <div class="flex items-center gap-3 pt-3 border-t border-indigo-100/50">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-400 flex items-center justify-center text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-indigo-900 leading-none">Kartu Tanda Penduduk (KTP)</p>
                                                <p class="text-[10px] text-indigo-500 mt-1 truncate max-w-[150px]">{{ $selectedUmkmLoad->detail->ktp_file_path ?? 'Belum diunggah' }}</p>
                                            </div>
                                            @if($selectedUmkmLoad->detail->ktp_file_path)
                                                <a href="{{ Storage::url($selectedUmkmLoad->detail->ktp_file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-10 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-4">
                <button wire:click="rejectUmkm({{ $selectedUmkmLoad->id }})" class="px-8 py-4 text-sm font-bold text-red-500 hover:bg-red-50 rounded-2xl transition-all">Tolak Aplikasi</button>
                <button wire:click="approveUmkm({{ $selectedUmkmLoad->id }})" class="px-10 py-4 bg-[#000B44] text-white text-sm font-black rounded-2xl hover:bg-slate-900 shadow-xl shadow-[#000B44]/10 transition-all flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Setujui & Aktifkan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>