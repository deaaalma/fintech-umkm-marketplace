@props([
    'companyName' => "Auralink",
    'tagline' => "The Intelligence Layer for Modern Communication",
    'sections' => [
        [
            'title' => "Product",
            'links' => [
                ['label' => "Features", 'href' => "#features"],
                ['label' => "Integrations", 'href' => "#integrations"],
                ['label' => "Pricing", 'href' => "#pricing"],
                ['label' => "API Docs", 'href' => "#api"],
                ['label' => "Changelog", 'href' => "#changelog"],
            ]
        ],
        [
            'title' => "Company",
            'links' => [
                ['label' => "About", 'href' => "#about"],
                ['label' => "Careers", 'href' => "#careers"],
                ['label' => "Blog", 'href' => "#blog"],
                ['label' => "Press Kit", 'href' => "#press"],
                ['label' => "Contact", 'href' => "#contact"],
            ]
        ],
        [
            'title' => "Resources",
            'links' => [
                ['label' => "Documentation", 'href' => "#docs"],
                ['label' => "Help Center", 'href' => "#help"],
                ['label' => "Community", 'href' => "#community"],
                ['label' => "Case Studies", 'href' => "#case-studies"],
                ['label' => "Webinars", 'href' => "#webinars"],
            ]
        ],
        [
            'title' => "Legal",
            'links' => [
                ['label' => "Privacy Policy", 'href' => "#privacy"],
                ['label' => "Terms of Service", 'href' => "#terms"],
                ['label' => "Security", 'href' => "#security"],
                ['label' => "Compliance", 'href' => "#compliance"],
                ['label' => "Cookie Policy", 'href' => "#cookies"],
            ]
        ],
    ],
    'socialLinks' => [
        'twitter' => "https://twitter.com",
        'linkedin' => "https://linkedin.com",
        'github' => "https://github.com",
        'email' => "hello@auralink.com",
    ]
])

<footer class="w-full bg-[#fafafa] border-t border-[#e5e5e5]">
    <div class="max-w-[1200px] mx-auto px-8 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-2 md:grid-cols-6 gap-8 mb-12">
            <!-- Brand Column -->
            <div class="col-span-2">
                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-[#202020] mb-2" style="font-family: 'Figtree', sans-serif; font-weight: 500;">
                        {{ $companyName }}
                    </h3>
                    <p class="text-sm leading-5 text-[#666666] max-w-xs" style="font-family: 'Figtree', sans-serif;">
                        {{ $tagline }}
                    </p>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-3 mt-6">
                    @if(isset($socialLinks['twitter']))
                        <a href="{{ $socialLinks['twitter'] }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#202020] hover:border-[#202020] transition-colors duration-150" aria-label="Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-12.7 16.4S.2 17.5 3 16c-1.7-.9-2.7-2-2.7-2 .4.1.8.1 1.1 0C.5 13.9.5 9 .5 9c.1.6 1 .9 1.4 1C1 8.8.6 3.4 3.9 4.3 6.1 6.6 8.5 7.8 11.2 7.7c-.6-2.5 1.5-5.4 4.1-5.4 1.3 0 2.5.6 3.3 1.5 1-.2 2-.8 2.8-1.5-.3 1.1-1.1 2-1.9 2.5 1-.1 1.9-.4 2.8-.8z"/></svg>
                        </a>
                    @endif
                    @if(isset($socialLinks['linkedin']))
                        <a href="{{ $socialLinks['linkedin'] }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#202020] hover:border-[#202020] transition-colors duration-150" aria-label="LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    @endif
                    @if(isset($socialLinks['github']))
                        <a href="{{ $socialLinks['github'] }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#202020] hover:border-[#202020] transition-colors duration-150" aria-label="GitHub">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                        </a>
                    @endif
                    @if(isset($socialLinks['email']))
                        <a href="mailto:{{ $socialLinks['email'] }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-[#e5e5e5] text-[#666666] hover:text-[#202020] hover:border-[#202020] transition-colors duration-150" aria-label="Email">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Link Sections -->
            @foreach($sections as $section)
                <div class="col-span-1">
                    <h4 class="text-sm font-medium text-[#202020] mb-4 uppercase tracking-wide" style="font-family: 'Figtree', sans-serif; font-weight: 500;">
                        {{ $section['title'] }}
                    </h4>
                    <ul class="space-y-3">
                        @foreach($section['links'] as $link)
                            <li>
                                <a href="{{ $link['href'] }}" class="text-sm text-[#666666] hover:text-[#202020] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-[#e5e5e5]">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">
                    &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#status" class="text-sm text-[#666666] hover:text-[#202020] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">
                        Status
                    </a>
                    <a href="#sitemap" class="text-sm text-[#666666] hover:text-[#202020] transition-colors duration-150" style="font-family: 'Figtree', sans-serif;">
                        Sitemap
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
