<div class="mb-12 flex flex-wrap gap-4 animate-on-load">
    @foreach($tabs as $tab)
    <button @click="changeTab('{{ $tab['id'] }}')"
            :class="activeTab === '{{ $tab['id'] }}' ? 'bg-brand-dark text-white border-brand-dark shadow-2xl shadow-brand-dark/20' : 'bg-white text-slate-400 border-slate-100 hover:border-brand-primary/20'"
            class="px-8 py-5 rounded-[2rem] border font-black text-[10px] uppercase tracking-[0.2em] transition-all flex items-center gap-4 group">
        <span>{{ $tab['label'] }}</span>
        <span :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white/20 text-white' : 'bg-slate-50 text-slate-400 group-hover:bg-brand-primary/10'" class="px-3 py-1 rounded-full text-[9px] font-black transition-colors">
            {{ $tab['count'] }}
        </span>
    </button>
    @endforeach
</div>
