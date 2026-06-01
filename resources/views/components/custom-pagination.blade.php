@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full pt-4">
        
        <div class="text-xs text-gray-400 font-medium">
            Showing <span class="text-gray-900">{{ $paginator->firstItem() }}</span> to <span class="text-gray-900">{{ $paginator->lastItem() }}</span> of <span class="text-gray-900">{{ $paginator->total() }}</span> orders
        </div>

        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <button disabled class="px-4 py-2 border border-gray-100 rounded-lg text-xs font-bold text-gray-300 cursor-not-allowed">
                    &lt; Previous
                </button>
            @else
                <button wire:click="previousPage" class="px-4 py-2 border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all">
                    &lt; Previous
                </button>
            @endif

            <div class="hidden md:flex items-center gap-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="text-gray-400 text-xs px-1">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button class="w-8 h-8 flex items-center justify-center bg-black text-white rounded-lg text-xs font-bold">
                                    {{ $page }}
                                </button>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 flex items-center justify-center border border-gray-200 text-gray-500 rounded-lg text-xs font-bold hover:bg-gray-50 transition-all">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="px-4 py-2 border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all">
                    Next &gt;
                </button>
            @else
                <button disabled class="px-4 py-2 border border-gray-100 rounded-lg text-xs font-bold text-gray-300 cursor-not-allowed">
                    Next &gt;
                </button>
            @endif
        </div>
    </div>
@else
    <div class="flex items-center justify-between w-full pt-4">
        <p class="text-xs text-gray-400 font-medium">
            Showing all <span class="text-gray-900">{{ $paginator->total() }}</span> orders
        </p>
    </div>
@endif