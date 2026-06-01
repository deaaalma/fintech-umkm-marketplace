<x-slot:title>Give Your Review</x-slot>

<div class="max-w-[800px] mx-auto animate-fade-in-up pb-20">
    {{-- Header Section --}}
    <div class="mb-8">
        <a href="{{ route('customer.order-details', $order->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Order
        </a>
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight">Give Your Review</h1>
    </div>

    {{-- Order Brief Card --}}
    <div class="bg-gray-50 border border-gray-200 rounded-[32px] p-8 mb-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">For</p>
                <p class="text-sm font-bold text-gray-900">{{ $order->umkm->name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Order ID</p>
                <p class="text-sm font-bold text-gray-900">ORD-{{ $order->id }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Service Date</p>
                <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->booking_date)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Staff</p>
                <p class="text-sm font-bold text-gray-900">Ahmad Syarif</p>
            </div>
        </div>
    </div>

    <p class="text-xs text-gray-500 font-medium mb-10 text-center">Help other customers by giving honest review based on your experience. Thank you! 🙏</p>

    <div class="bg-white border border-gray-100 rounded-[40px] p-8 md:p-12 shadow-sm space-y-12">
        {{-- Service Rating --}}
        <div>
            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-2">Service Rating*</h3>
            <p class="text-xs text-gray-400 font-medium mb-6">How many stars for this service?</p>
            
            <div class="flex gap-4 mb-8">
                @for($i = 1; $i <= 5; $i++)
                <button wire:click="setRating({{ $i }})" class="w-12 h-12 flex items-center justify-center transition-all duration-300">
                    <svg class="w-10 h-10 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-200' }} hover:scale-110 transition-transform" 
                         viewBox="0 0 20 20" 
                         fill="{{ $rating >= $i ? 'currentColor' : 'none' }}" 
                         stroke="currentColor" 
                         stroke-width="{{ $rating >= $i ? '0' : '1' }}">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </button>
                @endfor
            </div>

            <div class="space-y-2">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Dynamic labels that appear after selection:</p>
                <div class="grid grid-cols-1 gap-1.5">
                    <div class="flex items-center gap-2 text-[11px] {{ $rating == 5 ? 'text-gray-900 font-black' : 'text-gray-400 font-medium' }}">
                        <span>5 stars 😍</span>
                        <span>Very Satisfied! Awesome! (Common choice)</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] {{ $rating == 4 ? 'text-gray-900 font-black' : 'text-gray-400 font-medium' }}">
                        <span>4 stars 🙂</span>
                        <span>Satisfied - Ideal! (Excellent value)</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] {{ $rating == 3 ? 'text-gray-900 font-black' : 'text-gray-400 font-medium' }}">
                        <span>3 stars 😐</span>
                        <span>Adequate - Room for improvement (Standard value)</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] {{ $rating == 2 ? 'text-gray-900 font-black' : 'text-gray-400 font-medium' }}">
                        <span>2 stars 🙁</span>
                        <span>Unsatisfying (Base service)</span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] {{ $rating == 1 ? 'text-gray-900 font-black' : 'text-gray-400 font-medium' }}">
                        <span>1 star 😡</span>
                        <span>Very Unsatisfying (Poor service)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upload Photos --}}
        <div>
            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-2">Upload Result Photos (Optional)</h3>
            <p class="text-xs text-gray-400 font-medium mb-6">Show the work results you received</p>

            <div class="border-2 border-dashed border-gray-200 rounded-[32px] p-10 text-center hover:border-gray-900 hover:bg-gray-50/50 transition-all cursor-pointer relative group">
                <input type="file" wire:model="photos" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-bold text-gray-900 mb-1">Drag photos here or <span class="underline">click to upload</span></p>
                <p class="text-[10px] text-gray-400 font-medium">Max 5 photos, max 2MB per photo (JPG, PNG)</p>
            </div>
            @if ($photos)
                <div class="grid grid-cols-5 gap-3 mt-4">
                    @foreach ($photos as $photo)
                        <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Review Text --}}
        <div>
            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-2">Your Review* (Minimum 20 characters)</h3>
            <p class="text-xs text-gray-400 font-medium mb-6">Tell your experience in detail. What do you like? What needs improvement?</p>
            
            <textarea wire:model.live="review_text" rows="6" class="w-full p-6 bg-gray-50 border border-gray-100 rounded-[32px] text-sm font-medium focus:bg-white focus:ring-0 focus:border-gray-900 transition-all outline-none" placeholder="Service was very satisfying! Cleaning team arrived on time and worked professionally. Results were perfect..."></textarea>
            
            <div class="flex justify-between items-center mt-4">
                <span class="text-[10px] font-bold {{ strlen($review_text) < 20 ? 'text-red-400' : 'text-teal-500' }} uppercase tracking-widest">{{ strlen($review_text) }} characters</span>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Reviews help other customers
                </div>
            </div>
            @error('review_text') <span class="text-[11px] text-red-500 font-bold mt-2 inline-block">{{ $message }}</span> @enderror
        </div>

        {{-- Recommendation --}}
        <div>
            <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-wider mb-6">Would you recommend this service to others?*</h3>
            <div class="space-y-3">
                <label class="flex items-center p-4 bg-gray-50 border border-transparent rounded-2xl cursor-pointer hover:bg-white hover:border-gray-900 transition-all group">
                    <input type="radio" wire:model.live="recommend" value="yes" class="sr-only">
                    <div class="w-5 h-5 rounded-full border-2 border-gray-200 flex items-center justify-center shrink-0 mr-4 group-hover:border-gray-900 transition-colors {{ $recommend === 'yes' ? 'bg-gray-900 border-gray-900' : '' }}">
                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900 transition-colors">Yes, I recommend this service</span>
                </label>
                <label class="flex items-center p-4 bg-gray-50 border border-transparent rounded-2xl cursor-pointer hover:bg-white hover:border-gray-900 transition-all group">
                    <input type="radio" wire:model.live="recommend" value="no" class="sr-only">
                    <div class="w-5 h-5 rounded-full border-2 border-gray-200 flex items-center justify-center shrink-0 mr-4 group-hover:border-gray-900 transition-colors {{ $recommend === 'no' ? 'bg-gray-900 border-gray-900' : '' }}">
                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900 transition-colors">No, I do not recommend this service</span>
                </label>
            </div>
        </div>

        {{-- Aggrement --}}
        <div class="pt-8 border-t border-gray-100">
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="relative flex items-center mt-0.5">
                    <input type="checkbox" wire:model="agreed" class="hidden">
                    <div class="w-6 h-6 rounded-lg border-2 border-gray-200 flex items-center justify-center transition-all group-hover:border-gray-900 {{ $agreed ? 'bg-gray-900 border-gray-900' : '' }}">
                        <svg class="w-4 h-4 text-white {{ $agreed ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-900 leading-tight">I declare that this review is honest and based on my personal experience. I understand the review will be displayed publicly.</p>
                    <a href="#" class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2 block hover:text-gray-900 underline decoration-2 underline-offset-4">Read Review Policy</a>
                </div>
            </label>
            @error('agreed') <span class="text-[11px] text-red-500 font-bold mt-2 inline-block">{{ $message }}</span> @enderror
        </div>

        {{-- Submit Section --}}
        <div class="pt-10 flex flex-col sm:flex-row gap-4">
            <button wire:click="submitReview" 
                    {{ !$agreed || strlen($review_text) < 20 ? 'disabled' : '' }}
                    class="flex-1 py-5 bg-[#2D2D2D] hover:bg-black disabled:bg-gray-200 disabled:cursor-not-allowed text-white rounded-[24px] font-black text-xs uppercase tracking-widest transition-all shadow-xl">
                Submit Review
            </button>
            <a href="{{ route('customer.order-details', $order->id) }}" class="flex-1 py-5 bg-white border border-gray-200 text-gray-500 hover:text-gray-900 rounded-[24px] font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center">
                Cancel
            </a>
        </div>
    </div>

    {{-- Error Footer Summary --}}
    @if(!$agreed || strlen($review_text) < 20)
    <div class="mt-8 bg-gray-50 rounded-3xl p-6 border border-gray-100">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Checklist state:</p>
        <ul class="space-y-2">
            <li class="flex items-center gap-2 text-[11px] font-bold {{ $rating > 0 ? 'text-teal-500' : 'text-gray-400' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Rating selected
            </li>
            <li class="flex items-center gap-2 text-[11px] font-bold {{ strlen($review_text) >= 20 ? 'text-teal-500' : 'text-red-400' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ strlen($review_text) >= 20 ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"/></svg>
                Review text (Min. 20 chars)
            </li>
            <li class="flex items-center gap-2 text-[11px] font-bold {{ $agreed ? 'text-teal-500' : 'text-red-400' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $agreed ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"/></svg>
                Agreement accepted
            </li>
        </ul>
    </div>
    @endif
</div>
