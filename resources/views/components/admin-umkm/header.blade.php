@props(['title'])

<header class="px-8 lg:px-12 py-8 flex flex-col sm:flex-row justify-between items-center bg-[#F8FAFC]/50 backdrop-blur-xl sticky top-0 z-40 transition-all duration-300 border-b border-slate-100/50">
    <div class="mb-4 sm:mb-0 text-left w-full sm:w-auto">
        <h2 class="text-3xl font-black text-[#000B44] font-plus tracking-tight">{{ $title }}</h2>
        <p class="text-slate-400 font-medium text-sm mt-1">Hello, <span class="text-[#0077B6] font-bold">{{ auth()->user()->name }}</span></p>
    </div>
    
    <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-6">
        <form action="{{ route('umkm.orders') }}" method="GET" class="relative hidden xl:block group transition-all duration-300">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="w-72 focus:w-80 pl-12 pr-6 py-3.5 bg-white/70 border border-slate-200 rounded-2xl text-xs font-bold focus:ring-[12px] focus:ring-[#0078B6]/10 focus:border-[#0078B6]/30 focus:bg-white transition-all duration-500 placeholder:text-slate-400 outline-none shadow-sm">
            <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>

        <div class="flex items-center gap-4">
            <button class="w-12 h-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all group relative">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-[#000B44]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            
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
    </div>
</header>