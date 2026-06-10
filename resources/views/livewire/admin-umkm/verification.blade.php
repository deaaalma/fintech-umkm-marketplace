<x-slot:title>Menunggu Verifikasi</x-slot>

<div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-6 relative overflow-hidden">
    <!-- Clean Abstract Background Elements -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-[#0077B6]/5 to-transparent"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#0077B6]/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-[#000B44]/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-lg bg-white border border-slate-100 p-10 lg:p-16 rounded-[3rem] shadow-xl text-center flex flex-col items-center animate-in zoom-in-95 duration-500">
        
        <!-- Elegant CSS Loading Animation -->
        <div class="relative w-32 h-32 mb-10 flex items-center justify-center">
            <!-- Outer Ring -->
            <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
            <!-- Spinning Ring 1 (Navy) -->
            <div class="absolute inset-0 border-4 border-transparent border-t-[#000B44] border-r-[#000B44] rounded-full animate-[spin_1.5s_linear_infinite]"></div>
            <!-- Spinning Ring 2 (Light Blue) -->
            <div class="absolute inset-4 border-4 border-transparent border-b-[#0077B6] border-l-[#0077B6] rounded-full animate-[spin_2s_linear_infinite_reverse]"></div>
            
            <!-- Center Icon -->
            <div class="relative z-10 w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#000B44] shadow-sm">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-black text-[#000B44] font-plus tracking-tight mb-4">
            Sedang <span class="text-[#0077B6]">Ditinjau</span>
        </h1>
        
        <p class="text-slate-500 font-medium text-sm md:text-base leading-relaxed mb-10 px-4">
            Mohon bersabar, ya. Tim JOS sedang memverifikasi data dan legalitas UMKM Anda demi keamanan bersama. 
            <br><br>
            Silakan cek kembali halaman ini secara berkala.
        </p>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full px-8 py-4 bg-[#000B44] hover:bg-[#0077B6] text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                Keluar / Logout
            </button>
        </form>

    </div>
</div>