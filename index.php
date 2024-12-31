<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <title>Hello, world!</title>
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="theme-color" content="#000">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php
include 'connection.php';
$result = mysqli_query($dbhandle, "SELECT poster_url FROM movies");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
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
            <div class="center-menulink">
               <img src="circle-user.svg" id="log-in" alt="log-in" />
               <a href="servicing.html">Login / Register</a>
            </div>
         </div>
         <br />
         <div class="search-contain">
            <img src="search.svg" id="log-in" alt="log-in" />
            <input id="search-nav" type="text" placeholder="Search anything..." spellcheck="false" />
         </div>
      </div>
   </div>
</div>
<section class="content-section hero">
   <div class="swiper hero-swiper">
      <button id="mute-video" type="button">
         <img src="volume-off.svg" id="volume-off" alt="volume-off" />
         <img src="volume.svg" id="volume-on" alt="volume" />
      </button>
      <div class="swiper-wrapper">
         <div class="swiper-slide">
            <div class="mask-wrapper">
               <div class="dif2">
                  <video playsinline autoplay="" muted loop="">
                     <source src="alien.webm" type="video/mp4" />
                  </video>
                  <img src="deadpool.webp" alt="Fallback Image">
               </div>
            </div>
            <div class="content-wrapper">
                <h1 class="title">dewdwe</h1>
                <div class="metadata-group">
                  <div class="metadata">
                     <img src="star.svg" class="icon-star" alt="star" />
                     <span class="text">7.4</span>
                  </div>
                  <div class="metadata">
                     <img src="hourglass.svg" class="icon-hourglass" alt="hourglass" />
                     <span class="text">1h 59m</span>
                  </div>
                  <div class="metadata">
                     <img src="drama.svg" class="icon-drama" alt="drama" />
                     <span class="text">Science Fiction, Horror</span>
                  </div>
               </div>
               <p class="paragraph">While scavenging the deep ends of a derelict space station, a group of young space colonizers come face to face with the most terrifying life form in the universe.</p>
               <div class="buttons">
                  <a href="servicing.html">
                     <button class="button" type="submit">
                        Book now
                     </button>
                  </a>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Start Membership
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="mask-wrapper">
               <div class="dif2">
                  <video playsinline autoplay="" muted loop="">
                     <source src="blink_twice.webm" type="video/mp4" />
                  </video>
                  <img src="deadpool.webp" alt="Fallback Image">
               </div>
            </div>
            <div class="content-wrapper">
                <h1 class="title">dewdwe</h1>
                <div class="metadata-group">
                    <div class="metadata">
                        <img src="star.svg" class="icon-star" alt="star" />
                        <span class="text">7.4</span>
                    </div>
                    <div class="metadata">
                        <img src="hourglass.svg" class="icon-hourglass" alt="hourglass" />
                        <span class="text">1h 59m</span>
                    </div>
                    <div class="metadata">
                        <img src="drama.svg" class="icon-drama" alt="drama" />
                        <span class="text">Science Fiction, Horror</span>
                    </div>
                </div>
               <p class="paragraph">When tech billionaire Slater King meets cocktail waitress Frida at his fundraising gala, he invites her to join him and his friends on a dream vacation on his private island. As strange things start to happen, Frida questions her reality.</p>
               <div class="buttons">
                  <a href="servicing.html">
                     <button class="button" type="submit">
                        Book now
                     </button>
                  </a>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Start Membership
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
            </div>
         </div>
          <div class="swiper-slide">
              <div class="mask-wrapper">
                  <div class="dif2">
                      <video playsinline autoplay="" muted loop="">
                          <source src="blink_twice.webm" type="video/mp4" />
                      </video>
                      <img src="deadpool.webp" alt="Fallback Image">
                  </div>
              </div>
              <div class="content-wrapper">
                  <h1 class="title">Blink Twice</h1>
                  <div class="metadata-group">
                      <div class="metadata">
                          <img src="star.svg" class="icon-star" alt="star" />
                          <span class="text">7.4</span>
                      </div>
                      <div class="metadata">
                          <img src="hourglass.svg" class="icon-hourglass" alt="hourglass" />
                          <span class="text">1h 59m</span>
                      </div>
                      <div class="metadata">
                          <img src="drama.svg" class="icon-drama" alt="drama" />
                          <span class="text">Science Fiction, Horror</span>
                      </div>
                  </div>
                  <p class="paragraph">When tech billionaire Slater King meets cocktail waitress Frida at his fundraising gala, he invites her to join him and his friends on a dream vacation on his private island. As strange things start to happen, Frida questions her reality.</p>
                  <div class="buttons">
                      <a href="servicing.html">
                          <button class="button" type="submit">
                              Book now
                          </button>
                      </a>
                      <a href="servicing.html">
                          <button class="button start" type="submit">
                              Start Membership
                              <img src="right.svg" width="20px" aria-label="Icon"></img>
                          </button>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>
<section class="content-trending">
   <div class="padding" style="padding-top: 0 !important;">
      <div class="h1-content">
          <div class="h1-background">
              <dotlottie-player src="https://lottie.host/d83ff914-7e42-445f-b064-1b2cac556c33/MlPCw4bGJk.lottie" background="transparent" speed="1" style="width: 20px; height: 20px" loop autoplay></dotlottie-player>
              <h1 id="trendingtitle">Playing this week</h1>
          </div>
      </div>
       <div class="swiper mySwiper">
           <div class="swiper-wrapper">
               <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                   <div class="swiper-slide" style="background-image: url('<?php echo htmlspecialchars($row['poster_url']); ?>'); background-size: cover; background-position: center center">
                       <a href="https://www.google.com">
                           <button class="btn">Book now</button>
                       </a>
                   </div>
               <?php endwhile; ?>
           </div>
           <div class="swiper-scrollbar"></div>
       </div>
   </div>
</section>
<section class="content-releases">
   <div class="padding" style="padding-top: 0 !important;">
       <div class="h1-content">
           <div class="h1-background">
               <h1 id="trendingtitle">Playing this week</h1>
           </div>
       </div>
      <div class="swiper mySwiper">
         <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url(alien_romulus.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(blinktwice.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(borderlands.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(deadpool.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(ghostlight.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(itendswithus.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(longlegs.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(thecrow.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(twisters.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(twisters.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
         </div>
         <div class="swiper-scrollbar"></div>
      </div>
   </div>
</section>
<section class="content-suggested">
   <div class="padding" style="padding-top: 0 !important;">
      <div class="h1-content">
          <div class="h1-background">
              <dotlottie-player src="https://lottie.host/920e4643-6c08-4989-b9f6-dfb96a7fd15a/2fKA75c0U5.lottie" background="transparent" speed="1" style="width: 20px; height: 20px" loop autoplay></dotlottie-player>
              <h1 id="trendingtitle">Coming soon</h1>
          </div>
      </div>
      <div class="swiper mySwiper">
         <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url(alien_romulus.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(blinktwice.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(borderlands.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(deadpool.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(ghostlight.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(itendswithus.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(longlegs.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(thecrow.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(twisters.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
            <div class="swiper-slide" style="background-image: url(twisters.webp); background-size: cover; background-position: center center">
               <a href="https://www.google.com">
                  <button class="btn">Book now</button>
               </a>
            </div>
         </div>
         <div class="swiper-scrollbar"></div>
      </div>
   </div>
</section>
<section class="content-suggested">
   <div class="padding" style="padding-top: 0 !important;">
      <div class="h1-content">
         <h1 id="trendingtitle">Browse by Category</h1>
      </div>
      <div class="swiper yoo">
         <div class="swiper-wrapper">
            <div class="swiper-slide testing">
               <img src="comedy.svg" id="horror" alt="comedy" />
               <h1 class="category-h1">Comedy</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="horror.svg" id="horror" alt="horror" />
               <h1 class="category-h1">Horror</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="novel.svg" id="horror" alt="novel" />
               <h1 class="category-h1">Romantic</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="musical.svg" id="horror" alt="musical" />
               <h1 class="category-h1">Musical</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="sci-fi.svg" id="horror" alt="sci-fi" />
               <h1 class="category-h1">Sci-Fi</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="adventures.svg" id="horror" alt="adventures" />
               <h1 class="category-h1">Adventure</h1>
            </div>
            <div class="swiper-slide testing">
               <img src="action.svg" id="horror" alt="action" />
               <h1 class="category-h1">Action</h1>
            </div>
         </div>
         <div class="swiper-scrollbar"></div>
      </div>
   </div>
</section>
<section class="hello">
   <div class="marquee-container">
      <div class="content-wrapper-scrolling">
         <p class="p-marquee">Interactive Games</p>
         <img class="twinkle" src="darktwinkle.svg" alt="BrewDog" aria-label="BrewDog">
         <p class="p-marquee">Easy Booking</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Mackie's of Scotland" aria-label="Mackie's of Scotland">
         <p class="p-marquee">Exclusive Offers</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Coco Chocolatier" aria-label="Coco Chocolatier">
      </div>
      <div class="content-wrapper-scrolling">
         <p class="p-marquee">Interactive Games</p>
         <img class="twinkle" src="darktwinkle.svg" alt="BrewDog" aria-label="BrewDog">
         <p class="p-marquee">Easy Booking</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Mackie's of Scotland" aria-label="Mackie's of Scotland">
         <p class="p-marquee">Exclusive Offers</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Coco Chocolatier" aria-label="Coco Chocolatier">
      </div>
      <div class="content-wrapper-scrolling">
         <p class="p-marquee">Interactive Games</p>
         <img class="twinkle" src="darktwinkle.svg" alt="BrewDog" aria-label="BrewDog">
         <p class="p-marquee">Easy Booking</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Mackie's of Scotland" aria-label="Mackie's of Scotland">
         <p class="p-marquee">Exclusive Offers</p>
         <img class="twinkle" src="darktwinkle.svg" alt="Coco Chocolatier" aria-label="Coco Chocolatier">
      </div>
   </div>
</section>
<section class="content-reasons">
   <div class="padding" style="padding-top: 0 !important;">
      <div class="container-reasons">
         <div class="swiper card-swiper">
            <div class="swiper-wrapper">
               <div class="swiper-slide card">
                  <img src="https://ik.imagekit.io/carl/limelight/unlimited_shows.webp?updatedAt=1734002913222" alt=" " class="hero__image" loading="lazy" />
                  <div class="swiper-lazy-preloader"></div>
                  <h1 class="title">Unlimited shows<span class="desktop-only">, anytime.</span></h1>
                  <p class="paragraph-join">Any movie, at anytime with a monthly membership</p>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Get Started
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
               <div class="swiper-slide card">
                  <img src="discounted_food.webp" alt="Sample Image" class="hero__image" loading="lazy" />
                  <div class="swiper-lazy-preloader"></div>
                  <h1 class="title">Discounted food<span class="desktop-only">, anytime.</span></h1>
                  <p class="paragraph-join">Become a member and get 20% off food & drinks!</p>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Get Started
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
               <div class="swiper-slide card">
                  <img src="any_venue.webp" alt="Sample Image" class="hero__image" loading="lazy" />
                  <h1 class="title">Any venue<span class="desktop-only">, anywhere.</span></h1>
                  <p class="paragraph-join">Membership perks available at any of our venues.</p>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Get Started
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
               <div class="swiper-slide card">
                  <img src="exclusive_access.webp" alt="Sample Image" class="hero__image" loading="lazy" />
                  <div class="swiper-lazy-preloader"></div>
                  <h1 class="title">Exclusive access<span class="desktop-only">, always.</span></h1>
                  <p class="paragraph-join">Create personalized profiles based on your taste.</p>
                  <a href="servicing.html">
                     <button class="button start" type="submit">
                        Get Started
                        <img src="right.svg" width="20px" aria-label="Icon"></img>
                     </button>
                  </a>
               </div>
            </div>
            <div class="swiper-pagination"></div>
         </div>
      </div>
   </div>
</section>
</section>
<section class="content-suggested">
   <!-- FAQ -->
   <div class="max-w-[85rem] px-4 pt-0 sm:px-6 lg:px-8 lg:py-10 mx-auto" style="padding-top: 0 !important;">
      <!-- FAQ -->
      <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
         <!-- Title -->
         <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h1 class="title">Answering<span class="desktop-only"> ⎯ Questions</span></h1>
            <p class="paragraph-join">Answers to the most frequently asked questions.</p>
         </div>
         <!-- End Title -->
         <div class="max-w-2xl mx-auto">
            <!-- Accordion -->
            <div class="hs-accordion-group">
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10 active" id="hs-basic-with-title-and-arrow-stretched-heading-one">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="true" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-one">
                     Can I cancel at anytime?
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-one" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-one">
                     <p class="text-gray-800 dark:text-neutral-200">
                        Yes, you can cancel anytime no questions are asked while you cancel but we would highly appreciate if you will give us some feedback.
                     </p>
                  </div>
               </div>
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10" id="hs-basic-with-title-and-arrow-stretched-heading-two">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                     My team has credits. How do we use them?
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-two" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                     <p class="text-gray-800 dark:text-neutral-200">
                        Once your team signs up for a subscription plan. This is where we sit down, grab a cup of coffee and dial in the details.
                     </p>
                  </div>
               </div>
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">
                     How does Preline's pricing work?
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-three" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                     <p class="text-gray-800 dark:text-neutral-200">
                        Our subscriptions are tiered. Understanding the task at hand and ironing out the wrinkles is key.
                     </p>
                  </div>
               </div>
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10" id="hs-basic-with-title-and-arrow-stretched-heading-four">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-four">
                     How secure is Preline?
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-four" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-four">
                     <p class="text-gray-800 dark:text-neutral-200">
                        Protecting the data you trust to Preline is our first priority. This part is really crucial in keeping the project in line to completion.
                     </p>
                  </div>
               </div>
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10" id="hs-basic-with-title-and-arrow-stretched-heading-five">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-five">
                     How do I get access to a theme I purchased?
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-five" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-five">
                     <p class="text-gray-800 dark:text-neutral-200">
                        If you lose the link for a theme you purchased, don't panic! We've got you covered. You can login to your account, tap your avatar in the upper right corner, and tap Purchases. If you didn't create a login or can't remember the information, you can use our handy Redownload page, just remember to use the same email you originally made your purchases with.
                     </p>
                  </div>
               </div>
               <div class="hs-accordion hs-accordion-active:bg-gray-100 rounded-xl p-6 dark:hs-accordion-active:bg-white/10" id="hs-basic-with-title-and-arrow-stretched-heading-six">
                  <button class="hs-accordion-toggle group pb-3 inline-flex items-center justify-between gap-x-3 w-full md:text-lg font-semibold text-start text-gray-800 rounded-lg transition hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400" aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-six">
                     Upgrade License Type
                     <svg class="hs-accordion-active:hidden block shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                     </svg>
                     <svg class="hs-accordion-active:block hidden shrink-0 size-5 text-gray-600 group-hover:text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                     </svg>
                  </button>
                  <div id="hs-basic-with-title-and-arrow-stretched-collapse-six" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-six">
                     <p class="text-gray-800 dark:text-neutral-200">
                        There may be times when you need to upgrade your license from the original type you purchased and we have a solution that ensures you can apply your original purchase cost to the new license purchase.
                     </p>
                  </div>
               </div>
            </div>
            <!-- End Accordion -->
         </div>
      </div>
      <!-- End FAQ -->
   </div>
   <!-- End FAQ -->
   <!-- End FAQ -->
</section>
<br />
<br />
</div>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script src="https://unpkg.com/split-type"></script>
<script>
    const text = new SplitType(".title", {
        type: "chars",
    });
    gsap.from(text.chars, {
        opacity: 0,
        stagger: 0.05,
        y: 25,
        duration: 1,
    });
</script>
<script src="./node_modules/preline/dist/preline.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
   var swiper = new Swiper(".hero-swiper", {
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
              fadeEffect: {
                 crossFade: true,
              },
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
   var swiper = new Swiper(".mySwiper",
           {
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
                 hide: true,
                 draggable: true,

                 dragSize: 180,
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
         450: {
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
         hide: true,
         draggable: true,
         dragSize: 180,
      },
      keyboard: {
         enabled: true,
         onlyInViewport: false,
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
      $(".radial-gradient").css("background", "radial-gradient(circle at " + mouseXpercentage + "% " + mouseYpercentage + "%, #14142B 0%, #14142B 2%, #14142A 4%, #13132A 6%, #131329 8%, #131328 9%, #121228 11%, #121227 13%, #121226 14%, #111125 16%, #111123 18%, #101022 20%, #0F0F21 22%, #0F0F20 24%, #0E0E1E 27%, #0E0E1D 30%, #0D0D1C 33%, #0D0D1B 36%, #0C0C19 40%, #0B0B18 44%, #0B0B17 48%, #0B0B16 53%, #0A0A16 59%, #0A0A15 64%, #0A0A15 71%)");
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./gsap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollTrigger/1.0.6/ScrollTrigger.min.js" integrity="sha512-+LXqbM6YLduaaxq6kNcjMsQgZQUTdZp7FTaArWYFt1nxyFKlQSMdIF/WQ/VgsReERwRD8w/9H9cahFx25UDd+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="./script.js"></script>
</body>
</html>