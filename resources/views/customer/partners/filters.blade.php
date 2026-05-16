<div class="mb-12 animate-on-load">
    <div class="flex flex-col lg:flex-row gap-8 items-start lg:items-center justify-between">
        <div class="flex flex-wrap gap-4">
            @foreach($categories as $cat)
            <button @click="activeCategory = '{{ $cat['id'] }}'"
                    :class="activeCategory === '{{ $cat['id'] }}' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/10' : 'bg-white text-slate-400 border border-slate-100 hover:border-brand-primary/20'"
                    class="px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>

        <div class="relative w-full lg:w-96 group">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-brand-primary transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <input type="text" 
                   x-model="search"
                   placeholder="Cari partner atau layanan..." 
                   class="w-full pl-14 pr-6 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-bold text-brand-dark focus:outline-none focus:border-brand-primary/30 transition-all shadow-sm">
        </div>
    </div>
</div>
