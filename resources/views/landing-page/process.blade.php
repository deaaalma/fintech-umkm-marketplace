<section id="workflow" class="w-full bg-white relative pt-60 lg:pt-80 pb-20 px-6 lg:px-8 overflow-visible">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-start justify-between gap-12 lg:gap-20">
        
        <div class="w-full lg:w-[60%] space-y-32 pb-48">
            <div class="flex flex-col gap-4 mb-20 workflow-header">
                <div class="flex items-center gap-3">
                     <div class="w-10 h-0.5 bg-[#0078b7]"></div>
                     <h2 class="text-4xl lg:text-5xl font-jakarta-bold text-[#003d5c] tracking-tight">
                        How it <span class="font-georgia-italic italic text-[#0078b7]">Works</span>
                     </h2>
                </div>
                <p class="text-[#666666] text-lg leading-relaxed font-jakarta max-w-xl">
                    Ikuti langkah mudah berikut untuk mendigitalisasi dan mengembangkan bisnis UMKM Anda bersama kami.
                </p>
            </div>

            <div class="workflow-step-content opacity-100 transition-all duration-700" data-index="0">
                <div class="flex items-start gap-6">
                    <span class="text-3xl font-jakarta-bold text-[#003d5c] mt-1">01</span>
                    <div>
                        <h3 class="text-3xl font-jakarta-bold text-[#003d5c] mb-6">Pendaftaran Akun</h3>
                        <p class="text-lg text-[#666666] leading-relaxed font-jakarta max-w-lg">
                            Mulai langkah pertama dengan membuat profil UMKM Anda. Lengkapi data administrasi dasar dan identitas brand Anda untuk diverifikasi secara otomatis.
                        </p>
                    </div>
                </div>
            </div>

            <div class="workflow-step-content opacity-30 transition-all duration-700" data-index="1">
                <div class="flex items-start gap-6">
                    <span class="text-3xl font-jakarta-bold text-[#003d5c] mt-1">02</span>
                    <div>
                        <h3 class="text-3xl font-jakarta-bold text-[#003d5c] mb-6">Konfigurasi Toko</h3>
                        <p class="text-lg text-[#666666] leading-relaxed font-jakarta max-w-lg">
                            Atur tampilan landing page Anda. Unggah produk-produk terbaik, tentukan harga, dan pilih metode pembayaran serta logistik yang ingin Anda gunakan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="workflow-step-content opacity-30 transition-all duration-700" data-index="2">
                <div class="flex items-start gap-6">
                    <span class="text-3xl font-jakarta-bold text-[#003d5c] mt-1">03</span>
                    <div>
                        <h3 class="text-3xl font-jakarta-bold text-[#003d5c] mb-6">Manajemen Pesanan</h3>
                        <p class="text-lg text-[#666666] leading-relaxed font-jakarta max-w-lg">
                            Terima dan kelola pesanan masuk secara real-time. Dashboard kami memudahkan Anda melacak stok barang dan interaksi dengan pelanggan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="workflow-step-content opacity-30 transition-all duration-700" data-index="3">
                <div class="flex items-start gap-6">
                    <span class="text-3xl font-jakarta-bold text-[#003d5c] mt-1">04</span>
                    <div>
                        <h3 class="text-3xl font-jakarta-bold text-[#003d5c] mb-6">Analisis Pertumbuhan</h3>
                        <p class="text-lg text-[#666666] leading-relaxed font-jakarta max-w-lg">
                            Pantau laporan penjualan harian dan insight performa bisnis Anda. Gunakan data ini untuk mengambil keputusan cerdas dalam memperluas pasar.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex w-[32%] sticky top-[25vh] h-[40vh] items-center justify-center">
            <div class="relative w-full h-full overflow-visible" id="sticky-visual-box">
                <div class="workflow-mockup absolute inset-0 opacity-100 scale-100 transition-all duration-500" data-mockup="0">
                    <img src="{{ asset('storage/images/mockup.png') }}" alt="Step 1" class="w-full h-full object-cover">
                </div>

                <div class="workflow-mockup absolute inset-0 opacity-0 scale-95 transition-all duration-500" data-mockup="1">
                    <img src="{{ asset('storage/images/mockup.png') }}" alt="Step 2" class="w-full h-full object-cover">
                </div>

                <div class="workflow-mockup absolute inset-0 opacity-0 scale-95 transition-all duration-500" data-mockup="2">
                    <img src="{{ asset('storage/images/mockup.png') }}" alt="Step 3" class="w-full h-full object-cover">
                </div>

                <div class="workflow-mockup absolute inset-0 opacity-0 scale-95 transition-all duration-500" data-mockup="3">
                    <img src="{{ asset('storage/images/mockup.png') }}" alt="Step 4" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
