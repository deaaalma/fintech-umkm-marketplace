<x-slot:title>Review Order #{{ $order->invoice_number ?? $order->id }}</x-slot>

<div class="space-y-6" wire:poll.5s x-data="{ showCancelModal: @entangle('showCancelModal') }">
    <div class="space-y-6 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Order #{{ $order->invoice_number ?? $order->id }}</h1>
                <p class="text-sm text-gray-500 font-medium">Customer: <span class="text-gray-900 font-bold">{{ $order->customer->name }}</span> • Submitted {{ $order->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div>
            @php
                $statusMap = [
                    'pending_valuation' => $order->agreed_price ? 
                        ['bg' => 'bg-white border-gray-200', 'text' => 'text-gray-900', 'label' => 'WAITING_CUSTOMER_ACTION'] : 
                        ['bg' => 'bg-amber-50 border-amber-100', 'text' => 'text-amber-600', 'label' => 'Awaiting Review'],
                    'waiting_payment'   => ['bg' => 'bg-orange-50 border-orange-100', 'text' => 'text-orange-600', 'label' => 'Awaiting Payment'],
                    'paid'              => ['bg' => 'bg-teal-50 border-teal-100',   'text' => 'text-teal-600',   'label' => 'Paid'],
                    'processing'        => ['bg' => 'bg-blue-50 border-blue-100',   'text' => 'text-blue-600',   'label' => 'Processing'],
                    'completed'         => ['bg' => 'bg-green-50 border-green-100',  'text' => 'text-green-600',  'label' => 'Completed'],
                    'cancelled'         => ['bg' => 'bg-red-50 border-red-100',    'text' => 'text-red-600',    'label' => 'Cancelled'],
                    'cancel_requested'  => ['bg' => 'bg-red-50 border-red-100',    'text' => 'text-red-600',    'label' => 'Cancel Requested'],
                ];
                $s = $statusMap[$order->status] ?? ['bg' => 'bg-gray-50 border-gray-100', 'text' => 'text-gray-600', 'label' => $order->status];
            @endphp
            <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border {{ $s['bg'] }} {{ $s['text'] }}">
                {{ $s['label'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Order Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-50">
                    <h2 class="text-lg font-black text-gray-900 font-plus">Service & Requirement</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Service Type</label>
                            <p class="text-base font-black text-gray-900 font-plus">{{ $order->product->name }}</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Initial Estimated Price</label>
                            <p class="text-lg font-black text-gray-900 font-plus">Rp {{ number_format($order->product->estimated_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Customer</label>
                            <div class="flex items-center gap-2">
                                @if($order->customer->profile_photo_path)
                                    <img src="{{ Storage::url($order->customer->profile_photo_path) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200" alt="{{ $order->customer->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ substr($order->customer->name, 0, 1) }}
                                    </div>
                                @endif
                                <p class="text-sm font-bold text-gray-900">{{ $order->customer->name }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Booking Schedule</label>
                            <p class="text-sm font-bold text-gray-900">{{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->translatedFormat('l, d F Y') : '-' }}</p>
                            <p class="text-[11px] text-gray-500 font-medium">{{ $order->booking_time }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-50">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Service Address</label>
                    <div class="flex items-start gap-3 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed">{{ $order->service_address ?? 'No address provided' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Customer Notes</label>
                    <div class="p-5 bg-blue-50/30 rounded-2xl border border-blue-100 text-sm font-medium text-blue-900 leading-relaxed italic">
                        "{{ $order->notes ?? 'No notes provided by customer.' }}"
                    </div>
                </div>
            </div>

            {{-- Site Photos (Dynamic) --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Site Photos ({{ count($this->sitePhotos) }})</h2>
                    @if(count($this->sitePhotos) > 0)
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Customer Uploads</span>
                    @endif
                </div>
                <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar">
                    @forelse($this->sitePhotos as $image)
                        <div class="w-40 h-40 bg-gray-100 rounded-2xl border border-gray-200 overflow-hidden shrink-0 group relative cursor-pointer">
                            <img src="{{ $image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                        </div>
                    @empty
                        @for($i=1; $i<=3; $i++)
                            <div class="w-40 h-40 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col items-center justify-center shrink-0 border-dashed">
                                <svg class="w-6 h-6 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">No Photo {{ $i }}</span>
                            </div>
                        @endfor
                    @endforelse
                </div>
                @if(count($this->sitePhotos) > 0)
                    <p class="text-[10px] text-gray-400 font-medium mt-3 italic">* These photos were uploaded by the customer to help with your valuation.</p>
                @endif
            </div>

            {{-- Staff Work Results --}}
            @if($order->worker_notes || $order->work_result_photos)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-lg font-black text-gray-900 font-plus uppercase tracking-tight">Staff Work Results</h2>
                </div>

                <div class="space-y-6">
                    @if($order->worker_notes)
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Worker Report / Notes</label>
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 text-sm font-medium text-gray-700 leading-relaxed italic">
                            "{{ $order->worker_notes }}"
                        </div>
                    </div>
                    @endif

                    @if($order->work_result_photos)
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Work Evidence Photos</label>
                        <div class="flex gap-4 overflow-x-auto pb-2 hide-scrollbar">
                            @foreach($order->work_result_photos as $photo)
                                <div class="w-48 h-48 rounded-2xl border border-gray-100 overflow-hidden shrink-0 group relative cursor-pointer">
                                    <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="px-4 py-2 bg-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl scale-0 group-hover:scale-100 transition-all">View Proof</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Actions --}}
        <div class="space-y-6">
            @if(!in_array($order->status, ['pending_valuation', 'paid', 'completed', 'cancelled', 'cancel_requested']))
            {{-- Worker Assignment Section --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-black text-gray-900 font-plus mb-6">Assign Staff / Worker</h2>
                
                @if($order->orderAssignment)
                <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-2xl border border-blue-100 mb-6">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-600 border border-blue-200 shrink-0 font-black text-lg shadow-sm">
                        {{ substr($order->orderAssignment->worker->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-0.5">Currently Assigned</p>
                        <p class="text-sm font-black text-blue-900">{{ $order->orderAssignment->worker->name }}</p>
                    </div>
                </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5 ml-1">Select Available Staff</label>
                        <select wire:model="selectedWorkerId" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all text-sm font-medium outline-none">
                            <option value="">-- Choose Worker --</option>
                            @foreach($availableWorkers as $worker)
                                <option value="{{ $worker->user_id }}">{{ $worker->user->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedWorkerId') <span class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <button wire:click="assignWorker" class="w-full py-4 bg-[#000B44] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        {{ $order->orderAssignment ? 'Update Assignment' : 'Assign to Order' }}
                    </button>
                </div>
            </div>
            @endif

            @if($order->status === 'pending_valuation')
            <div class="bg-[#000B44] rounded-3xl shadow-xl p-8 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
                
                @php
                    $latestProposal = $order->messages()->where('type', 'proposal')->latest()->first();
                    $isPending = $latestProposal && ($latestProposal->metadata['status'] ?? 'pending') === 'pending';
                @endphp

                <h2 class="text-lg font-black font-plus mb-6 relative z-10">
                    {{ $order->agreed_price ? ($isPending ? 'Status Proposal' : 'Update Proposal') : 'Take Action' }}
                </h2>
                
                <div class="space-y-6 relative z-10">
                    @if($isPending)
                        <div class="text-center py-6 bg-white/5 rounded-2xl border border-white/10">
                            <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-300 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-white mb-1">Menunggu Review Customer</p>
                            <p class="text-xs text-blue-200">Proposal seharga Rp {{ number_format($latestProposal->metadata['price'] ?? $order->agreed_price, 0, ',', '.') }} sedang direview.</p>
                        </div>
                        <div class="pt-4">
                            <button @click="showCancelModal = true" class="w-full py-3.5 bg-transparent border border-red-500/50 text-red-300 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Batalkan Pesanan (Harga Tidak Masuk Akal)
                            </button>
                        </div>
                    @else
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Set Final Price (Proposal)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-4 flex items-center text-gray-500 font-bold">Rp</span>
                                <input type="number" wire:model="agreed_price" class="w-full pl-12 pr-4 py-3.5 bg-white/10 border border-white/20 rounded-2xl focus:bg-white focus:text-gray-900 focus:ring-0 focus:border-white transition-all font-black text-lg outline-none" placeholder="0">
                            </div>
                            @error('agreed_price') <span class="text-xs text-red-400 font-bold mt-1.5 inline-block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Notes to Customer</label>
                            <textarea wire:model="admin_note" rows="3" class="w-full px-4 py-3.5 bg-white/10 border border-white/20 rounded-2xl focus:bg-white focus:text-gray-900 focus:ring-0 focus:border-white transition-all text-sm font-medium outline-none placeholder:text-gray-500" placeholder="Explain the price details..."></textarea>
                        </div>

                        <div class="space-y-3 pt-4">
                            <button wire:click="acceptOrder" wire:confirm="Send this price proposal to customer?" class="w-full py-4 bg-white text-gray-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition-all shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                {{ $order->agreed_price ? 'Update & Send Proposal' : 'Accept & Send Proposal' }}
                            </button>
                            {{-- Tolak pesanan: muncul baik sebelum maupun SAAT negosiasi (harga tidak masuk akal) --}}
                            <button @click="showCancelModal = true" class="w-full py-4 bg-transparent border border-red-500/50 text-red-300 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ $order->agreed_price ? 'Batalkan Pesanan (Harga Tidak Masuk Akal)' : 'Batalkan Pesanan' }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            @elseif($order->status === 'processing')
            <div class="bg-teal-600 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
                <h2 class="text-lg font-black font-plus mb-6 relative z-10">Proses Layanan Berjalan</h2>
                <p class="text-xs text-teal-50 font-medium mb-6 leading-relaxed relative z-10">
                    Layanan sedang dikerjakan. Setelah pekerjaan selesai, klik tombol di bawah untuk memberi tahu pelanggan dan pindah ke fase pembayaran.
                </p>
                @if($order->orderAssignment)
                <div class="space-y-3 relative z-10">
                    <button wire:click="completeOrder" wire:confirm="Apakah layanan sudah benar-benar selesai? Status akan berpindah ke Menunggu Pembayaran." class="w-full py-4 bg-white text-teal-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-teal-50 transition-all shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Tandai Layanan Selesai
                    </button>

                    {{-- Bypass: hanya muncul jika staff sudah submit tapi customer belum setujui --}}
                    @if($order->work_result_photos && !$order->is_work_accepted)
                    <div class="pt-2 border-t border-white/10">
                        <p class="text-[10px] text-teal-200 font-bold uppercase tracking-widest mb-3 text-center">Staff sudah submit — Customer belum konfirmasi</p>
                        <button wire:click="adminMarkServiceComplete" wire:confirm="Konfirmasi pekerjaan staff sebagai selesai? Customer akan langsung diminta melakukan pembayaran (bypass persetujuan customer)." class="w-full py-3.5 bg-white/10 border border-white/20 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Konfirmasi Selesai (Admin Bypass)
                        </button>
                    </div>
                    @endif

                    {{-- Cancel order saat processing (force majeure, staf sakit, dll) --}}
                    <div class="pt-2 border-t border-white/10">
                        <button @click="showCancelModal = true" class="w-full py-3.5 bg-transparent border border-red-400/40 text-red-300 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batalkan Pesanan
                        </button>
                    </div>
                </div>
                @else
                <div class="space-y-3 relative z-10">
                    <div class="p-4 bg-white/10 rounded-2xl border border-white/20 text-center">
                        <p class="text-xs text-teal-100 font-bold">⚠️ Tugaskan staf terlebih dahulu sebelum menyelesaikan layanan.</p>
                    </div>
                    {{-- Cancel tetap tersedia meski staf belum ditugaskan --}}
                    <button @click="showCancelModal = true" class="w-full py-3.5 bg-transparent border border-red-400/40 text-red-300 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batalkan Pesanan
                    </button>
                </div>
                @endif
            </div>
            @elseif($order->status === 'waiting_payment')
            <div class="bg-white rounded-3xl border-2 border-orange-500 shadow-xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-10 -mt-10"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-lg font-black text-gray-900 font-plus uppercase tracking-tight">Awaiting Payment</h2>
                    </div>

                    <div class="p-6 bg-orange-50 rounded-2xl border border-orange-100 mb-8 text-center">
                        <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1">Agreed Price (Final Total)</p>
                        @php
                            $additionalTotal = \App\Models\OrderAdditionalFee::where('order_id', $order->id)->where('status', 'accepted')->sum('amount');
                        @endphp
                        <p class="text-3xl font-black text-orange-600">Rp {{ number_format($order->agreed_price + $additionalTotal, 0, ',', '.') }}</p>
                        @if($additionalTotal > 0)
                        <p class="text-xs font-bold text-orange-500 mt-2">Termasuk Biaya Tambahan: Rp {{ number_format($additionalTotal, 0, ',', '.') }}</p>
                        @endif
                    </div>


                    @php $pendingPayment = $order->payments->where('status', 'pending')->first(); @endphp
                    @if($pendingPayment)
                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                                <p class="text-[11px] font-black text-blue-700 uppercase tracking-widest">New Payment Proof Uploaded</p>
                            </div>

                            <div class="aspect-[3/4] bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 group relative cursor-pointer shadow-sm">
                                <img src="{{ asset('storage/' . $pendingPayment->payment_gateway_ref) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <a href="{{ asset('storage/' . $pendingPayment->payment_gateway_ref) }}" target="_blank" class="px-4 py-2 bg-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl scale-0 group-hover:scale-100 transition-all">Full View</a>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3">
                                <button wire:click="verifyPayment({{ $pendingPayment->id }})" class="w-full py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Confirm Receipt
                                </button>
                                <button wire:click="rejectPayment({{ $pendingPayment->id }})" class="w-full py-4 bg-white border border-red-100 text-red-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-50 transition-all flex items-center justify-center gap-2">
                                    Reject Payment
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mx-auto mb-3 text-gray-300 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed">Waiting for customer<br>to upload receipt...</p>
                            </div>

                            <button wire:click="markAsPaidManual" wire:confirm="Are you sure you want to mark this as PAID manually (Cash/Manual)?" class="w-full py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Mark as Paid Manually
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- History --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-black text-gray-900 font-plus mb-6">Activity Timeline</h2>
                <div class="space-y-8 relative">
                    <div class="absolute left-[7px] top-2 bottom-2 w-px bg-gray-100"></div>
                    @foreach($logs as $log)
                    <div class="flex gap-4 relative z-10">
                        <div class="w-3.5 h-3.5 rounded-full bg-gray-900 border-2 border-white flex items-center justify-center shrink-0 shadow-sm"></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $log->created_at->format('d M, H:i') }}</p>
                            <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $log->action }}</p>
                            @if($log->reason)
                                <p class="text-[11px] text-gray-500 font-medium leading-relaxed italic mt-1">"{{ $log->reason }}"</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    </div>

    {{-- Floating Chat --}}
    @if($order->status === 'pending_valuation' || in_array($order->status, ['negotiation', 'processing', 'waiting_payment']))
        <livewire:order-chat :order="$order" />
    @endif

    {{-- Card: Permintaan Pembatalan dari Customer --}}
    @if($order->status === 'cancel_requested' && $order->cancellation_requested_by === 'customer')
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-gray-900">Permintaan Pembatalan</h3>
                    <p class="text-xs text-gray-500 font-medium">dari Customer — {{ $order->customer->name }}</p>
                </div>
            </div>
            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-6">
                <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1">Alasan Pembatalan:</p>
                <p class="text-sm font-medium text-gray-800 leading-relaxed italic">"{{ $order->cancellation_reason }}"</p>
            </div>
            <p class="text-sm text-gray-600 font-medium mb-6">Apakah Anda menyetujui pembatalan ini? Jika ditolak, pesanan akan dilanjutkan kembali ke status sebelumnya.</p>
            <div class="flex gap-3">
                <button wire:click="rejectCancel" class="flex-1 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all">
                    Tolak, Lanjutkan
                </button>
                <button wire:click="approveCancel" class="flex-1 py-3.5 bg-red-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 transition-all">
                    Setujui Pembatalan
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal: Input Alasan Pembatalan (Admin) --}}
    <div x-show="showCancelModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
            <h3 class="text-base font-black text-gray-900 mb-2">Ajukan Pembatalan Pesanan</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Permintaan pembatalan akan dikirim ke customer untuk mendapat persetujuan terlebih dahulu.</p>
            <div class="mb-5">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Alasan Pembatalan <span class="text-red-500">*</span></label>
                <textarea wire:model="cancellationReason" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none" placeholder="Jelaskan alasan pembatalan (min. 10 karakter)..."></textarea>
                @error('cancellationReason') <span class="text-xs text-red-500 font-bold mt-1 inline-block">{{ $message }}</span> @enderror
            </div>
            <div class="flex gap-3">
                <button @click="showCancelModal = false" class="flex-1 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button wire:click="requestCancel" class="flex-1 py-3.5 bg-red-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 transition-all">
                    Kirim Permintaan
                </button>
            </div>
        </div>
    </div>
</div>
