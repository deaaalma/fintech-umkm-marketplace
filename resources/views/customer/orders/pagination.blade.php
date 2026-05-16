<div x-show="totalPages > 1" class="mt-16 flex items-center justify-center gap-2 animate-on-load">
    <button @click="currentPage--" 
            :disabled="currentPage === 1"
            :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:border-brand-primary/20 hover:bg-slate-50'"
            class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 transition-all">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
    </button>

    <div class="flex items-center gap-2">
        <template x-for="p in totalPages" :key="p">
            <button @click="currentPage = p; $nextTick(() => animateTabs())"
                    :class="currentPage === p ? 'bg-brand-dark text-white border-brand-dark shadow-lg shadow-brand-dark/20' : 'bg-white text-brand-dark border-slate-100 hover:bg-slate-50'"
                    class="w-12 h-12 rounded-2xl border font-bold text-xs transition-all"
                    x-text="p">
            </button>
        </template>
    </div>

    <button @click="currentPage++" 
            :disabled="currentPage === totalPages"
            :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:border-brand-primary/20 hover:bg-slate-50'"
            class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center text-slate-400 transition-all">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
    </button>
</div>
