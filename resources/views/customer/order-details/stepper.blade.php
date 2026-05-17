<div class="premium-card p-10 mb-12 overflow-x-auto">
    <div class="min-w-[800px] flex items-start justify-between relative">
        <div class="absolute top-[18px] left-[40px] right-[40px] h-[2px] bg-slate-100 -z-0"></div>
        
        @foreach($steps as $index => $step)
        <div class="flex flex-col items-center text-center gap-4 relative z-10 w-32 {{ $step['status'] === 'active' ? 'step-active' : ($step['status'] === 'completed' ? 'step-completed' : 'text-slate-300') }}">
            <div class="step-circle w-10 h-10 rounded-full flex items-center justify-center transition-all duration-500 {{ $step['status'] === 'completed' ? 'bg-brand-dark text-white' : ($step['status'] === 'active' ? 'bg-brand-primary text-white' : 'bg-slate-100 text-slate-400') }}">
                @if($step['status'] === 'completed')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                @else
                    <span class="text-xs font-black">{{ $index + 1 }}</span>
                @endif
            </div>
            <div class="space-y-1">
                <div class="text-[10px] font-black uppercase tracking-widest leading-tight">{{ $step['label'] }}</div>
                @if($step['date'])
                <div class="text-[9px] font-bold opacity-60 uppercase tracking-tighter">{{ $step['date'] }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
