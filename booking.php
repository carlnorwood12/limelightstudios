<?php
session_start();
include 'connection.php';


$id = htmlspecialchars($_GET['id']);
$title = htmlspecialchars($_GET['title']);


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <title>Hello, world!</title>
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
      <script src="https://cdn.tailwindcss.com"></script>
       <link href="https://cdn.jsdelivr.net/npm/atropos@2.0.2/atropos.min.css" rel="stylesheet">
      <link rel="stylesheet" href="styles.css" />
   </head>
   <body>
      <div class="radial-gradient"></div>
      <header>
         <img src="limelight.svg" class="limelight" alt="limelight-01" />
         <a class="hamburger-icon hamburger-left">
         <img src="twinkle.svg" class="twinkle" alt="twinkle" />
         </a>
         <a class="hamburger-icon hamburger-right">
         <img src="twinkle.svg" class="twinkle" alt="twinkle" />
         </a>
      </header>
      <div class="menu-overlay">
         <div class="menu-cols">
            <div class="col-2">
               <div class="middle-logo"></div>
               <div class="menu-link">
                  <a href="index.html">Home</a>
               </div>
               <div class="menu-link">
                  <a href="products.html">Venues</a>
               </div>
               <div class="menu-link">
                  <a href="servicing.html">Contact</a>
               </div>
               <div class="menu-link">
                  <a href="servicing.html">About</a>
               </div>
               <div class="menu-link">
                  <a href="servicing.html" class="menu-item">Dashboard</a>
                  <div class="sub-menu">
                     <a href="subitem1.html"> • Profile</a>
                     <a href="subitem1.html"> • Games</a>
                     <a href="subitem2.html"> • Benefits</a>
                  </div>
               </div>
               <div class="menu-link">
                  <div class="center-menulink">
                     <img src="log-in.svg" id="log-in" alt="log-in" />
                     <a href="servicing.html">Login / Register</a>
                  </div>
               </div>
               <br />
               <input id="search-nav" type="text" placeholder="Search anything..." />
            </div>
         </div>
      </div>
      <section class="content-section hero2">
            <div class="container-them">
                <div class="atropos my-atropos">
                    <!-- scale container (required) -->
                    <div class="atropos-scale">
                        <!-- rotate container (required) -->
                        <div class="atropos-rotate">
                            <!-- inner container (required) -->
                            <div class="atropos-inner">
                                <!-- put your custom content here -->
                            </div>
                        </div>
                    </div>
                </div>
            <div class="contain-image">
            </div>
            <div class="left-text">
               <h1 class="title"><?php echo $title; ?></h1>
               <p class="paragraph-left">While scavenging the deep ends of a derelict space station, a group of young space colonists come face to face with the most terrifying life form in the universe. </p>
            </div>
            </div>
      </section>
      <section class="booking-stage">
        <div class="book">$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'No ID provided';
          <h1 class="title">Start your<span class="title-span"> ⎯ Booking</span></h1>
            <p class="paragraph-venues">Let's start off by choosing your favorite venue <span class="paragraph-venues-2">, making it easy to get to the perfect spot.</span></p>        </div>
        <div class="swiper myUniqueSwiper">
          <div class="swiper-wrapper myUniqueSwiperWrapper">
            <div class="swiper-slide myUniqueSwiperSlide">
              <div class="name myUniqueName">
                <h1 class="myUniqueNameHeading">Jake Thompson</h1>
                <p class="myUniqueRole">Owner</p>
              </div>
            </div>
            <div class="swiper-slide myUniqueSwiperSlide">
              <div class="name myUniqueName">
                <h1 class="myUniqueNameHeading">Andrew Bennett</h1>
                <p class="myUniqueRole">Marketing Specialist</p>
              </div>
            </div>
            <div class="swiper-slide myUniqueSwiperSlide">
              <div class="name myUniqueName">
                <h1 class="myUniqueNameHeading">Mike Carter</h1>
                <p class="myUniqueRole">Customer Manager</p>
              </div>
            </div>
            <div class="swiper-slide myUniqueSwiperSlide">
              <div class="name myUniqueName">
                <h1 class="myUniqueNameHeading">Angel Ramirez</h1>
                <p class="myUniqueRole">Customer Service</p>
              </div>
            </div>
          </div>
          <div class="swiper-scrollbar"></div>
        </div>
      </section>
      <br />
      <br />
      </div>
      <script src="
https://cdn.jsdelivr.net/npm/atropos@2.0.2/atropos.min.js
"></script>
      <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
      <script src="./node_modules/preline/dist/preline.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script>
         const swiper2 = new Swiper(".hero-swiper", {
           effect: "fade",
           fadeEffect: {
             crossFade: true,
           },
           grabCursor: true,
           centeredSlides: true,
           pagination: {
             el: ".swiper-pagination",
             dynamicBullets: true,
           },
         });

         var swiper = new Swiper(".card-swiper",
         {
           effect: "fade",
           grabCursor: true,
           followFinger:false,
           centeredSlides: true,
           pagination: {
             el: ".swiper-pagination",
             dynamicBullets: true,
           },
           preloadImages: false,
             lazy: {
                   loadPrevNext: true
               },
         });
         var swiper = new Swiper(".mySwiper", {
           slidesPerView: 6,
           spaceBetween: 10,
           grabCursor: true,
           breakpoints: {
             0: {
               slidesPerView: 2, // bigger than 0px do this:
             },
             200: {
               slidesPerView: 3, // bigger than 0px do this:
             },
             450: {
               slidesPerView: 4, // bigger than 450px do this:
             },
             600: {
               slidesPerView: 5, // bigger than 600px do this:
             },
             750: {
               slidesPerView: 6, // bigger than 750px do this:
             },
             900: {
               slidesPerView: 7, // bigger than 900px do this:
             },
             1050: {
               slidesPerView: 8, // bigger than 900px do this:
             },
             1200: {
               slidesPerView: 9, // bigger than 900px do this:
             },
             1350: {
               slidesPerView: 10, // bigger than 900px do this:
             },
             1500: {
               slidesPerView: 11, // bigger than 900px do this:
             },
           },
           simulateTouch: true,
           mousewheel: {
             invert: false,
             forceToAxis: true,
           },
           scrollbar: {
             el: ".swiper-scrollbar",
             draggable: true,
             hide: true,
           },
           keyboard: {
             enabled: true,
             onlyInViewport: false,
           },
         });
         var swiper = new Swiper(".yoo", {
           slidesPerView: 1,
           spaceBetween: 10,
           grabCursor: true,
           breakpoints: {
             200: {
               slidesPerView: 2, // bigger than 0px do this:
             },
             430: {
               slidesPerView: 3, // bigger than 450px do this:
             },
             660: {
               slidesPerView: 4, // bigger than 600px do this:
             },
             890: {
               slidesPerView: 5, // bigger than 600px do this:
             },
             1120: {
               slidesPerView: 6, // bigger than 600px do this:
             },
             1350: {
               slidesPerView: 7, // bigger than 600px do this:
             },
           },
           simulateTouch: true,
           mousewheel: {
             invert: false,
             forceToAxis: true,
           },
           scrollbar: {
             el: ".swiper-scrollbar",
             draggable: true,
             hide: true,
           },
           keyboard: {
             enabled: true,
             onlyInViewport: false,
           },
           pagination: {
             el: ".swiper-pagination",
             clickable: true,
           },
         });
      </script>
      <script>
        var swiper = new Swiper(".myUniqueSwiper", {
          slidesPerView: 2,
          spaceBetween: 10,
          grabCursor: true,
          simulateTouch: true,
          mousewheel: {
            invert: false,
            forceToAxis: true,
          },
          keyboard: {
            enabled: true,
            onlyInViewport: false,
          },
           scrollbar: {
             el: ".swiper-scrollbar",
             draggable: true,
             hide: true,
           },
        });
      </script>
      <script src="cursor-trail.min.js"></script>
      <script>
         cursorTrail({
           paused: false,
           pattern: "colorGlitter",
           animationType: "swing",
           theme: "dark", // dark, light
         });
      </script>
      <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
      <script>
         window.onscroll = function () {
           scrollRotate();
         };

         function scrollRotate() {
           let images = document.querySelectorAll("#twinkle1, #twinkle3");
           images.forEach(function (image) {
             image.style.transform = "rotate(" + window.pageYOffset / 2 + "deg)";
           });
         }
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.4.0/gsap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.4.0/ScrollTrigger.min.js"></script>
      <script src="scroll.js"></script>
      <script src="https://unpkg.com/split-type"></script>
      <script>
         const text = new SplitType(".title", {
           type: "chars",
         });
         gsap.from(text.chars, {
           opacity: 0,
           scale: 0.9,
           duration: 1,
         });
      </script>
      <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
      <script src="http://threejs.org/examples/js/libs/stats.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
      <script>
         $(document).mousemove(function (event) {
           var windowWidth = $(window).width();
           var windowHeight = $(window).height();
           var scrollX = $(window).scrollLeft();
           var scrollY = $(window).scrollTop();
           var mouseXpercentage = Math.round(((event.pageX - scrollX) / windowWidth) * 100);
           var mouseYpercentage = Math.round(((event.pageY - scrollY) / windowHeight) * 100);
           $(".radial-gradient").css("background", "radial-gradient(circle at " + mouseXpercentage + "% " + mouseYpercentage + "%, #14142b 10%, #0a0a15 70%)");
         });
         $("header").click(function () {
           if ($(".twinkle").hasClass("rotate")) {
             $(".twinkle").removeClass("rotate");
           } else {
             $(".twinkle").addClass("rotate");
           }
         });
         $("#mute-video").click(function () {
         // Get the currently active slide
         const activeSlide = $(".hero-swiper .swiper-slide-active video");

         // Check if the active slide's video is currently muted
         if (activeSlide.prop("muted"))
         {
            activeSlide.prop("muted", false);
         }
         else
         {
            activeSlide.prop("muted", true);
         }

         // Toggle the volume icons
         $("#volume-off").toggle();
         $("#volume-on").toggle();
      });
      </script>
      <script>
         document.querySelectorAll('.menu-item').forEach(item => {
         item.addEventListener('click', function(event) {
           event.preventDefault(); // Prevent default link behavior
           const parentMenu = this.parentElement;

           // Toggle active class
           parentMenu.classList.toggle('active');
         });
         });
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollTrigger/1.0.6/ScrollTrigger.min.js" integrity="sha512-+LXqbM6YLduaaxq6kNcjMsQgZQUTdZp7FTaArWYFt1nxyFKlQSMdIF/WQ/VgsReERwRD8w/9H9cahFx25UDd+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
      <script src="./script.js"></script>
   </body>
</html>