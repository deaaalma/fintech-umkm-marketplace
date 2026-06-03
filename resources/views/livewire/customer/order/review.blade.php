<x-slot:title>Tulis Review</x-slot>

<div class="max-w-[800px] mx-auto animate-fade-in-up pb-20">
    {{-- Header --}}
    <div class="mb-10">
        <a href="{{ route('customer.order-details', $order->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Detail Pesanan
        </a>
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-2">Bagikan Pengalaman Anda</h1>
        <p class="text-gray-500 text-sm font-medium leading-relaxed">Review Anda sangat berarti bagi <span class="text-gray-900 font-bold">{{ $order->umkm->name }}</span> dan pelanggan lainnya.</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-8">
        {{-- Order Summary Mini Card --}}
        <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100 flex items-center gap-4">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center border border-gray-100 shrink-0 shadow-sm">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pesanan #{{ $order->invoice_number ?? $order->id }}</p>
                <h3 class="text-sm font-black text-gray-900 font-plus">{{ $order->product->name }}</h3>
                <p class="text-[11px] text-gray-500 font-medium">Selesai pada {{ $order->updated_at->translatedFormat('d M Y') }}</p>
            </div>
        </div>

        {{-- Star Rating --}}
        <div class="bg-white border border-gray-200 rounded-[32px] p-8 md:p-10 shadow-sm text-center">
            <h3 class="text-lg font-black text-gray-900 font-plus mb-2">Seberapa puas Anda?</h3>
            <p class="text-xs text-gray-500 font-medium mb-8">Ketuk bintang untuk memberi penilaian</p>
            
            <div class="flex justify-center gap-3 mb-10">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="setRating({{ $i }})" class="group outline-none transition-transform active:scale-90">
                        <svg class="w-12 h-12 {{ $rating >= $i ? 'text-amber-400 fill-amber-400' : 'text-gray-200 fill-transparent group-hover:text-amber-200' }} transition-colors duration-200" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </button>
                @endfor
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button type="button" wire:click="$set('is_recommended', true)" class="flex flex-col items-center gap-3 p-6 rounded-3xl border-2 transition-all {{ $is_recommended ? 'border-gray-900 bg-gray-900 text-white shadow-xl' : 'border-gray-100 bg-gray-50 text-gray-500 hover:border-gray-300' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.757c1.246 0 2.25 1.004 2.25 2.25 0 .438-.124.847-.338 1.192l-3.25 4.5A2.25 2.25 0 0115.586 19H7.5c-1.242 0-2.25-1.008-2.25-2.25v-7.5c0-1.242 1.008-2.25 2.25-2.25h1.125a.375.375 0 00.375-.375V4.875C9 3.84 9.84 3 10.875 3h2.25C14.16 3 15 3.84 15 4.875v5.125h-1z"/></svg>
                    <span class="text-xs font-black uppercase tracking-widest">Recommended</span>
                </button>
                <button type="button" wire:click="$set('is_recommended', false)" class="flex flex-col items-center gap-3 p-6 rounded-3xl border-2 transition-all {{ !$is_recommended ? 'border-red-600 bg-red-600 text-white shadow-xl' : 'border-gray-100 bg-gray-50 text-gray-500 hover:border-gray-300' }}">
                    <svg class="w-6 h-6 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.757c1.246 0 2.25 1.004 2.25 2.25 0 .438-.124.847-.338 1.192l-3.25 4.5A2.25 2.25 0 0115.586 19H7.5c-1.242 0-2.25-1.008-2.25-2.25v-7.5c0-1.242 1.008-2.25 2.25-2.25h1.125a.375.375 0 00.375-.375V4.875C9 3.84 9.84 3 10.875 3h2.25C14.16 3 15 3.84 15 4.875v5.125h-1z"/></svg>
                    <span class="text-xs font-black uppercase tracking-widest">Not Recommended</span>
                </button>
            </div>
        </div>

        {{-- Comment & Photos --}}
        <div class="bg-white border border-gray-200 rounded-[32px] p-8 md:p-10 shadow-sm space-y-8">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Ulasan Anda</label>
                <textarea wire:model="comment" rows="6" class="w-full px-6 py-5 bg-gray-50 border border-transparent rounded-3xl focus:bg-white focus:ring-4 focus:ring-gray-900/5 focus:border-gray-900 transition-all text-sm font-medium outline-none placeholder:text-gray-300" placeholder="Apa yang Anda sukai dari layanan ini?"></textarea>
                @error('comment') <span class="text-[10px] text-red-500 font-bold mt-2 inline-block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Tambahkan Foto (Opsional)</label>
                <div class="flex flex-wrap gap-4">
                    @foreach($images as $index => $image)
                        <div class="w-24 h-24 rounded-2xl border-2 border-gray-100 overflow-hidden relative group">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            <button type="button" wire:click="$set('images.{{ $index }}', null)" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endforeach
                    
                    @if(count($images) < 4)
                    <div class="relative">
                        <input type="file" wire:model="images" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-24 h-24 rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 hover:border-gray-900 hover:text-gray-900 transition-all bg-gray-50/50">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span class="text-[9px] font-black uppercase">Upload</span>
                        </div>
                    </div>
                    @endif
                </div>
                <p class="text-[10px] text-gray-400 font-medium mt-4 italic">Maksimal 4 foto, format JPG/PNG, maks 2MB per file.</p>
            </div>
        </div>

        {{-- Issue Reporting (If any) --}}
        <div class="bg-white border border-gray-200 rounded-[32px] p-8 md:p-10 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider">Laporan Masalah?</h3>
                    <p class="text-[10px] text-gray-500 font-medium mt-1">Apakah ada masalah selama pengerjaan?</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="$toggle('is_resolved')" class="w-12 h-6 rounded-full transition-colors relative {{ $is_resolved ? 'bg-teal-500' : 'bg-gray-200' }}">
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform {{ $is_resolved ? 'translate-x-6' : '' }}"></div>
                    </button>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $is_resolved ? 'Resolved' : 'Unresolved' }}</span>
                </div>
            </div>

            <div>
                <select wire:model="issue_type_id" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-gray-900/5 focus:border-gray-900 transition-all text-xs font-bold outline-none">
                    <option value="">-- Pilih Tipe Masalah (Opsional) --</option>
                    <option value="1">Kualitas Pekerjaan</option>
                    <option value="2">Ketepatan Waktu</option>
                    <option value="3">Komunikasi Staff</option>
                    <option value="4">Lainnya</option>
                </select>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button type="submit" class="w-full py-5 bg-gray-900 text-white rounded-3xl font-black text-sm uppercase tracking-widest hover:bg-black transition-all shadow-2xl shadow-gray-200 flex items-center justify-center gap-3">
                <span wire:loading.remove>Kirim Review Sekarang</span>
                <span wire:loading>Mengirim...</span>
            </button>
            <p class="text-[10px] text-gray-400 font-medium text-center mt-6">Review Anda akan dipublikasikan secara anonim jika Anda memilih demikian di pengaturan profil.</p>
        </div>
    </form>
</div>
