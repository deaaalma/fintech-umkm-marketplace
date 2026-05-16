<div class="space-y-10 animate-on-load">
    <h3 class="text-2xl font-black text-brand-dark tracking-tighter">Activity Timeline</h3>
    <div class="space-y-12 pl-10 border-l-[3px] border-slate-100 ml-5">
        <div class="relative">
            <div class="absolute -left-[3.25rem] top-0 w-8 h-8 rounded-2xl bg-brand-dark text-white flex items-center justify-center shadow-lg shadow-brand-dark/20 ring-8 ring-white">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 2v20"/><path d="M2 12h20"/></svg>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em]">Initial Creation</span>
                    <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400">14 Jan, 15:30</span>
                </div>
                <div class="text-lg font-bold text-brand-dark">Order initiated by Ahmad Santoso</div>
                <p class="text-sm text-slate-500 leading-relaxed max-w-lg">The request for {{ $current['service'] }} ({{ $current['id'] }}) has been logged and queued for professional review.</p>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -left-[3.25rem] top-0 w-8 h-8 rounded-2xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center shadow-sm ring-8 ring-white group hover:border-brand-primary transition-colors">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">System Update</span>
                    <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400">14 Jan, 15:38</span>
                </div>
                <div class="text-lg font-bold text-brand-dark tracking-tight">Status: Awaiting Expert Review</div>
                <p class="text-sm text-slate-500 leading-relaxed max-w-lg">The detailed documentation has been shared with the operations team for resource allocation.</p>
            </div>
        </div>
    </div>
</div>
