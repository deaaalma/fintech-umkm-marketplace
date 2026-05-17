<div class="flex items-center justify-between mb-8">
    <h2 class="text-3xl font-black text-brand-dark tracking-tighter">Recent Activities</h2>
    <a href="{{ route('templates.customer.orders.preview') }}" class="text-xs font-bold text-brand-primary uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2">
        View All <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
    </a>
</div>

<div class="space-y-6">
    <!-- Simplified Order Card 1 -->
    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-primary/20 transition-all group">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest font-mono">#BWP-2026-0001</span>
                    <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">BWP Cleaning Service</span>
                </div>
                <h4 class="text-2xl font-bold text-brand-dark tracking-tight group-hover:text-brand-primary transition-colors">Deep Cleaning Service</h4>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Menunggu Review Admin</span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold text-brand-dark">Rp 2.500.000</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga Total</div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 py-8 border-t border-slate-50">
            <div class="space-y-1">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jadwal Pakai</div>
                <div class="text-sm font-bold text-brand-dark">16 Jan 2026</div>
                <div class="text-xs text-brand-primary font-medium">10:00 WIB</div>
            </div>
            <div class="space-y-1">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Area Layanan</div>
                <div class="text-sm font-bold text-brand-dark">Denpasar, Bali</div>
            </div>
            <div class="col-span-2 md:col-span-1 flex items-center md:justify-end">
                <a href="{{ route('templates.customer.order-details.preview') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-brand-dark hover:bg-slate-50 transition-all flex items-center gap-2">
                    Detail Pesanan <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Simplified Order Card 2 -->
    <div class="bg-white rounded-[2rem] p-8 border border-slate-100/50 hover:border-brand-primary/20 hover:shadow-xl hover:shadow-brand-primary/[0.03] hover:-translate-y-1 transition-all group">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest font-mono">#ABC-2026-0042</span>
                    <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SecureLocal JOS</span>
                </div>
                <h4 class="text-2xl font-bold text-brand-dark tracking-tight group-hover:text-brand-primary transition-colors">Office Cleaning Service</h4>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-brand-primary/5 rounded-full border border-brand-primary/10">
                    <div class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></div>
                    <span class="text-[10px] font-bold text-brand-primary uppercase tracking-wider">Perlu Tindakan Anda</span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold text-brand-dark">Rp 3.200.000</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Belum Dibayar</div>
            </div>
        </div>

        <div class="p-4 bg-slate-50 rounded-xl mb-8 flex items-center gap-4">
            <span class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-brand-primary shadow-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <p class="text-xs font-semibold text-slate-600">Admin telah mengirim pre-invoice. Silakan review sebelum melakukan pembayaran.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 pt-8 border-t border-slate-50">
            <div class="space-y-1">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Target Kerja</div>
                <div class="text-sm font-bold text-brand-dark">18 Jan 2026</div>
            </div>
            <div class="space-y-1">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi Proyek</div>
                <div class="text-sm font-bold text-brand-dark">Uluwatu, Bali</div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <button class="w-full py-3 rounded-xl bg-brand-dark text-white text-xs font-bold hover:bg-brand-primary transition-all shadow-md shadow-brand-dark/10">
                    Review Pre-Invoice
                </button>
            </div>
        </div>
    </div>
</div>
