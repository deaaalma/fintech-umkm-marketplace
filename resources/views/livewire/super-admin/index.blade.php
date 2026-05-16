<div>
    <x-slot:title>Dashboard Utama</x-slot>

    <x-slot:header>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2 font-figtree">Dashboard UMKM Management</h1>
                <p class="text-sm text-[#666666] font-figtree">Monitor dan kelola semua mitra bisnis Anda</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 text-sm font-medium flex items-center gap-2 font-figtree">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path><polyline points="23 4 23 10 17 10"></polyline></svg>
                    Refresh
                </button>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
        {{-- Loop stats di sini --}}
    </div>

    <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5]">
        {{-- Konten Tabel --}}
    </div>
</div>
