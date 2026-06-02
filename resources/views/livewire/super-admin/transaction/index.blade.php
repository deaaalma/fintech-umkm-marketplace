<div class="min-h-screen" x-data="{ activeTab: @entangle('activeTab') }">
    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('superadmin.dashboard') }}" class="text-[#666666] hover:text-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]"><polyline points="9 18 15 12 9 6"></polyline></svg>
                <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Monitoring Transaksi</span>
            </div>
        </div>
    </div>

    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-family: 'Figtree', sans-serif;">Monitoring Transaksi</h1>
                    <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Monitor dan kelola semua transaksi platform</p>
                </div>
                <button wire:click="processPayouts" class="px-6 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center justify-center gap-2" style="font-family: 'Figtree', sans-serif;">
                    Process UMKM Payouts
                </button>
            </div>
        </div>
    </div>

    <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @foreach($stats as $stat)
                <div class="bg-white rounded-3xl p-6 border border-[#e5e5e5] hover:shadow-md transition-all duration-300">
                    <p class="text-xs uppercase tracking-wide mb-2 text-[#999999]" style="font-family: 'Figtree', sans-serif;">{{ $stat['title'] }}</p>
                    <div class="text-3xl font-bold text-[#003d5c] mb-2" style="font-family: 'Figtree', sans-serif;">{{ $stat['value'] }}</div>
                    <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $stat['subtitle'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-t-3xl border border-[#e5e5e5] border-b-0">
                <div class="flex items-center gap-6 px-8 pt-6 border-b border-[#e5e5e5]">
                    @foreach(['all' => 'All Transactions', 'payments' => 'Payments', 'payouts' => 'Payouts', 'refunds' => 'Refunds'] as $key => $label)
                        <button wire:click="$set('activeTab', '{{ $key }}')"
                            class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200 {{ $activeTab === $key ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]' }}"
                            style="font-family: 'Figtree', sans-serif;">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-[#e5e5e5] border-t-0 p-6">
                <div class="mb-6 relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Transaction ID, Order ID, or UMKM..."
                        class="w-full px-4 py-3 pl-10 rounded-lg border border-[#e5e5e5] focus:ring-2 focus:ring-[#0078b7] text-sm" style="font-family: 'Figtree', sans-serif;">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999999] w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    @php $labelClass = "block text-xs font-semibold text-[#999999] uppercase mb-2"; @endphp
                    @php $inputClass = "w-full px-4 py-2.5 rounded-lg border border-[#e5e5e5] focus:ring-2 focus:ring-[#0078b7] text-sm"; @endphp

                    <div class="md:col-span-2">
                        <label class="{{ $labelClass }}">Status</label>
                        <select wire:model.live="filterStatus" class="{{ $inputClass }}">
                            <option value="">All Status</option>
                            <option value="SUCCESS">Success</option>
                            <option value="PENDING">Pending</option>
                            <option value="FAILED">Failed</option>
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="{{ $labelClass }}">Date Range</label>
                        <div class="flex gap-2">
                            <input type="date" wire:model.live="dateFrom" class="{{ $inputClass }}">
                            <input type="date" wire:model.live="dateTo" class="{{ $inputClass }}">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="{{ $labelClass }}">Payment</label>
                        <select wire:model.live="filterMethod" class="{{ $inputClass }}">
                            <option value="">All Methods</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet">E-Wallet</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="{{ $labelClass }}">Amount Range</label>
                        <div class="flex gap-2">
                            <input type="number" wire:model.live="minAmount" placeholder="Min" class="{{ $inputClass }}">
                            <input type="number" wire:model.live="maxAmount" placeholder="Max" class="{{ $inputClass }}">
                        </div>
                    </div>

                    <div class="md:col-span-1 flex items-end">
                        <button wire:click="resetFilters" class="w-full py-2.5 bg-white border border-[#e5e5e5] rounded-lg hover:bg-gray-50 text-sm font-medium">Clear</button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-b-3xl border border-[#e5e5e5] border-t-0 p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-[#e5e5e5] text-xs font-semibold text-[#999999] uppercase tracking-wide" style="font-family: 'Figtree', sans-serif;">
                                <th class="py-4 px-4">Invoice Number</th>
                                <th class="py-4 px-4">Date & Time</th>
                                <th class="py-4 px-4">UMKM</th>
                                <th class="py-4 px-4">Amount</th>
                                <th class="py-4 px-4">Payment</th>
                                <th class="py-4 px-4">Status</th>
                                <th class="py-4 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($transactions as $trx)
                                    <tr class="border-b border-[#e5e5e5] hover:bg-gray-50 transition-colors" style="font-family: 'Figtree', sans-serif;">
                                        <td class="py-4 px-4 text-sm font-mono font-semibold text-[#003d5c]">
                                            {{ $trx->invoice_number ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-sm text-[#666666]">{{ $trx->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-[#999999]">{{ $trx->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="py-4 px-4 text-sm font-semibold text-[#003d5c]">{{ $trx->umkm_name }}</td>
                                        <td class="py-4 px-4 text-sm font-semibold text-[#003d5c]">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                                {{ $trx->payment_method ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            @php $statusUpper = strtoupper($trx->status); @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                                {{ $statusUpper === 'SUCCESS' ? 'bg-green-100 text-green-700' : ($statusUpper === 'PENDING' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $statusUpper }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <button wire:click="viewDetails('{{ $trx->id }}')" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50">View</button>
                                                @if($statusUpper === 'FAILED')
                                                    <button wire:click="refund('{{ $trx->id }}')" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-xs font-medium hover:bg-gray-50">Refund</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-4 px-4 text-center text-sm text-[#999999]">
                                                No transactions found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                <div class="mt-6">
                    {{ $transactions->links('components.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>