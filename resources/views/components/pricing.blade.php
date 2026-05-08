@php
    $plans = [
        [
            'name' => 'Starter',
            'level' => 'starter',
            'price' => ['monthly' => 29, 'yearly' => 290],
            'popular' => false,
        ],
        [
            'name' => 'Pro',
            'level' => 'pro',
            'price' => ['monthly' => 99, 'yearly' => 990],
            'popular' => true,
        ],
        [
            'name' => 'Enterprise',
            'level' => 'enterprise',
            'price' => ['monthly' => 299, 'yearly' => 2990],
            'popular' => false,
        ],
    ];

    $features = [
        ['name' => "Real-time conversation analysis", 'included' => "starter"],
        ['name' => "Up to 10,000 messages/month", 'included' => "starter"],
        ['name' => "Basic sentiment detection", 'included' => "starter"],
        ['name' => "Email support", 'included' => "starter"],
        ['name' => "Advanced emotional intelligence", 'included' => "pro"],
        ['name' => "Up to 100,000 messages/month", 'included' => "pro"],
        ['name' => "Multi-language support (50+ languages)", 'included' => "pro"],
        ['name' => "Priority support", 'included' => "pro"],
        ['name' => "Custom AI model training", 'included' => "enterprise"],
        ['name' => "Unlimited messages", 'included' => "enterprise"],
        ['name' => "Dedicated account manager", 'included' => "enterprise"],
        ['name' => "24/7 phone support", 'included' => "enterprise"],
        ['name' => "API access", 'included' => "all"],
        ['name' => "Team collaboration tools", 'included' => "all"],
    ];

    function shouldShowCheck($included, $level) {
        if ($included === 'all') return true;
        if ($included === 'enterprise' && $level === 'enterprise') return true;
        if ($included === 'pro' && ($level === 'pro' || $level === 'enterprise')) return true;
        if ($included === 'starter') return true; // Starter features are in all plans usually, but logic here follows specific strictness? 
        // Based on React code: 
        // if (included === "starter") return true -> implies starter features are everywhere? 
        // Yes, usually higher tiers include lower tiers.
        return false;
    }
@endphp

<section class="py-24 bg-background" x-data="{ isYearly: false, selectedPlan: 'pro' }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-sans text-[40px] font-normal leading-tight mb-4" style="font-family: 'Figtree', sans-serif;">Choose Your Plan</h2>
            <p class="font-sans text-lg text-muted-foreground max-w-2xl mx-auto" style="font-family: 'Figtree', sans-serif;">
                Get started with Auralink's communication intelligence platform. All plans include API access and team collaboration.
            </p>
        </div>

        <!-- Billing Toggle -->
        <div class="flex justify-center mb-12">
            <div class="inline-flex items-center gap-2 bg-secondary rounded-full p-1">
                <button
                    type="button"
                    @click="isYearly = false"
                    :class="!isYearly ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                    class="px-6 py-2 rounded-full font-sans text-lg transition-all"
                    style="font-family: 'Figtree', sans-serif;"
                >
                    Monthly
                </button>
                <button
                    type="button"
                    @click="isYearly = true"
                    :class="isYearly ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                    class="px-6 py-2 rounded-full font-sans text-lg transition-all "
                    style="font-family: 'Figtree', sans-serif;"
                >
                    Yearly
                    <span class="ml-2 text-sm text-[#156d95]">Save 17%</span>
                </button>
            </div>
        </div>

        <!-- Plan Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($plans as $plan)
                <button
                    type="button"
                    @click="selectedPlan = '{{ $plan['level'] }}'"
                    :class="selectedPlan === '{{ $plan['level'] }}' ? 'border-[#156d95] bg-[#156d95]/5' : 'border-border hover:border-[#156d95]/50'"
                    class="relative p-8 rounded-2xl text-left transition-all border-2"
                >
                    @if($plan['popular'])
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#156d95] text-white px-4 py-1 rounded-full text-sm font-sans" style="font-family: 'Figtree', sans-serif;">
                            Most Popular
                        </span>
                    @endif
                    <div class="mb-6">
                        <h3 class="font-sans text-2xl font-medium mb-2" style="font-family: 'Figtree', sans-serif;">{{ $plan['name'] }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="font-sans text-4xl font-medium" style="font-family: 'Figtree', sans-serif;" x-text="isYearly ? '${{ $plan['price']['yearly'] }}' : '${{ $plan['price']['monthly'] }}'"></span>
                            <span class="font-sans text-lg text-muted-foreground" style="font-family: 'Figtree', sans-serif;" x-text="isYearly ? '/year' : '/month'"></span>
                        </div>
                    </div>
                    <div
                        :class="selectedPlan === '{{ $plan['level'] }}' ? 'bg-[#156d95] text-white' : 'bg-secondary text-foreground'"
                        class="w-full py-3 px-6 rounded-full font-sans text-lg transition-all text-center"
                        style="font-family: 'Figtree', sans-serif;"
                    >
                        <span x-text="selectedPlan === '{{ $plan['level'] }}' ? 'Selected' : 'Select Plan'"></span>
                    </div>
                </button>
            @endforeach
        </div>

        <!-- Features Table -->
        <div class="border border-border rounded-2xl overflow-hidden bg-white">
            <div class="overflow-x-auto">
                <div class="min-w-[768px]">
                    <!-- Table Header -->
                    <div class="flex items-center p-6 bg-secondary border-b border-border">
                        <div class="flex-1">
                            <h3 class="font-sans text-xl font-medium" style="font-family: 'Figtree', sans-serif;">Features</h3>
                        </div>
                        <div class="flex items-center gap-8">
                            @foreach($plans as $plan)
                                <div class="w-24 text-center font-sans text-lg font-medium" style="font-family: 'Figtree', sans-serif;">
                                    {{ $plan['name'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Feature Rows -->
                    @foreach($features as $index => $feature)
                        <div
                            :class="{
                                'bg-background': {{ $index % 2 === 0 ? 'true' : 'false' }},
                                'bg-secondary/30': {{ $index % 2 !== 0 ? 'true' : 'false' }},
                                'bg-[#156d95]/5': '{{ $feature['included'] }}' === selectedPlan
                            }"
                            class="flex items-center p-6 transition-colors"
                        >
                            <div class="flex-1">
                                <span class="font-sans text-lg" style="font-family: 'Figtree', sans-serif;">{{ $feature['name'] }}</span>
                            </div>
                            <div class="flex items-center gap-8">
                                @foreach($plans as $plan)
                                    <div class="w-24 flex justify-center">
                                        @if(shouldShowCheck($feature['included'], $plan['level']))
                                            <div class="w-6 h-6 rounded-full bg-[#156d95] flex items-center justify-center">
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white"><path d="M11.4669 3.72684C11.7558 3.91574 11.8369 4.30308 11.648 4.59198L7.39799 11.092C7.29783 11.2452 7.13556 11.3467 6.95402 11.3699C6.77247 11.3931 6.58989 11.3355 6.45446 11.2124L3.70446 8.71241C3.44905 8.48022 3.43023 8.08494 3.66242 7.82953C3.89461 7.57412 4.28989 7.55529 4.5453 7.78749L6.75292 9.79441L10.6018 3.90792C10.7907 3.61902 11.178 3.53795 11.4669 3.72684Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                                            </div>
                                        @else
                                            <span class="text-muted-foreground">-</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="mt-12 text-center">
             <button class="bg-[#156d95] text-white px-[18px] py-[15px] rounded-full font-sans text-lg hover:rounded-2xl transition-all" style="font-family: 'Figtree', sans-serif;">
                Get started with <span x-text="selectedPlan === 'starter' ? 'Starter' : (selectedPlan === 'pro' ? 'Pro' : 'Enterprise')"></span>
            </button>
        </div>
    </div>
</section>
