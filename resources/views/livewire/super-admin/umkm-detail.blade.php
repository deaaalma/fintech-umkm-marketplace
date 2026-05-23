<div>
    <style>
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    </style>

    <div class="pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ── BREADCRUMBS ── --}}
        <nav class="flex text-sm font-medium text-slate-400 mb-8 animate-fade-in-up">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <span class="mx-3">/</span>
            <a href="{{ route('admin.dashboard.umkm') }}" class="hover:text-blue-600 transition-colors">UMKM List</a>
            <span class="mx-3">/</span>
            <span class="text-slate-600 font-bold">{{ $umkm->name }}</span>
        </nav>

        {{-- ── HEADER PROFILE ── --}}
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 mb-12 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex items-center gap-8">
                <div class="w-24 h-24 rounded-[32px] bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-3xl font-black text-slate-400 shadow-inner border border-white">
                    {{ substr($umkm->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-4xl font-black font-plus text-[#000B44] tracking-tight">{{ $umkm->name }}</h1>
                        <span class="px-3 py-1 bg-teal-50 text-teal-600 border border-teal-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                            {{ $umkm->status === 'active' ? 'ACTIVE' : 'SUSPENDED' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 mt-2">
                        <p class="text-slate-500 font-medium">{{ $umkm->category->name ?? 'Bidang Usaha' }}</p>
                        <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                        <div class="flex items-center gap-1.5 font-bold text-slate-700">
                            <svg class="w-4 h-4 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 8.768c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.951-.69l1.286-3.957z"/></svg>
                            {{ $stats['avg_rating'] }} <span class="text-slate-400 font-medium">({{ $stats['total_reviews'] }})</span>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-slate-500 mt-2">Owner: <span class="text-slate-800">{{ $umkm->owner->name ?? '-' }}</span></p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all">Edit Info</button>
                <button class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold text-sm hover:bg-slate-50 transition-all">Suspend</button>
                <button class="bg-[#000B44] text-white px-8 py-3 rounded-2xl font-bold text-sm hover:scale-105 transition-all shadow-xl shadow-blue-900/10">Send Message</button>
            </div>
        </div>

        {{-- ── STATS CARDS ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in-up" style="animation-delay: 0.2s">
            @php $cards = [['PESANAN', $stats['total_orders'], 'pcs'], ['REVENUE', 'Rp '.number_format($stats['revenue']/1000000, 1).' Jt', 'total'], ['AVG. RATING', $stats['avg_rating'], 'star'], ['TOTAL REVIEWS', $stats['total_reviews'], 'review']]; @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm shadow-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all">
                <h6 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">{{ $card[0] }}</h6>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-black font-plus text-[#000B44]">{{ $card[1] }}</span>
                    @if($card[2])<span class="text-xs font-bold text-slate-300 mb-1 uppercase tracking-widest">{{ $card[2] }}</span>@endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up" style="animation-delay: 0.3s">
            
            {{-- Left Column (Profile info) --}}
            <div class="lg:col-span-2 space-y-8 text-slate-700">
                <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm shadow-slate-100">
                    <h3 class="text-lg font-black font-plus text-[#000B44] mb-8">Informasi UMKM</h3>
                    <div class="grid grid-cols-2 gap-y-10 gap-x-12">
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Usaha</p><p class="font-bold text-sm">{{ $umkm->address ?? '-' }}, {{ $umkm->city ?? '-' }}</p></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">No. HP/WA</p><p class="font-bold text-sm">{{ $umkm->owner->phone ?? '-' }}</p></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email</p><p class="font-bold text-sm lowercase">{{ $umkm->owner->email ?? '-' }}</p></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</p><p class="font-bold text-sm">{{ $umkm->category->name ?? '-' }}</p></div>
                        <div class="col-span-2"><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Toko</p><p class="text-sm font-medium leading-relaxed italic">"{{ $umkm->detail->description ?? ($umkm->description ?? 'Tidak ada deskripsi.') }}"</p></div>
                    </div>
                </div>

                {{-- Performance Card --}}
                <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm shadow-slate-100">
                    <h3 class="text-lg font-black font-plus text-[#000B44] mb-8">Performance</h3>
                    <div class="grid grid-cols-3 gap-8">
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Response Rate</p><p class="text-2xl font-black">{{ $stats['response_rate'] }}%</p><p class="text-[10px] font-bold text-slate-300 mt-1 uppercase tracking-widest">Dalam 30 Hari</p></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Avg. Response Time</p><p class="text-2xl font-black">{{ $stats['response_time'] }}</p><p class="text-[10px] font-bold text-slate-300 mt-1 uppercase tracking-widest">Dalam 30 Hari</p></div>
                        <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Order Completion</p><p class="text-2xl font-black">{{ $stats['completion_rate'] }}%</p><p class="text-[10px] font-bold text-slate-300 mt-1 uppercase tracking-widest">Dalam 30 Hari</p></div>
                    </div>
                </div>

                {{-- Reviews List --}}
                <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm shadow-slate-100">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-lg font-black font-plus text-[#000B44]">Reviews ({{ $stats['total_reviews'] }})</h3>
                        <div class="flex items-center gap-2">
                             <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sort by:</span>
                             <select class="text-xs font-bold bg-slate-50 border-none rounded-xl focus:ring-0">
                                 <option>Terbaru</option>
                                 <option>Rating Tertinggi</option>
                             </select>
                        </div>
                    </div>
                    <div class="space-y-10 divide-y divide-slate-50">
                        @foreach($reviews as $rev)
                        <div class="pt-10 first:pt-0">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    @for($i=0; $i<$rev['rating']; $i++)<svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.957c.3-.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 8.768c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.951-.69l1.286-3.957z"/></svg>@endfor
                                </div>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $rev['date'] }}</span>
                            </div>
                            <h5 class="text-sm font-black text-[#000B44] mb-2">{{ $rev['user'] }}</h5>
                            <p class="text-sm font-medium text-slate-500 leading-relaxed">{{ $rev['comment'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    <button class="w-full py-4 bg-slate-50 text-slate-400 font-black rounded-2xl mt-10 hover:bg-slate-100 transition-all uppercase text-[10px] tracking-[0.3em]">Load More Reviews</button>
                </div>
            </div>

            {{-- Right Column (Adjustment Area) --}}
            <div class="space-y-8">
                <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm shadow-slate-100">
                    <h3 class="text-lg font-black font-plus text-[#000B44] mb-4 italic text-slate-300 opacity-50">Superadmin Adjustment</h3>
                    <p class="text-xs font-bold text-slate-400 leading-relaxed mb-8 uppercase tracking-wider">Adjustment Area - For bonus or emergency quota adjustments.</p>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Adjustment Amount</p>
                            <div class="relative group">
                                <input type="text" placeholder="e.g. +10 or -5" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 transition-all">
                                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest">Orders</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Reason / Note</p>
                            <textarea rows="4" placeholder="Explain reason for adjustment..." class="w-full bg-slate-50 border-none rounded-[24px] px-6 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 transition-all resize-none"></textarea>
                        </div>

                        <div class="pt-4 grid grid-cols-2 gap-3">
                            <button class="bg-slate-100 text-slate-500 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                            <button class="bg-[#2D3142] text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-slate-900/20">Apply Adjustment</button>
                        </div>
                    </div>

                    <div class="mt-12 space-y-6 border-t border-slate-50 pt-10">
                        <p class="text-[10px] font-black text-[#000B44] uppercase tracking-widest">Recent Adjustments</p>
                        
                        <div class="p-5 bg-teal-50 border border-teal-100/50 rounded-2xl">
                             <div class="flex items-center justify-between mb-2">
                                 <span class="text-xs font-black text-teal-600 uppercase tracking-widtest">+15 orders</span>
                                 <span class="text-[9px] font-bold text-teal-400 uppercase tracking-widest">02 Jan 2026</span>
                             </div>
                             <p class="text-[10px] font-bold text-teal-700 leading-tight">Bonus quota for high performance in Dec 2025.</p>
                             <p class="text-[9px] font-black text-teal-400/70 mt-2 uppercase tracking-widest">Adjusted by Admin</p>
                        </div>

                        <div class="p-5 bg-red-50 border border-red-100/50 rounded-2xl">
                             <div class="flex items-center justify-between mb-2">
                                 <span class="text-xs font-black text-red-600 uppercase tracking-widtest">-5 orders</span>
                                 <span class="text-[9px] font-bold text-red-400 uppercase tracking-widest">28 Dec 2025</span>
                             </div>
                             <p class="text-[10px] font-bold text-red-700 leading-tight">Penalty for late service completion.</p>
                             <p class="text-[9px] font-black text-red-400/70 mt-2 uppercase tracking-widest">Adjusted by Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
