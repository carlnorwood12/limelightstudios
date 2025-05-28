// Timeline 1 - .uk-accordion Animation




let tl = gsap.timeline({
  scrollTrigger: {
    trigger: ".uk-accordion",
    start: "top+=800 bottom+=800", // Increased to 800px offset for start and end
    end: "bottom+=800 bottom+=800",
    scrub: 1, // Smooth scrub for consistent timing
    id: "scrub",
  },
});
tl.from(".uk-accordion", {
  scale: 0.95,
  opacity: 0,
  filter: "grayscale(100%)",
  duration: 1,
});

tl2.from(".container", {
  scale: 0.95,
  opacity: 0,
  filter: "grayscale(100%)",
  duration: 1,
});

gsap.set(".swiper-slide:not(.hero-swiper .swiper-slide)", { opacity: 0 });
ScrollTrigger.batch(".swiper-slide:not(.hero-swiper .swiper-slide)", {
  start: "top 95%",
  once: true,
  onEnter: (batch) => {
    gsap.from(batch, {
      duration: 0.5,
      opacity: 0,
      stagger: 0.05,
      ease: "ease",
    });
    gsap.to(batch, {
      duration: 0.5,
      opacity: 1,
      stagger: 0.05,
      ease: "ease",
    });
  },
});


gsap.fromTo(".button", { scale: 0.8, opacity: 0 }, { scale: 1, opacity: 1, stagger: 0.2, duration: 1 });
gsap.fromTo(".button2", { scale: 0.8, opacity: 0 }, { scale: 1, opacity: 1, stagger: 0.2, duration: 1 });

