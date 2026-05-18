<div class="min-h-screen bg-[#F8FAFC] flex flex-col items-center justify-center p-8 font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6] overflow-hidden">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .video-container {
            mask-image: linear-gradient(to bottom, black 85%, transparent 100%);
        }
        
        .glow-soft {
            box-shadow: 0 40px 100px rgba(0, 11, 68, 0.03);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }
    </style>

    <!-- Simple Header -->
    <div class="fixed top-12 left-0 w-full flex justify-center px-8 sm:px-12">
        <div class="w-full max-w-5xl flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#000B44] rounded-2xl flex items-center justify-center text-white font-black font-plus tracking-tighter">J</div>
                <span class="text-xl font-black text-[#000B44] font-plus tracking-tight">JOS Partner</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] font-black text-slate-400 hover:text-red-500 uppercase tracking-widest transition-all">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Simplified Content -->
    <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        
        <!-- Left Section: Status -->
        <div class="text-center lg:text-left space-y-8 animate-float">
            <div class="space-y-4">
                <h1 class="text-4xl lg:text-6xl font-black text-[#000B44] font-plus tracking-tighter leading-none">Pendaftaran <br> <span class="text-slate-300">Ditinjau</span></h1>
                <p class="text-slate-400 font-medium text-sm leading-relaxed max-w-xs mx-auto lg:mx-0">
                    Mohon tunggu sebentar, kami sedang melakukan verifikasi data dan dokumen UMKM Anda.
                </p>
            </div>

            <!-- Minimalist Steps -->
            <div class="space-y-6 pt-4">
                @foreach([['Pendaftaran', 'check'], ['Verifikasi', 'loading'], ['Selesai', 'lock']] as $step)
                <div class="flex items-center gap-5">
                    <div class="relative flex flex-col items-center">
                        <div @class([
                            'w-8 h-8 rounded-xl flex items-center justify-center border transition-all duration-500',
                            'bg-[#000B44] border-[#000B44] text-white shadow-lg shadow-black/10' => $step[1] == 'check',
                            'bg-white border-[#0077B6] text-[#0077B6] animate-pulse' => $step[1] == 'loading',
                            'bg-white border-slate-100 text-slate-200' => $step[1] == 'lock'
                        ])>
                            @if($step[1] == 'check') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                            @elseif($step[1] == 'loading') <div class="w-1.5 h-1.5 bg-[#0077B6] rounded-full"></div>
                            @else <div class="w-1.5 h-1.5 bg-slate-100 rounded-full"></div> @endif
                        </div>
                        @if(!$loop->last) <div class="w-[1.5px] h-6 bg-slate-50 absolute top-8"></div> @endif
                    </div>
                    <span @class(['text-[11px] font-black uppercase tracking-widest', 'text-[#000B44]' => $step[1] != 'lock', 'text-slate-200' => $step[1] == 'lock'])>{{ $step[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Section: Video Player (Clean) -->
        <div class="relative flex justify-center items-center">
            <!-- Background Decoration (Extreme minimal) -->
            <div class="absolute inset-0 bg-gradient-to-tr from-[#0077B6]/10 to-transparent blur-3xl -z-10 rounded-full scale-110 opacity-50"></div>

            <div class="relative w-full aspect-square max-w-[340px] bg-white rounded-[3rem] p-4 glow-soft border border-slate-50 overflow-hidden">
                <div class="w-full h-full bg-[#000B44] rounded-[2.5rem] overflow-hidden relative shadow-inner">
                    <!-- High-Contrast Filtered Video -->
                    <video autoplay loop muted playsinline class="w-full h-full object-cover" style="filter: contrast(110%) brightness(110%);">
                        <source src="{{ asset('storage/videos/scan.webm') }}" type="video/webm">
                    </video>
                    
                    <!-- HD Scanline Overlay (To mask low resolution) -->
                    <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.02), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.02)); background-size: 100% 3px, 3px 100%; opacity: 0.15"></div>

                    <!-- Simpler HUD -->
                    <div class="absolute inset-0 p-8 flex flex-col justify-end pointer-events-none">
                        <div class="flex items-center gap-3">
                            <span class="text-[9px] font-black text-white/50 uppercase tracking-[0.3em]">Processing...</span>
                            <div class="flex gap-1">
                                <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce"></span>
                                <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                                <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Help Bottom -->
    <div class="fixed bottom-12 left-0 w-full flex justify-center text-[10px] font-bold text-slate-400 uppercase tracking-widest gap-8">
        <a href="#" class="hover:text-[#000B44] transition-colors">Bantuan</a>
        <span class="text-slate-200">|</span>
        <a href="#" class="hover:text-[#0077B6] transition-colors">WhatsApp Kami</a>
    </div>

</div>
