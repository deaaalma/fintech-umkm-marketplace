<div class="max-w-4xl mx-auto space-y-8 animate-fade-in-up">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-2">
        <div>
            <h2 class="text-3xl font-black text-slate-900 font-plus tracking-tight mb-1">Pusat Notifikasi</h2>
            <p class="text-slate-500 font-semibold text-sm">Kelola semua informasi dan tugas terbaru kamu.</p>
        </div>
        <button wire:click="markAllAsRead" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            Tandai Semua Dibaca
        </button>
    </div>

    {{-- Notification List --}}
    <div class="space-y-4">
        @forelse($notifications as $notif)
            <div @class([
                'relative overflow-hidden bg-white p-6 rounded-[32px] border transition-all group flex items-start gap-6',
                'border-slate-100 shadow-sm hover:shadow-md' => $notif->read_at,
                'border-blue-100 shadow-blue-900/5 ring-1 ring-blue-50 hover:shadow-blue-900/10' => !$notif->read_at,
            ])>
                {{-- Status Indicator Line --}}
                @if(!$notif->read_at)
                    <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-[#0077B6] rounded-r-full"></div>
                @endif

                {{-- Icon --}}
                <div @class([
                    'w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 border transition-all',
                    'bg-slate-50 text-slate-400 border-slate-100' => $notif->read_at,
                    'bg-blue-50 text-[#0077B6] border-blue-100 group-hover:scale-110' => !$notif->read_at,
                ])>
                    @if($notif->type === 'order_status')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    @elseif($notif->type === 'info')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 space-y-2">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                        <h3 @class([
                            'text-lg font-black font-plus leading-tight',
                            'text-slate-900' => !$notif->read_at,
                            'text-slate-600' => $notif->read_at,
                        ])>{{ $notif->title }}</h3>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap bg-slate-50 px-3 py-1 rounded-full">{{ $notif->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <p @class([
                        'text-sm leading-relaxed max-w-2xl',
                        'text-slate-600 font-semibold' => !$notif->read_at,
                        'text-slate-500 font-medium' => $notif->read_at,
                    ])>{{ $notif->message }}</p>
                    
                    <div class="pt-2 flex items-center gap-4">
                        <button wire:click="markAsRead({{ $notif->id }})" 
                                class="text-xs font-black uppercase tracking-widest transition-all {{ $notif->read_at ? 'text-slate-400 cursor-default' : 'text-[#0077B6] hover:text-[#000B44] underline decoration-2 underline-offset-4' }}"
                                {{ $notif->read_at ? 'disabled' : '' }}>
                            {{ $notif->read_at ? 'Sudah Dibaca' : ($notif->link ? 'Buka Detail' : 'Tandai Dibaca') }}
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white py-24 rounded-[48px] border border-dashed border-slate-200 text-center space-y-4">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="space-y-1">
                    <p class="text-slate-900 font-black text-lg">Hening Sekali...</p>
                    <p class="text-slate-400 font-medium text-sm">Belum ada notifikasi baru untuk kamu saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
