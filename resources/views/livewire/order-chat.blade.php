<div>
    @if($messages->count() > 0 || request()->routeIs('umkm.*'))
    <template x-teleport="body">
        <div wire:poll.3s
             x-data="{ 
                chatOpen: false,
                unread: @entangle('unreadCount').live
             }" 
             x-init="
                $watch('unread', value => {
                    if(value > 0 && !chatOpen) {
                        chatOpen = true;
                    }
                });
                $watch('chatOpen', value => {
                    if(value) {
                        $wire.markAsRead();
                        setTimeout(() => {
                            let body = document.getElementById('chatBody');
                            if(body) body.scrollTop = body.scrollHeight;
                        }, 100);
                    }
                });
             "
             class="fixed top-1/2 -translate-y-1/2 right-6 z-[9999] flex items-center gap-4">
            

            <button x-show="!chatOpen" @click="chatOpen = true" x-transition class="w-14 h-14 bg-[#000B44] text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                

                <div x-cloak x-show="unread > 0" class="absolute -top-1 -right-1 flex w-5 h-5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 border-2 border-white shadow-sm"></span>
                </div>
            </button>


            <div x-cloak x-show="chatOpen" x-transition.opacity.scale.origin.right class="bg-white rounded-2xl shadow-2xl w-80 sm:w-96 overflow-hidden border border-gray-100 flex flex-col mt-4" style="height: 450px;">

                <div class="bg-[#000B44] px-4 py-3 flex items-center justify-between text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center font-bold text-xs uppercase">{{ substr($order->umkm->name ?? 'Admin', 0, 2) }}</div>
                        <div>
                            <div class="text-sm font-bold">{{ $order->umkm->name ?? 'Admin UMKM' }}</div>
                            <div class="text-xs text-blue-200">Online</div>
                        </div>
                    </div>
                    <button @click="chatOpen = false" class="text-gray-300 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                

                <div class="flex-1 bg-gray-50 p-4 overflow-y-auto flex flex-col gap-3" id="chatBody" x-init="$watch('chatOpen', value => { if(value) setTimeout(() => $el.scrollTop = $el.scrollHeight, 100) })">
                    @forelse($messages as $msg)
                        @if($msg->type === 'system')
                            <div class="text-center text-[11px] font-bold text-gray-400 my-2 bg-white py-1.5 px-3 rounded-full self-center shadow-sm border border-gray-100">
                                {{ $msg->message }}
                            </div>
                        @elseif($msg->type === 'proposal')
                            <div class="bg-white border-2 border-[#000B44] rounded-2xl p-4 shadow-sm my-2 self-center w-full max-w-[95%]">
                                <div class="text-[10px] font-bold text-[#000B44] mb-1 text-center tracking-widest uppercase">Penawaran Harga Baru</div>
                                <div class="text-2xl font-black text-gray-900 text-center mb-4 font-plus">Rp {{ number_format($msg->metadata['price'] ?? 0, 0, ',', '.') }}</div>
                                
                                @if(!request()->routeIs('umkm.*') && $order->status === 'pending_valuation')
                                <div class="flex gap-2">
                                    <button wire:click="rejectProposal" wire:confirm="Yakin ingin menolak dan membatalkan pesanan ini?" class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 text-xs font-bold hover:bg-gray-50 transition-colors">Tolak</button>
                                    <button wire:click="acceptProposal" wire:confirm="Yakin ingin menyetujui harga ini?" class="flex-1 py-2.5 rounded-xl bg-[#000B44] text-white text-xs font-bold hover:bg-black transition-colors shadow-lg">Terima</button>
                                </div>
                                @elseif(request()->routeIs('umkm.*') && $order->status === 'pending_valuation')
                                <div class="text-center text-[11px] text-gray-500 font-medium bg-gray-50 py-2 rounded-xl">Menunggu persetujuan pelanggan...</div>
                                @endif
                                <div class="text-[10px] text-gray-400 mt-3 text-center">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        @elseif($msg->type === 'additional_cost')
                            <div class="bg-white border-2 border-orange-500 rounded-2xl p-4 shadow-sm my-2 self-center w-full max-w-[95%]">
                                <div class="text-[10px] font-bold text-orange-600 mb-1 text-center tracking-widest uppercase">Tagihan Biaya Tambahan</div>
                                <div class="text-sm font-medium text-gray-700 text-center mb-1">{{ $msg->metadata['name'] ?? 'Biaya Tambahan' }}</div>
                                <div class="text-2xl font-black text-gray-900 text-center mb-4 font-plus">Rp {{ number_format($msg->metadata['amount'] ?? 0, 0, ',', '.') }}</div>
                                
                                @if(isset($msg->metadata['status']) && $msg->metadata['status'] === 'pending')
                                    @if(!request()->routeIs('umkm.*'))
                                    <div class="flex gap-2">
                                        <button wire:click="rejectAdditionalFee({{ $msg->id }})" wire:confirm="Yakin ingin menolak biaya tambahan ini?" class="flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 text-xs font-bold hover:bg-gray-50 transition-colors">Tolak</button>
                                        <button wire:click="acceptAdditionalFee({{ $msg->id }})" wire:confirm="Yakin ingin menyetujui biaya tambahan ini?" class="flex-1 py-2.5 rounded-xl bg-orange-500 text-white text-xs font-bold hover:bg-orange-600 transition-colors shadow-lg">Terima</button>
                                    </div>
                                    @else
                                    <div class="text-center text-[11px] text-gray-500 font-medium bg-gray-50 py-2 rounded-xl">Menunggu persetujuan pelanggan...</div>
                                    @endif
                                @else
                                    <div class="text-center text-[11px] font-bold py-2 rounded-xl {{ $msg->metadata['status'] === 'accepted' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                        {{ $msg->metadata['status'] === 'accepted' ? 'TELAH DISETUJUI' : 'TELAH DITOLAK' }}
                                    </div>
                                @endif
                                <div class="text-[10px] text-gray-400 mt-3 text-center">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        @elseif($msg->sender_id === Auth::id())

                            <div class="bg-[#000B44] px-4 py-2 rounded-2xl rounded-tr-sm shadow-sm text-sm text-white self-end max-w-[85%]">
                                {{ $msg->message }}
                                <div class="text-[10px] text-blue-200 mt-1 text-right">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        @else

                            <div class="bg-white px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm text-sm text-gray-800 border border-gray-100 self-start max-w-[85%]">
                                <div class="text-[10px] font-bold text-blue-900 mb-0.5">{{ $msg->sender->name }}</div>
                                {{ $msg->message }}
                                <div class="text-[10px] text-gray-400 mt-1 text-right">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-sm text-gray-400 my-auto">
                            Mulai obrolan untuk bernegosiasi atau bertanya seputar pesanan.
                        </div>
                    @endforelse
                </div>
                

                <form wire:submit="sendMessage" class="p-3 bg-white border-t border-gray-100 relative">
                    <input wire:model="newMessage" type="text" placeholder="Ketik pesan..." class="w-full bg-gray-50 border border-gray-200 rounded-full pl-4 pr-12 py-2.5 text-sm outline-none focus:border-[#000B44] focus:ring-1 focus:ring-[#000B44] transition-all" required autocomplete="off">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#000B44] text-white rounded-full flex items-center justify-center hover:scale-105 transition-transform disabled:opacity-50">
                        <svg wire:loading.remove wire:target="sendMessage" class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                        <div wire:loading wire:target="sendMessage" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </button>
                </form>

                @if(request()->routeIs('umkm.*') && $order->status === 'processing')
                <div class="px-3 pb-3 bg-white border-t border-gray-100">
                    <div x-data="{ showFeeForm: false }">
                        <button type="button" @click="showFeeForm = !showFeeForm" class="w-full py-2 bg-orange-50 text-orange-600 text-xs font-bold rounded-lg flex items-center justify-center gap-2 hover:bg-orange-100 transition-colors mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Ajukan Biaya Tambahan
                        </button>
                        
                        <div x-show="showFeeForm" x-collapse class="mt-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <form wire:submit="sendAdditionalFee" class="flex flex-col gap-2">
                                <input wire:model="additionalFeeName" type="text" placeholder="Nama Biaya (Misal: Ganti Freon)" class="w-full text-xs rounded-lg border-gray-200 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" required>
                                <input wire:model="additionalFeeAmount" type="number" placeholder="Nominal (Rp)" class="w-full text-xs rounded-lg border-gray-200 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" required min="1000">
                                <div class="flex gap-2 mt-1">
                                    <button type="button" @click="showFeeForm = false" class="flex-1 py-2 rounded-lg bg-white border border-gray-200 text-gray-600 text-xs font-bold">Batal</button>
                                    <button type="submit" @click="setTimeout(() => showFeeForm = false, 500)" class="flex-1 py-2 rounded-lg bg-orange-500 text-white text-xs font-bold hover:bg-orange-600">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </template>


    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', (el, component) => {
                let body = document.getElementById('chatBody');
                if(body) {
                    body.scrollTop = body.scrollHeight;
                }
            });
        });
    </script>
    @endif
</div>
