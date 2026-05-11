<script>
    document.addEventListener('DOMContentLoaded', () => {
        const initAnimations = () => {
            if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                setTimeout(initAnimations, 100);
                return;
            }

            gsap.registerPlugin(ScrollTrigger);

            gsap.to(".hero-text-anim", {
                y: -200,
                opacity: 0,
                scale: 0.8,
                filter: "blur(10px)",
                scrollTrigger: {
                    trigger: ".hero-section",
                    start: "top top",
                    end: "bottom top",
                    scrub: 1
                }
            });

            gsap.from(".hero-text-anim", {
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

            sectionTransitionTl.to("#workflow .max-w-7xl", {
                opacity: 0.3,
                scale: 0.95,
                filter: "blur(15px)",
                y: -50,
                ease: "power1.inOut"
            }, 0);

            sectionTransitionTl.to(["#workflow", "#faq"], {
                backgroundColor: "#f0f7ff",
                duration: 0.5,
            }, 0.2);

            sectionTransitionTl.to(["#workflow", "#faq"], {
                backgroundColor: "#ffffff",
                duration: 0.5,
            }, 0.7);

            sectionTransitionTl.from(".faq-content-wrapper", {
                y: 100,
                opacity: 0,
                scale: 0.98,
                filter: "blur(5px)",
                ease: "power2.out"
            }, 0.3);

            const workflowSection = document.querySelector("#workflow");
            const stepContents = gsap.utils.toArray(".workflow-step-content");
            const mockups = gsap.utils.toArray(".workflow-mockup");
            const stickyBox = document.querySelector("#sticky-visual-box");

            const bgColors = ["#ffffff", "#f0f7ff", "#e8f2ff", "#deedff"];

            let currentIndex = -1;

            ScrollTrigger.create({
                trigger: "#workflow",
                start: "top 80%",
                end: "bottom 20%",
                onUpdate: (self) => {
                    let closestIndex = 0;
                    let minDistance = Infinity;
                    const centerY = window.innerHeight / 2;

                    stepContents.forEach((step, i) => {
                        const rect = step.getBoundingClientRect();
                        const stepCenterY = rect.top + rect.height / 2;
                        const distance = Math.abs(centerY - stepCenterY);

                        if (distance < minDistance) {
                            minDistance = distance;
                            closestIndex = i;
                        }
                    });

                    if (closestIndex !== currentIndex) {
                        currentIndex = closestIndex;
                        updateWorkflow(currentIndex);
                    }
                }
            });

            function updateWorkflow(i) {
                gsap.to(workflowSection, { 
                    backgroundColor: bgColors[i], 
                    duration: 0.6, 
                    ease: "power2.out" 
                });

                const mainTitle = workflowSection.querySelector("h2");
                const mainDesc = workflowSection.querySelector(".workflow-header p");

                gsap.to(mainTitle, { color: "#003d5c", duration: 0.3 });
                gsap.to(mainDesc, { color: "#666666", duration: 0.3 });

                stepContents.forEach((s, idx) => {
                    const h3 = s.querySelector("h3");
                    const p = s.querySelector("p");
                    const num = s.querySelector("span");

                    const isActive = i === idx;
                    
                    gsap.to(s, { 
                        opacity: isActive ? 1 : 0.2, 
                        x: isActive ? 0 : -2,
                        duration: 0.05,
                        ease: "none"
                    });

                    if (isActive) {
                        gsap.to(h3, { color: "#003d5c", duration: 0.2 });
                        gsap.to(p, { color: "#666666", duration: 0.2 });
                        gsap.to(num, { color: "#003d5c", duration: 0.2 });
                    }
                });
                
                mockups.forEach((mock, idx) => {
                    const isActiveMock = i === idx;

                    gsap.to(mock, {
                        opacity: isActiveMock ? 1 : 0,
                        scale: isActiveMock ? 1 : 0.99,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                gsap.fromTo(stickyBox, { y: 3 }, { y: 0, duration: 0.1, ease: "power2.out" });
                gsap.to(stickyBox, { 
                    borderColor: "rgba(0,0,0,0.05)",
                    duration: 0.3 
                });
            }

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

            gsap.from("#faq h2", {
                x: -30,
                opacity: 0,
                duration: 1.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#faq",
                    start: "top 90%",
                    scrub: 1
                }
            });
        };
        
        initAnimations();
    });
</script>
