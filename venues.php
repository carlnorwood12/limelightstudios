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
   <head>
      <meta charset="UTF-8" />
      <title>Hello, world!</title>
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <meta name="description" content="" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <script src="https://cdn.tailwindcss.com"></script>
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
      <link rel="stylesheet" type="text/css" href="./css/venues.css" />
      <link rel="stylesheet" type="text/css" href="./css/menu.css" />
      <link rel="stylesheet" type="text/css" href="./css/footer.css" />
   </head>
   <body>
      <div class="radial-gradient"></div>
      <header>
         <a class="hamburger-icon">
         <span></span>
         <span></span>
         <span></span>
         </a>
         <img src="/svg/logo/limelight.svg" id="limelight-logo" alt="" />
      </header>
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
                                <?php if (isset($_SESSION['user_status']) && ($_SESSION['user_status'] === 'Admin' || $_SESSION['user_status'] === 'Adult')): ?>
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

                                    <!-- Both Admin and Adult users see Profile button -->
                                    <a
                                        href="<?= $_SESSION['user_status'] === 'Admin' ? '/adminpanel/profile-admin.php' : './adultpanel/profile.php' ?>">
                                        <button class="nav-buttons settings">
                                            <img src="/svg/adminpanel/profile.svg" alt="settings" class="menu-icon">
                                            Profile
                                        </button>
                                    </a>
                                <?php elseif (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                                    <!-- Junior users only see Profile button -->
                                    <a href="profile.php">
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
                    <div class="search-contain">
                        <img src="/svg/menu/search.svg" id="log-in" alt="log-in">
                        <input id="search-nav" type="text" placeholder="Search anything..." spellcheck="false">
                        <div class="result">
                            <p></p>
                        </div>
                        <img src="https://ik.imagekit.io/carl/limelight/go-right.svg?updatedAt=1748539460270"
                            id="go-right" alt="enter movie">
                    </div>
                    <div class="menu-link">
                        <a href="index.html">Home</a>
                    </div>
                    <div class="menu-link">
                        <a href="venues.php">Venues</a>
                    </div>
                    <div class="menu-link">
                        <a href="contact.php">Contact</a>
                    </div>
                    <div class="menu-link">
                        <a href="about.php">About</a>
                    </div>
                    <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                        <div class="menu-link">
                            <a href="games.php">Games</a>
                        </div>
                    <?php endif; ?>
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
      <footer>
        <div class="mx-auto max-w-screen-xl space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Links</p>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li><a href="/" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Home</a></li>
                        <li><a href="/venues.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Venues</a></li>
                        <li><a href="/contact.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Contact</a></li>
                        <li><a href="/about.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">About</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Account</p>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li><a href="/adultpanel/profile.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">My Account</a></li>
                        <li><a href="/adultpanel/bookings.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">My Bookings</a></li>
                        <li><a href="/adultpanel/saved.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">My Saved</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Entertainment</p>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li><a href="/games.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Games</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-bold" style="color: #9ca1ed;">Legal</p>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li><a href="/terms.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Terms and Conditions</a></li>
                        <li><a href="/privacy.php" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                &copy; 2025 Limelight Cinemas. All rights reserved.
            </p>
        </div>
    </footer>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
      <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="/js/scroll.js" defer></script>
      <script src="/js/script.js" defer></script>
      <script src="/js/gsap.js" defer></script>
      <script src="/js/map.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   </body>
</html>