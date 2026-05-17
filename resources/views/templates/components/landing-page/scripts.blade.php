<script>
    document.addEventListener('DOMContentLoaded', () => {
        const initAnimations = () => {
            if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                setTimeout(initAnimations, 100);
                return;
            }

            gsap.registerPlugin(ScrollTrigger);

            gsap.to(".hero-text-anim", {
                y: -150,
                opacity: 0,
                scale: 0.9,
                filter: "blur(8px)",
                scrollTrigger: {
                    trigger: ".hero-section",
                    start: "top top",
                    end: "bottom top",
                    scrub: 1
                }
            });

            gsap.to(".scroll-indicator", {
                y: 100,
                opacity: 0,
                scrollTrigger: {
                    trigger: ".hero-section",
                    start: "top top",
                    end: "30% top",
                    scrub: 1
                }
            });

            gsap.from(".hero-text-anim, .scroll-indicator", {
                y: 30,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power3.out"
            });

            gsap.fromTo(".partner-header-anim", 
                { y: 40, opacity: 0 },
                {
                    y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: "power3.out",
                    scrollTrigger: {
                        trigger: ".partner-header-section",
                        start: "top 80%",
                    }
                }
            );

            gsap.fromTo(".partners-animate-container",
                { x: -100, opacity: 0 },
                {
                    x: 0, opacity: 1, duration: 1.2, ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".partners-animate-container",
                        start: "top 90%",
                        end: "top 60%",
                        scrub: 1,
                    }
                }
            );

            gsap.fromTo(".solution-header", 
                { y: 40, opacity: 0, scale: 0.95 },
                {
                    y: 0, opacity: 1, scale: 1, duration: 1, ease: "power3.out",
                    scrollTrigger: {
                        trigger: ".solution-header",
                        start: "top 95%",
                        once: true
                    }
                }
            );

            const cards = gsap.utils.toArray(".solution-card");
            cards.forEach((card, i) => {
                gsap.fromTo(card, 
                    { y: 60, opacity: 0, scale: 0.9 },
                    {
                        y: 0, opacity: 1, scale: 1, duration: 0.8, delay: i * 0.1, ease: "power2.out",
                        scrollTrigger: {
                            trigger: card,
                            start: "top 95%",
                            once: true
                        }
                    }
                );
            });

            const sectionTransitionTl = gsap.timeline({
                scrollTrigger: {
                    trigger: "#faq",
                    start: "top bottom",
                    end: "top 20%",
                    scrub: 1.2,
                }
            });

            sectionTransitionTl.to(["#faq"], {
                backgroundColor: "#f8fafc",
                duration: 0.5,
            }, 0.2);

            sectionTransitionTl.from("#faq .max-w-7xl", {
                y: 50,
                opacity: 0,
                ease: "power2.out"
            }, 0.3);

            gsap.utils.toArray(".faq-item").forEach((item) => {
                gsap.fromTo(item, 
                    { 
                        y: 80, 
                        opacity: 0,
                        scale: 0.95
                    },
                    {
                        y: 0, 
                        opacity: 1,
                        scale: 1,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: item,
                            start: "top bottom-=50",
                            end: "top center+=100",
                            scrub: 1,
                        }
                    }
                );
            });

            gsap.from(".workflow-header", {
                y: 40, opacity: 0, duration: 1, ease: "power3.out",
                scrollTrigger: { trigger: ".workflow-header", start: "top 90%" }
            });

        };
        
        initAnimations();
    });
</script>