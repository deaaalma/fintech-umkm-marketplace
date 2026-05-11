<div id="service" class="w-full pt-24 pb-0 bg-[#0A0A0A] overflow-visible relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="partners-animate-container flex flex-col lg:flex-row items-center justify-between gap-12 mb-12 border-b border-white/5 pb-8">
            <div class="text-white text-lg lg:text-xl max-w-md leading-tight font-circular-bold">
                Dipercaya oleh berbagai <span class="font-georgia-italic italic text-white">mitra UMKM</span> di seluruh Indonesia
            </div>
            <div class="flex-1 w-full relative overflow-hidden">
                <div class="flex items-center gap-16 animate-scroll whitespace-nowrap">
                    @foreach($apps as $app)
                        <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain brightness-0 invert opacity-40 logo-hover-blue transition-all duration-300">
                    @endforeach
                    @foreach($apps as $app)
                        <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain brightness-0 invert opacity-40 logo-hover-blue transition-all duration-300">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 mb-12 max-w-3xl solution-header">
            <h2 class="text-4xl lg:text-5xl font-medium text-white tracking-tight" style="font-family: 'Figtree', sans-serif;">
                Built for Serious <span class="font-georgia-italic italic">Growth</span>
            </h2>
            <p class="text-[#666666] text-lg leading-relaxed font-circular-book">
                Tingkatkan kredibilitas usaha dengan sistem manajemen website dan pesanan berstandar profesional.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden solution-card">
                <div class="z-10">
                    <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Website Builder</h3>
                    <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                        Setiap UMKM memiliki landing page profesional sendiri yang dapat dikustomisasi secara fleksibel sesuai kebutuhan bisnis.
                    </p>
                </div>
                <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                     <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                     </div>
                </div>
            </div>
            <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden solution-card">
                <div class="z-10">
                    <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Order Management</h3>
                    <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                        Kelola setiap pesanan masuk dengan sistem yang terorganisir dan efisien untuk meningkatkan produktivitas.
                    </p>
                </div>
                <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                     <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                     </div>
                </div>
            </div>
            <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden solution-card">
                <div class="z-10">
                    <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Sales Reports</h3>
                    <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                        Pantau pertumbuhan bisnis Anda melalui laporan penjualan otomatis yang akurat dan mudah dipahami.
                    </p>
                </div>
                <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                     <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                     </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-30 -mb-28 lg:-mb-40 bridge-cards">
            <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden solution-card">
                <div class="z-10">
                    <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Tracking</h3>
                    <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                        Lacak status pengiriman dan pesanan secara real-time untuk memberikan transparansi penuh kepada pelanggan.
                    </p>
                </div>
                <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                     <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                     </div>
                </div>
            </div>
            <div class="bg-[#111111] p-8 h-52 rounded-2xl border border-white/5 flex flex-col group hover:bg-white transition-all duration-500 relative overflow-hidden solution-card">
                <div class="z-10">
                    <h3 class="text-white group-hover:text-black text-xl font-circular-bold mb-3 transition-colors duration-500">Chat</h3>
                    <p class="text-gray-400 group-hover:text-black text-[15px] font-circular-book opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 max-w-[90%] leading-relaxed">
                        Terhubung langsung dengan pelanggan melalui integrasi pesan instan yang cepat, mudah, dan terintegrasi.
                    </p>
                </div>
                <div class="absolute bottom-6 right-6 z-10 transition-transform duration-500 group-hover:scale-110">
                     <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:bg-[#0078b7] group-hover:border-[#0078b7] transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white group-hover:text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
