let tl = gsap.timeline({
  scrollTrigger: {
    trigger: ".uk-accordion",
    start: "top bottom",
    end: "bottom bottom",
    scrub: true,
    id: "scrub",
  },
});
tl.from(".uk-accordion", {
  scale: 0.95,
  opacity: 0,
  filter: "grayscale(100%)",
  duration: 1,
});
let tl2 = gsap.timeline({
  scrollTrigger: {
    trigger: ".container",
    start: "top bottom",
    end: "bottom bottom",
    scrub: true,
    id: "scrub",
  },
});
tl2.from(".container", {
  scale: 0.95,
  opacity: 0,
  filter: "grayscale(100%)",
  duration: 1,
});
let tl3 = gsap.timeline({
  scrollTrigger: {
    trigger: ".yoo .swiper-slide",
    start: "top bottom",
    end: "bottom+=200 bottom",
    scrub: true,
    id: "scrub",
  },
});
tl3.from(" .yoo .swiper-slide", {
  scale: 0.95,
  y: 10,
  stagger: 0.05, 
  opacity: 0,
  filter: "grayscale(100%)",
  ease: "power3.out",
  duration: 1,
});
