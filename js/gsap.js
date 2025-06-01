gsap.to(".contain-the-image", {
    opacity: 1,
    scale: 1,
    duration: 2,
    filter: "grayscale(0%)",
    ease: "power2.inOut"
});

gsap.from("header",
{
    opacity: 0,
    stagger: 1,
    duration: 1,
    ease: "power2.inOut"
});
gsap.to("header",
{
    opacity: 1,
    duration: 1,
    ease: "power2.inOut"
});
gsap.to(".left", {
    duration: 1,
    opacity: 1,
    clipPath: "polygon(0 0, 100% 0, 100% 100%, 0% 100%)",
    ease: "power2.inOut",
    filter: "grayscale(0%)",
});
gsap.from(".quiz-image", 
{
    duration: 2,
    opacity: 0,
    scale: 0.5,
});
