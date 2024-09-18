$(document).ready(function () {

  let menuTimeline = gsap.timeline({ paused: true });
  menuTimeline.to(".menu-overlay", {
    opacity: 1,
    duration: 1,
    clipPath: "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
    ease: "power2.out",
  });
  menuTimeline.from(
    ".menu-link",
    {
      opacity: 0,
      y: 60,
      stagger: 0.05,
      duration: 0.75,
      ease: "power1.inOut",
    },
    "<"
  );
  function toggleMenu() {
    if ($(".menu-overlay").css("pointer-events") === "none") {
      $(".menu-overlay").css("pointer-events", "all");
      menuTimeline.play();
    } else {
      $(".menu-overlay").css("pointer-events", "none");
      menuTimeline.reverse();
    }
  }
  $("header").click(toggleMenu);
  $(".menu-link a").click(function (event) {
    event.preventDefault();
    let targetUrl = $(this).attr("href");
    menuTimeline.reverse();
    $(".menu-overlay").css("pointer-events", "none");
    setTimeout(function () {
      window.location.href = targetUrl;
    }, menuTimeline.duration() * 1000);
  });

  $(".menu-overlay").css("pointer-events", "none");
});