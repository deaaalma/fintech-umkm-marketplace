@props(['title'])

<header class="px-8 lg:px-12 py-8 flex flex-col sm:flex-row justify-between items-center bg-[#F8FAFC]/50 backdrop-blur-xl sticky top-0 z-40 transition-all duration-300 border-b border-slate-100/50">
    <div class="mb-4 sm:mb-0 text-left w-full sm:w-auto">
        <h2 class="text-3xl font-black text-[#000B44] font-plus tracking-tight">{{ $title }}</h2>
        @if(request()->routeIs('umkm.dashboard'))
        <p class="text-slate-400 font-medium text-base mt-1">Hello, <span class="text-[#0077B6] font-bold">{{ auth()->user()->name }}</span></p>
        @endif
    </div>
    
    <div class="flex items-center justify-end w-full sm:w-auto gap-4">
        @php
            $unreadNotifications = \App\Models\UserNotification::where('user_id', auth()->id())->whereNull('read_at')->count();
            $recentNotifications = \App\Models\UserNotification::where('user_id', auth()->id())->latest()->take(5)->get();
        @endphp

        @unless(request()->routeIs('umkm.notifications'))
        <!-- Notification Dropdown -->
        <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
            <button @click="openNotif = !openNotif" class="w-12 h-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all group relative {{ request()->routeIs('umkm.notifications') ? 'border-[#0077B6] bg-slate-50 shadow-sm' : '' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('umkm.notifications') ? 'text-[#0077B6]' : 'text-slate-400 group-hover:text-[#000B44]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if($unreadNotifications > 0)
                <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div x-show="openNotif" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                 class="absolute right-0 mt-3 w-96 bg-white border border-slate-100 rounded-2xl shadow-2xl shadow-slate-900/10 z-[70] overflow-hidden"
                 x-cloak>
                 
                {{-- Dropdown Header --}}
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                    <div class="flex items-center gap-2.5">
                        <h4 class="text-sm font-black text-[#000B44] font-plus">Notifikasi</h4>
                        @if($unreadNotifications > 0)
                            <span class="px-2 py-0.5 bg-red-500 text-white text-[10px] font-black rounded-full">{{ $unreadNotifications }}</span>
                        @endif
                    </div>
                    <a href="{{ route('umkm.notifications') }}" wire:navigate
                       class="text-[11px] font-black text-[#0077B6] hover:text-[#000B44] uppercase tracking-widest transition-colors">
                        Lihat Semua →
                    </a>
                </div>

                {{-- Notification Items --}}
                <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                    @forelse($recentNotifications as $notif)
                        <div @class([
                            'flex items-start gap-3 px-4 py-3.5 hover:bg-slate-50 transition-colors cursor-pointer group',
                            'bg-blue-50/40' => !$notif->read_at,
                        ])>
                            {{-- Icon --}}
                            <div @class([
                                'w-9 h-9 rounded-xl flex items-center justify-center shrink-0',
                                'bg-slate-100 text-slate-400' => $notif->read_at,
                                'bg-[#0077B6]/10 text-[#0077B6]' => !$notif->read_at,
                            ])>
                                @if($notif->type === 'payment')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                @elseif($notif->type === 'invoice')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-1">
                                    <p @class([
                                        'text-xs font-black leading-tight truncate',
                                        'text-[#000B44]' => !$notif->read_at,
                                        'text-slate-500' => $notif->read_at,
                                    ])>{{ $notif->title }}</p>
                                    @if(!$notif->read_at)
                                        <span class="w-2 h-2 rounded-full bg-[#0077B6] shrink-0 mt-0.5"></span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-500 leading-snug mt-0.5 line-clamp-2">{{ $notif->message }}</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <p class="text-sm font-bold text-slate-400">Tidak ada notifikasi</p>
                        </div>
                    @endforelse
                </div>

                {{-- Dropdown Footer --}}
                @if($recentNotifications->count() > 0)
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/80 flex items-center justify-between">
                    <a href="{{ route('umkm.notifications') }}" wire:navigate
                       class="text-xs font-black text-[#0077B6] hover:text-[#000B44] transition-colors">
                        Kelola Notifikasi
                    </a>
                    <span class="text-[10px] text-slate-400 font-medium">{{ $recentNotifications->count() }} dari total</span>
                </div>
                @endif
            </div>
        </div>
        @endunless
        
        <div class="relative" x-data="{ open: false }">
            <div @click="open = !open" @click.outside="open = false" class="flex items-center gap-4 pl-6 border-l border-slate-200 cursor-pointer hover:opacity-80 transition-opacity">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-black text-[#000B44] font-plus">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Admin UMKM</p>
                </div>
                <div class="w-12 h-12 bg-[#000B44] rounded-full flex items-center justify-center overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <span class="text-white font-black text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    @endif
                </div>
            </div>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-4 w-40 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 z-[60]"
                x-cloak>
                
                <a href="{{ route('umkm.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-slate-50 transition-colors border-b border-slate-50">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Pengaturan
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] font-bold text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>