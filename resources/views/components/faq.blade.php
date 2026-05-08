@props([
    'title' => "Frequently asked questions",
    'faqs' => [
        [
            'question' => "What is Auralink and how does it work?",
            'answer' => "Auralink is an AI-powered intelligence layer that connects all your communication tools—calls, chats, and meetings—into a unified system. It analyzes conversations in real-time to provide insights on sentiment, tone, team alignment, and collaboration patterns. Simply integrate Auralink with your existing tools like Slack, Zoom, or Microsoft Teams, and start gaining actionable insights immediately."
        ],
        [
            'question' => "How does Auralink use my data to build a custom AI chat?",
            'answer' => "Auralink processes your communication data using advanced natural language processing and machine learning models. All data is encrypted end-to-end and processed in compliance with enterprise-grade security standards. Your data is never shared with third parties, and you maintain complete control over what gets analyzed. The AI learns from patterns in your team's communication to provide personalized insights specific to your organization."
        ],
        [
            'question' => "How do I get started with Auralink and what are the pricing options?",
            'answer' => "Getting started is simple: sign up for a free trial, connect your communication tools, and start analyzing within minutes. We offer flexible pricing tiers: Starter (free for small teams), Professional ($29/user/month), and Enterprise (custom pricing with dedicated support). All plans include core features like sentiment analysis and real-time insights. Contact our sales team for volume discounts and custom enterprise solutions."
        ]
    ]
])

<section class="w-full py-24 px-8 bg-white" x-data="{ openIndex: null }">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-12 gap-16">
            <!-- Left Column - Title -->
            <div class="lg:col-span-4">
                <h2
                    class="text-[40px] leading-tight font-normal text-[#202020] tracking-tight sticky top-24"
                    style="font-family: 'Figtree', sans-serif; font-weight: 400;"
                >
                    {{ $title }}
                </h2>
            </div>

            <!-- Right Column - FAQ Items -->
            <div class="lg:col-span-8">
                <div class="space-y-0">
                    @foreach($faqs as $index => $faq)
                        <div class="border-b border-[#e5e5e5] last:border-b-0">
                            <button
                                @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                                class="w-full flex items-center justify-between py-6 text-left group hover:opacity-70 transition-opacity duration-150"
                                :aria-expanded="openIndex === {{ $index }}"
                            >
                                <span
                                    class="text-lg leading-7 text-[#202020] pr-8"
                                    style="font-family: 'Figtree', sans-serif; font-weight: 400;"
                                >
                                    {{ $faq['question'] }}
                                </span>
                                <div
                                    class="flex-shrink-0 transition-transform duration-200 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="openIndex === {{ $index }} ? 'rotate-45' : 'rotate-0'"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[#202020]"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </div>
                            </button>

                            <div
                                x-show="openIndex === {{ $index }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="height-0 opacity-0"
                                x-transition:enter-end="height-auto opacity-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="height-auto opacity-100"
                                x-transition:leave-end="height-0 opacity-0"
                                class="overflow-hidden"
                            >
                                <div class="pb-6 pr-12">
                                    <p
                                        class="text-lg leading-6 text-[#666666]"
                                        style="font-family: 'Figtree', sans-serif;"
                                    >
                                        {{ $faq['answer'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
