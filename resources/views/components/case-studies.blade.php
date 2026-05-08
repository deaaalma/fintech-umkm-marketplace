@php
    $caseStudies = [
        [
            'id' => 'notion',
            'company' => 'Clandestine',
            'logo' => '<svg fill="none" height="48" viewBox="0 0 38 48" width="38" xmlns="http://www.w3.org/2000/svg"><path d="m14.25 5c0 7.8701-6.37994 14.25-14.25 14.25v9.5h14.25v14.25h9.5c0-7.8701 6.3799-14.25 14.25-14.25v-9.5h-14.25v-14.25z" fill="#16b364"/></svg>',
            'title' => "Clandestine uses Auralink to understand how their teams collaborate in real-time.",
            'features' => ["Slack Calls", "Meeting Transcripts", "Sentiment Reports"],
            'quote' => "Auralink gives us clarity on team alignment we never had before.",
            'attribution' => "Marie Chen, Head of Operations, Clandestine",
            'accentColor' => "#16b364",
            'cards' => ['notion', 'slack']
        ],
        [
            'id' => 'cloudwatch',
            'company' => 'Cloudwatch',
            'logo' => '<svg fill="none" height="48" viewBox="0 0 192 48" width="192" xmlns="http://www.w3.org/2000/svg"><text fill="currentColor" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="600" x="58" y="32">Cloudwatch</text><rect fill="#3b82f6" height="48" rx="12" width="48"/><path d="m23.9995 14.25c5.3848 0 9.7505 4.3658 9.7505 9.7506s-4.3657 9.7505-9.7505 9.7505-9.7506-4.3657-9.7506-9.7505 4.3658-9.7506 9.7506-9.7506z" fill="#fff" x="0" y="0"/></svg>',
            'title' => "Cloudwatch leverages Auralink to monitor cross-functional team dynamics across global offices.",
            'features' => ["Slack Calls", "Meeting Transcripts", "Sentiment Reports"],
            'quote' => "With Auralink, we can see collaboration patterns that directly impact our product velocity.",
            'attribution' => "Sarah Chen, VP Engineering, Cloudwatch",
            'accentColor' => "#3b82f6",
            'cards' => ['stripe', 'slack']
        ],
        [
            'id' => 'eightball',
            'company' => 'EightBall',
            'logo' => '<svg fill="none" height="48" viewBox="0 0 151 48" width="151" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="m20 44c11.0457 0 20-8.9543 20-20s-8.9543-20-20-20-20 8.9543-20 20 8.9543 20 20 20zm5-16c4.9706 0 9-4.0294 9-9s-4.0294-9-9-9-9 4.0294-9 9 4.0294 9 9 9z" fill="#0A0D12" fill-rule="evenodd"/><text fill="#0A0D12" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="bold" x="50" y="32">EightBall</text></svg>',
            'title' => "EightBall relies on Auralink to track team health metrics and async communication quality.",
            'features' => ["Slack Calls", "Sentiment Reports"],
            'quote' => "Auralink transformed how we understand our remote-first culture.",
            'attribution' => "Karri Saarinen, Co-founder, EightBall",
            'accentColor' => "#0A0D12",
            'cards' => ['meeting', 'slack']
        ],
        [
            'id' => 'coreos',
            'company' => 'CoreOS',
            'logo' => '<svg fill="none" height="48" viewBox="0 0 155 48" width="155" xmlns="http://www.w3.org/2000/svg"><rect fill="#101828" height="48" rx="12" width="48"/><text fill="#101828" fontFamily="Inter, sans-serif" fontSize="20" fontWeight="bold" x="60" y="32">CoreOS</text></svg>',
            'title' => "CoreOS uses Auralink to ensure design and engineering teams stay in sync during sprints.",
            'features' => ["Meeting Transcripts", "Sentiment Reports"],
            'quote' => "The sentiment analysis helps us identify friction points before they become blockers.",
            'attribution' => "Noah Levin, VP Engineering, CoreOS",
            'accentColor' => "#155eef",
            'cards' => ['figma', 'meeting']
        ]
    ];
@endphp

<div
    class="w-full min-h-screen bg-gradient-to-br from-background via-background to-muted/20 flex items-center justify-center py-24 px-8"
    x-data="{
        currentIndex: 0,
        direction: 1,
        isAutoPlaying: true,
        timer: null,
        caseStudies: {{ json_encode($caseStudies) }},
        init() {
            this.startAutoPlay();
            this.$watch('currentIndex', () => {
                 // Trigger animations if needed
            });
        },
        startAutoPlay() {
            this.stopAutoPlay();
            this.timer = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        stopAutoPlay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        nextSlide() {
            this.direction = 1;
            this.currentIndex = (this.currentIndex + 1) % this.caseStudies.length;
        },
        prevSlide() {
            this.direction = -1;
            this.currentIndex = (this.currentIndex - 1 + this.caseStudies.length) % this.caseStudies.length;
        },
        goToSlide(index) {
            this.direction = index > this.currentIndex ? 1 : -1;
            this.currentIndex = index;
        }
    }"
    @mouseenter="stopAutoPlay()"
    @mouseleave="startAutoPlay()"
>
    <div class="max-w-7xl w-full">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h1 class="text-[40px] leading-tight font-normal text-foreground mb-6 tracking-tight" style="font-weight: 400; font-family: 'Figtree', sans-serif;">
                Customer Success Stories
            </h1>
            <p class="text-lg leading-7 text-muted-foreground max-w-2xl mx-auto" style="font-family: 'Figtree', sans-serif;">
                See how leading teams use Auralink to gain clarity on collaboration and team alignment.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8 min-h-[400px]">
                <template x-for="(study, index) in caseStudies" :key="study.id">
                    <div
                        x-show="currentIndex === index"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-8"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200 transform absolute"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-8"
                        class="space-y-6 w-full"
                    >
                        <div class="text-foreground/60" x-html="study.logo"></div>

                        <h2 class="text-4xl font-bold text-foreground leading-tight tracking-tight" style="font-family: 'Figtree', sans-serif; font-weight: 400; font-size: 32px;">
                            <span x-text="study.title"></span>
                        </h2>

                        <div class="flex flex-wrap gap-2">
                             <template x-for="feature in study.features">
                                <span class="flex items-center gap-2 bg-white/75 shadow-sm border border-black/5 rounded-lg px-2 py-1 text-sm font-medium text-foreground">
                                    <span x-text="feature"></span>
                                </span>
                             </template>
                        </div>

                        <blockquote class="border-l-4 border-primary pl-6 py-2">
                            <p class="text-lg leading-7 text-foreground/80 italic mb-3" style="font-family: 'Figtree', sans-serif;">
                                "<span x-text="study.quote"></span>"
                            </p>
                            <footer class="text-sm text-muted-foreground" style="font-family: 'Inter', sans-serif;">
                                <span x-text="study.attribution"></span>
                            </footer>
                        </blockquote>
                    </div>
                </template>

                 <!-- Navigation -->
                 <div class="flex items-center gap-6 mt-8 relative z-10">
                    <div class="flex gap-2">
                        <template x-for="(study, index) in caseStudies" :key="index">
                            <button
                                @click="goToSlide(index)"
                                class="h-2 rounded-full transition-all duration-300"
                                :class="index === currentIndex ? 'w-8 bg-primary' : 'w-2 bg-muted-foreground/30 hover:bg-muted-foreground/50'"
                                :aria-label="'Go to slide ' + (index + 1)"
                            ></button>
                        </template>
                    </div>

                    <div class="flex gap-2">
                        <button @click="prevSlide()" class="p-2 rounded-lg border border-border hover:bg-accent transition-colors">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button @click="nextSlide()" class="p-2 rounded-lg border border-border hover:bg-accent transition-colors">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Content - Card Visualization -->
            <div class="relative h-[500px] flex items-center justify-center">
                 <!-- 
                    Simplified representation of the cards:
                    Since the React code has specific sub-components (NotionCollaborationCard, etc.),
                    we will emulate one generic card style that adapts its content, or simplified static placeholders with transitions.
                    For exact fidelity, we would need to port every SVG/Card structure.
                    Here we provide a representative generic card implementation.
                 -->
                <div class="relative w-full h-full flex items-center justify-center">
                     <template x-for="(study, index) in caseStudies" :key="study.id + '-card'">
                        <div
                            x-show="currentIndex === index"
                            x-transition:enter="transition ease-out duration-500 delay-100"
                            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-300 absolute"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                            class="absolute w-[380px] rounded-xl p-6 backdrop-blur-xl bg-white/85 shadow-2xl border border-white/80"
                            style="box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12);"
                        >
                            <div class="flex flex-col space-y-5">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-semibold text-foreground">Team Alignment</h4>
                                    <span class="text-xs text-muted-foreground">Real-time</span>
                                </div>
                                <div class="space-y-4">
                                     <!-- Mock Data visual -->
                                    <div class="flex items-center justify-between p-3 bg-muted/30 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                            <span class="text-sm text-foreground">Design Team</span>
                                        </div>
                                        <span class="text-sm font-semibold text-green-600">96%</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-muted/30 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full" :style="'background-color: ' + study.accentColor"></div>
                                            <span class="text-sm text-foreground">Engineering</span>
                                        </div>
                                        <span class="text-sm font-semibold" :style="'color: ' + study.accentColor">94%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </template>
                </div>
            </div>
        </div>
    </div>
</div>
