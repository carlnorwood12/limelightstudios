<?php
// Start the session allowing us to access session variables for user information
session_start();

// Include the database connection file
include 'connection.php';
global $dbhandle; // Make sure $dbhandle is accessible globally
// Check if the user is logged in with cookies
if (isset($_COOKIE['logged_in'])) 
{
    // Ensures the username is safe to use in a SQL query
    $username = mysqli_real_escape_string($dbhandle, $_COOKIE['logged_in']);
    // Query selecting everything from the users table where the name matches the cookie
    $query = "SELECT * FROM users WHERE name='{$_COOKIE['logged_in']}'";
    // Execute the query and get the results
    $result = mysqli_query($dbhandle, $query);
    // Convert the result into an associative array
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // If the profile picture is not empty, set the file path
    if (!empty($user['profile_picture'])) 
    {
        // set $filePath to the profile picture path, ensuring it's safe for HTML output
        $filePath = htmlspecialchars($user['profile_picture']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8" />
  <title>Limelight Cinema | About</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./css/about.css" />
  <link rel="stylesheet" href="./css/menu.css" />
  <link rel="stylesheet" href="./css/footer.css" />
</head>

<body>
  <div class="radial-gradient"></div>

    <!-- Header -->
    <header>
        <a class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </a>
        <img src="/svg/logo/limelight.svg" id="limelight-logo" />
    </header>
    <!-- Header -->
    <!-- Menu Overlay -->
    <div class="menu-overlay">
        <div class="menu-cols">
            <div class="col-2">
                <div class="first-menu-item">
                    <div class="profile-section">
                        <div class="profile-image-container">
                            <img class="profile-image" 
                                 src="upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>" 
                                 alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h3 class="profile-name"><?= $_SESSION['name'] ?? "Please login" ?></h3>
                            <p class="profile-role"><?= $_SESSION['user_status'] ?? "To view account details" ?></p>
                            <div class="row-buttons">
                                <?php 
                                // If the user_status is set, show different buttons based on the user type
                                if (isset($_SESSION['user_status']) && ($_SESSION['user_status'] === 'Admin' || $_SESSION['user_status'] === 'Adult')): 
                                ?>
                                    <?php if ($_SESSION['user_status'] === 'Admin'): ?>
                                        <a href="adminpanel/dashboard.php">
                                            <button class="nav-buttons dashboard">
                                                <img src="/svg/adminpanel/dashboard.svg" alt="dashboard" class="menu-icon">
                                                Dashboard
                                            </button>
                                        </a>
                                    <?php elseif ($_SESSION['user_status'] === 'Adult'): ?>
                                        <a href="./adultpanel/bookings.php">
                                            <button class="nav-buttons dashboard">
                                                <img src="/svg/adminpanel/bookings.svg" alt="bookings" class="menu-icon">
                                                Bookings
                                            </button>
                                        </a>
                                    <?php endif; ?>
                                    <!-- Both Admin and Adult users see Profile -->
                                    <a href="<?= $_SESSION['user_status'] === 'Admin' ? './adminpanel/profile-admin.php' : './adultpanel/profile.php' ?>">
                                        <button class="nav-buttons settings">
                                            <img src="/svg/adminpanel/profile.svg" alt="settings" class="menu-icon">
                                            Profile
                                        </button>
                                    </a>
                                    <?php elseif (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                                        <!-- Junior users only can see the Profile -->
                                        <a href="./adultpanel/profile.php">
                                            <button class="nav-buttons settings">
                                                <img src="/svg/adminpanel/profile.svg" alt="settings" class="menu-icon">
                                                Profile
                                            </button>
                                        </a>
                                    <?php else: ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-menu-item">
                    <!-- Search functionality -->
                    <div class="search-contain">
                        <img src="/svg/menu/search.svg" id="log-in" alt="log-in">
                        <input id="search-nav" type="text" placeholder="Search anything..." spellcheck="false">
                        <div class="result">
                            <p></p>
                        </div>
                        <img src="https://ik.imagekit.io/carl/limelight/go-right.svg?updatedAt=1748539460270" id="go-right" alt="enter movie">
                    </div>
                    <!-- Menu links -->
                    <div class="menu-link"><a href="index.html">Home</a></div>
                    <div class="menu-link"><a href="venues.php">Venues</a></div>
                    <div class="menu-link"><a href="contact.php">Contact</a></div>
                    <div class="menu-link"><a href="about.php">About</a></div>
                    <?php 
                    // If user_status is set to 'Junior', show the Games link
                    if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): 
                    ?>
                        <div class="menu-link"><a href="games.php">Games</a></div>
                    <?php endif; ?>
                </div>
                <!-- Login / Logout Buttons -->
                <div class="third-menu-item">
                    <a href="logout.php">
                        <button class="arrow-btn exit-btn">
                            <span class="arrow-icon">
                                <img src="/svg/menu/logout.svg" alt="exit">
                                Logout
                            </span>
                        </button>
                    </a>
                    <a href="register.php">
                        <button class="arrow-btn login-btn">
                            <span class="arrow-icon">
                                Login / Register
                                <img src="/svg/menu/login.svg" alt="login">
                            </span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
  <div class="content-body">
    <section class="hero-card">
      <div class="card hero">
        <svg class="animate-spotlight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none"
          preserveAspectRatio="none"></svg>
        <img
          src="https://media.giphy.com/media/GsJO3Yy0DCvEk/giphy.gif?cid=ecf05e47bj2lagn7rfo3479w8cbrd42ku1r2rewfazf2f2ny&ep=v1_gifs_search&rid=giphy.gif&ct=g"
          alt="Spotlight visual effect" class="spotlight__hero-image" loading="lazy" />
        <h1 class="title">Our mission is <span class="desktop-only">simple.</span></h1>
        <p class="hero-paragraph">Bring the magic of movies back to our community, one screening at a time.</p>
      </div>
    </section>
    <section class="content-trending">
      <div class="h1-content">
        <h1 class="title">Our Team</h1>
        <p class="content-paragraph">We are a team of passionate movie lovers who are dedicated to bringing the magic of
          movies to our community.</p>
      </div>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="name">
              <h1>Jake</h1>
              <p>Owner</p>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="name">
              <h1>Andrew</h1>
              <p>Marketing</p>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="name">
              <h1>Mike</h1>
              <p>Manager</p>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="name">
              <h1>Angel</h1>
              <p>Manager</p>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="name">
              <h1>Sandy</h1>
              <p>Manager</p>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="name">
              <h1>Julie</h1>
              <p>Manager</p>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </section>
    <section class="content-trending first-content">
      <div class="h1-content">
        <h1 class="title">Setting the standard</h1>
      </div>
      <div class="content-wrapper">
        <div class="left"></div>
        <div class="right">
          <h1 class="subtitle">Our company</h1>
          <p>We pride ourselves on delivering exceptional cinema experiences that go beyond just watching movies. Our
            state-of-the-art facilities, premium sound systems, and comfortable seating ensure every visit is memorable.
          </p>
        </div>
      </div>
    </section>
    <section class="content-trending">
      <div class="h1-content">
        <h1 class="title">What makes us special?</h1>
      </div>
      <div class="content-wrapper">
        <div class="right">
          <h1 class="subtitle">What we do</h1>
          <p>From the latest blockbusters to independent films, we curate a diverse selection of movies that cater to
            all tastes. Our commitment to quality extends to every aspect of your cinema experience.</p>
        </div>
        <div class="left"></div>
      </div>
    </section>
    <section class="content-trending scrolling">
      <div class="h1-content">
        <h1 class="title">Our partners</h1>
        <p class="content-paragraph">From snacks to drinks, we've got you covered with the best Scotland has to offer.
        </p>
      </div>
      <div class="marquee-container">
        <div class="marquee-track">
            <div class="content-wrapper-scrolling">
              <img src="https://ik.imagekit.io/carl/limelight/irnbru.svg?updatedAt=1748431689733" alt="Irn-Bru" class="twinkle">
              <p class="p-marquee">Irn-Bru</p>
              <img src="https://ik.imagekit.io/carl/limelight/innis_and_gunn.svg?updatedAt=1748429640856" alt="Innis & Gunn logo" class="twinkle">
              <p class="p-marquee">Innis & Gunn</p>
              <img src="https://ik.imagekit.io/carl/limelight/mackies.svg?updatedAt=1748431395636" alt="Mackie's of Scotland logo" class="twinkle">
              <p class="p-marquee">Mackie's of Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/coco.svg?updatedAt=1748431764714" alt="Coco Chocolatier" class="twinkle">
              <p class="p-marquee">Coco Chocolatier</p>
              <img src="https://ik.imagekit.io/carl/limelight/visit_scotland.svg?updatedAt=1748431650543" alt="Visit Scotland" class="twinkle">
              <p class="p-marquee">Visit Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/young_scot.svg?updatedAt=1748431801230" alt="Young Scot" class="twinkle">
              <p class="p-marquee">Young Scot</p>
            </div>
            <div class="content-wrapper-scrolling">
              <img src="https://ik.imagekit.io/carl/limelight/irnbru.svg?updatedAt=1748431689733" alt="Irn-Bru" class="twinkle">
              <p class="p-marquee">Irn-Bru</p>
              <img src="https://ik.imagekit.io/carl/limelight/innis_and_gunn.svg?updatedAt=1748429640856" alt="Innis & Gunn logo" class="twinkle">
              <p class="p-marquee">Innis & Gunn</p>
              <img src="https://ik.imagekit.io/carl/limelight/mackies.svg?updatedAt=1748431395636" alt="Mackie's of Scotland logo" class="twinkle">
              <p class="p-marquee">Mackie's of Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/coco.svg?updatedAt=1748431764714" alt="Coco Chocolatier" class="twinkle">
              <p class="p-marquee">Coco Chocolatier</p>
              <img src="https://ik.imagekit.io/carl/limelight/visit_scotland.svg?updatedAt=1748431650543" alt="Visit Scotland" class="twinkle">
              <p class="p-marquee">Visit Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/young_scot.svg?updatedAt=1748431801230" alt="Young Scot" class="twinkle">
              <p class="p-marquee">Young Scot</p>
            </div>
            <div class="content-wrapper-scrolling">
              <img src="https://ik.imagekit.io/carl/limelight/irnbru.svg?updatedAt=1748431689733" alt="Irn-Bru" class="twinkle">
              <p class="p-marquee">Irn-Bru</p>
              <img src="https://ik.imagekit.io/carl/limelight/innis_and_gunn.svg?updatedAt=1748429640856" alt="Innis & Gunn logo" class="twinkle">
              <p class="p-marquee">Innis & Gunn</p>
              <img src="https://ik.imagekit.io/carl/limelight/mackies.svg?updatedAt=1748431395636" alt="Mackie's of Scotland logo" class="twinkle">
              <p class="p-marquee">Mackie's of Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/coco.svg?updatedAt=1748431764714" alt="Coco Chocolatier" class="twinkle">
              <p class="p-marquee">Coco Chocolatier</p>
              <img src="https://ik.imagekit.io/carl/limelight/visit_scotland.svg?updatedAt=1748431650543" alt="Visit Scotland" class="twinkle">
              <p class="p-marquee">Visit Scotland</p>
              <img src="https://ik.imagekit.io/carl/limelight/young_scot.svg?updatedAt=1748431801230" alt="Young Scot" class="twinkle">
              <p class="p-marquee">Young Scot</p>
            </div>
        </div>
      </div>
    </section>
  </div>

  <footer>
        <div class="mx-auto max-w-screen-xl space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Links</p>

                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="/" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="/venues.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Venues
                            </a>
                        </li>

                        <li>
                            <a href="/contact.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Contact
                            </a>
                        </li>

                        <li>
                            <a href="/about.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                About
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Account</p>

                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="/profile.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                My Account
                            </a>
                        </li>

                        <li>
                            <a href="/bookings.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                My Bookings
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Entertainment</p>

                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="/games.php" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Games
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Legal</p>

                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="/terms" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Terms and Conditions
                            </a>
                        </li>

                        <li>
                            <a href="/privacy" class="text-white transition"
                                style="opacity: 0.5; transition: opacity 0.3s ease;"
                                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                &copy; 2025 Limelight Cinemas. All rights reserved.
            </p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script src="/js/script.js" defer></script>
  <script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo(".animate-spotlight",
      {
        width: "0%",
        opacity: 0,
      },
      {
        width: "100%",
        opacity: 0.6,
        filter: "blur(50px) grayscale(0)",
        duration: 5,
        ease: "power2.out",
        scrollTrigger: {
          trigger: ".hero-card",
          start: "top 80%",
          end: "bottom 20%",
          toggleActions: "play none none reverse",
          markers: false,
        },
      }
    );

    gsap.to(".card.hero", {
      opacity: 1,
      duration: 2,
      ease: "power2.out",
      scrollTrigger: {
        trigger: ".hero-card",
        start: "top 70%",
        toggleActions: "play none none none",
      },
    });

    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 2,
      spaceBetween: 10,
      grabCursor: true,
      breakpoints: {
        200: { slidesPerView: 2, },
        400: { slidesPerView: 3, },
        600: { slidesPerView: 4, },
        800: { slidesPerView: 5, },
      },
      simulateTouch: true,
      mousewheel: { invert: false, forceToAxis: true, },
      keyboard: { enabled: true, onlyInViewport: false, },
      pagination: { el: ".swiper-pagination", clickable: true, dynamicBullets: true, },
    });
  </script>
</body>
</html>