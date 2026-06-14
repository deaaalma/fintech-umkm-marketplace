<x-slot:title>Detail Pesanan</x-slot>

@push('styles')
<style>
    /* Custom Scrollbar for photos */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Stepper Logic */
    .step-item.active .step-icon {
        background-color: #000B44;
        color: white;
        border-color: #000B44;
    }
    .step-item.completed .step-icon {
        background-color: #000B44;
        color: white;
        border-color: #000B44;
    }
    .step-item.completed .step-line {
        background-color: #000B44;
    }
</style>
@endpush

<div class="w-full pb-20" wire:poll.5s>
    <div class="animate-fade-in-up">
    
    {{-- Header Section --}}
    <div class="mb-8">

        
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
            <span aria-label="Status Pesanan" class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold border uppercase tracking-widest {{ $statusBadge['class'] }}">
                {{ $statusBadge['label'] }}
            </span>
            {{-- State: Negotiation / Price Agreement --}}
            @if($order->status === 'negotiation' || ($order->status === 'pending_valuation' && $order->agreed_price !== null))
            <span aria-live="polite" class="text-sm text-gray-700 font-bold ml-2">Tindakan Anda Diperlukan</span>
            @endif
        </div>
        
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-2">#{{ $order->invoice_number ?? 'ORDER-'.$order->id }}</h1>
        <p class="text-gray-700 text-sm font-medium">Dibuat, {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <hr class="border-gray-100 mb-8">

    {{-- Stepper Progress --}}
    @php
        $currentIndex = $order->current_step;
    @endphp

    @if($order->status !== 'cancelled')
    <div class="mb-10 overflow-x-auto hide-scrollbar pb-4">
        <div class="flex items-start min-w-[800px] px-2">
            {{-- Step 1: Created --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 1 ? 'completed' : ($currentIndex == 1 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 1)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 1 ? 'text-gray-900' : 'text-gray-500' }}">Pesanan Dibuat</div>
                    <div class="text-[10px] text-center text-gray-500 font-medium mt-0.5">{{ $order->created_at->format('d M, H:i') }}</div>
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-200 transition-colors"></div>
            </div>

            {{-- Step 2: Tinjauan Admin --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 2 ? 'completed' : ($currentIndex == 2 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 1)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 2 ? 'text-gray-900' : 'text-gray-500' }}">Tinjauan Admin</div>
                    @if($currentIndex == 2)
                    <div class="text-[10px] text-center text-gray-500 font-medium mt-0.5">Sedang Berjalan</div>
                    @endif
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-200 transition-colors"></div>
            </div>

            {{-- Step 3: Negosiasi Harga --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 3 ? 'completed' : ($currentIndex == 3 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 2)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 3 ? 'text-gray-900' : 'text-gray-500' }}">Negosiasi Harga</div>
                    @if($currentIndex == 3)
                    <div class="text-[10px] text-center text-gray-500 font-medium mt-0.5">Sedang Berjalan</div>
                    @endif
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-200 transition-colors"></div>
            </div>

            {{-- Step 4: Proses Layanan --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 4 ? 'completed' : ($currentIndex == 4 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 3)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 4 ? 'text-gray-900' : 'text-gray-500' }}">Proses Layanan</div>
                    @if($currentIndex == 4)
                    <div class="text-[10px] text-center text-gray-500 font-medium mt-0.5">Sedang Berjalan</div>
                    @endif
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-200 transition-colors"></div>
            </div>

            {{-- Step 5: Pembayaran --}}
            <div class="step-item flex-1 relative {{ $currentIndex > 5 ? 'completed' : ($currentIndex == 5 ? 'active' : '') }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex > 4)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 5 ? 'text-gray-900' : 'text-gray-500' }}">Pembayaran</div>
                    @if($currentIndex == 5)
                    <div class="text-[10px] text-center text-gray-500 font-medium mt-0.5">Sedang Berjalan</div>
                    @endif
                </div>
                <div class="step-line absolute top-3 left-1/2 w-full h-[2px] bg-gray-200 transition-colors"></div>
            </div>

            {{-- Step 6: Selesai --}}
            <div class="step-item flex-1 relative {{ $currentIndex == 6 ? 'completed active' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="step-icon w-6 h-6 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center z-10 transition-colors">
                        @if($currentIndex >= 6)<svg aria-hidden="true" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@endif
                    </div>
                    <div class="text-[11px] text-center font-bold uppercase mt-3 {{ $currentIndex >= 6 ? 'text-gray-900' : 'text-gray-500' }}">Selesai</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Banner "Status Pesanan Saat Ini" --}}
    @if($order->status !== 'cancelled')
    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 mb-8 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center shrink-0 shadow-sm">
            @if($order->status === 'processing')
                <div class="w-2.5 h-2.5 rounded-full bg-blue-900 animate-pulse"></div>
            @elseif($order->status === 'waiting_payment')
                <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            @elseif($order->status === 'completed')
                <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-1">
                @if($order->status === 'processing')
                    @if($order->orderAssignment)
                        Layanan Sedang Berjalan
                    @else
                        Menunggu Penugasan Staf
                    @endif
                @elseif($order->status === 'waiting_payment')
                    Menunggu Pembayaran
                @elseif(in_array($order->status, ['paid', 'completed']))
                    Order Selesai
                @else
                    Status Pesanan Saat Ini
                @endif
            </h3>
            @if($order->status === 'pending_valuation' && $order->agreed_price === null)
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Pesanan Anda sedang ditinjau oleh Admin untuk verifikasi detail layanan. Admin akan menghubungi Anda via chat untuk mendiskusikan detail dan total harga jika diperlukan.</p>
                <button wire:click="$set('showCancelModal', true)" class="mt-3 text-xs font-bold text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                    Batalkan Pesanan
                </button>
            @elseif($order->status === 'pending_valuation' && $order->agreed_price !== null)
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Admin telah mengirimkan penawaran harga untuk pesanan Anda. Silakan periksa rincian biaya di bawah ini.</p>
            @elseif($order->status === 'waiting_payment')
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Pengerjaan layanan telah selesai. Silakan lakukan pembayaran sesuai dengan harga yang telah disepakati sebelumnya.</p>
            @elseif($order->status === 'processing')
                @if($order->orderAssignment)
                    <p class="text-sm text-gray-600 font-medium leading-relaxed">Staf profesional kami sedang bekerja di lokasi Anda. Anda dapat melacak progresnya di bawah ini dan menghubungi mereka jika diperlukan.</p>
                @else
                    <p class="text-sm text-gray-600 font-medium leading-relaxed">Pesanan Anda telah masuk tahap pengerjaan. Admin sedang mengatur jadwal dan akan segera menugaskan staf untuk Anda.</p>
                @endif
            @elseif(in_array($order->status, ['paid', 'completed']))
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Thank you! Pembayaran received and service successfully completed. We hope you're satisfied with the results.</p>
            @endif
        </div>
    </div>
    @endif


    @php
        $proposals = $order->messages()->where('type', 'proposal')->orderBy('created_at', 'asc')->get();
        if ($proposals->isEmpty() && $order->agreed_price !== null) {
            $proposals = collect([(object)[
                'metadata' => ['price' => $order->agreed_price, 'status' => 'pending']
            ]]);
        }
        $latestProposal = $proposals->last();
        $isLatestPending = $latestProposal ? ($latestProposal->metadata['status'] ?? 'pending') === 'pending' : false;
    @endphp

    @if($order->status === 'pending_valuation' && count($proposals) > 0)
        {{-- NEGOTIATION VIEW (Formal Table Style) --}}
        <div class="mb-10 w-full overflow-x-auto">
            <h2 class="text-2xl font-black text-gray-900 font-plus mb-6 text-center uppercase tracking-widest">PROPOSAL HARGA</h2>
            
            <div class="border border-gray-400 min-w-[800px] bg-white text-sm font-medium">
                {{-- Nama UMKM / Vendor --}}
                <div class="bg-white border-b border-gray-400 p-2.5 font-bold text-gray-900 text-sm">
                    {{ $order->umkm->name ?? 'Mitra UMKM' }}
                </div>
                
                {{-- Product / Service Info --}}
                <div class="flex border-b border-gray-400 bg-white">
                    <div class="flex-1 p-2.5 border-r border-gray-400 flex items-center">
                        <span class="text-gray-600 mr-2">Nama:</span> <span class="font-bold text-gray-900">{{ $order->product->name }}</span>
                    </div>
                    <div class="w-32 p-2.5 border-r border-gray-400 flex items-center justify-center text-gray-700">
                        Qty: 1
                    </div>
                    <div class="w-48 p-2.5 border-r border-gray-400 flex items-center justify-center text-gray-700">
                        Waktu: {{ $order->estimated_duration ?? '1' }} Hari
                    </div>
                    <div class="w-48 p-2.5 font-bold text-gray-900 flex items-center justify-center">
                        Rp. {{ number_format($latestProposal->metadata['price'] ?? $order->agreed_price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-1 border-r border-gray-400">
                        
                        {{-- Lokasi Layanan --}}
                        <div class="font-bold p-2.5 text-gray-900 border-b border-gray-200">
                            Lokasi Layanan
                        </div>
                        <div class="p-4 border-b border-gray-400">
                            <div class="border border-gray-200 rounded p-3 text-gray-600 bg-gray-50/50">
                                {{ $order->service_address ?: 'Gedung Pusat Rektorat (Jalan Raya Kampus Unud, Jimbaran, Kuta Selatan, Badung Bali 80361 80625 - Badung Bali)' }}
                            </div>
                        </div>

                        @foreach($proposals as $index => $proposal)
                            @php
                                $price = $proposal->metadata['price'] ?? $order->agreed_price;
                                $status = $proposal->metadata['status'] ?? 'pending';
                                $isLast = $loop->last;
                            @endphp

                            {{-- Negosiasi Header --}}
                            <div class="font-bold p-2.5 text-gray-900 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                                <span>Negosiasi{{ count($proposals) > 1 ? ' ' . ($index + 1) : '' }}</span>
                                @if($status === 'rejected')
                                    <span class="text-red-600 text-xs px-2 py-1 bg-red-100 rounded border border-red-200">DITOLAK</span>
                                @endif
                            </div>
                            
                            <div class="{{ !$isLast ? 'opacity-60 bg-gray-50' : '' }}">
                                <div class="flex border-b border-gray-400">
                                    <div class="flex-1 p-4 font-bold text-gray-900 flex items-center">
                                        {{ $order->product->name }}
                                    </div>
                                    <div class="flex-1 p-4 border-l border-gray-400">
                                        <div class="border border-gray-200 rounded p-2.5 mb-1.5 bg-white text-gray-900 w-full max-w-sm {{ $status === 'rejected' ? 'line-through text-gray-500' : '' }}">
                                            {{ number_format($price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-red-500">Harga per 1 pcs</div>
                                    </div>
                                </div>
                                @if(!empty($proposal->metadata['note']))
                                <div class="flex {{ !$isLast ? 'border-b border-gray-400' : '' }}">
                                    <div class="flex-1 p-4 text-gray-700 flex items-center">
                                        Catatan dari Admin UMKM
                                    </div>
                                    <div class="flex-1 p-4 border-l border-gray-400">
                                        <div class="border border-gray-200 rounded p-3 bg-blue-50 text-gray-900 w-full text-sm italic">
                                            "{{ $proposal->metadata['note'] }}"
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($index === 0)
                                <div class="flex {{ !$isLast && empty($proposal->metadata['note']) ? 'border-b border-gray-400' : '' }}">
                                    <div class="flex-1 p-4 text-gray-700 flex items-center">
                                        Waktu Pelaksanaan
                                    </div>
                                    <div class="flex-1 p-4 border-l border-gray-400">
                                        <div class="border border-gray-200 rounded p-2.5 mb-1.5 bg-gray-50 text-gray-900 w-full max-w-sm">
                                            {{ $order->estimated_duration ?? '12' }}
                                        </div>
                                        <div class="text-xs text-red-500">(Dalam Hari Kalender)</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Right Column (Empty for Udayana Mall layout) --}}
                    <div class="w-48 bg-white border-gray-400 border-l hidden md:block">
                    </div>
                </div>


            </div>

            @if($isLatestPending)
            {{-- Syarat dan Ketentuan Checkbox & Action Buttons --}}
            <div class="min-w-[800px] bg-white mt-4" x-data="{ agreed: false }">
                <div class="bg-gray-50 border border-gray-200 p-4 rounded mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="agreed" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">Saya menyetujui <span class="font-bold">Syarat dan Ketentuan</span> yang berlaku.</span>
                    </label>
                </div>

                <div class="flex justify-between items-center py-2">
                    <button wire:click="rejectPrice" wire:confirm="Yakin ingin menolak penawaran harga ini?" class="px-8 py-2 bg-white border border-gray-400 text-gray-700 rounded font-bold text-xs uppercase tracking-wider hover:bg-gray-50 transition-colors">
                        Kembali (Tolak)
                    </button>
                    <button wire:click="acceptPrice" wire:confirm="Yakin ingin menyetujui harga ini?" :class="agreed ? 'bg-[#3C82D6] hover:bg-blue-600 text-white border-[#3C82D6]' : 'bg-gray-300 text-gray-500 border-gray-300 cursor-not-allowed'" :disabled="!agreed" class="px-8 py-2 border rounded font-bold text-xs uppercase tracking-wider transition-colors shadow-sm relative overflow-hidden group">
                        BELI/LANJUT PEMBAYARAN
                    </button>
                </div>
                {{-- Batalkan Pesanan --}}
                <div class="mt-3 pt-3 border-t border-gray-100 text-center">
                    <button wire:click="$set('showCancelModal', true)" class="text-xs font-bold text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                        Batalkan Pesanan
                    </button>
                </div>
            </div>
            @else
            <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded text-center text-sm text-gray-600 font-medium">
                Menunggu tanggapan atau proposal baru dari Admin...
            </div>
            {{-- Batalkan Pesanan saat menunggu proposal baru --}}
            <div class="mt-2 text-center">
                <button wire:click="$set('showCancelModal', true)" class="text-xs font-bold text-red-500 hover:text-red-700 underline underline-offset-2 transition-colors">
                    Batalkan Pesanan
                </button>
            </div>
            @endif
        </div>

        {{-- Order Details Accordion --}}
        <div class="bg-white border border-gray-200 rounded-2xl mb-6 shadow-sm overflow-hidden" x-data="{ expanded: false }">
            <button @click="expanded = !expanded" class="w-full p-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors">
                <h3 class="text-sm font-bold text-gray-900">Order Details</h3>
                <div class="flex items-center gap-2 text-sm font-bold text-gray-600 uppercase tracking-widest">
                    <span x-text="expanded ? 'Show Less' : 'Show More'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div x-show="expanded" x-cloak>
                <div class="p-6 pt-0 border-t border-gray-100 bg-gray-50/50">
                    <ul class="space-y-3 text-sm text-gray-600 font-medium">
                        <li><strong class="text-gray-900">Service Type:</strong> {{ $order->product->name ?? 'N/A' }}</li>
                        <li><strong class="text-gray-900">Location:</strong> {{ $order->service_address ?? 'N/A' }}</li>
                        <li><strong class="text-gray-900">Requested Date:</strong> {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('d M Y') : 'TBD' }}</li>
                        <li><strong class="text-gray-900">Time Preference:</strong> Morning (09:00 - 12:00)</li>
                    </ul>
                </div>
            </div>
        </div>


    @elseif($order->status === 'processing')
        {{-- SERVICE PROCESS VIEW (Step 4) --}}
        <div class="space-y-8">
            {{-- Progress Status Card --}}
            @if($order->orderAssignment)
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                    <div class="flex items-center gap-4">
                        <div>
                            <h2 class="text-lg font-black text-gray-900 font-plus">Service Sedang Berjalan</h2>
                            <p class="text-sm text-gray-700 font-medium">Dimulai pada {{ $order->updated_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-end mb-1">
                        <span class="text-sm font-black text-gray-600 uppercase tracking-widest">Progress</span>
                        <span class="text-sm font-black text-gray-900 font-plus">Dalam Pengerjaan</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden flex border border-gray-200/50">
                        <div class="w-1/2 bg-gray-900 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-[32px] p-8 shadow-sm mb-8 text-center flex flex-col items-center justify-center">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="text-lg font-black text-yellow-900 font-plus mb-2">Menunggu Penugasan Staf</h3>
                <p class="text-sm text-yellow-800 font-medium max-w-md mx-auto">Admin sedang mengatur jadwal dan menugaskan staf profesional untuk mengerjakan layanan Anda. Mohon ditunggu.</p>
            </div>
            @endif

            {{-- Tim Staf Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Tim Staf</h3>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($staffTeam as $staff)
                    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-5 group hover:bg-white hover:border-gray-200 transition-all flex flex-col justify-between">
                        <div class="flex flex-wrap sm:flex-nowrap items-start sm:items-center justify-between gap-4 mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-sm font-black text-gray-600 group-hover:border-gray-900 group-hover:text-gray-900 transition-colors shrink-0">
                                    {{ $staff['initials'] }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-gray-900 font-plus">{{ $staff['name'] }}</h4>
                                    <p class="text-sm text-gray-700 font-medium">{{ $staff['experience'] }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[11px] font-bold text-gray-600 uppercase tracking-widest whitespace-nowrap">{{ $staff['role'] }}</span>
                        </div>
                        @if($staff['name'] !== 'Menunggu Penugasan')
                        <div class="mt-auto">
                            @php
                                $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $staff['phone'] ?? '');
                                if (str_starts_with($waLink, 'https://wa.me/0')) {
                                    $waLink = str_replace('https://wa.me/0', 'https://wa.me/62', $waLink);
                                }
                            @endphp
                            <a href="{{ $waLink }}" target="_blank" class="w-full py-2.5 bg-[#25D366]/10 border border-[#25D366]/20 rounded-xl text-sm font-bold text-[#128C7E] hover:bg-[#25D366]/20 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                {{ $staff['phone'] ?? 'Tidak tersedia' }}
                            </a>
                        </div>
                        @else
                        <div class="mt-auto pt-2">
                            <p class="text-xs text-gray-500 font-medium italic">Menunggu admin menugaskan staf untuk pesanan ini.</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Detail Layanan Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Detail Layanan</h3>
                <div class="bg-gray-50/50 border border-gray-100 rounded-3xl p-6 md:p-8 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-0.5">Tanggal Layanan</p>
                            <p class="text-sm font-black text-gray-900">{{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('l, d F Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-0.5">Waktu Layanan</p>
                            <p class="text-sm font-black text-gray-900">09:30 - 11:30 WIB (2 jam)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-0.5">Lokasi Layanan</p>
                            <p class="text-sm font-bold text-gray-900 leading-relaxed">{{ $order->service_address ?: 'Alamat tidak tersedia (Data dummy lama)' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-sm font-black text-gray-600 uppercase tracking-widest mb-4">Work Scope</p>
                    <div class="space-y-3">
                        @foreach($workScope as $scope)
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-100"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-600">{{ $scope }}</span>
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
                <p class="text-sm text-gray-700 font-medium mb-8">Staf akan memperbarui progres setelah menyelesaikan setiap tugas.</p>

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
                                <p class="text-sm font-black text-gray-900">{{ $progress['task'] }} - {{ ucfirst(str_replace('_', ' ', $progress['status'])) }}</p>
                                @if($progress['time'] && $progress['status'] === 'completed')
                                    <span class="text-sm font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">Selesai pada {{ $progress['time'] }}</span>
                                @endif
                            </div>
                            @if($progress['time'] && $progress['status'] === 'in_progress')
                                <p class="text-sm text-gray-700 font-bold mt-1 tracking-tight">{{ $progress['time'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Catatan Penting Card --}}
            <div class="bg-gray-50/50 border border-gray-100 rounded-[32px] p-8 mt-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Catatan Penting</h3>
                </div>
                <ul class="space-y-4 text-sm text-gray-600 font-medium list-disc list-outside ml-4">
                    <li>Pastikan staf memiliki akses ke air dan listrik.</li>
                    <li>Anda dapat menghubungi staf langsung jika ada permintaan khusus.</li>
                    <li>Pembayaran wajib dilakukan setelah layanan selesai.</li>
                    <li>Staf akan mengambil foto verifikasi setelah layanan selesai.</li>
                </ul>
            </div>

            @if($order->work_result_photos)
            {{-- Staff Work Results Card --}}
            <div class="bg-white border-2 border-blue-900 rounded-[32px] p-8 shadow-lg shadow-teal-50/50">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center shadow-lg shadow-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Hasil Kerja Staff</h3>
                            <p class="text-sm text-blue-900 font-bold uppercase tracking-widest mt-0.5">Menunggu Persetujuan Anda</p>
                        </div>
                    </div>
                </div>

                @if($order->worker_notes)
                <div class="p-6 bg-teal-50/50 rounded-2xl border border-blue-900 mb-8">
                    <p class="text-sm font-black text-blue-900 uppercase tracking-widest mb-2">Laporan Staff:</p>
                    <p class="text-sm font-bold text-gray-800 italic leading-relaxed">"{{ $order->worker_notes }}"</p>
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
                    <button wire:click="approveWork" class="flex-1 py-5 bg-gray-900 text-white rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-gray-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Setujui Hasil & Lanjut ke Pembayaran
                    </button>
                    <button class="px-8 py-5 bg-white border border-gray-200 text-gray-600 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                        Laporkan Masalah
                    </button>
                </div>
            </div>
            @endif

            {{-- Process Action Buttons --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
                <button type="button" wire:click.prevent="toggleNoteModal" class="py-4 bg-white border border-gray-200 rounded-2xl text-sm font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Tambah Catatan
                </button>
                <a href="https://wa.me/6281339925118?text=Ada%20masalah%20dengan%20pesanan%20{{ $order->invoice_number ?? $order->id }}" target="_blank" class="py-4 bg-white border border-gray-200 rounded-2xl text-sm font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Laporkan Masalah
                </a>
                <button x-data @click="navigator.clipboard.writeText(window.location.href); alert('Tautan status pesanan berhasil disalin ke clipboard!');" class="py-4 bg-white border border-gray-200 rounded-2xl text-sm font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Bagikan Status
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
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-0.5">Selesai Date</p>
                            <p class="text-sm font-black text-gray-900">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <p class="text-sm font-black text-gray-600 uppercase tracking-widest">Work Selesai</p>
                            @foreach($workScope as $scope)
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-sm font-bold text-gray-600">{{ $scope }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="space-y-3">
                            <p class="text-sm font-black text-gray-600 uppercase tracking-widest">Staff Insights</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-sm font-black text-gray-600">{{ $staffTeam[0]['initials'] }}</div>
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $staffTeam[0]['name'] }}</p>
                                    <p class="text-sm text-gray-700 font-medium">{{ $staffTeam[0]['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Final Pembayaran Card --}}
            <div class="bg-white border border-gray-200 rounded-[32px] p-6 md:p-10 shadow-sm overflow-hidden relative">
                <div class="absolute top-0 right-0 p-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-sm font-black uppercase tracking-tighter border border-gray-200">Final Invoice</span>
                </div>
                
                <h3 class="text-xl font-black text-gray-900 font-plus mb-8">Final Pembayaran Required</h3>

                <div class="space-y-6">
                    {{-- Base Services --}}
                    <div>
                        <p class="text-sm font-black text-gray-600 uppercase tracking-widest mb-4">Service Breakdown</p>
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
                            <span class="text-sm font-bold text-gray-600">Requested during work</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($paymentDetails['additional_services'] as $service)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700 font-bold">{{ $service['name'] }}</span>
                                <span class="text-gray-900 font-black">Rp {{ number_format($service['price'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Calculation --}}
                    <div class="pt-6 border-t border-gray-100 space-y-3">
                        @foreach($paymentDetails['discounts'] as $discount)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-blue-900 font-bold">{{ $discount['name'] }}</span>
                            <span class="text-blue-900 font-black">- Rp {{ number_format($discount['amount'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        @foreach($paymentDetails['fees'] as $fee)
                        <div class="flex justify-between items-center text-sm text-gray-600">
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
                                <span class="px-2 py-0.5 bg-blue-900 text-white rounded text-[8px] font-black uppercase tracking-tighter">Fixed</span>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mt-1">Verified by UMKM Admin</p>
                        </div>
                        <div class="text-3xl font-black text-gray-900 font-plus">Rp {{ number_format($paymentDetails['final_total'], 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Comparison Block --}}
                <div class="mt-10 pt-8 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <h4 class="text-sm font-black text-gray-600 uppercase tracking-widest">Price Comparison</h4>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm font-black">
                                <span class="text-gray-900">Final Price:</span>
                                <span class="text-gray-900">Rp {{ number_format($paymentDetails['final_total'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <p class="text-sm text-gray-700 font-medium leading-relaxed italic">
                            Harga di atas adalah total akhir yang telah disepakati bersama, termasuk jika ada layanan tambahan yang diajukan selama proses pengerjaan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- QRIS Pembayaran Card --}}
            <div class="bg-white border border-gray-200 rounded-[32px] p-8 md:p-12 shadow-sm">
                <div class="max-w-md mx-auto text-center">
                    <h3 class="text-xl font-black text-gray-900 font-plus mb-2">QRIS Pembayaran</h3>
                    <p class="text-sm text-gray-700 font-medium mb-10 uppercase tracking-widest">Scan QR code below to pay</p>
                    
                    {{-- QR Code Display --}}
                    <div class="bg-white p-6 rounded-[40px] border-2 border-gray-900 shadow-2xl shadow-gray-100 inline-block mb-10 relative group">
                        @if($order->umkm->qris_image_url)
                            <img src="{{ asset($order->umkm->qris_image_url) }}" class="w-64 h-64 md:w-80 md:h-80 mx-auto rounded-2xl object-contain">
                        @else
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=ORDER-{{ $order->id }}-TOTAL-{{ $order->agreed_price }}" class="w-64 h-64 md:w-80 md:h-80 mx-auto rounded-2xl">
                        @endif
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                            <span class="px-6 py-3 bg-gray-900 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-xl">UMKM Verified QRIS</span>
                        </div>
                    </div>

                    <div class="space-y-4 text-left mb-10">
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-sm shrink-0 shadow-sm border border-gray-100">1</div>
                            <p class="text-sm font-bold text-gray-600 leading-relaxed">Buka aplikasi mobile banking atau e-wallet (GoPay, OVO, Dana, dll).</p>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-sm shrink-0 shadow-sm border border-gray-100">2</div>
                            <p class="text-sm font-bold text-gray-600 leading-relaxed">Scan kode QR di atas dan masukkan nominal sesuai tagihan.</p>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-900 font-black text-sm shrink-0 shadow-sm border border-gray-100">3</div>
                            <p class="text-sm font-bold text-gray-600 leading-relaxed">Simpan bukti transfer dan unggah di bawah ini untuk verifikasi admin.</p>
                        </div>
                    </div>

                    {{-- Upload Section --}}
                    @php $pendingPembayaran = $order->payments->where('status', 'pending')->first(); @endphp

                    @if($pendingPembayaran)
                        <div class="p-8 bg-blue-50 rounded-[32px] border border-blue-100 flex flex-col items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-center">
                                <h4 class="text-sm font-black text-blue-900 font-plus mb-1 uppercase tracking-tight">Menunggu Verifikasi</h4>
                                <p class="text-sm text-blue-600 font-bold uppercase tracking-widest leading-relaxed">Bukti pembayaran Anda sedang dicek oleh Admin UMKM.</p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="relative group">
                                <input type="file" wire:model="paymentProof" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="p-8 bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200 group-hover:border-gray-900 transition-all flex flex-col items-center gap-4">
                                    @if($paymentProof)
                                        <img src="{{ $paymentProof->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-2xl shadow-lg border-2 border-white">
                                        <p class="text-sm font-black text-gray-900 uppercase tracking-widest">Receipt Selected ✓</p>
                                    @else
                                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-600 group-hover:bg-gray-900 group-hover:text-white transition-all shadow-sm border border-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-gray-900 font-plus uppercase">Upload Bukti Transfer</h4>
                                            <p class="text-sm text-gray-600 font-bold mt-1 tracking-tight">Format: JPG, PNG, max 2MB</p>
                                        </div>
                                    @endif
                                </div>
                                @error('paymentProof') <span class="text-sm text-red-500 font-bold mt-2 inline-block">{{ $message }}</span> @enderror
                            </div>

                            <button 
                                wire:click="submitPayment"
                                wire:loading.attr="disabled"
                                class="w-full py-5 bg-gray-900 text-white rounded-[24px] font-black text-sm uppercase tracking-widest transition-all shadow-xl hover:bg-black disabled:opacity-50"
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
                <p class="text-sm text-gray-700 font-medium mb-8">Awesome experience with {{ $order->umkm->name }}?</p>
                <a href="{{ route('customer.order-review', $order->id) }}" class="px-8 py-4 bg-[#000B44] hover:bg-black text-white rounded-2xl font-black text-sm uppercase tracking-widest transition-all shadow-lg flex items-center justify-center gap-2 mx-auto w-fit">
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
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm" x-data="photoDownloader()">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Work Results / Order Photos</h3>
                    <span class="text-sm font-bold text-gray-600">{{ count($this->workResults) }} Foto terlampir</span>
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
                    <button @click="downloadAll()" class="w-full py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-black text-gray-900 hover:bg-gray-50 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh Foto
                    </button>
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('photoDownloader', () => ({
                        urls: @json($this->workResults),
                        downloadAll() {
                            this.urls.forEach((url, index) => {
                                fetch(url)
                                    .then(response => response.blob())
                                    .then(blob => {
                                        const blobUrl = window.URL.createObjectURL(blob);
                                        const a = document.createElement('a');
                                        a.href = blobUrl;
                                        a.download = `hasil_kerja_${index + 1}.jpg`;
                                        document.body.appendChild(a);
                                        a.click();
                                        document.body.removeChild(a);
                                        window.URL.revokeObjectURL(blobUrl);
                                    })
                                    .catch(err => console.error('Error downloading image', err));
                            });
                        }
                    }))
                })
            </script>

            {{-- Pembayaran Summary Card --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Pembayaran Summary</h3>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 font-bold uppercase tracking-tighter">Paid Date</span>
                        <span class="text-gray-900 font-black">{{ $verificationData['completed_at'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 font-bold uppercase tracking-tighter">Total Paid</span>
                        <span class="text-gray-900 font-black">Rp {{ number_format($verificationData['amount'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 font-bold uppercase tracking-tighter">Method</span>
                        <span class="text-gray-900 font-black uppercase">{{ $verificationData['method'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 font-bold uppercase tracking-tighter">Transaction ID</span>
                        <span class="text-gray-900 font-black">{{ $verificationData['transaction_id'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('customer.order-invoice', $order->id) }}" target="_blank" class="flex-1 py-3.5 bg-gray-50 rounded-xl text-sm font-black text-gray-900 hover:bg-gray-100 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Full Invoice
                    </a>
                    <a href="{{ route('customer.order-invoice-download', $order->id) }}" class="flex-1 py-3.5 bg-gray-50 rounded-xl text-sm font-black text-gray-900 hover:bg-gray-100 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                        Download Receipt
                    </a>
                </div>
            </div>

            {{-- Share Section --}}
            @php
                $umkmName = $order->umkm->name ?? 'Mitra UMKM';
                $umkmLink = isset($order->umkm->id) ? route('customer.partner-detail', $order->umkm->id) : url('/');
                $shareText = "Saya baru saja menyelesaikan transaksi saya di {$umkmName} dengan sangat memuaskan! 🚀\n\nPesan layanan profesional yang sama melalui platform JOS sekarang:\n{$umkmLink}";
                $waShare = "https://wa.me/?text=" . urlencode($shareText);
            @endphp
            <div x-data="{ shareText: `{{ $shareText }}` }" class="bg-[#000B44] border border-blue-800 rounded-[32px] p-8 shadow-sm text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <h4 class="text-sm font-black text-white font-plus uppercase tracking-wider mb-1 text-center md:text-left">Bagikan Pengalaman Anda</h4>
                        <p class="text-sm text-blue-200 font-medium text-center md:text-left">Beri tahu teman Anda tentang layanan luar biasa ini!</p>
                    </div>
                    <div class="flex gap-3">
                        {{-- WhatsApp --}}
                        <a href="{{ $waShare }}" target="_blank" class="w-12 h-12 rounded-2xl bg-[#25D366] flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform" title="Share ke WhatsApp">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 2.12.553 4.12 1.536 5.862L.266 23.734l6.02-1.58C7.94 23.23 9.92 23.8 12 23.8c6.627 0 12-5.373 12-12S18.627 0 12 0zm5.666 16.945c-.256.719-1.488 1.378-2.08 1.467-.549.082-1.222.12-3.32-.75-2.518-1.045-4.103-3.626-4.227-3.791-.125-.164-1.008-1.34-1.008-2.557 0-1.218.633-1.817.859-2.05.226-.234.492-.293.657-.293.164 0 .328.001.472.008.151.007.353-.059.553.42.211.505.719 1.758.784 1.889.066.132.11.286.028.451-.082.164-.123.266-.247.411-.123.146-.263.32-.373.434-.124.126-.253.266-.111.512.143.246.634 1.047 1.365 1.7.941.84 1.728 1.1 1.974 1.224.246.123.391.103.535-.06.143-.163.623-.726.791-.975.168-.248.337-.207.564-.123.226.082 1.438.677 1.684.801.246.123.411.185.472.287.062.102.062.593-.194 1.312z"/></svg>
                        </a>
                        {{-- Instagram (Copy & Open) --}}
                        <button x-on:click="navigator.clipboard.writeText(shareText); alert('Teks berhasil disalin! Silakan paste di Story atau DM Instagram Anda.'); window.open('https://instagram.com', '_blank');" class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform" title="Share ke Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </button>
                        {{-- Copy Link / Text --}}
                        <button x-on:click="navigator.clipboard.writeText(shareText); alert('Teks dan link berhasil disalin!');" class="w-12 h-12 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center text-white shadow-lg hover:bg-white/30 transition-all" title="Copy Text & Link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
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
                <h2 class="text-xl font-black text-gray-900 font-plus">Detail Layanan</h2>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 space-y-6 shadow-sm">
                {{-- Service Name --}}
                <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Service</div>
                        <div class="text-base font-bold text-gray-900">{{ $order->product->name ?? 'Layanan tidak diketahui' }}</div>
                    </div>
                    <div class="text-sm font-bold text-gray-600 bg-gray-50 px-3 py-1 rounded-lg">Code: {{ $order->product_id ?? 'N/A' }}</div>
                </div>

                {{-- Date & Time --}}
                <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Tanggal Layanan</div>
                        <div class="text-base font-bold text-gray-900">
                            {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('l, d F Y') : 'Belum ditentukan' }}
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-4 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Time</div>
                        <div class="text-base font-bold text-gray-900">{{ $order->booking_time ? \Carbon\Carbon::parse($order->booking_time)->format('H:i') : 'Menunggu' }} WIB</div>
                        @if($order->status === 'pending_valuation')
                        <div class="text-sm font-medium text-gray-600 mt-1">* Time may adjust after negotiation.</div>
                        @endif
                    </div>
                </div>

                {{-- Optional Info (Total Size mock) --}}
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Total Size / Variant</div>
                        <div class="text-base font-bold text-gray-900">Standard Package</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Price Block --}}
        <div class="bg-gray-50 border border-gray-200 rounded-3xl p-6 md:p-8 mb-6">
            <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Agreed Price</div>
            <div class="text-2xl font-black text-gray-900 font-plus">
                @if($order->agreed_price)
                    Rp {{ number_format($order->agreed_price, 0, ',', '.') }}
                @elseif($order->product && $order->product->estimated_price)
                    <span class="text-lg text-gray-700 font-medium line-through mr-2">Est.</span>
                    Rp {{ number_format($order->product->estimated_price, 0, ',', '.') }}
                @else
                    Menunggu Penilaian
                @endif
            </div>
            @if($order->status === 'pending_valuation')
            <div class="text-sm font-medium text-gray-700 mt-2">* Harga final akan ditentukan oleh Admin.</div>
            @endif
        </div>

        {{-- Location Block --}}
        <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 mb-6 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-2">Service Address</div>
                <p class="text-sm font-bold text-gray-900 leading-relaxed mb-3">{{ $order->service_address ?? 'Alamat tidak diisi.' }}</p>
                @if($order->service_latitude && $order->service_longitude)
                <a href="https://maps.google.com/?q={{ $order->service_latitude }},{{ $order->service_longitude }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-100 transition-colors">
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
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-2">Customer Notes</div>
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
            <button class="mt-4 px-4 py-2 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                View All Photos
            </button>
            @endif
        </div>
    @endif

    {{-- Order Activity Timeline --}}
    <div class="mb-12 mt-12">
        <h2 class="text-xl font-black text-gray-900 font-plus mb-6">Aktivitas Pesanan</h2>
        
        <div class="space-y-8 relative">
            <div class="absolute left-[11px] top-2 bottom-2 w-px bg-gray-100"></div>
            
            {{-- Loop through Logs --}}
            @forelse($logs as $log)
                <div class="flex gap-6 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-gray-900 border-4 border-white flex items-center justify-center shrink-0 shadow-sm">
                        {{-- Dot --}}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">{{ $log->created_at->format('d M, H:i') }}</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $log->action }}</p>
                        @if($log->reason)
                            <p class="text-sm text-gray-700 font-medium leading-relaxed mt-1 italic">"{{ $log->reason }}"</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="flex gap-6 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-gray-900 border-4 border-white flex items-center justify-center shrink-0 shadow-sm">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">{{ $order->created_at->format('d M, H:i') }}</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5">Pesanan Dibuat</p>
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
                    <p class="text-sm font-bold text-gray-300 uppercase tracking-widest">Next Step</p>
                    <p class="text-sm font-bold text-gray-600 mt-0.5">Awaiting further progress...</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Bottom Actions --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 border-t border-gray-200 pt-8 mt-8">
        
        @if(in_array($order->status, ['pending_valuation', 'negotiation', 'waiting_payment']))
            <button wire:click="cancelOrder" wire:confirm="Are you sure you want to cancel this order?" class="w-full sm:w-auto px-8 py-3 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2">
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
        @php
            $invoiceNo = $order->invoice_number ?? 'ORDER-' . $order->id;
            $waText = urlencode("Halo Support, saya mau melaporkan kendala terkait pesanan dengan nomor Invoice: " . $invoiceNo);
        @endphp
        <p class="text-sm text-gray-700 font-medium">Need help with your order? <a href="https://wa.me/6281339925118?text={{ $waText }}" target="_blank" class="text-gray-900 font-bold hover:underline">Contact Support</a></p>
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
                    <p class="text-sm text-gray-700 font-medium">Are you sure you accept this price range?</p>
                </div>

                <div class="mt-8 bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="text-center border-b border-gray-200 pb-4 mb-4">
                        <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Estimated Total:</div>
                        <div class="text-2xl font-black text-gray-900 font-plus">Rp {{ number_format($order->agreed_price ?? 2600000, 0, ',', '.') }}</div>
                        <div class="text-sm font-bold text-gray-600 mt-1">± 15%</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Minimum</div>
                            <div class="text-sm font-black text-gray-900 font-plus">Rp {{ number_format(($order->agreed_price ?? 2600000) * 0.85, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Maximum</div>
                            <div class="text-sm font-black text-gray-900 font-plus">Rp {{ number_format(($order->agreed_price ?? 2600000) * 1.15, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-gray-50/50 rounded-2xl p-4 border border-gray-100 flex gap-3 items-start">
                    <div class="w-5 h-5 bg-white rounded-full flex items-center justify-center border border-gray-200 shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1 uppercase tracking-wide">Important Notice</h4>
                        <p class="text-sm text-gray-700 font-medium leading-relaxed">
                            By accepting, you agree to the estimated price range. Final invoice will be calculated based on actual work completed and sent after service completion. You will be notified before payment is required.
                        </p>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-2 gap-4">
                    <button type="button" wire:click="toggleAcceptModal" class="py-4 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="acceptPrice" class="py-4 bg-[#000B44] rounded-2xl text-sm font-bold text-white hover:bg-black transition-colors shadow-lg">
                        Yes, Accept & Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Note Modal --}}
    @if($showNoteModal)
    <template x-teleport="body">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-[110] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                
                <h3 class="text-xl font-black text-gray-900 font-plus mb-2">Tambah Catatan Baru</h3>
                <p class="text-sm text-gray-600 font-medium mb-6">Catatan ini akan ditambahkan ke aktivitas pesanan dan dapat dilihat oleh staf UMKM.</p>
                
                <form wire:submit.prevent="submitNote">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Isi Catatan</label>
                        <textarea wire:model="newNote" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none resize-none" placeholder="Tulis instruksi atau informasi tambahan di sini..."></textarea>
                        @error('newNote') <span class="text-xs font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" wire:click="toggleNoteModal" class="flex-1 py-3 bg-gray-50 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-100 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                            Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
    @endif

    </div>

    {{-- Functional Livewire Chat Widget --}}
    @if($order->messages()->count() > 0 && in_array($order->status, ['pending_valuation', 'negotiation', 'waiting_payment', 'processing']))
        <livewire:order-chat :order="$order" />
    @endif

    {{-- Card: Permintaan Pembatalan dari Admin (modal overlay) --}}
    @if($order->status === 'cancel_requested' && $order->cancellation_requested_by === 'admin')
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-gray-900">Permintaan Pembatalan dari Admin</h3>
                    <p class="text-xs text-gray-500 font-medium">{{ $order->umkm->name }} ingin membatalkan pesanan ini</p>
                </div>
            </div>
            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-6">
                <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1">Alasan dari Admin:</p>
                <p class="text-sm font-medium text-gray-800 leading-relaxed italic">"{{ $order->cancellation_reason }}"</p>
            </div>
            <p class="text-sm text-gray-600 font-medium mb-6">Jika Anda <strong>setuju</strong>, pesanan akan dibatalkan. Jika <strong>tolak</strong>, pesanan akan dilanjutkan kembali dan Admin akan mendapat notifikasi.</p>
            <div class="flex gap-3">
                <button wire:click="rejectCancel" class="flex-1 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all">
                    Tolak, Lanjutkan
                </button>
                <button wire:click="approveCancel" class="flex-1 py-4 bg-red-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 transition-all shadow-lg">
                    Setujui Pembatalan
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal: Input Alasan Pembatalan (Customer) --}}
    @if($showCancelModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
            <h3 class="text-base font-black text-gray-900 mb-1">Batalkan Pesanan</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Permintaan pembatalan akan dikirim ke Admin untuk mendapat persetujuan. Pesanan tidak langsung dibatalkan.</p>
            <div class="mb-5">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Alasan Pembatalan <span class="text-red-500">*</span></label>
                <textarea wire:model="cancellationReason" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none" placeholder="Jelaskan alasan pembatalan Anda (min. 10 karakter)..."></textarea>
                @error('cancellationReason') <span class="text-xs text-red-500 font-bold mt-1 inline-block">{{ $message }}</span> @enderror
            </div>
            <div class="flex gap-3">
                <button wire:click="$set('showCancelModal', false)" class="flex-1 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button wire:click="requestCancel" class="flex-1 py-4 bg-red-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 transition-all shadow-lg">
                    Kirim Permintaan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
