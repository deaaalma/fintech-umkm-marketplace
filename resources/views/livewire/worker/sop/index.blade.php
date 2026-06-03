<div class="max-w-6xl mx-auto space-y-10 animate-fade-in-up">
    {{-- Top Navigation: SOP Categories (Horizontal Layout) --}}
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-2">
            <div>
                <h2 class="text-3xl font-black text-slate-900 font-plus tracking-tight mb-2">SOP & Panduan Kerja</h2>
                <p class="text-slate-500 font-semibold text-sm">Pilih panduan untuk melihat standar operasional UMKM.</p>
            </div>
            
                {{-- Search Input --}}
            <div class="relative w-full md:w-80 group">
                <input type="text" 
                       wire:model.live="search"
                       placeholder="Cari panduan..." 
                       class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-[20px] text-sm font-bold text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-[#0077B6] focus:border-transparent transition-all outline-none shadow-sm shadow-slate-100">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

                {{-- Horizontal Pill Navigation --}}
        <div class="flex items-center gap-3 overflow-x-auto pb-4 no-scrollbar px-2">
            @forelse($sopsList as $sop)
                <button wire:click="selectSop({{ $sop['id'] }})" 
                        @class([
                            'flex items-center gap-3 px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
                            'bg-[#000B44] text-white border-[#000B44] shadow-lg shadow-indigo-900/20 focus-visible:ring-[#000B44]' => $activeSopId === $sop['id'],
                            'bg-white text-slate-500 border-slate-100 hover:border-slate-300 hover:text-slate-900 focus-visible:ring-slate-400 shadow-sm' => $activeSopId !== $sop['id']
                        ])>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($sop['icon'] === 'document-text')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        @elseif($sop['icon'] === 'sparkles')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.143-7.714L1 12l6.857-2.143L11 3z"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        @endif
                    </svg>
                    {{ $sop['title'] }}
                </button>
            @empty
                <div class="py-2 px-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Tidak ditemukan hasil untuk "{{ $search }}"
                </div>
            @endforelse
        </div>
    </div>

    {{-- Main Content: SOP Details --}}
    <div class="space-y-8">
        {{-- Header Card --}}
        <div class="bg-white p-8 md:p-12 rounded-[48px] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-slate-50 rounded-full -mr-40 -mt-40 opacity-50"></div>
            
            <div class="relative">
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Update: {{ $activeSop['last_updated'] }}</span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Versi {{ $activeSop['version'] }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 font-plus tracking-tight mb-10 leading-tight">{{ $activeSop['title'] }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-[#0077B6] rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 font-plus uppercase tracking-[0.2em]">Tujuan Utama</h3>
                        </div>
                        <p class="text-base text-slate-600 leading-relaxed font-medium">{{ $activeSop['tujuan'] }}</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-green-500 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 font-plus uppercase tracking-[0.2em]">Ruang Lingkup</h3>
                        </div>
                        <ul class="grid grid-cols-1 gap-4">
                            @foreach($activeSop['ruang_lingkup'] as $scope)
                            <li class="flex items-start gap-4 text-sm text-slate-600 font-semibold bg-slate-50/50 p-3 rounded-2xl border border-slate-100">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                {{ $scope }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Steps Section --}}
        <div class="bg-white p-8 md:p-12 rounded-[48px] border border-slate-100 shadow-sm">
            <h2 class="text-2xl font-black text-slate-900 font-plus mb-12 flex items-center gap-4">
                <span class="w-10 h-10 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </span>
                Prosedur & Langkah Kerja
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 relative before:hidden lg:before:block before:absolute before:left-1/2 before:top-20 before:bottom-20 before:w-px before:bg-slate-100">
                @foreach($activeSop['langkah_kerja'] as $index => $step)
                <div class="relative flex gap-8 p-6 rounded-[32px] hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-900 flex items-center justify-center font-black text-lg shrink-0 shadow-sm group-hover:bg-[#000B44] group-hover:text-white group-hover:border-[#000B44] transition-all">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-slate-900 font-plus mb-2 leading-tight">{{ $step['title'] }}</h4>
                        <p class="text-sm text-slate-500 leading-relaxed font-semibold">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Multimedia Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <button class="bg-white p-10 rounded-[48px] border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center group transition-all hover:ring-2 hover:ring-[#000B44] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#000B44] focus-visible:ring-offset-4">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-400 mb-6 group-hover:bg-[#000B44] group-hover:text-white transition-all">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 font-plus mb-2 uppercase tracking-[0.2em]">Ilustrasi Visual</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Klik untuk memperbesar gambar</p>
            </button>
            
            <button class="bg-white p-10 rounded-[48px] border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center group transition-all hover:ring-2 hover:ring-[#000B44] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#000B44] focus-visible:ring-offset-4">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-400 mb-6 group-hover:bg-[#000B44] group-hover:text-white transition-all relative">
                    <svg class="w-10 h-10 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 font-plus mb-2 uppercase tracking-[0.2em]">Video Tutorial</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Demonstrasi teknik di lapangan</p>
            </button>
        </div>

        {{-- Safety Notice --}}
        <div class="bg-red-50 p-10 md:p-12 rounded-[48px] border border-red-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10">
                <svg class="w-64 h-64 text-red-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45L19.53 19H4.47L12 5.45zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
            </div>
            <div class="relative">
                <div class="flex items-center gap-5 mb-10">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h2 class="text-2xl font-black text-red-900 font-plus uppercase tracking-tight">Perhatian Keselamatan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                    @foreach($activeSop['safety'] as $warning)
                    <div class="flex items-start gap-5">
                        <div class="w-2.5 h-2.5 bg-red-500 rounded-full mt-2 shrink-0 shadow-sm shadow-red-200"></div>
                        <p class="text-base text-red-900 font-bold leading-relaxed">{{ $warning }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
