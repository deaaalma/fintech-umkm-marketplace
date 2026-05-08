@php
    $stats = [
        ['value' => '1B+', 'description' => "Messages analyzed\ndaily", 'delay' => 0],
        ['value' => '99.9%', 'description' => "Accuracy in tone\ndetection", 'delay' => 0.2],
        ['value' => '50+', 'description' => "Languages supported\nworldwide", 'delay' => 0.4],
        ['value' => '1000+', 'description' => "Organizations using\nAuralink", 'delay' => 0.6],
    ];

    // Generate Data Points (PHP Implementation of original JS logic)
    $dataPoints = [];
    $baseLeft = 1;
    $spacing = 32;
    for ($i = 0; $i < 50; $i++) {
        $direction = $i % 2 === 0 ? "down" : "up";
        $height = rand(88, 208); // 88 + random(120)
        $top = $direction === "down" ? rand(250, 400) : rand(-80, 20);
        $dataPoints[] = [
            'id' => $i,
            'left' => $baseLeft + $i * $spacing,
            'top' => $top,
            'height' => $height,
            'direction' => $direction,
            'delay' => $i * 0.035,
        ];
    }
@endphp

<div class="w-full overflow-hidden bg-white" x-data="{ isVisible: false }" x-init="setTimeout(() => isVisible = true, 100)">
    <div class="mx-auto max-w-7xl px-8 py-24 pt-16">
        <div class="grid grid-cols-12 gap-5 gap-y-16">
            <!-- Left Content -->
            <div class="col-span-12 md:col-span-6 relative z-10">
                <div class="relative h-6 inline-flex items-center font-mono uppercase text-xs text-[#167E6C] mb-12 px-2" style="font-family: 'Geist Mono', monospace;">
                    <div class="flex items-center gap-0.5 overflow-hidden">
                        <span 
                            class="block whitespace-nowrap overflow-hidden text-[#167E6C] relative z-10 transition-all duration-800 ease-out"
                            style="color: #146e96;"
                            :style="isVisible ? 'width: auto' : 'width: 0'"
                        >
                            Trusted at scale
                        </span>
                        <span 
                            class="block w-1.5 h-3 bg-[#167E6C] ml-0.5 relative z-10 rounded-sm animate-pulse"
                            style="color: #146e96;"
                        ></span>
                    </div>
                </div>

                <h2 class="text-[40px] font-normal leading-tight tracking-tight text-[#111A4A] mb-6" style="font-family: 'Figtree', sans-serif;">
                    Analyzing billions of conversations daily 
                    <span class="opacity-40">
                        for the world's most sophisticated teams and enterprises.
                    </span>
                </h2>

                <p class="text-lg leading-6 text-[#111A4A] opacity-60 mt-0 mb-6" style="font-family: 'Figtree', sans-serif;">
                    As the intelligence layer for modern communication, we provide real-time insights and emotional detection through our advanced AI-powered platform.
                </p>

                <button class="relative inline-flex justify-center items-center leading-4 text-center cursor-pointer whitespace-nowrap outline-none font-medium h-9 text-[#232730] bg-white/50 backdrop-blur-sm shadow-[0_1px_1px_0_rgba(255,255,255,0),0_0_0_1px_rgba(87,90,100,0.12)] transition-all duration-200 ease-in-out rounded-lg px-4 mt-5 text-sm group hover:shadow-[0_1px_2px_0_rgba(0,0,0,0.05),0_0_0_1px_rgba(87,90,100,0.18)]">
                    <span class="relative z-10 flex items-center gap-1">
                        Learn about our platform
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 -mr-1 transition-transform duration-150 group-hover:translate-x-1"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </span>
                </button>
            </div>

            <!-- Right Visualization (Graph) -->
            <div class="col-span-12 md:col-span-6">
                <div class="relative w-full h-[416px] -ml-[200px]">
                    <div class="absolute top-0 left-[302px] w-[680px] h-[416px] pointer-events-none">
                        <div class="relative w-full h-full">
                            @foreach($dataPoints as $point)
                                <div
                                    class="absolute w-1.5 rounded-[3px] transition-all duration-[2000ms] ease-[cubic-bezier(0.5,0,0.01,1)]"
                                    style="
                                        left: {{ $point['left'] }}px;
                                        top: {{ $point['top'] }}px;
                                        background: {{ $point['direction'] === 'down' 
                                            ? 'linear-gradient(rgb(176, 200, 196) 0%, rgb(176, 200, 196) 10%, rgba(156, 217, 93, 0.1) 40%, rgba(113, 210, 240, 0) 75%)' 
                                            : 'linear-gradient(to top, rgb(176, 200, 196) 0%, rgb(176, 200, 196) 10%, rgba(156, 217, 93, 0.1) 40%, rgba(113, 210, 240, 0) 75%)' }};
                                        background-color: rgba(22, 126, 108, 0.01);
                                        transition-delay: {{ $point['delay'] * 1000 }}ms;
                                    "
                                    :style="isVisible ? 'opacity: 1; height: {{ $point['height'] }}px' : 'opacity: 0; height: 0'"
                                >
                                    <div
                                        class="absolute -left-[1px] w-2 h-2 bg-[#167E6C] rounded-full transition-opacity duration-300"
                                        style="
                                            top: {{ $point['direction'] === 'down' ? '0px' : ($point['height'] - 8) . 'px' }};
                                            transition-delay: {{ ($point['delay'] + 1.7) * 1000 }}ms;
                                        "
                                        :style="isVisible ? 'opacity: 1' : 'opacity: 0'"
                                    ></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="col-span-12">
                <div class="overflow-visible pb-5">
                    <div class="grid grid-cols-12 gap-5 relative z-10">
                        @foreach($stats as $stat)
                            <div class="col-span-6 md:col-span-3">
                                <div
                                    class="flex flex-col gap-2 transition-all duration-[1500ms] ease-[cubic-bezier(0.1,0,0.1,1)]"
                                    style="transition-delay: {{ $stat['delay'] * 1000 }}ms;"
                                    :style="isVisible ? 'opacity: 1; transform: translateY(0); filter: blur(0px)' : 'opacity: 0; transform: translateY(20px); filter: blur(4px)'"
                                >
                                    <span class="text-2xl font-medium leading-[26.4px] tracking-tight text-[#167E6C]" style="color: #146e96;">
                                        {{ $stat['value'] }}
                                    </span>
                                    <p class="text-xs leading-[13.2px] text-[#7C7F88] m-0 whitespace-pre-line">
                                        {{ $stat['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
