<x-slot:title>Review Order #{{ $order->invoice_number ?? $order->id }}</x-slot>

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('umkm.orders') }}" class="p-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all text-gray-400 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Order #{{ $order->invoice_number ?? $order->id }}</h1>
                <p class="text-sm text-gray-500 font-medium">Customer: <span class="text-gray-900 font-bold">{{ $order->customer->name }}</span> • Submitted {{ $order->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div>
            @php
                $statusMap = [
                    'pending_valuation' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'label' => 'Awaiting Review'],
                    'waiting_payment'   => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'label' => 'Awaiting Payment'],
                    'paid'              => ['bg' => 'bg-teal-50',   'text' => 'text-teal-600',   'label' => 'Paid'],
                    'processing'        => ['bg' => 'bg-blue-50',   'text' => 'text-blue-600',   'label' => 'Processing'],
                    'completed'         => ['bg' => 'bg-green-50',  'text' => 'text-green-600',  'label' => 'Completed'],
                    'cancelled'         => ['bg' => 'bg-red-50',    'text' => 'text-red-600',    'label' => 'Cancelled'],
                ];
                $s = $statusMap[$order->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'label' => $order->status];
            @endphp
            <span class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider {{ $s['bg'] }} {{ $s['text'] }}">
                {{ $s['label'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Order Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Service & Requirement</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Service Type</label>
                            <p class="text-base font-bold text-gray-900">{{ $order->product->name }}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Estimated Price</label>
                            <p class="text-base font-bold text-gray-900">Rp {{ number_format($order->product->estimated_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Booking Date & Time</label>
                            <p class="text-base font-bold text-gray-900">{{ $order->booking_date ? $order->booking_date->format('l, d F Y') : '-' }}</p>
                            <p class="text-sm text-gray-500 font-medium">{{ $order->booking_time ? $order->booking_time->format('H:i') : '-' }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Service Address</label>
                    <p class="text-sm font-bold text-gray-900 leading-relaxed">{{ $order->service_address ?? 'Not specified' }}</p>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Customer Notes</label>
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 text-sm text-gray-700 leading-relaxed">
                        {{ $order->notes ?? 'No notes provided by customer.' }}
                    </div>
                </div>
            </div>

            {{-- Site Photos (Mock) --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Site Photos (Mockup)</h2>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @for($i=1; $i<=3; $i++)
                        <div class="w-40 h-40 bg-gray-100 rounded-2xl border border-gray-200 flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-gray-400">Photo {{ $i }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Right Column: Actions --}}
        <div class="space-y-6">
            @if($order->status === 'pending_valuation')
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Take Action</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Agreed Price (Proposal)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 font-bold">Rp</span>
                            <input type="number" wire:model="agreed_price" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-1 focus:ring-black focus:border-black transition-all font-bold">
                        </div>
                        @error('agreed_price') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Notes to Customer</label>
                        <textarea wire:model="admin_note" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-1 focus:ring-black focus:border-black transition-all text-sm" placeholder="Explain the price details..."></textarea>
                    </div>

                    <div class="space-y-3 pt-4">
                        <button wire:click="acceptOrder" wire:confirm="Send this price proposal to customer?" class="w-full py-3.5 bg-[#2D2D2D] hover:bg-black text-white rounded-xl font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Accept & Send Proposal
                        </button>
                        <button wire:click="rejectOrder" wire:confirm="Are you sure you want to REJECT this order?" class="w-full py-3.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject Order
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- History --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Activity Timeline</h2>
                <div class="space-y-6">
                    @foreach($logs as $log)
                    <div class="flex gap-4">
                        <div class="w-2 bg-gray-100 rounded-full shrink-0"></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $log->created_at->format('d M, H:i') }}</p>
                            <p class="text-xs font-bold text-gray-900">{{ $log->action }}</p>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">{{ $log->reason }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
