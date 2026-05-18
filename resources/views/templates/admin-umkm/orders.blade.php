@component('layouts.blank')
<div class="min-h-screen bg-[#F8FAFC] flex font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    <!-- Sidebar -->
    @include('templates.admin-umkm.components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
        <!-- Header -->
        @include('templates.admin-umkm.components.header', ['title' => 'My Orders'])

        <div class="px-8 lg:px-12 py-10">
             <!-- Tools Toolbar (Search & Filters) -->
             <div class="flex flex-col xl:flex-row gap-6 justify-between items-start mb-10">
                <div class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                    @foreach(['All', 'Residential', 'Commercial', 'Specialty'] as $tab)
                    <button @class(['px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all', 'bg-[#000B44] text-white shadow-lg' => $loop->first, 'text-slate-400 hover:bg-slate-50' => !$loop->first])>{{ $tab }}</button>
                    @endforeach
                </div>
                
                <div class="flex items-center gap-3 w-full xl:w-auto">
                    <div class="relative flex-1 xl:w-64">
                         <input type="text" placeholder="Search ID or client..." class="w-full pl-12 pr-6 py-4 bg-white border border-slate-100 rounded-2xl text-[13px] font-medium focus:ring-[12px] focus:ring-[#0077B6]/10 focus:border-[#0077B6]/30 transition-all outline-none shadow-sm">
                         <svg class="w-4 h-4 text-slate-400 absolute left-5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button class="px-6 py-4 bg-white border border-slate-100 rounded-2xl flex items-center gap-3 hover:bg-slate-50 transition-all shadow-sm">
                         <svg class="w-5 h-5 text-[#000B44]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                         <span class="text-[11px] font-black text-[#000B44] uppercase tracking-widest leading-none">Filters</span>
                    </button>
                </div>
             </div>

             <!-- Orders Table -->
             <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/20 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/70 border-b border-slate-100">
                        <tr>
                            <th class="p-8 text-[11px] font-black text-slate-500 uppercase tracking-widest">Order Info</th>
                            <th class="p-8 text-[11px] font-black text-slate-500 uppercase tracking-widest">Client</th>
                            <th class="p-8 text-[11px] font-black text-slate-500 uppercase tracking-widest text-center">Status</th>
                            <th class="p-8 text-[11px] font-black text-slate-500 uppercase tracking-widest text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach([1, 2, 3, 4, 5] as $i)
                        <tr class="hover:bg-slate-50/50 transition-all cursor-pointer group">
                            <td class="p-8"><p class="text-[14px] font-black text-[#000B44] tracking-tight group-hover:text-[#0077B6] transition-colors mb-1">ORD-2403{{ $i }}</p><p class="text-[11px] font-bold text-slate-400">Deep Cleaning Service</p></td>
                            <td class="p-8"><p class="text-[13px] font-bold text-[#000B44]">Ahmad S.</p><p class="text-[11px] font-medium text-slate-400">Jakarta Selatan</p></td>
                            <td class="p-8 text-center"><span class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">Active</span></td>
                            <td class="p-8 text-right"><p class="text-[15px] font-black text-[#000B44] tracking-tight">Rp 750.000</p></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
             </div>
        </div>
    </main>
</div>
@endcomponent
