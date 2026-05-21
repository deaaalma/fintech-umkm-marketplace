<header class="px-8 md:px-12 py-8 flex flex-col xl:flex-row justify-between xl:items-center bg-[#F8FAFC]/50 backdrop-blur-xl sticky top-0 z-40 transition-all duration-300 border-b border-slate-100/50">
    <div class="mb-4 xl:mb-0 w-full xl:w-auto">
        {{ $slot }}
    </div>
    
    <div class="flex items-center gap-4 xl:gap-6 justify-between xl:justify-end w-full xl:w-auto">
        <!-- Search Bar -->
        <div class="relative group transition-all duration-300 w-full xl:w-auto">
            <input type="text" placeholder="Search data..." class="w-full xl:w-64 focus:xl:w-80 pl-12 pr-6 py-3.5 bg-white/70 border border-slate-200 rounded-2xl text-xs font-bold focus:ring-[12px] focus:ring-[#0077B6]/10 focus:border-[#0077B6]/30 focus:bg-white transition-all duration-500 placeholder:text-slate-400 outline-none shadow-sm font-plus">
            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex items-center gap-3 xl:gap-4 shrink-0">
            <!-- Notifications -->
            <button class="w-12 h-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all group relative shadow-sm">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-[#000B44]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            
            <div class="w-px h-8 bg-slate-200 hidden xl:block mx-1"></div>
            
            <!-- Quick Profile (Desktop Only) -->
            <div class="hidden xl:flex items-center gap-3">
                <div class="w-12 h-12 bg-[#0077B6]/10 border-2 border-[#0077B6]/20 rounded-2xl flex items-center justify-center text-[#0077B6] font-black font-plus shadow-sm overflow-hidden group hover:border-[#0077B6] transition-all cursor-pointer">
                     <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=0077B6&color=fff" alt="Avatar" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                </div>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="w-12 h-12 flex md:hidden items-center justify-center bg-white border border-slate-200 rounded-2xl text-[#000B44] hover:bg-slate-50 shadow-sm transition-all" onclick="document.querySelector('aside').classList.toggle('hidden')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>
</header>
