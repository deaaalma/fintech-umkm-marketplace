@php
    if (request()->is('templates/*')) {
        $user = (object)[
            'name' => 'Ahmad',
            'role' => 'Customer'
        ];
    } else {
        $user = auth()->user() ?? (object)['name' => 'Guest', 'role' => 'Visitor'];
    }
@endphp

<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            {{-- Left: Logo --}}
            <div class="flex-shrink-0 flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span class="font-black text-gray-900 font-plus text-lg tracking-tight">JOS</span>
            </div>

            {{-- Center: Menu --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 text-sm font-bold {{ request()->routeIs('customer.dashboard') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900' }} transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('customer.orders') }}" class="text-sm font-bold {{ request()->routeIs('customer.orders') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900' }} transition-colors">Pesanan Saya</a>
                <a href="#" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">UMKM Partner</a>
                <a href="#" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Bantuan</a>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors rounded-full hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 rounded-full border border-white"></span>
                </button>

                <div x-data="{ openProfile: false }" class="relative">
                    <button @click="openProfile = !openProfile" @click.outside="openProfile = false" class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-200 text-gray-600 hover:bg-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="openProfile" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <div class="px-4 py-2 border-b border-gray-50">
                            <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $user->role }}</p>
                        </div>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 font-medium">Profile Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>