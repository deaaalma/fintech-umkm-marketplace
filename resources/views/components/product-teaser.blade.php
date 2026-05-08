@props([
    'dailyVolume' => "1,430,992,688",
    'dailyVolumeLabel' => "DAILY ANALYZED MESSAGES",
    'headline' => "The Intelligence Layer for Modern Communication",
    'subheadline' => "Auralink connects every call, chat, and meeting into a unified AI layer — delivering real-time insights, tone analysis, and team alignment across your favorite tools.",
    'description' => "Trusted by fast-growing teams and enterprises, Auralink powers smarter communication across 1,000+ organizations — with enterprise-grade security, multilingual analysis, and instant emotional detection.",
    'videoSrc' => "https://cdn.sanity.io/files/1t8iva7t/production/a2cbbed7c998cf93e7ecb6dae75bab42b13139c2.mp4",
    'posterSrc' => "/images/design-mode/9ad78a5534a46e77bafe116ce1c38172c60dc21a-1069x1068.png",
    'primaryButtonText' => "Start analyzing",
    'primaryButtonHref' => "#",
    'secondaryButtonText' => "View API Docs",
    'secondaryButtonHref' => "#",
])

<section class="w-full px-8 pt-32 pb-16">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-12 gap-2">
            <!-- Left Card -->
            <div
                x-data="{ shown: false }"
                x-init="setTimeout(() => shown = true, 100)"
                :class="shown ? 'opacity-100' : 'opacity-0'"
                class="col-span-12 lg:col-span-6 bg-[#e9e9e9] rounded-[40px] p-12 lg:p-16 flex flex-col justify-end aspect-square overflow-hidden transition-opacity duration-1000 ease-out"
            >
                <div class="flex flex-col gap-1 text-[#9a9a9a]">
                    <span
                        class="text-sm uppercase tracking-tight font-mono flex items-center gap-1"
                        style="font-family: 'Geist Mono', monospace;"
                    >
                        {{ $dailyVolumeLabel }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-[0.71em] h-[0.71em]"><path d="M7 7h10v10"/><path d="M7 17L17 7"/></svg>
                    </span>
                    <span
                        class="text-[32px] leading-[160px] tracking-tight bg-gradient-to-r from-[#202020] via-[#00517f] via-[#52aee3] to-[#9ed2fc] bg-clip-text text-transparent"
                        style="font-feature-settings: 'clig' 0, 'liga' 0; height: 98px; display: none;"
                    >
                        {{ $dailyVolume }}
                    </span>
                </div>

                <h1
                    class="text-[56px] leading-[60px] tracking-tight text-[#202020] max-w-[520px] mb-6"
                    style="font-weight: 500; font-family: 'Figtree', sans-serif;"
                >
                    {{ $headline }}
                </h1>

                <p
                    class="text-lg leading-7 text-[#404040] max-w-[520px] mb-6"
                    style="font-family: 'Figtree', sans-serif;"
                >
                    {{ $subheadline }}
                </p>

                <ul class="flex gap-1.5 flex-wrap mt-10">
                    <li>
                        <a
                            href="{{ $primaryButtonHref }}"
                            class="block cursor-pointer text-white bg-[#156d95] rounded-full px-[18px] py-[15px] text-base leading-4 whitespace-nowrap transition-all duration-150 ease-out hover:rounded-2xl"
                        >
                            {{ $primaryButtonText }}
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ $secondaryButtonHref }}"
                            class="block cursor-pointer text-[#202020] border border-[#202020] rounded-full px-[18px] py-[15px] text-base leading-4 whitespace-nowrap transition-all duration-150 ease-out hover:rounded-2xl"
                        >
                            {{ $secondaryButtonText }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right Card (Video) -->
            <div
                x-data="{ shown: false }"
                x-init="setTimeout(() => shown = true, 300)"
                :class="shown ? 'opacity-100' : 'opacity-0'"
                class="col-span-12 lg:col-span-6 bg-white rounded-[40px] flex justify-center items-center aspect-square overflow-hidden transition-opacity duration-1000 ease-out"
                style="background-image: url('https://storage.googleapis.com/storage.magicpath.ai/user/282171029206482944/assets/882ef3dd-3459-4fd8-a939-52ceada51d5c.png'); background-size: cover; background-position: center;"
            >
                <video
                    src="{{ $videoSrc }}"
                    autoplay
                    muted
                    loop
                    playsinline
                    poster="{{ $posterSrc }}"
                    class="block w-full h-full object-cover"
                ></video>
            </div>
        </div>
    </div>
</section>
