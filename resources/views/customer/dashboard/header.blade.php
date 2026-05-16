<div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-green-50 border border-green-100 animate-on-load">
            <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-[10px] font-bold text-green-600 uppercase tracking-[0.2em]">Online</span>
        </div>
        <div class="space-y-1">
            <h1 class="text-5xl md:text-6xl text-brand-dark tracking-tighter leading-none animate-on-load">
                <span class="font-bold">Welcome back,</span>
            </h1>
            <div class="flex items-center gap-2 overflow-hidden h-16 md:h-20 bg-transparent shadow-none border-none" id="typewriter-container">
                <span class="text-5xl md:text-6xl font-georgia-italic italic font-normal text-brand-primary whitespace-nowrap" id="typewriter-text">
                    {{ $user['name'] }}
                </span>
                <div class="w-[4px] h-10 md:h-12 bg-brand-primary rounded-full" id="typewriter-cursor"></div>
            </div>
        </div>
    </div>
</div>
