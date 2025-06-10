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
/* Search functionality */
// check if the search term is set in the request
if (isset($_REQUEST["search_term"])) 
{
    // Prepared statement where title matches the search term (? means we'll bind a value later)
    $sql = "SELECT id, title FROM movies WHERE title LIKE ?";
    // Prepare the statement for execution
    $stmt = mysqli_prepare($dbhandle, $sql);
    // % allows us to match any title that starts with the search term
    $param_term = $_REQUEST["search_term"] . '%';
    // Bind the parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $param_term);
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    // Get the results
    $result = mysqli_stmt_get_result($stmt);
    // Loop through each movie found and display it
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        // Output the movie title as a paragraph with a data-id attribute were setting id to the movie's ID
        echo "<p data-id='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["title"]) . "</p>";
    }
    // Close the prepared statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($dbhandle);
    exit; // Stop from further execution
}
/* Saving movies */
// Check if the form to save a movie has been submitted
if (isset($_POST['save_movie'])) 
{
    // Get the movie information from the form and clean
    $movie_title = mysqli_real_escape_string($dbhandle, $_POST['movie_title']);
    // Get the poster URL from the form and clean
    $poster_url = mysqli_real_escape_string($dbhandle, $_POST['poster_url']);
    // Insert the movie into the saved_movies table
    $insert_saved_movie = "INSERT INTO saved_movies (title, poster_url) VALUES (?, ?)";
    // Prepare the SQL statement to prevent SQL injection
    $insert_stmt = mysqli_prepare($dbhandle, $insert_saved_movie);
    // Bind both values as strings
    mysqli_stmt_bind_param($insert_stmt, "ss", $movie_title, $poster_url);
    // Execute the insert
    mysqli_stmt_execute($insert_stmt);
    // Close the prepared statement
    mysqli_stmt_close($insert_stmt);
    // Send back JSON response indicating success
    echo json_encode(['success' => true]);
    exit; // Stop here
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Limelight Cinema | Home</title>
    <link rel="icon" type="image/png" href="favicon_limelightcinema/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="favicon_limelightcinema/favicon.svg">
    <link rel="shortcut icon" href="favicon_limelightcinema/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_limelightcinema/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/nice-select2@2.2.0/dist/js/nice-select2.min.js" defer></script>
    <link rel="stylesheet" href="./css/dropdown.css">
    <link rel="stylesheet" href="./css/index.css">
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
        <img src="/svg/logo/limelight.svg" id="limelight-logo" alt="" aria-hidden="true">
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
                        <label for="search-nav" class="sr-only">Search</label>
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
    <!-- HERO SECTION WITH MOVIE CAROUSEL -->
    <section class="content-section hero">
        <!-- Webgl animated Mouse Trail -->
        <div data-us-project="StkVPcD0Yf5lLEEatwJ9" style="position: absolute; width:100%; height: 100%"></div>
        <script type="text/javascript">
            !function () { 
                if (!window.UnicornStudio) { 
                    window.UnicornStudio = { isInitialized: !1 }; 
                    var i = document.createElement("script"); 
                    i.src = "https://cdn.jsdelivr.net/gh/hiunicornstudio/unicornstudio.js@v1.4.25/dist/unicornStudio.umd.js", 
                    i.onload = function () { 
                        window.UnicornStudio.isInitialized || (UnicornStudio.init(), window.UnicornStudio.isInitialized = !0) 
                    }, 
                    (document.head || document.body).appendChild(i) 
                } 
            }();
        </script>
        <div class="swiper hero-swiper">
            <!-- Video volume off and on -->
            <button id="mute-video" type="button">
                <img src="/svg/volume/volume-off.svg" id="volume-off" alt="">
                <img src="/svg/volume/volume-on.svg" id="volume-on" class="hidden" alt="">
            </button>
            <div class="swiper-wrapper">
                <?php 
                // Get only the first 3 movies from the database and order them by ID ascending
                $result = mysqli_query($dbhandle, "SELECT * FROM movies ORDER BY id ASC LIMIT 3"); 
                ?>
                <?php 
                // Loop through each movie and create a slide for it
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): 
                ?>
                    <div class="swiper-slide">
                        <div class="mask-wrapper">
                            <div class="dif2">
                                <!-- Background video for each movie -->
                                <video class="video-hero" playsinline autoplay muted loop>
                                    <source src="<?php echo htmlspecialchars($row['video_url']); ?>" type="video/mp4">
                                </video>
                                <!-- Fallback image for Safari -->
                                <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>" alt="">
                            </div>
                        </div>
                        <!-- Movie information -->
                        <div class="content-wrapper">
                            <h1 class="title"><?php echo htmlspecialchars($row['title']); ?></h1>
                            <!-- Movie metadata -->
                            <div class="metadata-group">
                                <div class="metadata">
                                    <img src="/svg/stars/star.svg" class="icon-star" alt="star">
                                    <span class="text"><?php echo htmlspecialchars($row['movie_rating']); ?></span>
                                </div>
                                •
                                <span class="text"><?php echo htmlspecialchars($row['duration']); ?></span>
                                •
                                <div class="metadata">
                                    <span class="text"><?php echo htmlspecialchars($row['genre_1'] . ' / ' . $row['genre_2']); ?></span>
                                </div>
                            </div>
                            <!-- Movie description -->
                            <p class="paragraph"><?php echo htmlspecialchars($row['description']); ?></p>
                            <!-- Book now, Get Started  -->
                            <div class="buttons">
                                <?php 
                                // Different buttons for different user types
                                if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): 
                                ?>
                                    <!-- If the user is a junior it will call the NotJunior method restricting access to bookings -->
                                    <button class="book-button" type="button" onclick="notJunior()">
                                        <img src="/svg/tickets/tickets.svg" alt="Book now" class="ticket-icon">
                                        Book now
                                    </button>
                                    <a href="register.php">
                                        <button class="start-button" type="submit">
                                            Get Started
                                            <img src="/svg/arrows/right.svg" alt="Get Started" class="ticket-icon">
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <!-- Otherwise allow bookings -->
                                    <!-- When you click the Book now button, it will redirect to the booking page with the movie ID and title -->
                                    <a href="booking.php?id=<?php echo urlencode($row['id']); ?>&title=<?php echo urlencode($row['title']); ?>">
                                        <button class="book-button" type="submit">
                                            <img src="/svg/tickets/tickets.svg" alt="" class="ticket-icon">
                                            Book now
                                        </button>
                                    </a>
                                    <a href="register.php">
                                        <button class="start-button" type="submit">
                                            Get Started
                                            <img src="/svg/arrows/right.svg" alt="" class="ticket-icon">
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Carousel pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Scrolling Marquee -->
    <section class="content-banner">
        <div class="marquee-container">
            <!-- Im using three copies so its infinite -->
            <div class="content-wrapper-scrolling">
                <p class="p-marquee">Interactive Games</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Easy Booking</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Exclusive Offers</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
                <p class="p-marquee">Interactive Games</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Easy Booking</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Exclusive Offers</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
                <p class="p-marquee">Interactive Games</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Easy Booking</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
                <p class="p-marquee">Exclusive Offers</p>
                <img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
        </div>
    </section>
    <!-- Now Showing -->
    <section class="content-showing">
        <div class="padding" style="padding-top: 0 !important;">
            <div class="h1-content">
                <div class="h1-background">
                    <?php 
                    // If the user is logged in and their status is Junior, show the bird emoji animation
                    if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): 
                    ?>
                        <dotlottie-player src="https://lottie.host/96618697-a731-4531-aaa4-db4c2c871578/hpqsgNi9CQ.json"
                            background="transparent" speed="1" style="width: 20px; height: 20px" loop autoplay></dotlottie-player>
                    <?php else: ?>
                        <!-- Otherwise show the flames emoji animation -->
                        <dotlottie-player src="https://lottie.host/417aacf8-1ddd-4521-b218-18431f9b66c6/KO7LQrW1nM.lottie"
                            background="transparent" speed="1" style="width: 20px; height: 20px" loop autoplay></dotlottie-player>
                    <?php endif; ?>

                    <h1 id="trendingtitle">
                        <?php
                        // We'll change the now showing to Family Friendly indicating the results shown are family friendly only
                        if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior') {
                            echo 'Family Friendly';
                        } else {
                            echo 'Now Showing';
                        }
                        ?>
                    </h1>
                </div>
            </div>
            <?php 
            // Only show the dropdown for if the user is not a Junior user
            if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Junior'): 
            ?>
                <select id="a-select">
                    <option value="movie_rating">Movie Rating</option>
                    <option value="highest_rated">Highest Rated</option>
                    <option value="release_date">Release Date</option>
                </select>
            <?php endif; ?>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php
                    // If the user is logged in and is a Junior user, show only age-appropriate films
                    if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior') {
                        // Select only allowed age ratings for Junior users
                        $result = mysqli_query($dbhandle, "SELECT * FROM movies WHERE age_rating IN ('U', 'PG', '12', '12A') ORDER BY title ASC");
                    } 
                    else 
                    {
                        // Otherwise show all of them
                        $result = mysqli_query($dbhandle, "SELECT * FROM movies ORDER BY id ASC");
                    }
                    // While these movies are fetched, we loop through each row
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): 
                    ?>
                        <div class="swiper-slide">
                            <!-- Movie poster image -->
                            <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>"
                                 alt="Movie"
                                 class="movie-image">
                            <div class="content">
                                <!-- Genre badges -->
                                <div class="genre-container-index">
                                    <div class="genre-badge" style="filter: <?php
                                    // Use switch statement to assign different colors to different genres
                                    switch ($row['genre_1']) {
                                        case 'Horror':
                                            echo 'hue-rotate(0deg);'; // Red
                                            break;
                                        case 'Action':
                                            echo 'hue-rotate(28deg);'; // Orange
                                            break;
                                        case 'Adventure':
                                            echo 'hue-rotate(56deg);'; // Golden orange
                                            break;
                                        case 'Family':
                                        case 'family':
                                            echo 'hue-rotate(84deg);'; // Yellow-green
                                            break;
                                        case 'Fantasy':
                                        case 'fantasy':
                                            echo 'hue-rotate(112deg);'; // Green
                                            break;
                                        case 'Comedy':
                                            echo 'hue-rotate(140deg);'; // Bright green
                                            break;
                                        case 'Sci-Fi':
                                            echo 'hue-rotate(168deg);'; // Teal
                                            break;
                                        case 'Mystery':
                                            echo 'hue-rotate(196deg);'; // Aqua
                                            break;
                                        case 'Thriller':
                                            echo 'hue-rotate(224deg);'; // Blue
                                            break;
                                        case 'Crime':
                                            echo 'hue-rotate(252deg);'; // Deep blue
                                            break;
                                        case 'Musical':
                                            echo 'hue-rotate(280deg);'; // Purple
                                            break;
                                        case 'Drama':
                                            echo 'hue-rotate(308deg);'; // Deep purple
                                            break;
                                        case 'Romance':
                                            echo 'hue-rotate(336deg);'; // Pink
                                            break;
                                        case 'History':
                                            echo 'hue-rotate(364deg);'; // Magenta
                                            break;
                                        default:
                                            echo 'hue-rotate(0deg);'; // Default to red
                                            break;
                                    }
                                    ?>">
                                        <?php echo htmlspecialchars($row['genre_1']); ?>
                                    </div>
                                    <!-- Second genre badge with same color logic -->
                                    <div class="genre-badge" style="filter: <?php
                                    switch ($row['genre_2']) {
                                        case 'Horror': echo 'hue-rotate(0deg);'; break;
                                        case 'Action': echo 'hue-rotate(28deg);'; break;
                                        case 'Adventure': echo 'hue-rotate(56deg);'; break;
                                        case 'Family':
                                        case 'family': echo 'hue-rotate(84deg);'; break;
                                        case 'Fantasy':
                                        case 'fantasy': echo 'hue-rotate(112deg);'; break;
                                        case 'Comedy': echo 'hue-rotate(140deg);'; break;
                                        case 'Sci-Fi': echo 'hue-rotate(168deg);'; break;
                                        case 'Mystery': echo 'hue-rotate(196deg);'; break;
                                        case 'Thriller': echo 'hue-rotate(224deg);'; break;
                                        case 'Crime': echo 'hue-rotate(252deg);'; break;
                                        case 'Musical': echo 'hue-rotate(280deg);'; break;
                                        case 'Drama': echo 'hue-rotate(308deg);'; break;
                                        case 'Romance': echo 'hue-rotate(336deg);'; break;
                                        case 'History': echo 'hue-rotate(364deg);'; break;
                                        default: echo 'hue-rotate(0deg);'; break;
                                    }
                                    ?>">
                                        <?php echo htmlspecialchars($row['genre_2']); ?>
                                    </div>
                                </div>
                                <!-- Movie title -->
                                <h2 class="title-card"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <!-- Movie details -->
                                <div class="details">
                                    <span><?php echo htmlspecialchars($row['age_rating']); ?></span>•
                                    <div class="rating-container">
                                        <img src="/svg/stars/star.svg" alt="Star rating icon" class="star">
                                        <span><?php echo htmlspecialchars($row['movie_rating']); ?></span>
                                    </div>
                                    <span>•&nbsp;&nbsp;<?php
                                    // New Datetime object
                                    $date = new DateTime($row['release_date']); 
                                    // Month, day, year format
                                    $dateformat = $date->format('F j, Y');
                                    // Output the formatted date
                                    echo htmlspecialchars($dateformat); 
                                    ?></span>
                                </div>

                                <?php 
                                // Different booking buttons for different user types
                                if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): 
                                ?>
                                    <!-- Junior users cannot book tickets -->
                                    <button class="book-button" type="button" onclick="notJunior()">
                                        <img src="/svg/tickets/tickets.svg" alt="Booking not available for junior users" class="ticket-icon">
                                        Book now
                                    </button>
                                <?php else: ?>
                                    <!-- Adult users can book tickets -->
                                    <a href="booking.php?id=<?php echo urlencode($row['id']); ?>&title=<?php echo urlencode($row['title']); ?>">
                                        <button class="book-button" type="submit">
                                            <img src="/svg/tickets/tickets.svg" alt="Book tickets for <?php echo htmlspecialchars($row['title']); ?>" class="ticket-icon">
                                            Book now
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <!-- Swiper scrollbar for navigation -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </section>
    <!-- Coming Soon -->
    <section class="content-trending">
        <div class="padding" style="padding-top: 0 !important;">
            <div class="h1-content">
                <div class="h1-background">
                    <!-- Animated icon for coming soon section -->
                    <dotlottie-player src="https://lottie.host/8af3dd86-8c49-4caf-ab2a-345499164622/QOlySXTkM5.lottie"
                        background="transparent" speed="1" style="width: 20px; height: 20px" loop autoplay></dotlottie-player>
                    <h1 id="trendingtitle">Coming Soon</h1>
                </div>
            </div>
            
            <div class="swiper ComingSoon">
                <div class="swiper-wrapper">
                    <?php
                    // Get movies_soon table and order them by release date
                    $result = mysqli_query($dbhandle, "SELECT * FROM movies_soon ORDER BY release_date ASC");
                    // Loop through each movie in the coming soon section
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): 
                    ?>
                        <div class="swiper-slide">
                            <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>" alt="" class="movie-image">
                            <div class="content">
                                <h2 class="title-card"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <div class="details">
                                    <span><?php echo htmlspecialchars($row['age_rating']); ?></span>
                                    <span>•&nbsp;&nbsp;<span class="genre-1"><?php echo htmlspecialchars($row['genre_1']); ?></span> / <span class="genre-2"><?php echo htmlspecialchars($row['genre_2']); ?></span></span>
                                    <span>•&nbsp;&nbsp;<?php 
                                    // New DateTime object for the release date
                                    $date = new DateTime($row['release_date']);
                                    // Month, day, year format
                                    echo htmlspecialchars($date->format('F j, Y')); 
                                    ?></span>
                                </div>
                                <!-- Save heart button which on click calls saveMovie function and passes the movie title and banner -->
                                <!-- addslashes() is used to escape any quotes in the movie title and banner URL -->
                                <button class="save-button" onclick="saveMovie('<?php echo addslashes(htmlspecialchars($row['title'])); ?>', '<?php echo addslashes(htmlspecialchars($row['movie_banner'])); ?>')">
                                    <img src="/svg/saveforlater.svg" alt="" class="ticket-icon">
                                    Save
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </section>
    <!-- Membership Benefits -->
    <section class="content-reasons">
        <div class="padding-reasons">
            <div class="container-reasons">
                <div class="swiper card-swiper">
                    <!-- Animated spotlight effect that empty but is styled and animated by CSS/JS -->
                    <svg class="animate-spotlight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" preserveAspectRatio="none">
                    </svg>
                    <div class="swiper-wrapper">
                        <!-- Membership benefit cards -->
                        <div class="swiper-slide card">
                            <img src="https://ik.imagekit.io/carl/limelight/unlimited_shows.webp?updatedAt=1734002913222" alt="Unlimited shows" class="hero__image" loading="lazy" />
                            <h1 class="title">Unlimited shows<span class="desktop-only">, anytime.</span></h1>
                            <p class="paragraph-join">Any movie, at anytime with a monthly membership</p>
                            <a href="register.php">
                                <button class="start-button" type="submit">
                                    Get Started
                                    <img src="/svg/arrows/right.svg" alt="Get Started" class="ticket-icon">
                                </button>
                            </a>
                        </div>
                        <div class="swiper-slide card">
                            <img src="https://ik.imagekit.io/carl/limelight/discounted_food.webp?updatedAt=1741116353856" alt="Discounted food" class="hero__image" />
                            <h1 class="title">Discounted food<span class="desktop-only">, anytime.</span></h1>
                            <p class="paragraph-join">Become a member and get 20% off food & drinks!</p>
                            <a href="register.php">
                                <button class="start-button" type="submit">
                                    Get Started
                                    <img src="/svg/arrows/right.svg" alt="Get Started" class="ticket-icon">
                                </button>
                            </a>
                        </div>
                        <div class="swiper-slide card">
                            <img src="https://ik.imagekit.io/carl/limelight/any_venue.webp?updatedAt=1738168521679" alt="Any venue" class="hero__image" />
                            <h1 class="title">Any venue<span class="desktop-only">, anywhere.</span></h1>
                            <p class="paragraph-join">Membership perks available at any of our venues.</p>
                            <a href="register.php">
                                <button class="start-button" type="submit">
                                    Get Started
                                    <img src="/svg/arrows/right.svg" alt="Get Started" class="ticket-icon">
                                </button>
                            </a>
                        </div>
                        <div class="swiper-slide card">
                            <img src="https://ik.imagekit.io/carl/limelight/exclusive_access.webp?updatedAt=1738168494867" alt="Exclusive access" class="hero__image" />
                            <h1 class="title">Exclusive access<span class="desktop-only">, always.</span></h1>
                            <p class="paragraph-join">Create personalized profiles based on your taste.</p>
                            <a href="register.php">
                                <button class="start-button" type="submit">
                                    Get Started
                                    <img src="/svg/arrows/right.svg" alt="Get Started" class="ticket-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq Section -->
    <section class="content-footer">
        <div class="padding-reasons">
            <div class="faq-container">
                <div id="faq-emoji">
                    <h1 class="title-faq">Frequently Asked <br>Questions</h1>
                </div>
                <!-- Faq items -->
                <div class="faq-item">
                    <button class="faq-question">Can junior members book tickets online?</button>
                    <div class="faq-answer">
                        <p>No, junior members cannot book tickets through our website. This is part of our safety measures for younger viewers. Tickets for junior members need to be purchased by an adult member or at the cinema box office.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">How do I register and book tickets?</button>
                    <div class="faq-answer">
                        <p>Click on the "Login / Register" button in the hamburger menu and complete the form, Once registered, you can log in to book tickets for any screening. After booking, you'll be able to download an e-ticket that can be printed or saved onto your device.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Where are the Limelight Cinemas located?</button>
                    <div class="faq-answer">
                        <p>Limelight Cinemas operates 5 venues across Midlothian: Balerno, Bonnyrigg, Corstorphine and Leith. Visit our "Venues" page to find detailed information about each venue.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">How can I download my e-ticket?</button>
                    <div class="faq-answer">
                        <p>Once you've made a booking with us and navigated to "My Bookings", you'll see a "Print" button to download your e-ticket.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br />
    <br />
    <!-- Footer from tailwind -->
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
    <script>
        // Function that was called earlier to fire an error once a junior tries to make a booking
        function notJunior() {
            Swal.fire({
                icon: "error",
                title: "Access Denied",
                text: "Junior users are not allowed to book tickets.",
            });
        }
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" async></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="/js/faq.js" defer></script>
    <script src="/js/dropdown.js" defer></script>
    <script src="/js/nice-select.js" defer></script>
    <script src="/js/swiper.js" defer></script>
    <script src="/js/video.js" defer></script>
    <script src="/js/script.js" defer></script>
    <script src="/js/gsap.js" defer></script>
    <script src="/js/scroll.js" defer></script>
    <script>
        // Initialize nice select dropdowns when page loads
        $(document).ready(function () {
            $('#a-select').niceSelect();
            $('#select-venue').niceSelect();
        });
    </script>
    <!-- Second GSAP script section - this might be causing conflicts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        // Register GSAP ScrollTrigger plugin for scroll-based animations
        gsap.registerPlugin(ScrollTrigger);
        // Animate spotlight effect when scrolling to membership section
        gsap.fromTo(".animate-spotlight",
            {
                width: "0%", // Start with zero width
            },
            {
                width: "100%", // Expand full width
                opacity: 1,
                filter: "blur(50px) grayscale(0)",
                duration: 5,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".content-reasons", // Set trigger to the membership section
                    start: "top 80%", // Start when top of trigger hits 80% down the viewport
                    end: "bottom 20%", // End when bottom of trigger hits 20% down the viewport
                    toggleActions: "play none none none", // Play on enter, no reverse
                    markers: false, // Don't show the debugging markers
                },
            }
        );
        // Fade in the card swiper
        gsap.to(".card-swiper", {
            opacity: 1,
            duration: 2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".content-reasons", // Set trigger to the membership section
                start: "top 70%", // Start when the top of the section hits 70% down the viewport
                toggleActions: "play none none none", // Play on enter, no reverse
            },
        });
    </script>
    <script>
        // Function to save movie to the database parameters: title and posterUrl
        function saveMovie(title, posterUrl) {
            // AJAX helps send data without refresh
            $.ajax({
                url: '', // Send to same page
                type: 'POST', // Use POST method
                data: {
                    save_movie: true, // Set save_movie to true 
                    movie_title: title, // Pass the movie title
                    poster_url: posterUrl // Pass the movie poster URL
                },
                dataType: 'json', // Set response type to JSON
                success: function (response) 
                {
                    // Upon success show a success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Movie added to your saved',
                        timer: 1500, 
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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