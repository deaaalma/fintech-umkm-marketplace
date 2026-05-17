<div class="premium-banner rounded-[3rem] p-10 mb-16 flex items-start gap-8 animate-on-load">
    <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-brand-primary shadow-xl shadow-brand-primary/10 flex-shrink-0 floating-action">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
    </div>
    <div class="space-y-4">
        <h3 class="text-brand-dark font-black text-2xl tracking-tight italic font-georgia-italic">What's happening now?</h3>
        <p class="text-slate-600 text-base leading-relaxed max-w-2xl">Your order is being reviewed by our expert team at <span class="text-brand-dark font-bold underline decoration-brand-primary/20 underline-offset-4">{{ $current['provider'] }}</span>. We'll finalize the details and send you a custom proposal shortly.</p>
        <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pt-2">
            <div class="w-8 h-[1px] bg-slate-200"></div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Estimated review time: 1-2 working hours
        </div>
    </div>
</div>
