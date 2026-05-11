<div class="space-y-6 min-h-[600px]" id="orders-container">
    <template x-for="order in paginatedOrders" :key="order.id">
        <div class="order-item bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-primary/15 transition-all group overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] font-mono" x-text="'ORDER ID: #' + order.id"></span>
                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]" x-text="order.date"></span>
            </div>

            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h4 class="text-3xl font-bold text-brand-dark tracking-tight mb-2 group-hover:text-brand-primary transition-colors" x-text="order.service"></h4>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="order.status"></p>
                </div>
                <a :href="'{{ route('customer.order-details.preview') }}?type=' + (order.id.startsWith('WEB') ? 'website' : (order.id.startsWith('SKR') ? 'skripsi' : 'cleaning'))" 
                   class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em] hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                    Lihat Detail <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <template x-if="order.type === 'action_required'">
                <div class="mb-8 p-6 bg-slate-50 border border-slate-100/50 rounded-[1.5rem] flex items-start gap-4 ring-1 ring-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-primary"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-500 leading-relaxed" x-text="order.alert"></p>
                </div>
            </template>

            <template x-if="order.type === 'in_progress'">
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-2 text-xs font-black text-brand-dark uppercase tracking-widest">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-brand-primary"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Pembayaran dikonfirmasi
                        </div>
                        <span class="text-xs font-black text-slate-400" x-text="order.progress + '%'"></span>
                    </div>
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-dark rounded-full transition-all duration-1000" :style="'width: ' + order.progress + '%'"></div>
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-10 border-b border-slate-50">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal & Waktu</div>
                        <div class="text-sm font-bold text-brand-dark" x-text="order.target_date"></div>
                        <div class="text-xs font-bold text-slate-400" x-text="order.time"></div>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</div>
                        <div class="text-sm font-bold text-brand-dark" x-text="order.location"></div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-[11px] font-medium text-slate-400">
                    Penyedia Jasa: <span class="text-brand-dark font-black" x-text="order.provider"></span>
                </div>
                
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <template x-if="order.type === 'action_required'">
                        <button class="flex-1 sm:flex-none px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                            Review Pre-Invoice
                        </button>
                    </template>
                    <template x-if="order.type === 'in_progress'">
                         <button class="flex-1 sm:flex-none px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                            Track Progress
                        </button>
                    </template>
                    <template x-if="order.type === 'completed'">
                        <button class="px-8 py-4 bg-brand-dark text-white rounded-[1rem] text-xs font-bold hover:shadow-xl hover:shadow-brand-dark/20 transition-all">
                            Pesan Lagi
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </template>

    <div x-show="filteredOrders.length === 0" class="py-20 text-center animate-on-load">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-300"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        </div>
        <h3 class="text-lg font-bold text-brand-dark mb-2">Tidak ada pesanan ditemukan</h3>
        <p class="text-slate-400 text-sm">Coba cari dengan kata kunci lain atau filter berbeda.</p>
    </div>
</div>
