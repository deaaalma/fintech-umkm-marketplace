@props(['stat'])

<div @class([
    'rounded-3xl p-6 border transition-all duration-300 hover:shadow-lg',
    'bg-[#003d5c] text-white border-[#003d5c]' => isset($stat['highlight']) && $stat['highlight'],
    'bg-white text-gray-900 border-[#e5e5e5]' => !isset($stat['highlight']),
])>
    <p @class([
        'text-[10px] uppercase tracking-widest font-bold mb-4',
        'text-white/70' => isset($stat['highlight']) && $stat['highlight'],
        'text-[#999999]' => !isset($stat['highlight']),
    ])>{{ $stat['title'] }}</p>
    
    @if(isset($stat['rating']) && $stat['rating'])
        <div class="text-4xl font-bold mb-4 text-[#003d5c] font-figtree">{{ $stat['value'] }}</div>
        <div class="space-y-1.5">
            @foreach($stat['ratingBars'] as $bar)
                <div class="flex items-center gap-2">
                    <span class="text-[9px] text-[#666666] w-2 font-bold">{{ $bar['stars'] }}</span>
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#F59E0B] rounded-full" style="width: {{ ($bar['count'] / 1500) * 100 }}%"></div>
                    </div>
                    <span class="text-[9px] text-[#999999] w-6 text-right">{{ $bar['count'] }}</span>
                </div>
            @endforeach
        </div>
    @else
        <div @class([
            'text-4xl font-bold mb-4 font-figtree',
            'text-white' => isset($stat['highlight']) && $stat['highlight'],
            'text-[#003d5c]' => !isset($stat['highlight']),
        ])>{{ $stat['value'] }}</div>
        
        <div class="space-y-2 mb-6">
            @foreach($stat['details'] as $detail)
                <div class="flex items-center justify-between text-[11px]">
                    <span @class(['opacity-70' => isset($stat['highlight'])])>{{ $detail['label'] }}</span>
                    <span class="font-bold">{{ $detail['value'] }}</span>
                </div>
            @endforeach
        </div>

        @if(isset($stat['action']))
            <button class="w-full bg-white text-[#003d5c] py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition-all uppercase tracking-wider">
                {{ $stat['action'] }}
            </button>
        @endif

        @if(isset($stat['change']))
            <div @class([
                'pt-3 border-t mt-auto',
                'border-white/20' => isset($stat['highlight']),
                'border-gray-100' => !isset($stat['highlight']),
            ])>
                <p class="text-[10px]">
                    <span @class([
                        'font-bold',
                        'text-green-500' => strpos($stat['change'], '+') !== false,
                        'text-red-500' => strpos($stat['change'], '-') !== false,
                    ])>{{ $stat['change'] }}</span>
                    <span class="opacity-60 ml-1">{{ $stat['changeLabel'] }}</span>
                </p>
            </div>
        @endif
    @endif
</div>