<section id="home" class="relative w-full min-h-screen flex items-center justify-start overflow-hidden pt-20">
    <div class="absolute inset-0 w-full h-full">
        <video autoplay muted loop playsinline class="w-full h-full object-cover">
            <source src="{{ asset('storage/videos/hero.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-[#0A0A0A]/20 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <div class="flex flex-col gap-1 text-white mb-8 hero-text-anim">
                <span class="text-sm flex items-center gap-3 opacity-90 font-circular-bold">
                    <div class="w-6 h-6 bg-white/10 backdrop-blur-md rounded-md flex items-center justify-center border border-white/10">
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#38bdf8]"><path d="M12 2v20"/><path d="m17 7-5-5-5 5"/><path d="m17 17-5 5-5-5"/></svg>
                    </div>
                    Solusi UMKM Digital
                </span>
            </div>
            
            <h1 class="text-[64px] lg:text-[110px] leading-[0.9] tracking-tight text-white mb-10 hero-text-anim" style="font-weight: 500; font-family: 'Figtree', sans-serif;">
                Ubah Tantangan<br>
                Jadi <span class="relative inline-block text-white" 
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

            <p class="text-lg leading-relaxed text-gray-300 max-w-[650px] mb-12 hero-text-anim font-circular-book">
                Kami membantu UMKM Indonesia bertransformasi ke era digital. Dari strategi hingga eksekusi, kami membangun ekosistem yang mendorong pertumbuhan bisnis Anda ke level berikutnya.
            </p>

            <div class="flex flex-wrap items-center gap-6 hero-text-anim">
                <a href="{{ route('register') }}" class="bg-black/20 backdrop-blur-xl border border-white/10 text-white pl-8 pr-2 py-2 rounded-2xl text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-500 flex items-center gap-8 group shadow-2xl">
                    <span class="font-circular-book">Mulai Sekarang</span>
                    <div class="w-12 h-12 bg-[#0078b7] rounded-xl flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rounded-full shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 hero-text-anim">
        <span class="text-[10px] uppercase tracking-widest text-white font-medium" style="font-family: 'Figtree', sans-serif;">Scroll for more</span>
        <div class="w-[1px] h-12 bg-gradient-to-b from-white to-transparent"></div>
    </div>

    <div class="absolute bottom-10 right-10 z-20 hero-text-anim hidden lg:block">
        <div class="relative w-28 h-28 flex items-center justify-center">
            <div class="absolute inset-0 border border-white/20 rounded-full animate-[spin_10s_linear_infinite]">
                 <svg class="w-full h-full" viewBox="0 0 100 100">
                    <defs>
                        <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                    </defs>
                    <text class="text-[9.5px] uppercase tracking-[0.25em] fill-white opacity-40">
                        <textPath xlink:href="#circlePath">
                            Jasa Order Service &nbsp;&bull;&nbsp; Jasa Order Service &nbsp;&bull;&nbsp;
                        </textPath>
                    </text>
                </svg>
            </div>
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
            </div>
        </div>
    </div>
</section>
