@props(['count' => 0, 'notifications' => []])

<div {{ $attributes->merge(['class' => 'bg-white rounded-[2rem] p-8 border border-slate-100']) }}>
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-lg font-bold text-brand-dark tracking-tight">Notifikasi Terbaru</h3>
        @if($count > 0)
            <span class="w-6 h-6 rounded-full bg-brand-dark text-white text-[10px] font-black flex items-center justify-center">
                {{ $count }}
            </span>
        @endif
    </div>

    <div class="space-y-4">
        {{-- Jika ada data real dari database --}}
        @forelse($notifications as $notif)
            <div class="notification-item p-5 {{ $notif['is_read'] ? 'bg-white' : 'bg-slate-50/80' }} rounded-2xl border border-slate-100 relative group cursor-pointer hover:bg-slate-50 transition-colors">
                <div class="flex items-start gap-3">
                    <div @class([
                        'w-1.5 h-1.5 rounded-full mt-1.5 flex-shrink-0',
                        'bg-brand-primary' => !$notif['is_read'],
                        'bg-transparent border border-slate-200' => $notif['is_read']
                    ])></div>
                    <div class="space-y-1">
                        <p @class([
                            'text-xs leading-tight',
                            'font-bold text-brand-dark' => !$notif['is_read'],
                            'font-medium text-slate-500' => $notif['is_read']
                        ])>{{ $notif['message'] }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $notif['time'] }}</p>
                    </div>
                </div>
            </div>
        @empty
            {{-- Data Dummy (Sesuai kode asli Anda) jika $notifications kosong --}}
            <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-100 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">No notifications yet</p>
            </div>
        @endforelse
    </div>

    <a href="#" class="w-full mt-6 py-4 rounded-xl bg-slate-50 text-slate-600 text-[11px] font-black uppercase tracking-widest hover:bg-brand-dark hover:text-white transition-all flex items-center justify-center">
        Lihat Semua
    </a>
</div>