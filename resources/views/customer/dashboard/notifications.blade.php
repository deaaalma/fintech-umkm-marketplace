<div class="bg-white rounded-[2rem] p-8 border border-slate-100">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-lg font-bold text-brand-dark tracking-tight">Notifikasi Terbaru</h3>
        <span class="w-6 h-6 rounded-full bg-brand-dark text-white text-[10px] font-black flex items-center justify-center">3</span>
    </div>

    <div class="space-y-4">
        <div class="notification-item p-5 bg-slate-50/80 rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
            <div class="flex items-start gap-3">
                <div class="w-1.5 h-1.5 rounded-full bg-brand-primary mt-1.5 flex-shrink-0"></div>
                <div class="space-y-1">
                    <p class="text-xs font-bold text-brand-dark leading-tight">Pre-invoice dikirim untuk pesanan #BWP-2026-0001</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">5 menit lalu</p>
                </div>
            </div>
        </div>

        <div class="notification-item p-5 bg-slate-50/80 rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
            <div class="flex items-start gap-3">
                <div class="w-1.5 h-1.5 rounded-full bg-brand-primary mt-1.5 flex-shrink-0"></div>
                <div class="space-y-1">
                    <p class="text-xs font-bold text-brand-dark leading-tight">Pembayaran dikonfirmasi #XYZ-2026-0033</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">2 jam lalu</p>
                </div>
            </div>
        </div>

        <div class="notification-item p-5 bg-white rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
            <div class="flex items-start gap-3">
                <div class="w-1.5 h-1.5 rounded-full bg-transparent border border-slate-200 mt-1.5 flex-shrink-0"></div>
                <div class="space-y-1">
                    <p class="text-xs font-medium text-slate-500 leading-tight">Staff ditugaskan ke pesanan Anda</p>
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">1 hari lalu</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('customer.notifications.preview') }}" class="w-full mt-6 py-4 rounded-xl bg-slate-50 text-slate-600 text-[11px] font-black uppercase tracking-widest hover:bg-brand-dark hover:text-white transition-all flex items-center justify-center">
        Lihat Semua
    </a>
</div>
