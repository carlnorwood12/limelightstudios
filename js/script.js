$(document).ready(function () {
  console.log("Document is ready");
  let menuTimeline = gsap.timeline({ paused: true });
  console.log("Menu timeline initialized");

  menuTimeline.to(".menu-overlay", {
    duration: 0.15,
    clipPath: "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
    width: "300px",
  });
  menuTimeline.from(
      ".menu-overlay",
      {
        opacity: 0,
        x: -50,
        stagger: 0.05,
        duration: 0.75,
        ease: "power1.out",
      },
      "<0.2"
  );

  function toggleMenu() {
    if ($(".menu-overlay").css("pointer-events") === "none") {
      $(".menu-overlay").css("pointer-events", "all");
      menuTimeline.play();
      $(".twinkle").addClass("rotate");
    } else {
      $(".menu-overlay").css("pointer-events", "none");
      menuTimeline.reverse();
      $(".twinkle").removeClass("rotate");
    }
    $(".hamburger-icon").toggleClass("active");

  }
  $(".hamburger-icon").click(toggleMenu);
  $(".menu-overlay a").click(function (event) {
    console.log("Menu link clicked: " + $(this).attr("href"))
    event.preventDefault();
    let targetUrl = $(this).attr("href");
    menuTimeline.reverse();
    $(".menu-overlay").css("pointer-events", "none");
    $(".hamburger-icon").removeClass("active");
    setTimeout(function () {
      window.location.href = targetUrl;
    }, menuTimeline.duration() * 1000);
  });

  $(".menu-overlay").css("pointer-events", "none");
});
