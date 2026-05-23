<div>
    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>

    <div class="max-w-7xl mx-auto px-6 py-12 font-plus text-slate-800">
        
        {{-- ── TOP HEADER: Minimal & Clean ── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 animate-fade-in">
            <div class="flex items-start gap-6">
                <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center text-2xl font-bold text-slate-400 select-none">
                    {{ substr($umkm->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $umkm->name }}</h1>
                        <span @class([
                            'px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider',
                            'bg-emerald-100 text-emerald-700' => $umkm->status === 'active',
                            'bg-rose-100 text-rose-700' => $umkm->status === 'suspended',
                        ])>
                            {{ $umkm->status }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">
                        {{ $umkm->category->name ?? 'Kategori' }} &nbsp;•&nbsp; {{ $umkm->owner->name ?? 'Owner' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                
                @if($umkm->status === 'suspended')
                    <button wire:click="toggleSuspend" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/10">
                        Aktifkan Kembali
                    </button>
                @else
                    <button wire:click="toggleSuspend" wire:confirm="Suspend UMKM ini?" class="px-6 py-2.5 bg-white border border-slate-200 text-rose-600 rounded-xl text-sm font-bold hover:bg-rose-50 hover:border-rose-100 transition-all">
                        Suspend UMKM
                    </button>
                @endif
            </div>
        </div>

        {{-- ── GRID LAYOUT ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- LEFT: Main Stats & Info --}}
            <div class="lg:col-span-8 space-y-12">
                
                {{-- Quick Stats Row --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach([
                        ['Orders', number_format($stats['total_orders']), 'bg-blue-50 text-blue-600'],
                        ['Rating', $stats['avg_rating'], 'bg-amber-50 text-amber-600'],
                        ['Reviews', $stats['total_reviews'], 'bg-indigo-50 text-indigo-600']
                    ] as $s)
                    <div class="p-6 rounded-[2rem] bg-white border border-slate-50 shadow-sm transition-all hover:shadow-md">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ $s[0] }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-extrabold text-slate-900">{{ $s[1] }}</span>
                            <div class="w-2 h-2 rounded-full {{ explode(' ', $s[2])[0] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Information Details --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Business Intelligence</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Office Address</span>
                            <p class="text-sm font-bold text-slate-800 leading-relaxed">{{ $umkm->address ?? '-' }}, {{ $umkm->city ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Contact Channel</span>
                            <p class="text-sm font-bold text-slate-800 leading-relaxed">{{ $umkm->owner->phone ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Merchant Story</span>
                            <p class="text-sm font-medium text-slate-500 leading-relaxed">
                                {{ $umkm->detail->description ?? ($umkm->description ?? 'No description provided.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Performance Visualization --}}
                <div class="p-10 rounded-[2.5rem] bg-slate-900 text-white shadow-2xl shadow-slate-900/20 overflow-hidden relative">
                    <div class="relative z-10">
                        <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-8">Service Performance</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
                            <div>
                                <p class="text-3xl font-extrabold mb-1">{{ $stats['response_rate'] }}%</p>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Response Rate</p>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold mb-1">{{ $stats['response_time'] }}</p>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Avg. Time</p>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold mb-1">{{ $stats['completion_rate'] }}%</p>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Completion</p>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative blur --}}
                    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-500/10 blur-[100px]"></div>
                </div>

                {{-- Simple Customer Reviews --}}
                <div class="pt-4">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-extrabold text-slate-900">Recent Feedbacks</h3>
                        <span class="text-xs font-bold text-slate-400 underline decoration-slate-200 underline-offset-4 cursor-pointer">View All</span>
                    </div>
                    <div class="space-y-6">
                        @foreach($reviews as $rev)
                        <div class="p-6 bg-white rounded-3xl border border-slate-50 shadow-sm transition-all hover:-translate-x-1 cursor-default">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="text-sm font-extrabold text-slate-800">{{ $rev['user'] }}</h4>
                                    <div class="flex gap-0.5 mt-0.5">
                                        @for($i=0; $i<$rev['rating']; $i++)
                                            <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3-.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 8.768c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.951-.69l1.286-3.957z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $rev['date'] }}</span>
                            </div>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $rev['comment'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT: Top-up & Credits --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Credit Management Module --}}
                <div class="sticky top-12 space-y-8">
                    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-slate-900 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900">Credit Balance</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Managed by Superadmin</p>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="flex items-end gap-2 mb-2">
                                <span class="text-5xl font-black text-slate-900 leading-none">{{ number_format($umkm->credit_remaining) }}</span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest pb-1 italic">transaksi left</span>
                            </div>
                            @php
                                $pct = $umkm->transaction_credit > 0 ? min(100, round($umkm->credit_remaining / $umkm->transaction_credit * 100)) : 0;
                                $barCol = $pct > 40 ? 'bg-emerald-500' : ($pct > 15 ? 'bg-amber-400' : 'bg-rose-500');
                            @endphp
                            <div class="w-full bg-slate-50 rounded-full h-1.5 mb-2 overflow-hidden">
                                <div class="{{ $barCol }} h-1.5 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <span>Used: {{ number_format($umkm->credit_used) }}</span>
                                <span>Limit: {{ number_format($umkm->transaction_credit) }}</span>
                            </div>
                        </div>

                        <form wire:submit.prevent="topUpCredit" class="space-y-6">
                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block px-2">Refill Amount</label>
                                <input type="number" wire:model="creditAmount" placeholder="e.g. 100" class="w-full h-14 bg-slate-50 border border-slate-100 rounded-2xl px-6 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-slate-100 focus:border-slate-200 transition-all outline-none">
                                @error('creditAmount') <p class="text-rose-500 text-[10px] font-bold mt-2 px-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="group">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block px-2">Payment Reference</label>
                                <textarea wire:model="creditNote" rows="2" placeholder="Note payment details..." class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-slate-100 focus:border-slate-200 transition-all outline-none resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full h-14 bg-slate-900 text-white rounded-2xl text-sm font-bold hover:bg-slate-800 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-slate-900/10">
                                Apply Top-up
                            </button>
                        </form>
                    </div>

                    {{-- Compact Logs --}}
                    <div class="px-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6">Adjustment History</p>
                        <div class="space-y-4">
                             @forelse($creditLogs as $log)
                             <div @class([
                                 'p-5 rounded-2xl transition-all border-l-4 shadow-sm',
                                 'bg-emerald-100/60 border-emerald-500 text-emerald-900' => $log->type === 'topup',
                                 'bg-rose-100/60 border-rose-500 text-rose-900' => $log->type === 'deduction',
                             ])>
                                 <div class="flex flex-col gap-1">
                                     <span @class([
                                         'text-lg font-extrabold tracking-tight',
                                         'text-emerald-600' => $log->type === 'topup',
                                         'text-rose-600' => $log->type === 'deduction',
                                     ])>
                                         {{ $log->type === 'topup' ? '+' : '-' }}{{ number_format(abs($log->amount)) }} Credits
                                     </span>
                                 </div>
                                 <p class="text-[11px] font-bold text-slate-500 leading-snug mt-2">
                                     {{ $log->note ?: 'Manual adjustment applied.' }}
                                 </p>
                             </div>
                             @empty
                             <div class="py-10 text-center border-2 border-dashed border-slate-50 rounded-3xl">
                                 <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">No transaction records</p>
                             </div>
                             @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Minimal Notification Toast --}}
    <div x-data="{ show: false, message: '' }" x-on:message.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50">
        <div x-show="show" x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:leave="duration-200 ease-in" class="bg-slate-900 text-white text-xs font-bold px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span x-text="message"></span>
        </div>
    </div>
</div>
