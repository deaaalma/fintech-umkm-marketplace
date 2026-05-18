<div 
    x-data="{ open: false }" 
    @open-register-choice.window="open = true" 
    x-show="open" 
    class="fixed inset-0 z-[9999] overflow-y-auto" 
    style="display: none;"
    x-cloak
>
    <!-- Overlay -->
    <div 
        x-show="open" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0" 
        class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-md" 
        @click="open = false"
    ></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div 
            x-show="open" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            class="relative w-full max-w-4xl p-8 transition-all transform"
        >
            <!-- Close Button (X) -->
            <div class="absolute top-0 right-4 lg:-right-8 lg:-top-8">
                <button @click="open = false" class="bg-white/10 hover:bg-white/20 p-3 rounded-full text-white backdrop-blur-md transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transform group-hover:rotate-90 transition-transform duration-300">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-white font-plus tracking-tight capitalize">Bagaimana Anda ingin bergabung?</h2>
                <p class="text-blue-100/70 mt-3 font-medium">Pilih tipe akun yang sesuai dengan kebutuhan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Customer Card -->
                <div class="bg-white rounded-[2.5rem] p-10 flex flex-col items-center text-center shadow-2xl shadow-black/20 hover:scale-[1.02] transition-transform duration-300 group">
                    <div class="mb-8 w-28 h-28 relative group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-blue-50 rounded-full scale-125 opacity-50"></div>
                        <img src="{{ asset('storage/images/customer icon.png') }}" alt="Customer" class="relative z-10 w-full h-full object-contain">
                    </div>
                    
                    <h3 class="text-2xl font-black text-[#000B44] font-plus mb-3">Daftar sebagai Pelanggan</h3>
                    <p class="text-slate-500 font-medium mb-10 leading-relaxed max-w-[240px]">
                        Temukan berbagai produk dan layanan dari mitra UMKM terpercaya di seluruh Indonesia.
                    </p>

                    <div class="mt-auto w-full">
                        <a href="{{ route('register') }}" 
                            class="block w-full bg-[#000B44] hover:bg-[#0077B6] text-white font-black font-plus py-4 rounded-2xl shadow-xl shadow-[#000B44]/20 hover:shadow-[#0077B6]/30 transition-all duration-300"
                            wire:navigate>
                            Gabung Sekarang
                        </a>
                    </div>
                </div>

                <!-- UMKM Card -->
                <div class="bg-white rounded-[2.5rem] p-10 flex flex-col items-center text-center shadow-2xl shadow-black/20 hover:scale-[1.02] transition-transform duration-300 group">
                    <div class="mb-8 w-28 h-28 relative group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-indigo-50 rounded-full scale-125 opacity-50"></div>
                        <img src="{{ asset('storage/images/business icon.png') }}" alt="UMKM" class="relative z-10 w-full h-full object-contain">
                    </div>
                    
                    <h3 class="text-2xl font-black text-[#000B44] font-plus mb-3">Daftar sebagai UMKM</h3>
                    <p class="text-slate-500 font-medium mb-10 leading-relaxed max-w-[240px]">
                        Buka peluang bisnis yang lebih luas dan kelola pesanan Anda dengan lebih efisien.
                    </p>

                    <div class="mt-auto w-full">
                        <a href="{{ route('register.umkm') }}" 
                           class="block w-full bg-[#0077B6] hover:bg-[#000B44] text-white font-black font-plus py-4 rounded-2xl shadow-xl shadow-[#0077B6]/20 hover:shadow-[#000B44]/30 transition-all duration-300"
                           wire:navigate>
                            Daftar UMKM
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
