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
    end: "bottom bottom",
    scrub: true,
    id: "scrub",
  },
});
tl3.from(" .yo .swiper-slide", {
  stagger: 0.125,
  y: 50,
  opacity: 0,
  duration: 1,
});
let tl4 = gsap.timeline({
  scrollTrigger: {
    trigger: ".content-suggested .swiper-slide",
    start: "top bottom",
    end: "bottom bottom",
    scrub: true,
    id: "scrub",
  },
});
tl4.from(".content-suggested .swiper-slide", {
  stagger: 0.125,
  y: 50,
  opacity: 0,
  duration: 1,
});
let tl5 = gsap.timeline({
  scrollTrigger: {
    trigger: ".content-releases .swiper-slide",
    start: "top bottom",
    end: "bottom bottom",
    scrub: true,
    id: "scrub",
  },
});
tl5.from(".content-releases .swiper-slide", {
  stagger: 0.125,
  y: 50,
  opacity: 0,
  duration: 1,
});