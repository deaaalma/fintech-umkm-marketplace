<div class="max-w-4xl mx-auto space-y-8 animate-fade-in-up">

    {{-- Flash Message --}}
    @if(session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="flex items-center gap-3 px-5 py-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 px-1">
        <div>
            <h2 class="text-3xl font-black text-[#000B44] font-plus tracking-tight mb-1">Pusat Notifikasi</h2>
            <p class="text-slate-500 font-semibold text-sm">
                @if($unreadCount > 0)
                    <span class="text-[#0077B6]">{{ $unreadCount }} notifikasi belum dibaca</span>
                @else
                    Semua notifikasi sudah dibaca
                @endif
            </p>
        </div>

        {{-- Action Buttons --}}
        @if($notifications->count() > 0)
        <div class="flex items-center gap-3 flex-wrap">
            @if($unreadCount > 0)
            <button wire:click="markAllAsRead"
                    class="flex items-center gap-2 px-5 py-2.5 bg-[#000B44] text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#001166] transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
            @endif
            <button wire:click="clearRead"
                    wire:confirm="Hapus semua notifikasi yang sudah dibaca?"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Yg Dibaca
            </button>
            <button wire:click="clearAll"
                    wire:confirm="Hapus SEMUA notifikasi? Tindakan ini tidak bisa dibatalkan."
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-red-200 text-red-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-50 transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                Hapus Semua
            </button>
        </div>
        @endif
    </div>

    {{-- Notification List --}}
    <div class="space-y-3" wire:poll.15s>
        @forelse($notifications as $notif)
            <div @class([
                'relative overflow-hidden bg-white p-5 rounded-2xl border transition-all group flex items-start gap-5',
                'border-slate-100 shadow-sm hover:shadow-md opacity-80' => $notif->read_at,
                'border-blue-100 shadow-blue-900/5 ring-1 ring-blue-50 hover:shadow-blue-900/10' => !$notif->read_at,
            ])>
                {{-- Status Indicator Line --}}
                @if(!$notif->read_at)
                    <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-[#0077B6] rounded-r-full"></div>
                @endif

                {{-- Icon --}}
                <div @class([
                    'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border transition-all',
                    'bg-slate-50 text-slate-400 border-slate-100' => $notif->read_at,
                    'bg-blue-50 text-[#0077B6] border-blue-100 group-hover:scale-110' => !$notif->read_at,
                ])>
                    @switch($notif->type)
                        @case('order_status')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            @break
                        @case('payment')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            @break
                        @case('invoice')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            @break
                        @default
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                    @endswitch
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0 space-y-1.5">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-1">
                        <h3 @class([
                            'text-sm font-black font-plus leading-tight',
                            'text-[#000B44]' => !$notif->read_at,
                            'text-slate-500' => $notif->read_at,
                        ])>{{ $notif->title }}</h3>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap bg-slate-50 px-2.5 py-1 rounded-full">
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p @class([
                        'text-sm leading-relaxed',
                        'text-slate-600 font-semibold' => !$notif->read_at,
                        'text-slate-400 font-medium' => $notif->read_at,
                    ])>{{ $notif->message }}</p>

                    <div class="pt-1 flex items-center gap-4">
                        @if(!$notif->read_at)
                            <button wire:click="markAsRead({{ $notif->id }})"
                                    class="text-xs font-black uppercase tracking-widest text-[#0077B6] hover:text-[#000B44] underline decoration-2 underline-offset-4 transition-all">
                                {{ $notif->link ? '→ Buka Detail' : '✓ Tandai Dibaca' }}
                            </button>
                        @else
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Sudah Dibaca
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white py-24 rounded-3xl border border-dashed border-slate-200 text-center space-y-4">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="space-y-1">
                    <p class="text-[#000B44] font-black text-lg">Hening Sekali...</p>
                    <p class="text-slate-400 font-medium text-sm">Belum ada notifikasi untuk Anda saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Unread Count Footer --}}
    @if($notifications->count() > 0)
    <div class="text-center py-2">
        <p class="text-xs text-slate-400 font-medium">
            Menampilkan {{ $notifications->count() }} notifikasi &bull; Diperbarui otomatis setiap 15 detik
        </p>
    </div>
    @endif
</div>
