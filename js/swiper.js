// General Swiper Initialization
const initSwiper = (selector, options) => new Swiper(selector, options);

// Hero Swiper
initSwiper(".hero-swiper", {
    effect: "fade",
    fadeEffect: { crossFade: true },
    grabCursor: true,
    centeredSlides: true,
    pagination: { el: ".swiper-pagination", dynamicBullets: true },
});
var swiper = new Swiper(".yoo", {
    slidesPerView: 2,
    spaceBetween: 20,
    grabCursor: true,
    simulateTouch: true,
    mousewheel: {
        invert: false,
        forceToAxis: true,
    },
    scrollbar: {
        el: ".swiper-scrollbar",
        hide: true,
        draggable: true,
        dragSize: 180,
    },
    keyboard: {
        enabled: true,
        onlyInViewport: false,
    },
    breakpoints: {
        500: { slidesPerView: "auto", spaceBetween: 15 },
    },
});



// Card Swiper
initSwiper(".card-swiper", {
    effect: "fade",
    fadeEffect: { crossFade: true },
    grabCursor: true,
    followFinger: false,
    centeredSlides: true,
    preloadImages: false,
    lazy: { loadPrevNext: true },
    pagination: { el: ".swiper-pagination", dynamicBullets: true },
});

// General Multi-Slide Swiper
const multiSlideOptions = {
    slidesPerView: 1,
    spaceBetween: 15,
    grabCursor: true,
    simulateTouch: true,
    mousewheel: { invert: false, forceToAxis: true },
    scrollbar: { el: ".swiper-scrollbar", draggable: true, dragSize: 180 },
    keyboard: { enabled: true, onlyInViewport: false },
    slideToClickedSlide: true,
    breakpoints: {
        500: { slidesPerView: "auto", spaceBetween: 15 },
    },
};

initSwiper(".mySwiper", multiSlideOptions);
initSwiper(".ComingSoon", multiSlideOptions);