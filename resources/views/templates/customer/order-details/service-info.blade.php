<div class="space-y-8 animate-on-load">
    <h3 class="text-2xl font-black text-brand-dark tracking-tighter">Service Details</h3>
    <div class="premium-card p-10 divide-y divide-slate-50">
        <div class="py-8 first:pt-0 flex items-center justify-between group">
            <div class="flex items-center gap-8">
                <div class="detail-icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 flex-shrink-0">
                    {!! $current['icon'] !!}
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5 leading-none">Service Category</div>
                    <div class="text-xl font-bold text-brand-dark tracking-tight">{{ $current['service'] }}</div>
                </div>
            </div>
            <a href="#" class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em] hover:tracking-[0.3em] transition-all duration-300 flex items-center gap-2">
                View Page <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="py-8 flex items-center gap-8 group">
            <div class="detail-icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 flex-shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5 leading-none">Preferred Schedule</div>
                <div class="text-xl font-bold text-brand-dark tracking-tight underline decoration-brand-primary/30 underline-offset-8 decoration-2">Thursday, 16 January 2026</div>
            </div>
        </div>

        <div class="py-8 flex items-center gap-8 group">
            <div class="detail-icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 flex-shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5 leading-none">Target Window</div>
                <div class="text-xl font-bold text-brand-dark tracking-tight flex items-center gap-3">
                    10:00 - 14:00 
                    <span class="text-xs font-black bg-slate-100 text-slate-400 px-3 py-1 rounded-full uppercase tracking-widest">Est. Duration</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-2 font-bold italic font-georgia-italic">*Final duration after onsite assessment</p>
            </div>
        </div>
    </div>
</div>

<div class="premium-banner rounded-[3rem] p-10 flex items-center justify-between group overflow-hidden relative animate-on-load">
    <div class="absolute right-0 top-0 h-full w-40 bg-gradient-to-l from-brand-primary/5 to-transparent"></div>
    <div class="space-y-3 relative z-10">
        <div class="text-[10px] font-black text-brand-primary uppercase tracking-[0.3em] font-mono leading-none">Contract Estimate</div>
        <div class="text-4xl font-black text-brand-dark tracking-tighter">Rp 2.000.000 - Rp 3.000.000</div>
        <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold italic font-georgia-italic">
            <div class="w-1.5 h-1.5 rounded-full bg-slate-200"></div>
            Final quote will be provided after review
        </div>
    </div>
</div>

<div class="space-y-8 animate-on-load">
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-black text-brand-dark tracking-tighter">Site Documentation</h3>
        <button class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em] hover:tracking-[0.3em] transition-all">Expand Gallery (3)</button>
    </div>
    <div class="grid grid-cols-3 gap-8">
        @for($i=1; $i<=3; $i++)
        <div class="aspect-[4/3] bg-white border border-slate-100 rounded-[2.5rem] flex items-center justify-center text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] hover:border-brand-primary/20 hover:shadow-xl transition-all duration-500 cursor-pointer group">
            <span class="group-hover:scale-110 transition-transform">Photo {{ $i }}</span>
        </div>
        @endfor
    </div>
</div>
