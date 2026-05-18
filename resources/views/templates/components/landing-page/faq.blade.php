<section id="faq" class="w-full py-24 px-8 bg-white faq-section" x-data="{ openIndex: null }">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-12 gap-16">
            <div class="lg:col-span-4">
                <h2 class="text-4xl lg:text-[48px] leading-[1.1] font-bold text-[#000066] tracking-tight sticky top-24" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Frequently Asked Questions
                </h2>
            </div>
            <div class="lg:col-span-8">
                <div class="space-y-2">
                    @php
                        $faqs = [
                            [
                                "q" => "Bagaimana cara mendaftar sebagai partner UMKM?",
                                "a" => "Mulai langkah pertama dengan klik tombol 'Daftar' di navigasi atas. Isi formulir pendaftaran dengan data lengkap usaha Anda, dan tim kurasi kami akan melakukan verifikasi profil Anda dalam waktu maksimal 1x24 jam."
                            ],
                            [
                                "q" => "Apakah ada biaya pendaftaran untuk bergabung?",
                                "a" => "Pendaftaran di platform JOS sepenuhnya gratis! Kami berkomitmen mendukung UMKM Indonesia. Kami hanya menerapkan sistem bagi hasil yang kompetitif pada setiap transaksi yang berhasil dilakukan melalui platform."
                            ],
                            [
                                "q" => "Bagaimana keamanan sistem pembayarannya?",
                                "a" => "Semua transaksi diproses secara real-time menggunakan sistem QRIS yang terintegrasi. Dana pelanggan akan langsung masuk ke akun UMKM Anda setelah verifikasi sistem, menjamin transparansi dan keamanan bagi penjual maupun pembeli."
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                    <div class="border-b border-[#000066]/5 last:border-b-0 faq-item overflow-hidden">
                        <button @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}" 
                                class="w-full flex items-center justify-between py-8 text-left group hover:opacity-70 transition-all duration-300" 
                                :aria-expanded="openIndex === {{ $index }}">
                            <span class="text-xl leading-relaxed text-[#000066] pr-8 font-bold transition-colors duration-300"
                                  :class="openIndex === {{ $index }} ? 'text-[#0072BB]' : ''"
                                  style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $faq['q'] }}
                            </span>
                            <div class="flex-shrink-0 w-10 h-10 rounded-full border border-[#000066]/10 flex items-center justify-center transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] shadow-sm" 
                                 :class="openIndex === {{ $index }} ? 'rotate-[135deg] bg-[#0072BB] border-[#0072BB] text-white' : 'rotate-0 text-[#000066] bg-white'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </div>
                        </button>
                        <div class="faq-grid-transition" :class="openIndex === {{ $index }} ? 'open' : ''">
                            <div class="faq-grid-content">
                                <div class="pb-8 pr-12">
                                    <p class="text-lg leading-relaxed text-[#000066]/70 font-medium" style="font-family: 'Figtree', sans-serif;">
                                        {{ $faq['a'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>