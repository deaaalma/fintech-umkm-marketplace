<section id="faq" class="w-full py-24 px-8 bg-white faq-section" x-data="{ openIndex: null }">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-12 gap-16">
            <div class="lg:col-span-4">
                <h2 class="text-4xl lg:text-5xl leading-tight font-jakarta-bold text-[#003d5c] tracking-tight sticky top-24">
                    Frequently Asked <span class="text-[#0078b7] font-georgia-italic italic">Questions</span>
                </h2>
            </div>
            <div class="lg:col-span-8">
                <div class="space-y-2">
                    @php
                        $faqs = [
                            [
                                "q" => "Bagaimana cara mendaftar sebagai partner UMKM?",
                                "a" => "Klik tombol 'Gabung Sekarang', isi formulir pendaftaran dengan data usaha Anda, dan tim kami akan memverifikasi dalam 1x24 jam."
                            ],
                            [
                                "q" => "Apakah ada biaya pendaftaran?",
                                "a" => "Pendaftaran gratis! Kami menyediakan berbagai pilihan paketan transaksi yang bisa diambil oleh setiap UMKM, disesuaikan dengan volume transaksi usaha Anda."
                            ],
                            [
                                "q" => "Bagaimana sistem pembayarannya?",
                                "a" => "Sistem pembayaran saat ini dilakukan melalui QRIS yang nantinya akan diverifikasi secara langsung oleh admin untuk menjamin keamanan transaksi."
                            ]
                        ];
                    @endphp

                    @foreach($faqs as $index => $faq)
                    <div class="border-b border-[#e5e5e5] last:border-b-0 faq-item overflow-hidden">
                        <button @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}" 
                                class="w-full flex items-center justify-between py-8 text-left group hover:opacity-70 transition-all duration-300" 
                                :aria-expanded="openIndex === {{ $index }}">
                            <span class="text-xl leading-relaxed text-[#202020] pr-8 font-jakarta-bold transition-colors duration-300"
                                  :class="openIndex === {{ $index }} ? 'text-[#0078b7]' : ''">
                                {{ $faq['q'] }}
                            </span>
                            <div class="flex-shrink-0 w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]" 
                                 :class="openIndex === {{ $index }} ? 'rotate-[135deg] bg-[#0078b7] border-[#0078b7] text-white' : 'rotate-0 text-[#202020]'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </div>
                        </button>
                        <div class="faq-grid-transition" :class="openIndex === {{ $index }} ? 'open' : ''">
                            <div class="faq-grid-content">
                                <div class="pb-8 pr-12">
                                    <p class="text-lg leading-relaxed text-[#666666] font-jakarta">
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
