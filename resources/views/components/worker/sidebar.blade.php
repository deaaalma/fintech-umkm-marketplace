@php
    $umkm = auth()->user()->workerAt?->umkm;
    $umkmName = $umkm?->name ?? 'Staff Portal';
    
    // Generate initials (max 3 chars)
    $words = explode(' ', $umkmName);
    $initials = '';
    if (count($words) > 1) {
        foreach ($words as $w) {
            $initials .= mb_substr($w, 0, 1);
        }
    } else {
        $initials = mb_substr($umkmName, 0, 3);
    }
    $initials = strtoupper(mb_substr($initials, 0, 3));
@endphp

<aside class="hidden lg:flex w-72 flex-col fixed inset-y-0 bg-[#000B44] text-white z-50 shadow-2xl shadow-indigo-900/40">
    <div class="p-10 pb-12">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-sm font-plus border border-white/20 shadow-lg">{{ $initials }}</div>
            <div>
                <h1 class="text-xl font-black font-plus tracking-tight leading-none">{{ $umkmName }}</h1>
                <span class="text-[10px] font-bold text-blue-200/50 uppercase tracking-[0.2em] mt-1.5 block">Worker Portal</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-6 space-y-3 overflow-y-auto no-scrollbar pt-2">

        {{-- Label Section --}}
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] px-6 pb-1">Menu Staff</p>

        {{-- Home / Dashboard --}}
        <a href="{{ route('worker.dashboard') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('worker.dashboard'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('worker.dashboard')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('worker.dashboard') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Home</span>
            </div>
        </a>

        {{-- SOP & Panduan --}}
        <a href="{{ route('worker.sop') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('worker.sop'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('worker.sop')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('worker.sop') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">SOP &amp; Panduan</span>
            </div>
        </a>

        {{-- Tugas Saya --}}
        <a href="{{ route('worker.tasks') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('worker.tasks'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('worker.tasks')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('worker.tasks') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Tugas Saya</span>
            </div>
        </a>

        {{-- Profil --}}
        <a href="{{ route('worker.profile') }}" @class([
            'flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-300 group',
            'bg-white/5 text-white active-nav' => request()->routeIs('worker.profile'),
            'text-white/50 hover:bg-white/5 hover:text-white' => !request()->routeIs('worker.profile')
        ])>
            <div class="flex items-center gap-4">
                <svg class="w-6 h-6 {{ request()->routeIs('worker.profile') ? 'text-[#0077B6]' : 'text-slate-500 group-hover:text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[13px] font-bold tracking-wider uppercase">Profil</span>
            </div>
        </a>

    </nav>

    {{-- Logout --}}
    <div class="px-8 py-10 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl bg-white/5 hover:bg-red-500/10 text-white/50 hover:text-red-400 transition-all duration-300 group">
                <svg class="w-6 h-6 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-sm font-bold tracking-wider uppercase">Logout Session</span>
            </button>
        </form>
    </div>
</aside>
