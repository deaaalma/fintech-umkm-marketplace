<div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-10">
    <div class="animate-on-load">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-brand-primary/5 rounded-full border border-brand-primary/10 mb-6 group cursor-default">
            <div class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse group-hover:scale-125 transition-transform duration-500"></div>
            <span class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em]">Pending Review</span>
        </div>
        <h1 class="text-6xl font-bold text-brand-dark tracking-tighter mb-4">{{ $current['id'] }}</h1>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] flex items-center gap-3">
            Created
            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
            <span class="text-brand-dark">{{ $steps[0]['date'] ?? 'Just Now' }}</span>
        </p>
    </div>
    <div class="flex gap-4 animate-on-load">
        <a href="{{ route('customer.chat.preview') }}" class="px-10 py-5 bg-brand-dark text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-3xl hover:bg-brand-primary transition-all duration-500 shadow-2xl shadow-brand-dark/20 flex items-center gap-4 group">
            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-12.7 8.19 8.19 0 0 1 4.9 1.5L22 3l-1.5 5.5a8.19 8.19 0 0 1 1.5 4.9z"/></svg>
            </div>
            Chat with Admin
        </a>
    </div>
</div>
