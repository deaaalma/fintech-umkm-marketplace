@if ($paginator->hasPages())
    {{-- Container Utama: justify-between hanya bekerja jika w-full --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full" style="font-family: 'Figtree', sans-serif;">
        
        {{-- Sisi Kiri: Info Records --}}
        <div class="text-sm text-[#666666]">
            Showing <span class="font-semibold text-[#003d5c]">{{ $paginator->firstItem() }}</span> to <span class="font-semibold text-[#003d5c]">{{ $paginator->lastItem() }}</span> of <span class="font-semibold text-[#003d5c]">{{ $paginator->total() }}</span> records
        </div>

        {{-- Sisi Kanan: Tombol Navigasi --}}
        <div class="flex items-center gap-2">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <button disabled class="px-3 py-1.5 bg-gray-50 border border-[#e5e5e5] rounded-lg text-sm font-medium text-[#999999] cursor-not-allowed">
                    Previous
                </button>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium text-[#666666] hover:bg-gray-50 hover:text-[#003d5c] transition-colors">
                    Previous
                </button>
            @endif

            {{-- Angka-angka --}}
            <div class="hidden md:flex items-center gap-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-2 py-1.5 text-sm text-[#999999]">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button class="px-3 py-1.5 bg-[#003d5c] text-white rounded-lg text-sm font-semibold shadow-sm">
                                    {{ $page }}
                                </button>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium text-[#666666] hover:bg-gray-50 hover:text-[#003d5c] transition-colors">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" class="px-3 py-1.5 bg-white border border-[#e5e5e5] rounded-lg text-sm font-medium text-[#666666] hover:bg-gray-50 hover:text-[#003d5c] transition-colors">
                    Next
                </button>
            @else
                <button disabled class="px-3 py-1.5 bg-gray-50 border border-[#e5e5e5] rounded-lg text-sm font-medium text-[#999999] cursor-not-allowed">
                    Next
                </button>
            @endif
        </div>
    </div>
@else
    {{-- Versi Single Page: Tetap justify-between agar konsisten --}}
    <div class="flex items-center justify-between w-full" style="font-family: 'Figtree', sans-serif;">
        <p class="text-sm text-[#666666]">
            Showing all <span class="font-semibold text-[#003d5c]">{{ $paginator->total() }}</span> records
        </p>
        <div class="text-xs text-[#999999] italic">End of list</div>
    </div>
@endif