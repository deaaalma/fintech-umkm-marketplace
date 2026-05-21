@component('layouts.blank')
<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .active-nav { background: rgba(255, 255, 255, 0.05); position: relative; }
        .active-nav::after { content: ''; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #0077B6; border-radius: 0 4px 4px 0; }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    </style>

    <!-- Sidebar -->
    @include('components.super-admin.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Top Header -->
        <header class="h-24 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 backdrop-blur-md bg-white/80">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black font-plus text-[#000B44] leading-tight flex items-center gap-2">
                        Superadmin Portal
                    </h1>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-10 lg:p-12 space-y-12">
            <!-- Page Title Area -->
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-3">Pengaturan Sistem</h2>
                    <p class="text-slate-500 font-medium">Konfigurasi variabel global dan keamanan platform.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-[#000B44] px-10 py-5 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-[2rem] shadow-2xl shadow-black/20 transform hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan Perubahan</button>
                </div>
            </div>

            <!-- Settings Sections -->
            <div class="grid grid-cols-12 gap-10">
                <!-- Navigation -->
                <div class="col-span-12 lg:col-span-3 space-y-4">
                    @foreach(['General Settings', 'Auth & Security', 'Notifications', 'Payments', 'System Logs'] as $i => $s)
                    <button @class([
                        'w-full text-left p-6 rounded-[1.5rem] transition-all duration-300 font-plus flex items-center gap-4 group',
                        'bg-[#000B44] text-white shadow-xl shadow-black/20' => $i === 0,
                        'bg-white text-slate-400 hover:bg-slate-50' => $i !== 0
                    ])>
                        <span @class([
                            'text-[11px] font-black uppercase tracking-widest',
                            'text-white' => $i === 0,
                            'text-slate-400 group-hover:text-[#000B44]' => $i !== 0
                        ])>{{ $s }}</span>
                    </button>
                    @endforeach
                </div>

                <!-- Form Area -->
                <div class="col-span-12 lg:col-span-9 bg-white p-12 rounded-[3.5rem] border border-slate-100 shadow-2xl shadow-slate-200/20 space-y-12">
                    <div class="space-y-8">
                        <div class="flex items-center gap-4 border-l-4 border-[#000B44] pl-6 h-10">
                            <h4 class="text-xl font-black text-[#000B44] font-plus tracking-tight uppercase leading-none">General Configuration</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-8 pt-4">
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest ml-1">Nama Platform</label>
                                <input type="text" value="UMKM Connect" class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 text-sm font-black text-[#000B44] font-plus focus:ring-2 focus:ring-[#0077B6]/20 transition-all uppercase tracking-widest">
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest ml-1">Support Email</label>
                                <input type="text" value="support@umkmconnect.com" class="w-full bg-slate-50 border-none rounded-2xl py-5 px-8 text-sm font-black text-[#000B44] font-plus focus:ring-2 focus:ring-[#0077B6]/20 transition-all uppercase tracking-widest">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 pt-4">
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest ml-1">Platform Meta Description</label>
                                <textarea rows="3" class="w-full bg-slate-50 border-none rounded-2xl py-6 px-8 text-sm font-medium text-[#000B44] font-plus focus:ring-2 focus:ring-[#0077B6]/20 transition-all resize-none italic">Platform monitoring dan tata kelola UMKM terbaik untuk digitalisasi UMKM daerah secara masif.</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-slate-50 space-y-8">
                        <div class="flex items-center gap-4 border-l-4 border-teal-500 pl-6 h-10">
                            <h4 class="text-xl font-black text-[#000B44] font-plus tracking-tight uppercase leading-none">Keamanan Server</h4>
                        </div>
                        <div class="space-y-6">
                            @foreach([['Maintenance Mode', 'Matikan fitur login sementara untuk perbaikan sistem', false], ['Two-Factor Auth', 'Wajibkan admin menggunakan 2FA untuk login keamanan tinggi', true], ['IP Restriction', 'Batasi akses superadmin hanya pada IP Address tertentu', false]] as $toggle)
                            <div class="flex items-center justify-between p-8 bg-slate-50/50 rounded-3xl border border-slate-50 border-dashed group hover:border-[#0077B6]/30 transition-all">
                                <div>
                                    <h5 class="text-sm font-black text-[#000B44] font-plus tracking-tight uppercase leading-none mb-2">{{ $toggle[0] }}</h5>
                                    <p class="text-xs text-slate-400 font-medium">{{ $toggle[1] }}</p>
                                </div>
                                <button @class([
                                    'w-16 h-8 rounded-full relative p-1 transition-all duration-300 shadow-inner overflow-hidden',
                                    'bg-teal-500 shadow-teal-500/20' => $toggle[2],
                                    'bg-slate-200' => !$toggle[2]
                                ])>
                                    <div @class([
                                        'w-6 h-6 bg-white rounded-full transition-all duration-300 shadow-xl flex items-center justify-center',
                                        'ml-8' => $toggle[2],
                                        'ml-0' => !$toggle[2]
                                    ])>
                                        @if($toggle[2])
                                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </div>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endcomponent
