@props(['order'])

<div {{ $attributes->merge(['class' => 'bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-primary/20 hover:shadow-xl hover:shadow-brand-primary/[0.03] hover:-translate-y-1 transition-all group']) }}>
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest font-mono">#{{ $order->invoice_number ?? 'ORD-' . $order->id }}</span>
                <div class="w-1 h-1 rounded-full bg-slate-200"></div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->umkm->name }}</span>
            </div>
            <h4 class="text-2xl font-bold text-brand-dark tracking-tight group-hover:text-brand-primary transition-colors">{{ $order->product->name }}</h4>
            
            {{-- Status Badge Dinamis --}}
            <div @class([
                'inline-flex items-center gap-2 px-3 py-1 rounded-full border',
                'bg-brand-primary/5 border-brand-primary/10' => in_array($order->status, ['waiting_payment', 'paid']),
                'bg-slate-50 border-slate-100' => !in_array($order->status, ['waiting_payment', 'paid'])
            ])>
                <div @class([
                    'w-1.5 h-1.5 rounded-full',
                    'bg-brand-primary animate-pulse' => $order->status === 'waiting_payment',
                    'bg-slate-300' => $order->status !== 'waiting_payment'
                ])></div>
                <span @class([
                    'text-[10px] font-bold uppercase tracking-wider',
                    'text-brand-primary' => in_array($order->status, ['waiting_payment', 'paid']),
                    'text-slate-500' => !in_array($order->status, ['waiting_payment', 'paid'])
                ])>
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-brand-dark">Rp {{ number_format($order->agreed_price, 0, ',', '.') }}</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                {{ $order->status === 'waiting_payment' ? 'Belum Dibayar' : 'Harga Total' }}
            </div>
        </div>
    </div>

    {{-- Info Box Khusus Waiting Payment --}}
    @if($order->status === 'waiting_payment')
        <div class="p-4 bg-slate-50 rounded-xl mb-8 flex items-center gap-4">
            <span class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-brand-primary shadow-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <p class="text-xs font-semibold text-slate-600">Admin telah mengirim pre-invoice. Silakan review sebelum melakukan pembayaran.</p>
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 pt-8 border-t border-slate-50">
        <div class="space-y-1">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jadwal Pakai</div>
            <div class="text-sm font-bold text-brand-dark">{{ \Carbon\Carbon::parse($order->booking_date)->format('d M Y') }}</div>
            @if($order->booking_time)
                <div class="text-xs text-brand-primary font-medium">{{ \Carbon\Carbon::parse($order->booking_time)->format('H:i') }} WIB</div>
            @endif
        </div>
        <div class="space-y-1">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Area Layanan</div>
            <div class="text-sm font-bold text-brand-dark">{{ $order->service_address ? Str::limit($order->service_address, 20) : 'Alamat belum diatur' }}</div>
        </div>
        <div class="col-span-2 md:col-span-1 flex items-center md:justify-end">
            @if($order->status === 'waiting_payment')
                <button class="w-full py-3 rounded-xl bg-brand-dark text-white text-xs font-bold hover:bg-brand-primary transition-all shadow-md shadow-brand-dark/10">
                    Review Pre-Invoice
                </button>
            @else
                <a href="#" class="px-6 py-3 rounded-xl border border-slate-200 text-xs font-bold text-brand-dark hover:bg-slate-50 transition-all flex items-center gap-2">
                    Detail Pesanan <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14l-7 7-7-7"/></svg>
                </a>
            @endif
        </div>
    </div>
</div>