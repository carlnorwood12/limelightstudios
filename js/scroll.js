

gsap.fromTo(".marquee-container", 
  {
    filter: "blur(5px) grayscale(100%)",
    opacity: 0,
    clipPath: "polygon(0 50%, 100% 50%, 100% 50%, 0 50%)",
    ease: "power2.out",
    duration: 2,
  },
  {
    filter: "blur(0px) grayscale(0%)",
    opacity: 1,
    clipPath: "polygon(0 100%, 100% 100%, 100% 0%, 0% 0%)",
    duration: 2,
    ease: "power2.out",
  }
);
// ScrollTrigger batch for Swiper slides were avoiding the hero and card swipers
gsap.set(".swiper-slide:not(.hero-swiper .swiper-slide):not(.card-swiper .swiper-slide)", { opacity: 0 });
ScrollTrigger.batch(".swiper-slide:not(.hero-swiper .swiper-slide):not(.card-swiper .swiper-slide)", {
  start: "top 95%",
  once: true,
  onEnter: (batch) => {
    gsap.fromTo(batch, 
      {
        opacity: 0,
        filter: "blur(1px) grayscale(100%)",
        y: 50, 
        scale: 0.9
      },
      {
        duration: 0.8,
        opacity: 1,
        filter: "blur(0px) grayscale(0%)",
        y: 0,
        scale: 1,
        stagger: 0.1,
        ease: "power2.out",
      }
    );
  },
});