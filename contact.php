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
<html class="dark">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
<title>Contact Us | Limelight Cinema</title>

<link rel="icon" type="image/png" href="favicon_limelightcinema/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/svg+xml" href="favicon_limelightcinema/favicon.svg">
<link rel="shortcut icon" href="favicon_limelightcinema/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="favicon_limelightcinema/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
	rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<link rel="stylesheet" type="text/css" href="./css/forms.css">
<link rel="stylesheet" type="text/css" href="./css/menu.css">
<link rel="stylesheet" type="text/css" href="./css/footer.css">
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
        <img src="/svg/logo/limelight.svg" id="limelight-logo" alt="" />
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
    <div class="form-container">
		<div class="left">
			<video class="video-form" playsinline autoplay muted>
				<source src="https://limelightcinema.b-cdn.net/donthear_video.webm" type="video/mp4">
			</video>
			<div class="bottom">
			<div class="marquee-container">
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
        </div>
			</div>
		</div>
		<div class="right">
    	<form>
    	      action="php/contact.php" 
    	      method="post">
    		<h1 id="account-h1">Contact Us</h1>
			<p id="account-p">We'd love to hear from you!</p>
            
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/user.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="name" value="<?php echo (isset($_GET['name']))? $_GET['name']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Your name</label>
			</div>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/email.svg" width="20px" aria-label="Icon"/>
				<input type="email" id="email-input" class="input" name="email" value="<?php echo (isset($_GET['email']))? $_GET['email']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="email-input" class="label">Your email</label>
				<div class="error-message"><?php echo (isset($_GET['email_error']))? $_GET['email_error']:"" ?></div>
			</div>
            <div class="input-wrapper" style="height: 120px;">
				<textarea id="message-input" class="input" name="message" placeholder=" " spellcheck="false" required style="height: 100%; padding-top: 15px; resize: none;"><?php echo (isset($_GET['message']))? $_GET['message']:"" ?></textarea>
				<label for="message-input" class="label" style="top: 15px;">Your message</label>
			</div>
            
			<button class="button-submit" type="submit">
				Send Message
				<img src="/svg/right.svg" width="20px" aria-label="Icon"></img>
			</button>
            
    		<?php if(isset($_GET['error'])){ ?>
				<div class="alert-danger" role="alert">
					<img src="/svg/warning.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['error']; ?>
				</div>
		    <?php } ?>
            
            <?php if(isset($_GET['success'])){ ?>
				<div class="alert-success" role="alert">
					<img src="/svg/success.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['success']; ?>
				</div>
		    <?php } ?>
		</form>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
	<script src="/js/script.js" defer></script>
	<script src="/js/gsap.js" defer></script>
	<script>
        // Movie search functionality
        $(function () {
            // Listen for keyboard typing in the search input
            $('.search-contain input').on("keyup", function () {
                var val = $(this).val(); // Get the value of the input
                var result = $(this).siblings(".result"); // Find sibling element with class 'result'
                // If the search value has a length 
                if (val.length) 
                { 
                    // Sends a get request to the server with the search term on the same page ("") 
                    //  
                    $.get("", { search_term: val }).done(function (data) 
                    {
                        // 
                        if (data.trim()) 
                        { 
                            // Show only the first result
                            var firstResult = $(data).first();
                            if (firstResult.length > 0) 
                            {
                                result.html(firstResult).show();
                            } 
                            else 
                            {
                                result.hide();
                            }
                        } else {
                            result.hide(); // Hide if no results
                        }
                    });
                } else {
                    result.empty().hide(); // Clear and hide if search box is empty
                }
            });
            // Handle clicking on a search result
            $('.result').on("click", "p", function () {
                var title = $(this).text(); // Get movie title
                var id = $(this).data('id'); // Get movie ID from data attribute
                // Navigate to booking page with movie information
                window.location.href = "booking.php?id=" + id + "&title=" + encodeURIComponent(title);
            });
        });
    </script>
</body>
</html>