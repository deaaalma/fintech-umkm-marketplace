<div class="min-h-screen">
    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('superadmin.dashboard.preview') }}" class="text-[#666666] hover:text-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Manajemen Pengguna</span>
            </div>
        </div>
    </div>

    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
            <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Manajemen Pengguna</h1>
            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Kelola seluruh pengguna platform</p>
        </div>
    </div>

    <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @if(isset($stats))
                    @foreach($stats as $stat)
                    <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                        <p class="text-xs uppercase tracking-wide mb-2 text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $stat['title'] }}</p>
                        <div class="text-3xl font-bold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] mb-6">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <div class="relative">
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="search"
                                placeholder="Cari nama, email, phone..."
                                class="w-full px-4 py-3 pl-10 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] focus:border-transparent text-sm"
                                style="font-family: 'Figtree', sans-serif;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999]">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <select wire:model.live="filterRole" class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                            <option value="">ROLE</option>
                            <option value="Customer">Customer</option>
                            <option value="UMKM Admin">UMKM Admin</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <select wire:model.live="filterStatus" class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                            <option value="">STATUS</option>
                            <option value="ACTIVE">Active</option>
                            <option value="SUSPENDED">Suspended</option>
                            <option value="INACTIVE">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <select wire:model.live="filterDate" class="w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                            <option value="">TANGGAL DAFTAR</option>
                            <option value="today">Hari Ini</option>
                            <option value="7days">7 Hari Terakhir</option>
                            <option value="30days">30 Hari Terakhir</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <button wire:click="clearFilters" class="w-full px-4 py-3 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium" style="font-family: 'Figtree', sans-serif;">
                            Clear Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-[#e5e5e5]">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#e5e5e5]">
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">NAMA</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">EMAIL</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">PHONE</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ROLE</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">STATUS</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">TANGGAL DAFTAR</th>
                                <th class="text-left py-4 px-4 text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && count($users) > 0)
                                @foreach($users as $userData)
                                <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <span class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $userData['name'] }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['email'] }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['phone'] }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $userData['role'] === 'Customer' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $userData['role'] === 'UMKM Admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                            {{ $userData['role'] === 'Staff' ? 'bg-green-100 text-green-700' : '' }}"
                                            style="font-family: 'Figtree', sans-serif;">
                                            {{ $userData['role'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $userData['status'] === 'ACTIVE' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $userData['status'] === 'SUSPENDED' ? 'bg-red-100 text-red-700' : '' }}"
                                            style="font-family: 'Figtree', sans-serif;">
                                            {{ $userData['status'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $userData['created_at']->format('d M Y') }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="viewDetails({{ $userData['id'] ?? 0 }})" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                View Details
                                            </button>
                                            <button wire:click="toggleStatus({{ $userData['id'] ?? 0 }})" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                {{ $userData['status'] === 'ACTIVE' ? 'Suspend' : 'Activate' }}
                                            </button>
                                            <button wire:click="resetPassword({{ $userData['id'] ?? 0 }})" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                                Reset Password
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-sm text-[#999999]" style="font-family: 'Figtree', sans-serif;">
                                        Tidak ada data pengguna yang ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">
                        Showing {{ isset($users) ? count($users) : 0 }} records
                    </p>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1.5 bg-[#003d5c] text-white rounded-lg text-sm font-semibold">1</button>
                        <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">2</button>
                        <button class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>