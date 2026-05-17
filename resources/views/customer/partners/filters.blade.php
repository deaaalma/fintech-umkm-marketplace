<div class="mb-12 animate-on-load">
    <div class="flex flex-col-reverse lg:flex-row gap-6 lg:gap-8 items-stretch lg:items-center justify-between">
        <div class="flex flex-row overflow-x-auto gap-3 lg:gap-4 pb-2 lg:pb-0 scrollbar-hide snap-x">
            @foreach($categories as $cat)
            <button @click="activeCategory = '{{ $cat['id'] }}'"
                    :class="activeCategory === '{{ $cat['id'] }}' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/10' : 'bg-white text-slate-400 border border-slate-100 hover:border-brand-primary/20'"
                    class="px-6 lg:px-8 py-3 rounded-xl lg:rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all whitespace-nowrap snap-start flex-shrink-0">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>

        <div class="relative w-full lg:w-96 group flex-shrink-0">
            <div class="absolute inset-y-0 left-4 lg:left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <input type="text" 
                   x-model="search"
                   placeholder="Cari partner atau layanan..." 
                   class="w-full pl-10 lg:pl-14 pr-4 lg:pr-6 py-3.5 lg:py-4 bg-white border border-slate-100 rounded-xl lg:rounded-2xl text-[11px] lg:text-[13px] font-bold text-brand-dark placeholder:text-slate-300 focus:outline-none focus:border-brand-primary/30 focus:ring-4 focus:ring-brand-primary/5 transition-all shadow-sm group-hover:shadow-xl group-hover:shadow-brand-primary/5">
        </div>
    </div>
</div>
