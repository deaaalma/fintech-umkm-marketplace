<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
    <template x-for="partner in allPartners.filter(p => (activeCategory === 'semua' || p.category === activeCategory) && p.name.toLowerCase().includes(search.toLowerCase()))">
        <div class="partner-card bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden group">
            <div class="relative h-64 overflow-hidden">
                <img :src="partner.img" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 partner-img-overlay opacity-60"></div>
                
                <div class="absolute top-5 right-5" x-show="partner.verified">
                    <div class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-2 shadow-xl">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-primary"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-[9px] font-black text-brand-dark uppercase tracking-widest">Verified</span>
                    </div>
                </div>

                <div class="absolute bottom-5 left-5 right-5 flex items-center justify-between">
                    <div class="flex items-center gap-2 bg-brand-dark/30 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10 text-white">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="text-[10px] font-black" x-text="partner.rating"></span>
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-4">
                <div class="space-y-1">
                    <div class="text-[9px] font-black text-brand-primary uppercase tracking-[0.2em]" x-text="partner.category"></div>
                    <h4 class="text-xl font-bold text-brand-dark tracking-tight" x-text="partner.name"></h4>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed font-medium" x-text="partner.desc"></p>
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400" x-text="partner.reviews + ' Reviews'"></span>
                    <button class="px-6 py-2.5 bg-brand-primary/5 text-brand-primary rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-brand-primary hover:text-white transition-all shadow-sm">
                        Request Quote
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
