<x-slot:title>Verification Status</x-slot>

<div class="flex-1 flex flex-col items-center justify-center p-8 lg:p-20 relative">
    <div class="w-full max-w-4xl grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        
        <div class="space-y-12 text-center lg:text-left">
            <div class="space-y-4">
                @if($umkmStatus == 'approved')
                    <h2 class="text-5xl lg:text-6xl font-black text-[#000B44] font-plus tracking-tighter leading-none">Verifikasi <br> <span class="text-[#0077B6]">Selesai</span></h2>
                    <p class="text-slate-400 font-medium text-sm lg:text-base leading-relaxed max-w-sm mx-auto lg:mx-0">
                        Selamat! UMKM Anda telah diverifikasi. Anda sekarang bisa mulai mengelola layanan dan menerima pesanan.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('admin-umkm.dashboard.preview') }}" class="px-8 py-4 bg-[#000B44] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all inline-block">Masuk ke Dashboard</a>
                    </div>
                @else
                    <h2 class="text-5xl lg:text-6xl font-black text-[#000B44] font-plus tracking-tighter leading-none">Sedang <br> <span class="text-slate-300">Ditinjau</span></h2>
                    <p class="text-slate-400 font-medium text-sm lg:text-base leading-relaxed max-w-sm mx-auto lg:mx-0">
                        Mohon tunggu sebentar, kami sedang melakukan verifikasi data dan berkas legalitas UMKM Anda.
                    </p>
                @endif
            </div>

            <div class="space-y-8">
                @foreach($steps as $s)
                <div class="flex items-center gap-6">
                    <div @class([
                        'w-8 h-8 rounded-xl flex items-center justify-center border transition-all duration-500',
                        'bg-[#000B44] text-white border-[#000B44]' => $s['status'] == 'check',
                        'bg-white border-[#0077B6] text-[#0077B6] animate-pulse' => $s['status'] == 'active',
                        'bg-white border-slate-100 text-slate-200' => $s['status'] == 'waiting',
                    ])>
                        @if($s['status'] == 'check') 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        @elseif($s['status'] == 'active') 
                            <div class="w-1.5 h-1.5 bg-[#0077B6] rounded-full"></div>
                        @else 
                            <div class="w-1.5 h-1.5 bg-slate-100 rounded-full"></div> 
                        @endif
                    </div>
                    <span @class([
                        'text-[11px] font-black uppercase tracking-widest',
                        'text-slate-200' => $s['status'] == 'waiting',
                        'text-[#000B44]' => $s['status'] != 'waiting',
                    ])>{{ $s['title'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative flex justify-center items-center">
            <div class="absolute inset-0 bg-[#0077B6]/10 blur-3xl -z-10 rounded-full scale-125 opacity-20"></div>
            <div class="relative w-full aspect-square max-w-[340px] bg-white rounded-[3rem] p-4 shadow-2xl border border-slate-50 overflow-hidden">
                <div class="w-full h-full bg-[#000B44] rounded-[2.5rem] overflow-hidden relative shadow-inner">
                    
                    @if($umkmStatus == 'approved')
                        <div class="flex flex-col items-center justify-center h-full text-white space-y-4">
                            <div class="w-20 h-20 bg-[#0077B6] rounded-full flex items-center justify-center shadow-lg shadow-[#0077B6]/40">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-200">Verified Partner</span>
                        </div>
                    @else
                        <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-90" style="filter: contrast(110%) brightness(110%);">
                            <source src="{{ asset('storage/videos/scan.webm') }}" type="video/webm">
                        </video>
                        
                        <div class="absolute inset-0 pointer-events-none opacity-15" style="background: linear-gradient(rgba(18,16,16,0) 50%, rgba(0,0,0,0.1) 50%); background-size: 100% 4px;"></div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-end pointer-events-none">
                            <div class="flex items-center gap-3">
                                <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.3em]">Processing...</span>
                                <div class="flex gap-1">
                                    <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce"></span>
                                    <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                                    <span class="w-1 h-1 bg-[#0077B6] rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>