<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 animate-fade-in">
    {{-- Left Sidebar: List of SOPs --}}
    <div class="lg:col-span-3 space-y-6">
        <div class="bg-white p-6 rounded-[32px] border border-gray-100 shadow-sm sticky top-28">
            <h2 class="text-sm font-black text-gray-900 font-plus mb-6 uppercase tracking-widest">SOP & Panduan</h2>
            
            {{-- Search SOP --}}
            <div class="relative mb-6 group">
                <input type="text" 
                       wire:model.live="search"
                       placeholder="Cari SOP..." 
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-xs font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none">
                <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#2D2D2D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <nav class="space-y-2">
                @foreach($sops as $sop)
                <button wire:click="selectSop({{ $sop['id'] }})" 
                        @class([
                            'w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-xs font-bold transition-all group',
                            'bg-[#2D2D2D] text-white shadow-lg shadow-gray-200' => $activeSopId === $sop['id'],
                            'text-gray-400 hover:bg-gray-50 hover:text-gray-900' => $activeSopId !== $sop['id']
                        ])>
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($sop['icon'] === 'document-text')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            @elseif($sop['icon'] === 'sparkles')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.143-7.714L1 12l6.857-2.143L11 3z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            @endif
                        </svg>
                        {{ $sop['title'] }}
                    </span>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endforeach
            </nav>
        </div>
    </div>

    {{-- Main Content: SOP Details --}}
    <div class="lg:col-span-9 space-y-8">
        {{-- Header Card --}}
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gray-50 rounded-full -mr-32 -mt-32 opacity-50"></div>
            
            <div class="relative">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100">Aktif</span>
                    <span class="text-[10px] font-bold text-gray-400">Last updated: {{ $activeSop['last_updated'] }}</span>
                    <span class="text-[10px] font-bold text-gray-400">Version: {{ $activeSop['version'] }}</span>
                </div>
                <h1 class="text-4xl font-black text-gray-900 font-plus tracking-tight mb-8">{{ $activeSop['title'] }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-4">
                        <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-widest">Tujuan</h3>
                        <p class="text-sm text-gray-500 leading-relaxed font-medium">{{ $activeSop['tujuan'] }}</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-widest">Ruang Lingkup</h3>
                        <ul class="space-y-3">
                            @foreach($activeSop['ruang_lingkup'] as $scope)
                            <li class="flex items-start gap-3 text-sm text-gray-500 font-medium">
                                <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $scope }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Steps Card --}}
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
            <h2 class="text-xl font-black text-gray-900 font-plus mb-10">Langkah Kerja</h2>
            <div class="space-y-12 relative before:absolute before:left-[19px] before:top-4 before:bottom-4 before:w-0.5 before:bg-gray-50">
                @foreach($activeSop['langkah_kerja'] as $index => $step)
                <div class="relative flex gap-10">
                    <div class="w-10 h-10 rounded-2xl bg-[#2D2D2D] text-white flex items-center justify-center font-black text-sm relative z-10 shadow-lg shadow-gray-200">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-black text-gray-900 font-plus mb-2">{{ $step['title'] }}</h4>
                        <p class="text-sm text-gray-500 leading-relaxed font-medium">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Visuals & Video --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center group cursor-pointer hover:border-[#2D2D2D] transition-all">
                <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-6 group-hover:bg-[#2D2D2D] group-hover:text-white transition-all">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 font-plus mb-2 uppercase tracking-widest">Ilustrasi & Diagram</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Klik untuk memperbesar gambar</p>
            </div>
            <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center group cursor-pointer hover:border-[#2D2D2D] transition-all">
                <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-6 group-hover:bg-[#2D2D2D] group-hover:text-white transition-all relative">
                    <svg class="w-10 h-10 ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 font-plus mb-2 uppercase tracking-widest">Video Tutorial</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Video demonstrasi teknik cleaning</p>
            </div>
        </div>

        {{-- Safety Section --}}
        <div class="bg-red-50 p-10 rounded-[40px] border border-red-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-5">
                <svg class="w-64 h-64 text-red-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45L19.53 19H4.47L12 5.45zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
            </div>
            <div class="relative">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h2 class="text-xl font-black text-red-900 font-plus uppercase tracking-tight">Perhatian Keselamatan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @foreach($activeSop['safety'] as $warning)
                    <div class="flex items-start gap-4">
                        <div class="w-2 h-2 bg-red-400 rounded-full mt-2 shrink-0"></div>
                        <p class="text-sm text-red-800 font-bold leading-relaxed">{{ $warning }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Feedback Section --}}
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
            <div class="max-w-2xl">
                <h2 class="text-xl font-black text-gray-900 font-plus mb-2">Pertanyaan atau Feedback</h2>
                <p class="text-sm text-gray-400 font-bold mb-8">Ajukan pertanyaan atau berikan masukan terkait SOP ini. Masukan Anda membantu kami meningkatkan kualitas panduan kerja.</p>
                
                <form class="space-y-6">
                    <div class="space-y-3">
                        <textarea rows="4" 
                                  placeholder="Tuliskan pertanyaan atau feedback Anda disini..." 
                                  class="w-full p-6 bg-gray-50 border border-gray-100 rounded-[28px] text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none resize-none"></textarea>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-6 h-6 bg-gray-100 border border-gray-200 rounded-lg peer-checked:bg-red-500 peer-checked:border-red-500 transition-all"></div>
                                <svg class="w-4 h-4 text-white absolute left-1 top-1 scale-0 peer-checked:scale-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest group-hover:text-gray-900 transition-colors">Tanda sebagai urgent</span>
                        </label>
                        <button type="submit" class="px-10 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-gray-200">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
