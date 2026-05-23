<div class="relative w-full" x-data="{ focused: false }">
    <!-- Input Container -->
    <div class="relative transition-all duration-500 ease-in-out group" 
        :class="focused ? 'scale-[1.02] translate-y-[-2px]' : ''">
        
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            @focus="focused = true" 
            @click.away="focused = false"
            @keydown.escape="focused = false; @this.clear()"
            placeholder="Search users, UMKM, or orders..." 
            class="w-full bg-slate-50/80 backdrop-blur-sm border border-slate-200 rounded-2xl py-4 pl-14 pr-12 text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 transition-all font-plus focus:bg-white focus:shadow-2xl focus:shadow-[#0077B6]/10 focus:border-[#0077B6]/30 shadow-sm overflow-hidden"
        >
        
        <!-- Search Icon -->
        <svg class="w-5 h-5 transition-all duration-300 absolute left-5 top-1/2 -translate-y-1/2" 
            :class="focused ? 'text-[#0077B6] scale-110' : 'text-slate-300'" 
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>

        <!-- Command Shortcut (Hidden when focused) -->
        <div class="absolute right-5 top-1/2 -translate-y-1/2 flex items-center gap-1 transition-all duration-300 pointer-events-none" 
            :class="focused || query.length > 0 ? 'opacity-0 scale-75' : 'opacity-100 scale-100'">
            <span class="px-1.5 py-0.5 rounded border border-slate-200 bg-white text-[10px] font-bold text-slate-400 shadow-xs">⌘</span>
            <span class="px-1.5 py-0.5 rounded border border-slate-200 bg-white text-[10px] font-bold text-slate-400 shadow-xs">K</span>
        </div>

        <!-- Clear Button (Shown when has query) -->
        <button 
            x-show="query.length > 0"
            @click="@this.clear(); focused = false"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 transition-all"
            x-cloak
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Results Dropdown -->
    <div 
        x-show="focused && query.length >= 2"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="absolute top-20 left-0 right-0 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-[0_32px_64px_-16px_rgba(0,11,68,0.15)] overflow-hidden z-50 p-2"
        x-cloak
    >
        @if(!empty($results))
            <div class="divide-y divide-slate-100">
                <!-- UMKM Results -->
                @if(isset($results['umkm']) && $results['umkm']->count() > 0)
                    <div class="p-3">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-4 py-2">UMKM Applications</h4>
                        <div class="space-y-1">
                            @foreach($results['umkm'] as $umkm)
                                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-[#0077B6]/5 group transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-[#0077B6]/10 transition-colors">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800 group-hover:text-[#000B44]">{{ $umkm->name }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $umkm->category->name ?? 'No Category' }} • {{ ucfirst(str_replace('_', ' ', $umkm->status)) }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-300 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- User Results -->
                @if(isset($results['users']) && $results['users']->count() > 0)
                    <div class="p-3">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-4 py-2">System Users</h4>
                        <div class="space-y-1">
                            @foreach($results['users'] as $user)
                                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-teal-50 group transition-all">
                                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-sm">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=02b2af&color=fff" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800 group-hover:text-teal-900">{{ $user->name }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $user->email }} • <span class="font-bold text-teal-600">{{ strtoupper($user->role) }}</span></p>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-300 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Order Results -->
                @if(isset($results['orders']) && $results['orders']->count() > 0)
                    <div class="p-3">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-4 py-2">Active Orders</h4>
                        <div class="space-y-1">
                            @foreach($results['orders'] as $order)
                                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-slate-50 group transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-mono font-bold text-slate-800">{{ $order->invoice_number ?? 'NO-INV' }}</p>
                                        <p class="text-[11px] text-slate-500">Rp {{ number_format($order->agreed_price ?? 0, 0, ',', '.') }} • {{ ucfirst($order->status) }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-300 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(($results['umkm']->count() + $results['users']->count() + $results['orders']->count()) === 0)
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">No results found for "{{ $query }}"</p>
                        <p class="text-xs text-slate-500 mt-1">Try another search term or user ID</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-[10px] font-bold text-slate-400">Press ENTER to see all results</p>
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1.5 border border-slate-200 bg-white px-2 py-0.5 rounded-lg shadow-xs">
                        <span class="text-[10px] font-bold text-slate-400">ESC</span>
                        <span class="text-[10px] text-slate-400">to close</span>
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
