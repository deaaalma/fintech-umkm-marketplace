<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6] overflow-hidden">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    <!-- Sidebar -->
    @include('templates.admin-umkm.components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Header -->
        @include('templates.admin-umkm.components.header', ['title' => 'Verification Status'])

        <div class="flex-1 flex flex-col items-center justify-center p-8 lg:p-20 relative">
            
            <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                
                <!-- Info Section -->
                <div class="space-y-12 text-center lg:text-left">
                    <div class="space-y-4">
                        <h2 class="text-5xl lg:text-6xl font-black text-[#000B44] font-plus tracking-tighter leading-none">Sedang <br> <span class="text-slate-300">Ditinjau</span></h2>
                        <p class="text-slate-400 font-medium text-sm lg:text-base leading-relaxed max-w-sm mx-auto lg:mx-0">
                            Mohon tunggu sebentar, kami sedang melakukan verifikasi data dan berkas legalitas UMKM Anda.
                        </p>
                    </div>

                    <!-- Steps List -->
                    <div class="space-y-8">
                        @foreach([['Tahap pendaftaran', 'check'], ['Proses verifikasi developer', 'active'], ['Status pendaftaran selesai', 'waiting']] as $s)
                        <div class="flex items-center gap-6">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center border transition-all duration-500 {{ $s[1] == 'check' ? 'bg-[#000B44] text-white' : ($s[1] == 'active' ? 'bg-white border-[#0077B6] text-[#0077B6] animate-pulse' : 'bg-white border-slate-100 text-slate-200') }}">
                                @if($s[1] == 'check') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                                @elseif($s[1] == 'active') <div class="w-1.5 h-1.5 bg-[#0077B6] rounded-full"></div>
                                @else <div class="w-1.5 h-1.5 bg-slate-100 rounded-full"></div> @endif
                            </div>
                            <span class="text-[11px] font-black uppercase tracking-widest {{ $s[1] == 'waiting' ? 'text-slate-200' : 'text-[#000B44]' }}">{{ $s[0] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Video HUD Module -->
                <div class="relative flex justify-center items-center">
                    <div class="absolute inset-0 bg-[#0077B6]/10 blur-3xl -z-10 rounded-full scale-125 opacity-20"></div>
                    <div class="relative w-full aspect-square max-w-[340px] bg-white rounded-[3rem] p-4 shadow-2xl border border-slate-50 overflow-hidden">
                        <div class="w-full h-full bg-[#000B44] rounded-[2.5rem] overflow-hidden relative shadow-inner">
                            <!-- VIDEO INTEGRATION -->
                            <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-90" style="filter: contrast(110%) brightness(110%);">
                                <source src="{{ asset('storage/videos/scan.webm') }}" type="video/webm">
                            </video>
                            
                            <!-- Scanline Overlay -->
                            <div class="absolute inset-0 pointer-events-none opacity-15" style="background: linear-gradient(rgba(18,16,16,0) 50%, rgba(0,0,0,0.1) 50%); background-size: 100% 4px;"></div>

                            <!-- HUD Footer -->
                            <div class="absolute inset-0 p-8 flex flex-col justify-end pointer-events-none">
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.3em]">Processing...</span>
                                    <div class="flex gap-1"><span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce"></span><span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.1s"></span><span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.2s"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
