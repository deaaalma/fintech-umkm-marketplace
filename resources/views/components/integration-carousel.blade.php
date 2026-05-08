@php
    $topRowApps = [
        ['name' => 'Integration 1', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-389-Hc8XBOUI8vkVmIwWQZs33kxMF353Xj.png'],
        ['name' => 'Integration 2', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-407-eyikTTM6ccO0f4I7ZmNk5LpFI4EKOG.png'],
        ['name' => 'Integration 3', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-379-5hDaxwIw4LzjwXzWuorEXi7ESrGYl1.png'],
        ['name' => 'Integration 4', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-374-bp0RaoVnQI1JMqR9fjessWI8v33kLV.png'],
        ['name' => 'Integration 5', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-381-eKw7vkCp2Wq9hivZJaN1ERJdjCqR0d.png'],
        ['name' => 'Integration 6', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-401-F6mjMLGEZt4HAohKA889Z8Gf5fMzIw.png'],
        // Duplicate for seamless loop
        ['name' => 'Integration 1', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-389-Hc8XBOUI8vkVmIwWQZs33kxMF353Xj.png'],
        ['name' => 'Integration 2', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-407-eyikTTM6ccO0f4I7ZmNk5LpFI4EKOG.png'],
        ['name' => 'Integration 3', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-379-5hDaxwIw4LzjwXzWuorEXi7ESrGYl1.png'],
         ['name' => 'Integration 4', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-374-bp0RaoVnQI1JMqR9fjessWI8v33kLV.png'],
        ['name' => 'Integration 5', 'logo' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-381-eKw7vkCp2Wq9hivZJaN1ERJdjCqR0d.png'],
    ];
    $bottomRowApps = array_reverse($topRowApps);
@endphp

<style>
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-scroll {
        animation: scroll 30s linear infinite;
    }
    .animate-scroll-reverse {
        animation: scroll 30s linear infinite reverse;
    }
</style>

<div class="w-full py-24 bg-white overflow-hidden">
    <div class="max-w-[680px] mx-auto text-center mb-20 px-4">
        <h2 class="text-[40px] leading-tight font-normal text-[#222222] tracking-tight mb-4" style="font-family: 'Figtree', sans-serif;">
            Integrates with your entire collaboration stack.
        </h2>
        <p class="text-lg leading-7 text-[#666666] max-w-[600px] mx-auto" style="font-family: 'Figtree', sans-serif;">
            Connect Auralink to Slack, Zoom, Notion, Google Meet, and dozens of others to analyze communication seamlessly.
        </p>
        <div class="mt-8">
            <a href="#" class="inline-block px-5 py-2.5 rounded-full bg-white text-[#222222] text-[15px] font-medium transition-all duration-75 hover:shadow-lg border border-[#e3e3e3]">
                Explore Integrations
            </a>
        </div>
    </div>

    <div class="relative h-[268px] -mt-6">
        <!-- Top Row -->
        <div class="flex items-start gap-6 absolute top-6 whitespace-nowrap animate-scroll w-max">
            @foreach($topRowApps as $app)
                <div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]">
                    <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy">
                </div>
            @endforeach
             @foreach($topRowApps as $app)
                <div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]">
                    <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy">
                </div>
            @endforeach
        </div>

        <!-- Bottom Row -->
        <div class="flex items-start gap-6 absolute top-[148px] whitespace-nowrap animate-scroll-reverse w-max">
             @foreach($bottomRowApps as $app)
                <div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]">
                    <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy">
                </div>
            @endforeach
             @foreach($bottomRowApps as $app)
                <div class="flex items-center justify-center w-24 h-24 rounded-3xl flex-shrink-0 bg-white shadow-[0_0_0_1px_rgba(0,0,0,0.04),0_1px_1px_0_rgba(0,0,0,0.04),0_3px_3px_-1.4px_rgba(0,0,0,0.04)]">
                    <img src="{{ $app['logo'] }}" alt="{{ $app['name'] }}" class="w-9 h-9 object-contain" loading="lazy">
                </div>
            @endforeach
        </div>

        <!-- Fade Gradients -->
        <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
    </div>
</div>
