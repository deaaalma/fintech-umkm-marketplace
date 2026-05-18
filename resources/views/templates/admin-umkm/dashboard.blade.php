@component('layouts.blank')
<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .active-nav { background: rgba(255, 255, 255, 0.05); position: relative; }
        .active-nav::after { content: ''; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #0077B6; border-radius: 0 4px 4px 0; }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    </style>

    <!-- Sidebar -->
    @include('templates.admin-umkm.components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Header -->
        @include('templates.admin-umkm.components.header', ['title' => 'Overview'])

        <div class="px-8 lg:px-12 py-10 space-y-10">
            <!-- Hero Stats Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-[#000B44] p-8 rounded-[2rem] text-white shadow-2xl animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-white/70 uppercase tracking-widest leading-none">New Orders</h4>
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center border border-white/20"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
                    </div>
                    <h3 class="text-5xl font-black font-plus tracking-tighter leading-none mb-4">7</h3>
                    <div class="flex items-center gap-2 mt-auto"><span class="bg-teal-500/20 text-teal-400 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none shadow-sm h-min">12% <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg></span><span class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Since last month</span></div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Total Balance</h4>
                        <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
                    </div>
                    <h3 class="text-4xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-4 whitespace-nowrap">Rp 12,50M</h3>
                    <div class="flex items-center gap-2 mt-auto"><span class="bg-teal-50 text-teal-600 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none">8% <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg></span><span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Since last month</span></div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl animate-fade-in-up" style="animation-delay: 0.3s">
                     <div class="flex justify-between items-start mb-8">
                        <h4 class="text-xs font-bold font-plus text-slate-400 uppercase tracking-widest leading-none">Active Orders</h4>
                        <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7V17" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
                    </div>
                    <h3 class="text-5xl font-black text-[#000B44] font-plus tracking-tighter leading-none mb-4">8</h3>
                    <div class="flex items-center gap-2 mt-auto"><span class="bg-blue-50 text-blue-600 text-[10px] font-black px-2 py-0.5 rounded-lg flex items-center gap-1 leading-none shadow-sm shadow-blue-500/10">/ 15 <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"></path></svg></span><span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Resource Capacity</span></div>
                </div>
            </div>

            <!-- Dashboard Split (Grid / Table) -->
            <div class="grid grid-cols-12 gap-8 items-start">
                <div class="col-span-12 xl:col-span-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 transition-all font-plus">
                    <h3 class="text-2xl font-black text-[#000B44] tracking-tight leading-none mb-10">Live Pipeline</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                        @foreach([['Pending', 7, 70], ['Negotiating', 4, 45], ['Payment', 5, 55], ['Active', 5, 55], ['Completed', 12, 92]] as $p)
                        <div class="space-y-4">
                            <div class="flex justify-between items-end px-1"><span class="text-xs font-black text-[#000B44] uppercase tracking-widest">{{ $p[0] }}</span><span class="text-sm font-black text-[#000B44] leading-none">{{ $p[1] }} <span class="text-[10px] text-slate-400 uppercase font-bold ml-1">Orders</span></span></div>
                            <div class="w-full h-8 bg-slate-50 rounded-xl border border-slate-100 p-0 overflow-hidden shadow-inner"><div class="h-full bg-[#000B44] rounded-xl" style="width:{{ $p[2] }}%"></div></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-4 bg-white p-10 rounded-[2.5rem] border border-slate-100 flex flex-col font-plus shadow-sm">
                    <h3 class="text-2xl font-black text-[#000B44] tracking-tight leading-none mb-10">Recent Orders</h3>
                    <div class="border border-slate-100 rounded-[2rem] overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/70 border-b border-slate-100"><tr><th class="p-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">ID</th><th class="p-5 text-center border-l border-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th></tr></thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach([['ORD-1234', 'Pending', 'amber'], ['ORD-1233', 'Active', 'blue'], ['ORD-1232', 'Paid', 'teal']] as $o)
                                <tr class="hover:bg-slate-50/50 transition-all cursor-pointer">
                                    <td class="p-5"><p class="text-[13px] font-black text-[#000B44] tracking-tight">{{ $o[0] }}</p></td>
                                    <td class="p-5 border-l border-slate-100 text-center"><span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-{{ $o[2] }}-50 text-{{ $o[2] }}-600 border border-{{ $o[2] }}-100">{{ $o[1] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="w-full mt-8 py-5 bg-slate-50 hover:bg-[#000B44] hover:text-white border border-slate-100 rounded-[1.5rem] text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] transition-all duration-300">View All</button>
                </div>
            </div>
        </div>
    </main>
</div>
@endcomponent
