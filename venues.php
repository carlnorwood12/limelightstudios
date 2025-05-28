<?php

session_start();
include 'connection.php';
global $dbhandle;

if (isset($_COOKIE['logged_in']))
{
    $username = mysqli_real_escape_string($dbhandle, $_COOKIE['logged_in']);
    $query = "SELECT * FROM users WHERE name='{$_COOKIE['logged_in']}'";
    $result = mysqli_query($dbhandle, $query);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if(!empty($user['profile_picture']))
    {
        $filePath = htmlspecialchars($user['profile_picture']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <title>Hello, world!</title>
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <meta name="description" content="" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <script src="https://cdn.tailwindcss.com"></script>
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
      <link rel="stylesheet" type="text/css" href="styles2.css" />
   </head>
   <body style="background-color: black;">
      <div class="radial-gradient"></div>
      <header>
         <a class="hamburger-icon">
         <span></span>
         <span></span>
         <span></span>
         </a>
         <img src="/svg/logo/limelight.svg" id="limelight-logo" />
      </header>
      <div class="menu-overlay">
         <div class="menu-cols">
            <div class="col-2">
               <div class="first-menu-item">
                  <div class="profile-section">
                     <div class="profile-image-container">
                        <img class="profile-image" src="upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>" alt="Profile Picture">
                     </div>
                     <div class="profile-info">
                        <h2 class="profile-name"><?=$_SESSION['name'] ?? "Please login" ?></h2>
                        <p class="profile-role"><?=$_SESSION['user_status'] ?? "To view account details" ?></p>
                        <div class="row-buttons">
                           <a href="adminpanel.php">
                           <button class="nav-buttons dashboard">
                           <img src="/svg/adminpanel/dashboard.svg" alt="dashboard" class="menu-icon">
                           Dashboard
                           </button>
                           </a>
                           <a href="settings2.php">
                           <button class="nav-buttons settings">
                           <img src="/svg/menu/profile.svg" alt="settings" class="menu-icon">
                           Profile
                           </button>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="second-menu-item">
                  <div class="search-contain">
                     <img src="/svg/menu/search.svg" id="log-in" alt="log-in">
                     <input id="search-nav" type="text" placeholder="Search anything..." spellcheck="false">
                  </div>
                  <div class="menu-link">
                     <a href="index.html">Home</a>
                  </div>
                  <div class="menu-link">
                     <a href="venues.php">Venues</a>
                  </div>
                  <div class="menu-link">
                     <a href="contact.html">Contact</a>
                  </div>
                  <div class="menu-link">
                     <a href="about.html">About</a>
                  </div>
               </div>
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
      <div class="container-venues">
         <div class="item-0">
            <h1 id="h1-venues">Discovering Venues</h1>
            <p class="paragraph-venues">Explore near by venues to find the best places to watch movies.</p>
         </div>
         <div class="item-1">
            <div class="map-container">
               <div id="map" class="map"></div>
            </div>
         </div>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
      <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="/js/scroll.js" defer></script>
      <script src="/js/script.js" defer></script>
      <script src="/js/gsap.js" defer></script>
      <script src="/js/map.js"></script>
      <script src="/js/gradient.js" async></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   </body>
</html>