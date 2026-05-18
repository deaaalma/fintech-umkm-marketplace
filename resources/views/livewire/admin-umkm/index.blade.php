<div class="min-h-screen bg-[#f8fafc] font-['Figtree']">
    <!-- Simple Navbar for UMKM -->
    <nav class="bg-white border-b border-slate-100 py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <a href="/" class="text-xl font-black text-[#000B44] font-plus tracking-tight flex items-center gap-2">
            <div class="w-8 h-8 bg-[#000B44] rounded-lg flex items-center justify-center text-white text-xs">J</div>
            JOS Partner
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-black text-red-500 uppercase tracking-widest hover:text-red-600 transition-all flex items-center gap-2">
                Keluar
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2.5"></path></svg>
            </button>
        </form>
    </nav>

    <div class="py-20 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center justify-center text-center space-y-8 animate-in">
                <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-[#0077B6] shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2"></path></svg>
                </div>
                
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl font-black text-[#000B44] font-plus tracking-tight">Selamat Datang,<br><span class="text-[#0077B6]">{{ auth()->user()->umkm?->name ?: auth()->user()->name }}</span>!</h1>
                    <p class="text-slate-500 font-medium text-lg max-w-lg mx-auto leading-relaxed italic">"Terima kasih telah bergabung. Pendaftaran Anda telah kami terima dan sedang dalam antrean verifikasi."</p>
                </div>
                
                <div class="flex flex-col items-center gap-4">
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-teal-50 text-teal-700 rounded-2xl border border-teal-100 font-bold text-xs uppercase tracking-widest animate-pulse">
                        <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                        Status: Menunggu Verifikasi
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-2">Update berkala akan dikirimkan ke email Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-in { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</div>