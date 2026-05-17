<div class="space-y-12 animate-on-load">
    <div class="space-y-8">
         <h3 class="text-xl font-black text-brand-dark tracking-tighter">Location</h3>
         <div class="premium-card p-10 space-y-8 group">
            <div class="flex items-start gap-6">
                <div class="detail-icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 flex-shrink-0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2 leading-none">Property Address / Platform</div>
                    <div class="text-sm font-bold text-brand-dark leading-relaxed whitespace-pre-line">{{ $current['location'] }}</div>
                </div>
            </div>
            <button class="w-full py-5 border border-slate-100 text-[10px] font-black uppercase tracking-[0.2em] text-brand-dark rounded-[2rem] hover:bg-brand-dark hover:text-white hover:border-brand-dark transition-all duration-500 flex items-center justify-center gap-3 group">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="group-hover:rotate-12 transition-transform"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Open in Maps / View Link
            </button>
         </div>
    </div>

    <div class="space-y-8">
         <h3 class="text-xl font-black text-brand-dark tracking-tighter">Specific Instructions</h3>
         <div class="premium-card p-10">
            <div class="flex items-start gap-6">
                <div class="detail-icon-box w-14 h-14 rounded-2xl flex items-center justify-center text-slate-400 flex-shrink-0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="flex-1">
                     <div class="text-sm text-slate-500 leading-relaxed bg-slate-50 p-6 rounded-[2rem] italic font-georgia-italic relative">
                        <div class="absolute -top-3 -left-2 text-4xl text-brand-primary/20 font-serif">“</div>
                        "{{ $current['note'] }}"
                     </div>
                </div>
            </div>
         </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-3xl p-6 text-center shadow-lg shadow-brand-dark/[0.02]">
        <p class="text-xs font-medium text-slate-400 mb-2">Need help with your order?</p>
        <a href="#" class="text-xs font-black text-brand-primary uppercase tracking-widest hover:underline transition-all">Contact Support</a>
    </div>
</div>
