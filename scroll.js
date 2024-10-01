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
  filter: "blur(10px)",
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
  filter: "blur(5px)",
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

tl3.from(" .yoo .swiper-slide", {
  stagger: 0.125,
  filter: "blur(5px)",
  y: 50,
  opacity: 0,
  duration: 1,
});
tl3.to(".yoo .swiper-slide", {
  stagger: 0.125,
  filter: "blur(0)",
  y: 0,
  opacity: 1,
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
  filter: "blur(5px)",
  y: 50,
  opacity: 0,
  duration: 1,
});
tl4.to(".content-suggested .swiper-slide", {
  stagger: 0.125,
  filter: "blur(0)",
  y: 0,
  opacity: 1,
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
tl3.to(".content-releases .swiper-slide", {
  stagger: 0.125,
  y: 0,
  opacity: 1,
  duration: 1,
});


gsap.fromTo(".button", { scale: 0.8, opacity: 0, stagger: 0.2 }, { scale: 1, opacity: 1, stagger: 0.2, duration: 1 });
gsap.fromTo(".button2", { scale: 0.8, opacity: 0, stagger: 0.2 }, { scale: 1, opacity: 1, stagger: 0.2, duration: 1 });
