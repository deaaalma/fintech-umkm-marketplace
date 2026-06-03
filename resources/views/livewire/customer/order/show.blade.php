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
                    'pending_valuation' => $order->agreed_price ? 
                        ['label' => 'WAITING_CUSTOMER_ACTION', 'class' => 'bg-white border-gray-200 text-gray-900'] : 
                        ['label' => 'ADMIN_REVIEW', 'class' => 'bg-gray-100 text-gray-600 border-gray-200'],
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
            {{-- State: Negotiation / Price Agreement --}}
            @if($order->status === 'negotiation' || ($order->status === 'pending_valuation' && $order->agreed_price !== null))
            <span class="text-[11px] text-gray-500 font-medium">Tindakan Anda Diperlukan</span>
            @endif
        </div>
        
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-2">#{{ $order->invoice_number ?? 'INV-'.$order->id }}</h1>
        <p class="text-gray-500 text-sm font-medium">Dibuat, {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <hr class="border-gray-100 mb-8">

    {{-- Stepper Progress --}}
    @php
        $currentIndex = $order->current_step;
    @endphp

    @if($order->status !== 'cancelled')
    <div class="mb-10 overflow-x-auto hide-scrollbar pb-4">
        <div class="flex items-center min-w-[600px] px-2">
            {{-- Step 1: Created --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 1 ? 'completed' : ($currentIndex == 1 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 1)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Order Created</div>
                    <div class="text-[9px] text-gray-400 font-medium mt-0.5">{{ $order->created_at->format('d M, H:i') }}</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 2: Admin Review --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 2 ? 'completed' : ($currentIndex == 2 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 1)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Admin Review</div>
                    <div class="text-[9px] text-gray-400 font-medium mt-0.5">In Progress</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 3: Price Negotiation --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 3 ? 'completed' : ($currentIndex == 3 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 2)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Price Negotiation</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 4: Service Process --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 4 ? 'completed' : ($currentIndex == 4 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 3)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 4 ? 'text-gray-900' : 'text-gray-400' }}">Service Process</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 5: Payment --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 5 ? 'completed' : ($currentIndex == 5 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 4)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 5 ? 'text-gray-900' : 'text-gray-400' }}">Payment</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-100 transition-colors"></div>
            </div>

            {{-- Step 6: Completed --}}
            <div class="step-item flex-1 relative {{ $currentIndex == 6 ? 'completed active' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 6)<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[10px] font-bold uppercase mt-3 {{ $currentIndex >= 6 ? 'text-gray-900' : 'text-gray-400' }}">Completed</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Banner "What's happening now?" --}}
    @if($order->status !== 'cancelled')
    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 mb-8 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center shrink-0 shadow-sm">
            @if($order->status === 'processing')
                <div class="w-2.5 h-2.5 rounded-full bg-teal-500 animate-pulse"></div>
            @elseif($order->status === 'waiting_payment')
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            @elseif($order->status === 'completed')
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-1">
                @if($order->status === 'processing')
                    Service in Progress
                @elseif($order->status === 'waiting_payment')
                    Service Completed Successfully
                @elseif(in_array($order->status, ['paid', 'completed']))
                    Order Completed
                @else
                    What's happening now?
                @endif
            </h3>
            @if($order->status === 'pending_valuation' && $order->agreed_price === null)
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Your order is being reviewed by Admin. We are verifying service details. Admin will contact you via chat to discuss details and total price if needed.</p>
            @elseif($order->status === 'pending_valuation' && $order->agreed_price !== null)
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Admin has sent a price proposal for your order. Please review the cost details below and make your decision.</p>
            @elseif($order->status === 'waiting_payment')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Good news! Our professional staff have successfully completed the service. Please review the work summary and the final payment details below.</p>
            @elseif($order->status === 'processing')
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Our professional staff is currently working at your location. You can track the progress below and contact them if needed.</p>
            @elseif(in_array($order->status, ['paid', 'completed']))
                <p class="text-xs text-gray-600 font-medium leading-relaxed">Thank you! Payment received and service successfully completed. We hope you're satisfied with the results.</p>
            @endif
        </div>
    </div>
    @endif


    @if($order->status === 'pending_valuation' && $order->agreed_price !== null)
        {{-- NEGOTIATION VIEW --}}
        <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 shadow-sm mb-10">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-black text-gray-900 font-plus">Pro-invoice from Admin</h2>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-gray-100 text-gray-500 border border-gray-200 uppercase tracking-tighter">Awaiting Approval</span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium mt-1">PO# {{ $order->invoice_number ?? 'BWP-2026-0001' }} • Awaiting your approval</p>
                        <p class="text-[10px] text-gray-400 font-medium italic">Valid until {{ now()->addDays(5)->translatedFormat('d M Y') }} • 5 days left</p>
                    </div>
                </div>
                <button class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors hidden sm:block">
                    Download Pre-Invoice
                </button>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Ringkasan Biaya</h3>
                <div class="space-y-4 text-sm font-medium">
                    <div class="flex justify-between items-start pb-4 border-b border-gray-50">
                        <div>
                            <div class="text-gray-900 font-bold">{{ $order->product->name }}</div>
                            <div class="text-[11px] text-gray-400">Layanan profesional dari {{ $order->umkm->name }}</div>
                        </div>
                        <div class="text-gray-900 font-bold">Rp {{ number_format($order->agreed_price, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="flex justify-between items-center pt-2">
                        <div class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Total Bayar</div>
                        <div class="text-gray-900 font-black font-plus text-lg">Rp {{ number_format($order->agreed_price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-100 to-transparent rounded-bl-full opacity-50"></div>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Estimated Range</div>
                        <p class="text-[11px] text-gray-500 font-medium">Final price depends on actual work completed</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-gray-900 font-plus tracking-tight">Rp {{ number_format($order->agreed_price ?? 2600000, 0, ',', '.') }}</div>
                        <div class="text-[11px] font-bold text-gray-400 mt-1">± 15% tolerance</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-200 relative z-10">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Minimum</div>
                        <div class="text-sm font-bold text-gray-900">Rp {{ number_format(($order->agreed_price ?? 2600000) * 0.85, 0, ',', '.') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Maximum</div>
                        <div class="text-sm font-bold text-gray-900">Rp {{ number_format(($order->agreed_price ?? 2600000) * 1.15, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h4 class="text-xs font-bold text-blue-900">Notes from Admin</h4>
                </div>
                <p class="text-[11px] text-blue-800 font-medium leading-relaxed">
                    Price may vary after on-site inspection. Final invoice will include: (1) actual area measured, (2) extra services requested, (3) work complexity adjustments. Work be authorized before any additional charges are applied. Final invoice will be sent after service completion for your approval.
                </p>
                <ul class="mt-3 space-y-1 text-[10px] text-blue-700 font-medium list-disc list-inside">
                    <li>Prices quoted are for standard work conditions</li>
                    <li>Payment due after service completion (COD/Transfer)</li>
                    <li>You can negotiate via chat if needed</li>
                </ul>
            </div>

            <div class="border-t border-gray-100 pt-8">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Do you agree with this price?</h3>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button wire:click="toggleAcceptModal" class="flex-1 py-3.5 bg-[#2D2D2D] text-white rounded-xl text-xs font-bold hover:bg-black transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Accept & Continue to Schedule
                    </button>
                    <button class="sm:w-1/3 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Negotiate via Chat
                    </button>
                    <button wire:click="rejectPrice" wire:confirm="Are you sure you want to reject and cancel this order?" class="sm:w-1/4 py-3.5 bg-white border border-red-200 text-red-600 rounded-xl text-xs font-bold hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reject
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 font-medium mt-3 text-center">After accepting, you will schedule your service time. No payment required yet - you pay after service completion.</p>
            </div>
        </div>

        {{-- Order Details Accordion --}}
        <div class="bg-white border border-gray-200 rounded-2xl mb-6 shadow-sm overflow-hidden" x-data="{ expanded: false }">
            <button @click="expanded = !expanded" class="w-full p-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors">
                <h3 class="text-sm font-bold text-gray-900">Order Details</h3>
                <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    <span x-text="expanded ? 'Show Less' : 'Show More'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div x-show="expanded" x-cloak>
                <div class="p-6 pt-0 border-t border-gray-100 bg-gray-50/50">
                    <ul class="space-y-3 text-xs text-gray-600 font-medium">
                        <li><strong class="text-gray-900">Service Type:</strong> {{ $order->product->name ?? 'N/A' }}</li>
                        <li><strong class="text-gray-900">Location:</strong> {{ $order->service_address ?? 'N/A' }}</li>
                        <li><strong class="text-gray-900">Requested Date:</strong> {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('d M Y') : 'TBD' }}</li>
                        <li><strong class="text-gray-900">Time Preference:</strong> Morning (09:00 - 12:00)</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Chat History Accordion --}}
        <div class="bg-white border border-gray-200 rounded-2xl mb-10 shadow-sm overflow-hidden" x-data="{ expanded: true }">
            <button @click="expanded = !expanded" class="w-full p-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900">Chat History with Admin</h3>
                <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    <span x-text="expanded ? 'Hide Chat' : 'Show Chat'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div x-show="expanded" x-cloak>
                <div class="p-6 bg-gray-50/30 space-y-4">
                    {{-- Chat Bubble Admin --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-gray-500">AD</span>
                        </div>
                        <div class="flex-1 bg-white border border-gray-200 rounded-2xl rounded-tl-none p-4 shadow-sm">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-bold text-gray-900">Admin</span>
                                <span class="text-[10px] text-gray-400">{{ now()->subHours(2)->format('d M, H:i') }}</span>
                            </div>
                            <p class="text-xs text-gray-600 font-medium leading-relaxed">Hello! I've received your order and prepared a price estimate based on the standard 50m² requirement plus your extra 2 bathrooms note. Please review the details above. Let me know if you have any questions.</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-white border-t border-gray-100">
                    <div class="relative">
                        <input type="text" placeholder="Type a message..." class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-black/5 transition-all outline-none">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-black transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @elseif($order->status === 'processing')
        {{-- SERVICE PROCESS VIEW (Step 4) --}}
        <div class="space-y-8">
            {{-- Progress Status Card --}}
            <div class="bg-white border border-gray-200 rounded-[32px] p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-gray-900 font-plus">Service In Progress</h2>
                            <p class="text-xs text-gray-500 font-medium">Started at 09:30 WIB</p>
                        </div>
                    </div>
                    <span class="px-4 py-2 bg-teal-50 text-teal-700 rounded-xl text-[10px] font-black uppercase tracking-widest border border-teal-100 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                        Working Now
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-end mb-1">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Progress</span>
                        <span class="text-xs font-black text-gray-900 font-plus">1h 10m elapsed</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden flex border border-gray-200/50">
                        <div class="w-3/5 bg-gray-900 rounded-full"></div>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-bold text-gray-400">
                        <span>Started: 09:30</span>
                        <span>Est. finish: 11:30 WIB (2h remaining)</span>
                    </div>
                </div>
            </div>

            {{-- Staff Team Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Staff Team</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($staffTeam as $staff)
                    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-5 group hover:bg-white hover:border-gray-200 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-sm font-black text-gray-400 group-hover:border-gray-900 group-hover:text-gray-900 transition-colors">
                                    {{ $staff['initials'] }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-gray-900 font-plus">{{ $staff['name'] }}</h4>
                                    <p class="text-[10px] text-gray-500 font-medium">{{ $staff['experience'] }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-white border border-gray-200 rounded text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $staff['role'] }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <button class="py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-bold text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Call
                            </button>
                            <button class="py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-bold text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Service Details Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Service Details</h3>
                <div class="bg-gray-50/50 border border-gray-100 rounded-3xl p-6 md:p-8 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Service Date</p>
                            <p class="text-sm font-black text-gray-900">{{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('l, d F Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Time Slot</p>
                            <p class="text-sm font-black text-gray-900">09:30 - 11:30 WIB (2 hours)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Service Location</p>
                            <p class="text-xs font-bold text-gray-900 leading-relaxed">{{ $order->service_address }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Work Scope</p>
                    <div class="space-y-3">
                        @foreach($workScope as $scope)
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-100"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">{{ $scope }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Work Progress Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-6 h-6 rounded-full bg-gray-900 border-4 border-white flex items-center justify-center shrink-0 shadow-sm">
                        <div class="w-1 h-1 rounded-full bg-white"></div>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Work Progress</h3>
                </div>
                <p class="text-[11px] text-gray-500 font-medium mb-8">Staff will update progress as they complete each task.</p>

                <div class="space-y-8 relative">
                    <div class="absolute left-[9px] top-2 bottom-2 w-px bg-gray-100"></div>
                    @foreach($workProgress as $progress)
                    <div class="flex gap-6 relative z-10 {{ $progress['status'] === 'pending' ? 'opacity-40' : '' }}">
                        <div class="w-5 h-5 rounded-full border-2 {{ $progress['status'] === 'completed' ? 'bg-gray-900 border-gray-900' : ($progress['status'] === 'in_progress' ? 'bg-white border-gray-900' : 'bg-white border-gray-200') }} flex items-center justify-center shrink-0 shadow-sm">
                            @if($progress['status'] === 'completed')
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @elseif($progress['status'] === 'in_progress')
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-900 animate-pulse"></div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="text-xs font-black text-gray-900">{{ $progress['task'] }} - {{ ucfirst(str_replace('_', ' ', $progress['status'])) }}</p>
                                @if($progress['time'] && $progress['status'] === 'completed')
                                    <span class="text-[9px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">Finished at {{ $progress['time'] }}</span>
                                @endif
                            </div>
                            @if($progress['time'] && $progress['status'] === 'in_progress')
                                <p class="text-[10px] text-gray-500 font-bold mt-1 tracking-tight">{{ $progress['time'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Important Notes Card --}}
            <div class="bg-gray-50 border border-gray-200 rounded-[32px] p-8">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Important Notes</h3>
                </div>
                <ul class="space-y-4 text-xs font-medium text-gray-600 list-disc list-inside">
                    <li>Please ensure the staff has access to water and electricity.</li>
                    <li>You can contact staff directly if you have specific requests.</li>
                    <li>Payment will be required after service completion.</li>
                    <li>Staff take a verification photo after service is complete.</li>
                </ul>
            </div>

            @if($order->work_result_photos)
            {{-- Staff Work Results Card --}}
            <div class="bg-white border-2 border-teal-500 rounded-[32px] p-8 shadow-lg shadow-teal-50/50">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-500 text-white flex items-center justify-center shadow-lg shadow-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Hasil Kerja Staff</h3>
                            <p class="text-[10px] text-teal-600 font-bold uppercase tracking-widest mt-0.5">Menunggu Persetujuan Anda</p>
                        </div>
                    </div>
                </div>

                @if($order->worker_notes)
                <div class="p-6 bg-teal-50/50 rounded-2xl border border-teal-100 mb-8">
                    <p class="text-[9px] font-black text-teal-700 uppercase tracking-widest mb-2">Laporan Staff:</p>
                    <p class="text-xs font-bold text-gray-800 italic leading-relaxed">"{{ $order->worker_notes }}"</p>
                </div>
                @endif

                <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-4 mb-8">
                    @foreach($order->work_result_photos as $image)
                    <div class="w-40 h-40 md:w-56 md:h-56 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 shrink-0 group relative cursor-pointer">
                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                            <svg class="w-6 h-6 text-white scale-0 group-hover:scale-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0h-3"/></svg>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button wire:click="approveWork" class="flex-1 py-5 bg-gray-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-gray-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Setujui Hasil & Lanjut ke Pembayaran
                    </button>
                    <button class="px-8 py-5 bg-white border border-gray-200 text-gray-400 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                        Laporkan Masalah
                    </button>
                </div>
            </div>
            @endif

            {{-- Process Action Buttons --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="py-4 bg-white border border-gray-200 rounded-2xl text-xs font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Chat with Staff
                </button>
                <button class="py-4 bg-white border border-gray-200 rounded-2xl text-xs font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Report Issue
                </button>
                <button class="py-4 bg-white border border-gray-200 rounded-2xl text-xs font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Share Status
                </button>
            </div>
        </div>
    @elseif($order->status === 'waiting_payment')
        {{-- PAYMENT VIEW (Step 5) --}}
        <div class="space-y-8">
            {{-- Work Summary Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Service Summary</h3>
                <div class="bg-gray-50/50 border border-gray-100 rounded-3xl p-6 md:p-8 space-y-6">
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Completed Date</p>
                            <p class="text-sm font-black text-gray-900">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Work Completed</p>
                            @foreach($workScope as $scope)
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-[11px] font-bold text-gray-600">{{ $scope }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="space-y-3">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Staff Insights</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-xs font-black text-gray-400">AS</div>
                                <div>
                                    <p class="text-[11px] font-black text-gray-900">Ahmad Syarif</p>
                                    <p class="text-[9px] text-gray-500 font-medium">Team Lead</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Final Payment Card --}}
            <div class="bg-white border border-gray-200 rounded-[32px] p-6 md:p-10 shadow-sm overflow-hidden relative">
                <div class="absolute top-0 right-0 p-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-lg text-[9px] font-black uppercase tracking-tighter border border-gray-200">Final Invoice</span>
                </div>
                
                <h3 class="text-xl font-black text-gray-900 font-plus mb-8">Final Payment Required</h3>

                <div class="space-y-6">
                    {{-- Base Services --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Service Breakdown</p>
                        <div class="space-y-3">
                            @foreach($paymentDetails['base_services'] as $service)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 font-bold">{{ $service['name'] }}</span>
                                <span class="text-gray-900 font-black">Rp {{ number_format($service['price'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Additional Services --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-2 py-0.5 bg-gray-900 text-white rounded text-[8px] font-black uppercase tracking-tighter">Additional Services</span>
                            <span class="text-[10px] font-bold text-gray-400">Requested during work</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($paymentDetails['additional_services'] as $service)
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500 font-bold">{{ $service['name'] }}</span>
                                <span class="text-gray-900 font-black">Rp {{ number_format($service['price'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Calculation --}}
                    <div class="pt-6 border-t border-gray-100 space-y-3">
                        @foreach($paymentDetails['discounts'] as $discount)
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-teal-600 font-bold">{{ $discount['name'] }}</span>
                            <span class="text-teal-600 font-black">- Rp {{ number_format($discount['amount'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        @foreach($paymentDetails['fees'] as $fee)
                        <div class="flex justify-between items-center text-xs text-gray-400">
                            <span class="font-bold">{{ $fee['name'] }}</span>
                            <span>+ Rp {{ number_format($fee['amount'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Final Price --}}
                    <div class="pt-8 border-t-2 border-gray-900 flex justify-between items-center">
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-lg font-black text-gray-900 font-plus uppercase">Final Price</h4>
                                <span class="px-2 py-0.5 bg-teal-500 text-white rounded text-[8px] font-black uppercase tracking-tighter">Fixed</span>
                            </div>
                            <p class="text-[10px] text-gray-400 font-medium mt-1">Verified by UMKM Admin</p>
                        </div>
                        <div class="text-3xl font-black text-gray-900 font-plus">Rp {{ number_format($paymentDetails['final_total'], 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Comparison Block --}}
                <div class="mt-10 pt-8 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Price Comparison</h4>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-[11px] font-bold">
                                <span class="text-gray-400">Initial Estimate:</span>
                                <span class="text-gray-500 line-through italic">Rp 2.210.000 - Rp 2.990.000</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-black">
                                <span class="text-gray-900">Final Price:</span>
                                <span class="text-gray-900">Rp {{ number_format($paymentDetails['final_total'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <p class="text-[10px] text-gray-500 font-medium leading-relaxed italic">
                            "Price is within the projected estimate range. Additional services were requested and verified during the service process."
                        </p>
                    </div>
                </div>
            </div>

            {{-- QRIS Payment Card --}}
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 md:p-12 shadow-sm">
                <div class="max-w-md mx-auto text-center">
                    <h3 class="text-xl font-black text-gray-900 font-plus mb-2">QRIS Payment</h3>
                    <p class="text-xs text-gray-500 font-medium mb-10 uppercase tracking-widest">Scan QR code below to pay</p>
                    
                    {{-- QR Code Display --}}
                    <div class="bg-white p-6 rounded-[40px] border-2 border-gray-900 shadow-2xl shadow-gray-100 inline-block mb-10 relative group">
                        @if($order->umkm->qris_image_url)
                            <img src="{{ asset($order->umkm->qris_image_url) }}" class="w-64 h-64 md:w-80 md:h-80 mx-auto rounded-2xl object-contain">
                        @else
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=ORDER-{{ $order->id }}-TOTAL-{{ $order->agreed_price }}" class="w-64 h-64 md:w-80 md:h-80 mx-auto rounded-2xl">
                        @endif
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                            <span class="px-6 py-3 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">UMKM Verified QRIS</span>
                        </div>
                    </div>

                    <div class="space-y-4 text-left mb-10">
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-xs shrink-0 shadow-sm border border-gray-100">1</div>
                            <p class="text-[11px] font-bold text-gray-600 leading-relaxed">Buka aplikasi mobile banking atau e-wallet (GoPay, OVO, Dana, dll).</p>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-xs shrink-0 shadow-sm border border-gray-100">2</div>
                            <p class="text-[11px] font-bold text-gray-600 leading-relaxed">Scan kode QR di atas dan masukkan nominal sesuai tagihan.</p>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-xs shrink-0 shadow-sm border border-gray-100">3</div>
                            <p class="text-[11px] font-bold text-gray-600 leading-relaxed">Simpan bukti transfer dan unggah di bawah ini untuk verifikasi admin.</p>
                        </div>
                    </div>

                    {{-- Upload Section --}}
                    @php $pendingPayment = $order->payments->where('status', 'pending')->first(); @endphp

                    @if($pendingPayment)
                        <div class="p-8 bg-blue-50 rounded-[32px] border border-blue-100 flex flex-col items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-center">
                                <h4 class="text-sm font-black text-blue-900 font-plus mb-1 uppercase tracking-tight">Menunggu Verifikasi</h4>
                                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest leading-relaxed">Bukti pembayaran Anda sedang dicek oleh Admin UMKM.</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="relative group">
                                <input type="file" wire:model="paymentProof" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="p-8 bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200 group-hover:border-gray-900 transition-all flex flex-col items-center gap-4">
                                    @if($paymentProof)
                                        <img src="{{ $paymentProof->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-2xl shadow-lg border-2 border-white">
                                        <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Receipt Selected ✓</p>
                                    @else
                                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-gray-900 group-hover:text-white transition-all shadow-sm border border-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-black text-gray-900 font-plus uppercase">Upload Bukti Transfer</h4>
                                            <p class="text-[10px] text-gray-400 font-bold mt-1 tracking-tight">Format: JPG, PNG, max 2MB</p>
                                        </div>
                                    @endif
                                </div>
                                @error('paymentProof') <span class="text-[10px] text-red-500 font-bold mt-2 inline-block">{{ $message }}</span> @enderror
                            </div>

                            <button 
                                wire:click="submitPayment"
                                wire:loading.attr="disabled"
                                class="w-full py-5 bg-gray-900 text-white rounded-[24px] font-black text-xs uppercase tracking-widest transition-all shadow-xl hover:bg-black disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="submitPayment">Submit Bukti Pembayaran</span>
                                <span wire:loading wire:target="submitPayment">Mengirim Bukti...</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif(in_array($order->status, ['paid', 'completed']))
        {{-- COMPLETED VIEW (Step 6) --}}
        <div class="space-y-8">
            {{-- Review Section --}}
            @if(!$order->review)
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 font-plus mb-2">How do you feel?</h3>
                <p class="text-sm text-gray-500 font-medium mb-8">Awesome experience with {{ $order->umkm->name }}?</p>
                <a href="{{ route('customer.order-review', $order->id) }}" class="px-8 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg flex items-center justify-center gap-2 mx-auto w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Write a Review
                </a>
            </div>
            @else
            <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-[32px] p-8 shadow-xl text-center text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-xl font-black font-plus mb-2">Thank you for your review!</h3>
                    <p class="text-sm text-teal-50 font-medium mb-0">Your feedback helps {{ $order->umkm->name }} improve their service and helps other customers make better choices.</p>
                </div>
            </div>
            @endif

            {{-- Work Results Gallery --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Work Results / Order Photos</h3>
                    <span class="text-[10px] font-bold text-gray-400">{{ count($this->workResults) }} Photos attached</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    @foreach($this->workResults as $image)
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 group relative">
                        <img src="{{ $image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                    </div>
                    @endforeach
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="flex-1 py-3.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        View in Gallery Mode
                    </button>
                    <button class="flex-1 py-3.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Photos
                    </button>
                </div>
            </div>

            {{-- Payment Summary Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Payment Summary</h3>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-tighter">Paid Date</span>
                        <span class="text-gray-900 font-black">14 Jan 2024, 11:45</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-tighter">Total Paid</span>
                        <span class="text-gray-900 font-black">Rp 2.728.800</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-tighter">Method</span>
                        <span class="text-gray-900 font-black">Bank Transfer (BCA)</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-400 font-bold uppercase tracking-tighter">Transaction ID</span>
                        <span class="text-gray-900 font-black">TRX-992100445</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="flex-1 py-3.5 bg-gray-50 rounded-xl text-[10px] font-black text-gray-900 hover:bg-gray-100 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Full Invoice
                    </button>
                    <button class="flex-1 py-3.5 bg-gray-50 rounded-xl text-[10px] font-black text-gray-900 hover:bg-gray-100 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                        Download Receipt
                    </button>
                </div>
            </div>

            {{-- Rebook Section --}}
            <div class="bg-gray-900 rounded-[40px] p-10 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-bl-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>
                <h3 class="text-2xl font-black font-plus mb-2 relative z-10">Want to book for this again?</h3>
                <p class="text-gray-400 text-sm font-medium mb-8 relative z-10">Repeat this service with the same professional team.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10 relative z-10">
                    <button class="p-4 bg-white/10 border border-white/20 rounded-2xl text-left hover:bg-white/20 transition-all">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Frequency</p>
                        <p class="text-sm font-black">One-time</p>
                    </button>
                    <button class="p-4 bg-white/10 border border-white/20 rounded-2xl text-left hover:bg-white/20 transition-all">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Frequency</p>
                        <p class="text-sm font-black">Monthly</p>
                    </button>
                    <button class="p-4 bg-white/10 border border-white/20 rounded-2xl text-left hover:bg-white/20 transition-all">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Frequency</p>
                        <p class="text-sm font-black">Weekly</p>
                    </button>
                </div>

                <button class="w-full py-5 bg-white text-gray-900 rounded-[24px] font-black text-sm uppercase tracking-widest hover:bg-gray-100 transition-all shadow-xl flex items-center justify-center gap-3 relative z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Book Again
                </button>
            </div>

            {{-- Share Section --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <h4 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-1 text-center md:text-left">Share your success</h4>
                        <p class="text-[11px] text-gray-500 font-medium text-center md:text-left">Let your friends know about your clean space!</p>
                    </div>
                    <div class="flex gap-3">
                        <button class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </button>
                        <button class="w-12 h-12 rounded-2xl bg-teal-500 flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.77-5.764-5.77zm3.391 8.232c-.154.433-.746.77-1.028.814-.247.039-.553.056-.906-.057-.233-.074-.527-.172-.857-.311-1.414-.59-2.316-2.022-2.386-2.115-.07-.093-.578-.769-.578-1.479 0-.71.372-1.058.504-1.203.132-.144.288-.18.384-.18s.192.001.276.005c.094.004.22-.035.344.267.126.307.432 1.053.47 1.13.038.077.064.167.013.269-.051.103-.077.167-.154.257-.077.09-.161.2-.23.269-.077.077-.158.161-.068.315.09.154.399.658.855 1.064.588.524 1.082.686 1.236.762.154.077.243.064.333-.038.09-.103.384-.449.487-.603.103-.154.205-.128.346-.077s.91.43 1.064.513c.154.083.256.128.295.192.039.064.039.372-.115.805zM12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.013 21.05c-1.636 0-3.23-.433-4.629-1.253l-3.303.866.881-3.218c-.9-1.458-1.375-3.136-1.373-4.856.003-5.068 4.129-9.19 9.199-9.19 2.456.001 4.765.957 6.5 2.694 1.734 1.737 2.69 4.048 2.688 6.502-.004 5.07-4.13 9.195-9.163 9.195z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- STANDARD VIEW --}}
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

        {{-- Site Photos (Dynamic) --}}
        <div class="mb-12">
            <h2 class="text-xl font-black text-gray-900 font-plus mb-4">Site Photos ({{ count($this->workResults) }} photos)</h2>
            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-2">
                @foreach($this->workResults as $image)
                <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 shrink-0 group relative">
                    <img src="{{ $image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                </div>
                @endforeach
            </div>
            @if(count($this->workResults) > 0)
            <button class="mt-4 px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                View All Photos
            </button>
            @endif
        </div>
    @endif

    {{-- Order Activity Timeline --}}
    <div class="mb-12">
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6">Order Activity</h2>
        
        <div class="space-y-8 relative">
            <div class="absolute left-[11px] top-2 bottom-2 w-px bg-gray-100"></div>
            
            {{-- Loop through Logs --}}
            @forelse($logs as $log)
                <div class="flex gap-6 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-gray-900 border-4 border-white flex items-center justify-center shrink-0 shadow-sm">
                        {{-- Dot --}}
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $log->created_at->format('d M, H:i') }}</p>
                        <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $log->action }}</p>
                        @if($log->reason)
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1 italic">"{{ $log->reason }}"</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="flex gap-6 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-gray-900 border-4 border-white flex items-center justify-center shrink-0 shadow-sm">
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M, H:i') }}</p>
                        <p class="text-xs font-bold text-gray-900 mt-0.5">Order Created</p>
                    </div>
                </div>
            @endforelse
            
            {{-- Future Step Indicator --}}
            @if($order->status !== 'completed' && $order->status !== 'cancelled')
            <div class="flex gap-6 relative z-10 opacity-40">
                <div class="w-6 h-6 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center shrink-0">
                    {{-- Empty Dot --}}
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Next Step</p>
                    <p class="text-xs font-bold text-gray-400 mt-0.5">Awaiting further progress...</p>
                </div>
            </div>
            @endif
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

    {{-- CONFIRM ACCEPTANCE MODAL --}}
    @if($showAcceptModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="toggleAcceptModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-8 md:p-10">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-100">
                        <div class="w-8 h-8 rounded-full border-4 border-gray-900 flex items-center justify-center">
                            <div class="w-2 h-2 rounded-full bg-gray-900"></div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 font-plus mb-2" id="modal-title">Confirm Acceptance</h3>
                    <p class="text-sm text-gray-500 font-medium">Are you sure you accept this price range?</p>
                </div>

                <div class="mt-8 bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="text-center border-b border-gray-200 pb-4 mb-4">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Estimated Total:</div>
                        <div class="text-2xl font-black text-gray-900 font-plus">Rp {{ number_format($order->agreed_price ?? 2600000, 0, ',', '.') }}</div>
                        <div class="text-[10px] font-bold text-gray-400 mt-1">± 15%</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Minimum</div>
                            <div class="text-sm font-black text-gray-900 font-plus">Rp {{ number_format(($order->agreed_price ?? 2600000) * 0.85, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Maximum</div>
                            <div class="text-sm font-black text-gray-900 font-plus">Rp {{ number_format(($order->agreed_price ?? 2600000) * 1.15, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-gray-50/50 rounded-2xl p-4 border border-gray-100 flex gap-3 items-start">
                    <div class="w-5 h-5 bg-white rounded-full flex items-center justify-center border border-gray-200 shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-gray-900 mb-1 uppercase tracking-wide">Important Notice</h4>
                        <p class="text-[10px] text-gray-500 font-medium leading-relaxed">
                            By accepting, you agree to the estimated price range. Final invoice will be calculated based on actual work completed and sent after service completion. You will be notified before payment is required.
                        </p>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-2 gap-4">
                    <button type="button" wire:click="toggleAcceptModal" class="py-4 bg-white border border-gray-200 rounded-2xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="acceptPrice" class="py-4 bg-[#2D2D2D] rounded-2xl text-xs font-bold text-white hover:bg-black transition-colors shadow-lg">
                        Yes, Accept & Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
