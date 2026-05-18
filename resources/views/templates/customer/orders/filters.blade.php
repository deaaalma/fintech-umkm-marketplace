<div class="mb-12 animate-on-load relative z-30">
    <div class="flex flex-row gap-2 lg:gap-4 mb-6 items-stretch">
        <div class="relative w-full transition-all duration-700 ease-in-out group order-1"
             :class="(showFilterMenu || search.length > 0) ? 'lg:w-full' : 'lg:w-[480px] hover:lg:w-[520px]'">
            <div class="absolute inset-y-0 left-3 lg:left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <input type="text" 
                   x-model="search"
                   @focus="currentPage = 1"
                   @input="currentPage = 1; $nextTick(() => animateTabs())"
                   placeholder="Cari pesanan atau layanan..." 
                   class="w-full pl-10 lg:pl-14 pr-3 lg:pr-6 py-3.5 lg:py-4 bg-white border border-slate-100 rounded-xl lg:rounded-2xl text-[11px] lg:text-[13px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:border-brand-primary/30 focus:ring-4 focus:ring-brand-primary/5 transition-all group-hover:shadow-xl group-hover:shadow-brand-primary/5">
        </div>

        <div class="relative order-2 flex-shrink-0" @click.away="showFilterMenu = false">
            <button @click="showFilterMenu = !showFilterMenu"
                    class="h-full px-4 lg:px-8 py-3.5 lg:py-4 bg-white border border-slate-100 rounded-xl lg:rounded-2xl text-[11px] lg:text-[13px] font-black text-brand-dark hover:bg-slate-50 transition-all flex items-center gap-2 lg:gap-3">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <span class="hidden sm:inline">Filter</span>
            </button>

            <div x-show="showFilterMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute right-0 mt-3 w-72 bg-white border border-slate-100 rounded-[2.2rem] shadow-2xl p-8 z-50">
                
                <div class="mb-8">
                    <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Rentang Tanggal</div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors z-10">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                        </div>
                        <input type="text" 
                               x-ref="dateInput"
                               placeholder="Pilih Tanggal"
                               class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-transparent rounded-xl text-[12px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:bg-white focus:border-brand-primary/20 transition-all cursor-pointer">
                    </div>
                </div>

                <div class="mb-2">
                    <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Urutkan Status</div>
                    <div class="space-y-1.5">
                        <template x-for="status in ['Review Admin', 'Dalam Proses', 'Selesai']">
                            <button @click="statusFilter = status; showFilterMenu = false; $nextTick(() => animateTabs())"
                                    class="w-full text-left px-4 py-3 rounded-xl text-[12px] font-bold transition-all"
                                    :class="statusFilter === status ? 'bg-brand-primary/5 text-brand-primary' : 'text-slate-400 hover:bg-slate-50 hover:text-brand-dark'"
                                    x-text="status"></button>
                        </template>
                        <button @click="statusFilter = ''; showFilterMenu = false; $nextTick(() => animateTabs())"
                                class="w-full text-left px-4 py-3 rounded-xl text-[12px] font-bold text-slate-300 hover:bg-slate-50 transition-all italic">Reset Status</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mt-4" x-show="activeFilters.length > 0">
        <template x-for="filter in activeFilters" :key="filter.id">
            <div class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 rounded-2xl text-[12px] font-bold text-slate-500 shadow-sm">
                <span x-text="filter.label"></span>
                <button @click="clearFilter(filter.id)" class="text-brand-primary hover:text-brand-dark transition-colors pl-2">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </template>
        <button @click="clearFilter('date'); statusFilter = ''; search = ''; $nextTick(() => animateTabs())" 
                class="px-6 py-3 text-[12px] font-black uppercase tracking-widest text-brand-primary hover:text-brand-dark transition-all">Clear All Filters</button>
    </div>
</div>
