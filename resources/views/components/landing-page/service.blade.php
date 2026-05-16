<div id="service" class="w-full pt-24 pb-0 bg-[#0A0A0A] overflow-visible relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="partners-animate-container flex flex-col lg:flex-row items-center justify-between gap-12 mb-12 border-b border-[#000066]/10 pb-8">
            <div class="text-[#000066] text-lg lg:text-xl max-w-md leading-tight font-circular-bold">
                Dipercaya oleh berbagai <span class="font-georgia-italic italic text-[#0072BB]">mitra UMKM</span> di seluruh Indonesia
            </div>
            <div class="flex-1 w-full relative overflow-hidden">
                <div class="flex items-center gap-16 animate-scroll whitespace-nowrap">
                    @foreach($apps as $app)
                        <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain opacity-40 grayscale hover:grayscale-0 logo-hover-blue transition-all duration-300">
                    @endforeach
                    @foreach($apps as $app)
                        <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="h-8 lg:h-10 w-auto object-contain opacity-40 grayscale hover:grayscale-0 logo-hover-blue transition-all duration-300">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 mb-12 max-w-3xl solution-header">
            <h2 class="text-4xl lg:text-5xl font-medium text-[#000066] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Built for Serious <span class="font-georgia-italic italic text-[#0072BB]">Growth</span>
            </h2>
            <p class="text-[#000066]/70 text-lg leading-relaxed font-circular-book">
                Tingkatkan kredibilitas usaha dengan sistem manajemen website dan pesanan berstandar profesional.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Card 1: Website Builder -->
            <div class="aceternity-3d-card flex items-center justify-center relative w-full h-[380px]" style="perspective: 1000px;">
                <div class="aceternity-3d-body relative w-full h-full rounded-[32px] group/card bg-[#EBFBFF] shadow-xl shadow-[#000066]/5 transition-all duration-200 ease-linear" style="transform-style: preserve-3d;">
                    <!-- Base Layer (Image & Gradients) with overflow hidden -->
                    <div class="absolute inset-0 rounded-[32px] overflow-hidden border border-[#000066]/5">
                        <div class="absolute inset-x-0 top-0 h-[70%]">
                            <img src="{{ asset('storage/images/website builder.jpg') }}" alt="Website Builder" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#EBFBFF] via-[#EBFBFF]/95 via-35% to-transparent"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-[35%] bg-[#EBFBFF]"></div>
                    </div>
                    
                    <!-- Floating Content Layer -->
                    <div class="absolute inset-x-0 bottom-0 p-6 pb-7 flex flex-col justify-end z-10" style="transform-style: preserve-3d;">
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="40">
                            <h3 class="text-[#000066] text-[20px] font-circular-bold mb-1.5">Website Builder</h3>
                        </div>
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-full" data-translate-z="60">
                            <p class="text-[#000066]/70 text-[13px] font-circular-book line-clamp-2 leading-relaxed mb-4">
                                Setiap UMKM memiliki landing page profesional sendiri yang dapat dikustomisasi secara fleksibel sesuai kebutuhan bisnis.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="80">
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Customizable</span>
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Responsive</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Order Management -->
            <div class="aceternity-3d-card flex items-center justify-center relative w-full h-[380px]" style="perspective: 1000px;">
                <div class="aceternity-3d-body relative w-full h-full rounded-[32px] group/card bg-[#EBFBFF] shadow-xl shadow-[#000066]/5 transition-all duration-200 ease-linear" style="transform-style: preserve-3d;">
                    <div class="absolute inset-0 rounded-[32px] overflow-hidden border border-[#000066]/5">
                        <div class="absolute inset-x-0 top-0 h-[70%]">
                            <img src="{{ asset('storage/images/order management.jpg') }}" alt="Order Management" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#EBFBFF] via-[#EBFBFF]/95 via-35% to-transparent"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-[35%] bg-[#EBFBFF]"></div>
                    </div>
                    
                    <div class="absolute inset-x-0 bottom-0 p-6 pb-7 flex flex-col justify-end z-10" style="transform-style: preserve-3d;">
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="40">
                            <h3 class="text-[#000066] text-[20px] font-circular-bold mb-1.5">Order Management</h3>
                        </div>
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-full" data-translate-z="60">
                            <p class="text-[#000066]/70 text-[13px] font-circular-book line-clamp-2 leading-relaxed mb-4">
                                Kelola setiap pesanan masuk dengan sistem yang terorganisir dan efisien untuk meningkatkan produktivitas.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="80">
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Real-time</span>
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Organized</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Sales Reports -->
            <div class="aceternity-3d-card flex items-center justify-center relative w-full h-[380px]" style="perspective: 1000px;">
                <div class="aceternity-3d-body relative w-full h-full rounded-[32px] group/card bg-[#EBFBFF] shadow-xl shadow-[#000066]/5 transition-all duration-200 ease-linear" style="transform-style: preserve-3d;">
                    <div class="absolute inset-0 rounded-[32px] overflow-hidden border border-[#000066]/5">
                        <div class="absolute inset-x-0 top-0 h-[70%]">
                            <img src="{{ asset('storage/images/sales report.jpg') }}" alt="Sales Reports" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#EBFBFF] via-[#EBFBFF]/95 via-35% to-transparent"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-[35%] bg-[#EBFBFF]"></div>
                    </div>
                    
                    <div class="absolute inset-x-0 bottom-0 p-6 pb-7 flex flex-col justify-end z-10" style="transform-style: preserve-3d;">
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="40">
                            <h3 class="text-[#000066] text-[20px] font-circular-bold mb-1.5">Sales Reports</h3>
                        </div>
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-full" data-translate-z="60">
                            <p class="text-[#000066]/70 text-[13px] font-circular-book line-clamp-2 leading-relaxed mb-4">
                                Pantau pertumbuhan bisnis Anda melalui laporan penjualan otomatis yang akurat dan mudah dipahami.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="80">
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Accurate</span>
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Insightful</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-30 -mb-12 lg:-mb-24 bridge-cards">
            <!-- Card 4: Tracking -->
            <div class="aceternity-3d-card flex items-center justify-center relative w-full h-[380px]" style="perspective: 1000px;">
                <div class="aceternity-3d-body relative w-full h-full rounded-[32px] group/card bg-[#EBFBFF] shadow-xl shadow-[#000066]/5 transition-all duration-200 ease-linear" style="transform-style: preserve-3d;">
                    <div class="absolute inset-0 rounded-[32px] overflow-hidden border border-[#000066]/5">
                        <div class="absolute inset-x-0 top-0 h-[70%]">
                            <img src="{{ asset('storage/images/tracking.jpg') }}" alt="Tracking" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#EBFBFF] via-[#EBFBFF]/95 via-35% to-transparent"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-[35%] bg-[#EBFBFF]"></div>
                    </div>
                    
                    <div class="absolute inset-x-0 bottom-0 p-6 pb-7 flex flex-col justify-end z-10" style="transform-style: preserve-3d;">
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="40">
                            <h3 class="text-[#000066] text-[20px] font-circular-bold mb-1.5">Tracking</h3>
                        </div>
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-full" data-translate-z="60">
                            <p class="text-[#000066]/70 text-[13px] font-circular-book line-clamp-2 leading-relaxed mb-4">
                                Lacak status pengiriman dan pesanan secara real-time untuk memberikan transparansi penuh kepada pelanggan.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="80">
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Live Update</span>
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Transparent</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Chat -->
            <div class="aceternity-3d-card flex items-center justify-center relative w-full h-[380px]" style="perspective: 1000px;">
                <div class="aceternity-3d-body relative w-full h-full rounded-[32px] group/card bg-[#EBFBFF] shadow-xl shadow-[#000066]/5 transition-all duration-200 ease-linear" style="transform-style: preserve-3d;">
                    <div class="absolute inset-0 rounded-[32px] overflow-hidden border border-[#000066]/5">
                        <div class="absolute inset-x-0 top-0 h-[70%]">
                            <img src="{{ asset('storage/images/chat.jpg') }}" alt="Chat" class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110" />
                            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-[#EBFBFF] via-[#EBFBFF]/95 via-35% to-transparent"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-[35%] bg-[#EBFBFF]"></div>
                    </div>
                    
                    <div class="absolute inset-x-0 bottom-0 p-6 pb-7 flex flex-col justify-end z-10" style="transform-style: preserve-3d;">
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="40">
                            <h3 class="text-[#000066] text-[20px] font-circular-bold mb-1.5">Chat</h3>
                        </div>
                        <div class="aceternity-3d-item transition-transform duration-200 ease-linear w-full" data-translate-z="60">
                            <p class="text-[#000066]/70 text-[13px] font-circular-book line-clamp-2 leading-relaxed mb-4">
                                Terhubung langsung dengan pelanggan melalui integrasi pesan instan yang cepat, mudah, dan terintegrasi.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 aceternity-3d-item transition-transform duration-200 ease-linear w-fit" data-translate-z="80">
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Fast</span>
                            <span class="px-3.5 py-1.5 bg-[#000066]/5 rounded-full text-[#000066]/80 text-[11px] font-circular-medium border border-[#000066]/10">Integrated</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aceternity 3D Card Animation Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.aceternity-3d-card');
                
                cards.forEach(card => {
                    const body = card.querySelector('.aceternity-3d-body');
                    const items = card.querySelectorAll('.aceternity-3d-item');
                    let isMouseEntered = false;
                    
                    card.addEventListener('mousemove', (e) => {
                        if (!isMouseEntered) return;
                        const rect = card.getBoundingClientRect();
                        const x = (e.clientX - rect.left - rect.width / 2) / 25;
                        const y = (e.clientY - rect.top - rect.height / 2) / 25;
                        
                        body.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
                    });
                    
                    card.addEventListener('mouseenter', () => {
                        isMouseEntered = true;
                        items.forEach(item => {
                            const z = item.getAttribute('data-translate-z') || 50;
                            item.style.transform = `translateZ(${z}px)`;
                        });
                    });
                    
                    card.addEventListener('mouseleave', () => {
                        isMouseEntered = false;
                        body.style.transform = `rotateY(0deg) rotateX(0deg)`;
                        items.forEach(item => {
                            item.style.transform = `translateZ(0px)`;
                        });
                    });
                });
            });
        </script>
    </div>
</div>
