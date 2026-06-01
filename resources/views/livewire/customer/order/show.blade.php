<x-slot:title>Detail Pesanan</x-slot>

@push('styles')
<style>
    /* Custom Scrollbar for photos */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Stepper Logic */
    .step-item.active .step-icon {
        background-color: #1F2937;
        color: white;
        border-color: #1F2937;
    }
    .step-item.completed .step-icon {
        background-color: #1F2937;
        color: white;
        border-color: #1F2937;
    }
    .step-item.completed .step-line {
        background-color: #1F2937;
    }
</style>
@endpush

<div class="max-w-[800px] mx-auto animate-fade-in-up pb-20">
    
    {{-- Header Section --}}
    <div class="mb-8">
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Pesanan Saya
        </a>
        <div class="text-[10px] font-bold text-gray-400 mb-4 uppercase tracking-widest">Dashboard / Pesanan Saya / <span class="text-gray-900">Detail Pesanan</span></div>
        
        <div class="flex items-center gap-3 mb-2">
            @php
                $statusBadge = match($order->status) {
                    'pending_valuation' => ['label' => 'PENDING_REVIEW', 'class' => 'bg-gray-100 text-gray-600 border-gray-200'],
                    'negotiation' => ['label' => 'NEGOTIATION', 'class' => 'bg-[#2D2D2D] text-white border-[#2D2D2D]'],
                    'waiting_payment' => ['label' => 'WAITING_PAYMENT', 'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                    'paid' => ['label' => 'PAID', 'class' => 'bg-green-100 text-green-700 border-green-200'],
                    'processing' => ['label' => 'PROCESSING', 'class' => 'bg-blue-100 text-blue-700 border-blue-200'],
                    'completed' => ['label' => 'COMPLETED', 'class' => 'bg-gray-100 text-gray-800 border-gray-200'],
                    'cancelled' => ['label' => 'CANCELLED', 'class' => 'bg-red-50 text-red-600 border-red-100'],
                    default => ['label' => strtoupper($order->status), 'class' => 'bg-gray-100 text-gray-600 border-gray-200'],
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold border uppercase tracking-widest {{ $statusBadge['class'] }}">
                {{ $statusBadge['label'] }}
            </span>
            @if($order->status === 'negotiation')
            <span class="text-[11px] text-gray-500 font-medium">Tindakan Anda Diperlukan</span>
            @endif
        </div>
        
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-2">#{{ $order->invoice_number ?? 'INV-'.$order->id }}</h1>
        <p class="text-gray-500 text-sm font-medium">Dibuat, {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <hr class="border-gray-100 mb-8">

    {{-- Stepper Progress --}}
    @php
        $statuses = ['pending_valuation', 'negotiation', 'waiting_payment', 'processing', 'completed'];
        $currentIndex = array_search($order->status, $statuses);
        if ($currentIndex === false && $order->status === 'paid') $currentIndex = 3; // map paid to processing step visually
    @endphp

    @if($order->status !== 'cancelled')
    <div class="mb-10 overflow-x-auto hide-scrollbar pb-4">
        <div class="flex items-center min-w-[600px] px-2">
            {{-- Step 1: Created/Review --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 0 ? 'completed' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 0)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 0 ? 'text-gray-900' : 'text-gray-400' }}">Order Created</div>
                    <div class="text-[9px] text-gray-400 font-medium mt-0.5">{{ $order->created_at->format('d M, H:i') }}</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 2: Admin Review (pending_valuation is ongoing here until negotiation/payment) --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 0 ? ($currentIndex > 0 ? 'completed' : 'active') : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 0)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 0 ? 'text-gray-900' : 'text-gray-400' }}">Admin Review</div>
                    <div class="text-[9px] text-gray-400 font-medium mt-0.5">In Progress</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 3: Price Negotiation (if applicable or skipped to payment) --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 1 ? ($currentIndex > 1 ? 'completed' : 'active') : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 1)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Price Negotiation</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 4: Payment --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 2 ? ($currentIndex > 2 ? 'completed' : 'active') : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 2)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Payment</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 5: Service Process --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 3 ? ($currentIndex > 3 ? 'completed' : 'active') : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 3)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Service Process</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 6: Completed --}}
            <div class="step-item flex-1 relative {{ $currentIndex >= 4 ? 'completed active' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 4)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 4 ? 'text-gray-900' : 'text-gray-400' }}">Completed</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Banner "What's happening now?" --}}
    @if($order->status !== 'cancelled')
    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 mb-8 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-1">What's happening now?</h3>
            @if($order->status === 'pending_valuation')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Your order is being reviewed by Admin. We are verifying service details. Admin will contact you via chat to discuss details and total price if needed.</p>
                <div class="mt-3 flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-wide">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Estimated review time: 1-2 working hours
                </div>
            @elseif($order->status === 'negotiation')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Admin has reviewed your order and proposed a price. Please review the service details and the proposed price. You can accept or continue negotiating via chat.</p>
            @elseif($order->status === 'waiting_payment')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Price has been agreed upon. Please proceed to payment to confirm your booking and schedule the service.</p>
            @elseif($order->status === 'processing')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Your order is currently in progress. The service provider will arrive at the scheduled time.</p>
            @elseif($order->status === 'completed')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Service has been completed. Thank you for using our services! Please leave a review.</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Main Content Section --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-black text-gray-900 font-plus">Service Details</h2>
            @if($order->umkm)
                <div class="px-3 py-1.5 bg-[#2D2D2D] text-white rounded-lg text-xs font-bold flex items-center gap-2 cursor-pointer hover:bg-black transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Chat with {{ $order->umkm->name }}
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 space-y-6 shadow-sm">
            {{-- Service Name --}}
            <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Service</div>
                    <div class="text-base font-bold text-gray-900">{{ $order->product->name ?? 'Layanan tidak diketahui' }}</div>
                </div>
                <div class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-lg">Code: {{ $order->product_id ?? 'N/A' }}</div>
            </div>

            {{-- Date & Time --}}
            <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Service Date</div>
                    <div class="text-base font-bold text-gray-900">
                        {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('l, d F Y') : 'Belum ditentukan' }}
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Time</div>
                    <div class="text-base font-bold text-gray-900">{{ $order->booking_time ? \Carbon\Carbon::parse($order->booking_time)->format('H:i') : 'Menunggu' }} WIB</div>
                    @if($order->status === 'pending_valuation')
                    <div class="text-[10px] font-medium text-gray-400 mt-1">* Time may adjust after negotiation.</div>
                    @endif
                </div>
            </div>

            {{-- Optional Info (Total Size mock) --}}
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Size / Variant</div>
                    <div class="text-base font-bold text-gray-900">Standard Package</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Price Block --}}
    <div class="bg-gray-50 border border-gray-200 rounded-3xl p-6 md:p-8 mb-6">
        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Agreed Price</div>
        <div class="text-2xl font-black text-gray-900 font-plus">
            @if($order->agreed_price)
                Rp {{ number_format($order->agreed_price, 0, ',', '.') }}
            @elseif($order->product && $order->product->estimated_price)
                <span class="text-lg text-gray-500 font-medium line-through mr-2">Est.</span>
                Rp {{ number_format($order->product->estimated_price, 0, ',', '.') }}
            @else
                Menunggu Penilaian
            @endif
        </div>
        @if($order->status === 'pending_valuation')
        <div class="text-[11px] font-medium text-gray-500 mt-2">* Final price will be updated by Admin.</div>
        @endif
    </div>

    {{-- Location Block --}}
    <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 mb-6 shadow-sm flex items-start gap-4">
        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Service Address</div>
            <p class="text-sm font-bold text-gray-900 leading-relaxed mb-3">{{ $order->service_address ?? 'Alamat tidak diisi.' }}</p>
            @if($order->service_latitude && $order->service_longitude)
            <a href="https://maps.google.com/?q={{ $order->service_latitude }},{{ $order->service_longitude }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                View on Maps
            </a>
            @endif
        </div>
    </div>

    {{-- Customer Notes --}}
    @if($order->notes)
    <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 mb-10 shadow-sm flex items-start gap-4">
        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div class="flex-1">
            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Customer Notes</div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-sm font-medium text-gray-700 leading-relaxed">
                {{ $order->notes }}
            </div>
        </div>
    </div>
    @endif

    {{-- Site Photos (Mockup placeholder as requested) --}}
    <div class="mb-12">
        <h2 class="text-xl font-black text-gray-900 font-plus mb-4">Site Photos (3 photos)</h2>
        <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-2">
            <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-2xl flex items-center justify-center border border-gray-200 shrink-0">
                <div class="text-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg mx-auto mb-2"></div>
                    <span class="text-[10px] font-bold text-gray-400">Photo 1</span>
                </div>
            </div>
            <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-2xl flex items-center justify-center border border-gray-200 shrink-0">
                <div class="text-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg mx-auto mb-2"></div>
                    <span class="text-[10px] font-bold text-gray-400">Photo 2</span>
                </div>
            </div>
            <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-2xl flex items-center justify-center border border-gray-200 shrink-0">
                <div class="text-center">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg mx-auto mb-2"></div>
                    <span class="text-[10px] font-bold text-gray-400">Photo 3</span>
                </div>
            </div>
        </div>
        <button class="mt-4 px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
            View All Photos
        </button>
        <p class="text-[10px] text-gray-400 font-medium mt-2">*Photos are mockups and cannot be expanded in this version.</p>
    </div>

    {{-- Order Activity Timeline --}}
    <div class="mb-12">
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6">Order Activity</h2>
        
        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
            
            {{-- Loop through Logs --}}
            @forelse($logs as $log)
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-200 group-[.is-active]:bg-[#2D2D2D] text-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $log->created_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="text-sm font-bold text-gray-900 mb-1">{{ $log->action }}</div>
                    <div class="text-[11px] text-gray-500 leading-relaxed font-medium">
                        {{ $log->reason ?? 'System state updated.' }}
                    </div>
                </div>
            </div>
            @empty
            {{-- Default Creation Log if no logs exist --}}
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-[#2D2D2D] text-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $order->created_at->format('d M, H:i') }}</div>
                    </div>
                    <div class="text-sm font-bold text-gray-900 mb-1">Order Created</div>
                    <div class="text-[11px] text-gray-500 leading-relaxed font-medium">
                        Order #{{ $order->invoice_number ?? 'INV-'.$order->id }} was successfully created.
                    </div>
                </div>
            </div>
            @endforelse
            
        </div>
    </div>

    {{-- Bottom Actions --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 border-t border-gray-200 pt-8 mt-8">
        <button class="w-full sm:w-auto px-8 py-3 bg-gray-100 text-gray-400 rounded-xl text-xs font-bold flex items-center justify-center gap-2 cursor-not-allowed">
            <div class="w-4 h-4 border-2 border-gray-300 border-t-gray-500 rounded-full animate-spin"></div>
            Chat with Admin
        </button>
        
        @if(in_array($order->status, ['pending_valuation', 'negotiation', 'waiting_payment']))
            <button wire:click="cancelOrder" wire:confirm="Are you sure you want to cancel this order?" class="w-full sm:w-auto px-8 py-3 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Cancel Order
            </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="mt-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-bold text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-8 text-center bg-gray-50 rounded-xl py-4 border border-gray-100">
        <p class="text-xs text-gray-500 font-medium">Need help with your order? <a href="#" class="text-gray-900 font-bold hover:underline">Contact Support</a></p>
    </div>

</div>
