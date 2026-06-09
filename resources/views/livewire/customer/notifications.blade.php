<div class="max-w-3xl mx-auto py-6 animate-fade-in-up">

    {{-- Flash Message --}}
    @if(session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-lg text-sm font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2>
        </div>

        {{-- Action Buttons --}}
        @if($notifications->count() > 0)
        <div class="flex items-center gap-4">
            @if($unreadCount > 0)
            <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                Tandai semua dibaca
            </button>
            @endif
            <button wire:click="clearAll"
                    wire:confirm="Hapus SEMUA notifikasi? Tindakan ini tidak bisa dibatalkan."
                    class="text-sm text-red-600 hover:text-red-800 font-medium transition-colors">
                Bersihkan
            </button>
        </div>
        @endif
    </div>

    {{-- Notification List --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm" wire:poll.15s>
        @forelse($notifications as $notif)
            <div @class([
                'p-4 flex items-start gap-4 transition-colors',
                'border-b border-gray-100 last:border-0',
                'bg-white text-gray-500' => $notif->read_at,
                'bg-blue-50/30 text-gray-900' => !$notif->read_at,
            ])>
                {{-- Icon --}}
                <div @class([
                    'w-10 h-10 rounded-full flex items-center justify-center shrink-0',
                    'bg-gray-100 text-gray-500' => $notif->read_at,
                    'bg-blue-100 text-blue-600' => !$notif->read_at,
                ])>
                    @switch($notif->type)
                        @case('order_status')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            @break
                        @case('payment')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            @break
                        @case('invoice')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @break
                        @default
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @endswitch
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <h3 class="text-sm font-bold truncate">{{ $notif->title }}</h3>
                        <span class="text-xs text-gray-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $notif->message }}</p>

                    @if(!$notif->read_at)
                        <button wire:click="markAsRead({{ $notif->id }})" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            {{ $notif->link ? 'Lihat Detail & Tandai Dibaca' : 'Tandai Dibaca' }}
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-12 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 text-gray-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <p class="text-gray-900 font-medium text-sm">Tidak ada notifikasi</p>
                <p class="text-gray-500 text-xs mt-1">Anda sudah membaca semua pemberitahuan.</p>
            </div>
        @endforelse
    </div>
</div>
