<section id="home" class="relative w-full min-h-screen flex items-center justify-start overflow-hidden pt-20 hero-section">
    <div class="absolute inset-0 w-full h-full">
        <video autoplay muted loop playsinline class="w-full h-full object-cover">
            <source src="{{ asset('storage/videos/hero.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-[#C5EBF4]/75 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#C5EBF4] via-[#C5EBF4]/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#C5EBF4] via-transparent to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <h1 class="text-[48px] lg:text-[84px] leading-[1.1] tracking-tight text-[#000066] mb-10 hero-text-anim" style="font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; text-shadow: 0 2px 40px rgba(197, 235, 244, 0.8);">
                Ubah Tantangan<br>
                Jadi <span class="relative inline-block text-[#0072BB]" 
                    x-data="{
                        words: ['Peluang Baru', 'Ekosistem Digital', 'Pasar Global', 'Bisnis Modern'],
                        current: 0,
                        init() {
                            setInterval(() => {
                                this.current = (this.current + 1) % this.words.length;
                            }, 3000);
                        }
                    }">
                    <template x-for="(word, index) in words" :key="index">
                        <span x-text="word" 
                              class="absolute top-0 left-0 transition-all duration-700 transform whitespace-nowrap font-georgia-italic"
                              :class="{
                                  'opacity-100 translate-y-0': current === index,
                                  'opacity-0 translate-y-12': current !== index
                              }"
                        ></span>
                    </template>
                    <span class="opacity-0 font-georgia-italic">Peluang Baru</span>
                </span>
            </h1>

            <p class="text-xl leading-relaxed text-[#000066] max-w-[650px] mb-12 hero-text-anim" style="font-family: 'Figtree', sans-serif; font-weight: 500;">
                Membantu UMKM Indonesia berkembang di dunia digital.<br class="hidden lg:block">
                Jual produk Anda, kelola toko dengan mudah, dan jangkau lebih banyak pelanggan melalui satu platform marketplace.
            </p>

            <div class="flex flex-wrap items-center gap-6 hero-text-anim">
                <a href="{{ route('register') }}" class="bg-[#000066] text-white px-8 py-3 rounded-2xl text-lg font-semibold transition-all duration-500 flex items-center gap-0 hover:gap-8 border border-[#000066]/20 hover:bg-[#000066]/90 group shadow-2xl backdrop-blur-sm">
                    <span style="font-family: 'Figtree', sans-serif;">Mulai Sekarang</span>
                    <div class="w-0 opacity-0 group-hover:w-12 group-hover:opacity-100 transition-all duration-500 overflow-hidden">
                        <div class="w-12 h-12 bg-[#00ADEF] rounded-xl flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rounded-full shadow-lg shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 scroll-indicator">
        <span class="text-[10px] uppercase tracking-widest text-[#000066] font-medium" style="font-family: 'Figtree', sans-serif;">Scroll for more</span>
        <div class="w-[1px] h-12 bg-gradient-to-b from-[#000066] to-transparent"></div>
    </div>

    <div class="absolute bottom-10 right-10 z-20 hero-text-anim hidden lg:block">
        <div class="relative w-28 h-28 flex items-center justify-center">
            <div class="absolute inset-0 border border-[#000066]/20 rounded-full animate-[spin_10s_linear_infinite]">
                 <svg class="w-full h-full" viewBox="0 0 100 100">
                    <defs>
                        <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                    </defs>
                    <text class="text-[9.5px] uppercase tracking-[0.25em] fill-[#000066] opacity-40">
                        <textPath xlink:href="#circlePath">
                            Jasa Order Service &nbsp;&bull;&nbsp; Jasa Order Service &nbsp;&bull;&nbsp;
                        </textPath>
                    </text>
                </svg>
            </div>
            <div class="w-12 h-12 bg-[#000066] rounded-2xl flex items-center justify-center shadow-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
            </div>
        </div>
    </div>
</section>