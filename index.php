<?php

session_start();
include 'connection.php';
global $dbhandle;

if (isset($_COOKIE['logged_in'])) {
    $username = mysqli_real_escape_string($dbhandle, $_COOKIE['logged_in']);
    $query = "SELECT * FROM users WHERE name='{$_COOKIE['logged_in']}'";
    $result = mysqli_query($dbhandle, $query);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!empty($user['profile_picture'])) {
        $filePath = htmlspecialchars($user['profile_picture']);
    }
}
if (isset($_REQUEST["search_term"])) {
    $sql = "SELECT id, title FROM movies WHERE title LIKE ?";
    $stmt = mysqli_prepare($dbhandle, $sql);
    $param_term = $_REQUEST["search_term"] . '%';
    mysqli_stmt_bind_param($stmt, "s", $param_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<p data-id='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["title"]) . "</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($dbhandle);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>LimelightCinema | Home</title>
    <link rel="icon" type="image/png" href="favicon_limelightcinema/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="favicon_limelightcinema/favicon.svg">
    <link rel="shortcut icon" href="favicon_limelightcinema/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_limelightcinema/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="MyWebSite">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000">
    <meta name="description"
        content="Limelight Cinema is a movie streaming platform that offers a wide range of movies and TV shows.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Lora:wght@400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/nice-select2@2.2.0/dist/js/nice-select2.min.js" defer></script>
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
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
                            <img class="profile-image"
                                src="upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>"
                                alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h3 class="profile-name"><?= $_SESSION['name'] ?? "Please login" ?></h3>
                            <p class="profile-role"><?= $_SESSION['user_status'] ?? "To view account details" ?></p>
                            <div class="row-buttons">
                                <?php if (isset($_SESSION['user_status']) && ($_SESSION['user_status'] === 'Admin' || $_SESSION['user_status'] === 'Adult')): ?>
                                    <!-- Admin and Adult both see Dashboard button -->
                                    <a
                                        href="<?= $_SESSION['user_status'] === 'Admin' ? 'adminpanel.php' : 'dashboard.php' ?>">
                                        <button class="nav-buttons dashboard">
                                            <img src="/svg/menu/dashboard.svg" alt="dashboard" class="menu-icon">
                                            Dashboard
                                        </button>
                                    </a>

                                    <!-- Both also see Profile button -->
                                    <a href="settings2.php">
                                        <button class="nav-buttons settings">
                                            <img src="/svg/menu/profile.svg" alt="settings" class="menu-icon">
                                            Profile
                                        </button>
                                    </a>

                                <?php elseif (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                                    <!-- Junior users only see Profile button -->
                                    <a href="settings2.php">
                                        <button class="nav-buttons settings">
                                            <img src="/svg/menu/profile.svg" alt="settings" class="menu-icon">
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
                        <img src="https://ik.imagekit.io/carl/limelight/go-right.svg?updatedAt=1748539460270" id="go-right" alt="enter movie">
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
    <section class="content-section hero">
        <div class="swiper hero-swiper">
            <button id="mute-video" type="button">
                <img src="/svg/volume/volume-off.svg" id="volume-off" alt="">
                <img src="/svg/volume/volume-on.svg" id="volume-on" class="hidden" alt="">
            </button>
            <div class="swiper-wrapper">
                <?php $result = mysqli_query($dbhandle, "SELECT * FROM movies ORDER BY id ASC LIMIT 3"); ?>
                <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                    <div class="swiper-slide">
                        <div class="mask-wrapper">
                            <div class="dif2">
                                <video class="video-hero" playsinline autoplay muted loop>
                                    <source src="<?php echo htmlspecialchars($row['video_url']); ?>" type="video/mp4">
                                </video>
                                <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>" alt="">
                            </div>
                        </div>
                        <div class="content-wrapper">
                            <h1 class="title"><?php echo htmlspecialchars($row['title']); ?></h1>
                            <div class="metadata-group">
                                <div class="metadata">
                                    <img src="/svg/stars/star.svg" class="icon-star" alt="star">
                                    <span class="text"><?php echo htmlspecialchars($row['movie_rating']); ?></span>
                                </div>
                                •
                                <span class="text"><?php echo htmlspecialchars($row['duration']); ?></span>
                                •
                                <div class="metadata">
                                    <span
                                        class="text"><?php echo htmlspecialchars($row['genre_1'] . ' / ' . $row['genre_2']); ?></span>
                                </div>
                            </div>
                            <p class="paragraph"><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="buttons">
                                <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                                    <button class="book-button" type="button" onclick="notJunior()">
                                        <img src="/svg/tickets/tickets.svg" alt="" class="ticket-icon">
                                        Book now
                                    </button>
                                    <a href="register.php">
                                        <button class="start-button" type="submit">
                                            Get Started
                                            <img src="/svg/arrows/right.svg" alt="" class="ticket-icon">
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a
                                        href="booking.php?id=<?php echo urlencode($row['id']); ?>&title=<?php echo urlencode($row['title']); ?>">
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
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <section class="content-banner welcome">
        <div class="left-welcome">
            <h1 class="welcome-title">The Ultimate <br> Cinema Experience</h1>
        </div>
        <div class="right-welcome">
            <div class="right-welcome-container">
                <div class="wrapper">
                    <img src="https://media1.tenor.com/m/7Jmp-dDhutEAAAAC/scream-cinema-scene.gif" alt="">
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="content-banner">
        <div class="marquee-container">
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
    <section class="content-showing">
        <div class="padding" style="padding-top: 0 !important;">
            <div class="h1-content">
                <div class="h1-background">
                    <dotlottie-player src="https://lottie.host/417aacf8-1ddd-4521-b218-18431f9b66c6/KO7LQrW1nM.lottie"
                        background="transparent" speed="1" style="width: 20px; height: 20px" loop
                        autoplay></dotlottie-player>
                    <h1 id="trendingtitle">Now Showing</h1>
                </div>
            </div>
            <select id="a-select">
                <option value="movie_rating">Movie Rating</option>
                <option value="highest_rated">Highest Rated</option>
                <option value="release_date">Release Date</option>
            </select>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php
                    $result = mysqli_query($dbhandle, "SELECT * FROM movies");
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                        <div class="swiper-slide">
                            <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>" alt="" class="movie-image">
                            <div class="content">
                                <div class="genre-container-index">
                                    <div class="genre-badge" style="filter: <?php
                                    switch ($row['genre_1']) {
                                        case 'Horror':
                                            echo 'hue-rotate(0deg);'; // Red
                                            break;
                                        case 'Action':
                                            echo 'hue-rotate(28deg);'; // Fiery orange
                                            break;
                                        case 'Adventure':
                                            echo 'hue-rotate(56deg);'; // Golden orange
                                            break;
                                        case 'family':
                                            echo 'hue-rotate(84deg);'; // Bright yellow-green
                                            break;
                                        case 'fantasy':
                                            echo 'hue-rotate(112deg);'; // Lush green
                                            break;
                                        case 'Comedy':
                                            echo 'hue-rotate(140deg);'; // Bright green
                                            break;
                                        case 'Sci-Fi':
                                            echo 'hue-rotate(168deg);'; // Teal green
                                            break;
                                        case 'Mystery':
                                            echo 'hue-rotate(196deg);'; // Aquamarine
                                            break;
                                        case 'Thriller':
                                            echo 'hue-rotate(224deg);'; // Cyan blue
                                            break;
                                        case 'Crime':
                                            echo 'hue-rotate(252deg);'; // Deep blue
                                            break;
                                        case 'Musical':
                                            echo 'hue-rotate(280deg);'; // Rich violet-blue
                                            break;
                                        case 'Drama':
                                            echo 'hue-rotate(308deg);'; // Deep purple
                                            break;
                                        case 'Romance':
                                            echo 'hue-rotate(336deg);'; // Hot pink
                                            break;
                                        case 'History':
                                            echo 'hue-rotate(364deg);'; // Soft magenta
                                            break;
                                        default:
                                            echo 'hue-rotate(0deg);'; // Default to Horror/Red
                                            break;
                                    }
                                    ?>">
                                        <?php echo htmlspecialchars($row['genre_1']); ?>
                                    </div>
                                    <div class="genre-badge" style="filter: <?php
                                    switch ($row['genre_2']) {
                                        case 'Horror':
                                            echo 'hue-rotate(0deg);'; // Red
                                            break;
                                        case 'Action':
                                            echo 'hue-rotate(28deg);'; // Fiery orange
                                            break;
                                        case 'Adventure':
                                            echo 'hue-rotate(56deg);'; // Golden orange
                                            break;
                                        case 'family':
                                            echo 'hue-rotate(84deg);'; // Bright yellow-green
                                            break;
                                        case 'fantasy':
                                            echo 'hue-rotate(112deg);'; // Lush green
                                            break;
                                        case 'Comedy':
                                            echo 'hue-rotate(140deg);'; // Bright green
                                            break;
                                        case 'Sci-Fi':
                                            echo 'hue-rotate(168deg);'; // Teal green
                                            break;
                                        case 'Mystery':
                                            echo 'hue-rotate(196deg);'; // Aquamarine
                                            break;
                                        case 'Thriller':
                                            echo 'hue-rotate(224deg);'; // Cyan blue
                                            break;
                                        case 'Crime':
                                            echo 'hue-rotate(252deg);'; // Deep blue
                                            break;
                                        case 'Musical':
                                            echo 'hue-rotate(280deg);'; // Rich violet-blue
                                            break;
                                        case 'Drama':
                                            echo 'hue-rotate(308deg);'; // Deep purple
                                            break;
                                        case 'Romance':
                                            echo 'hue-rotate(336deg);'; // Hot pink
                                            break;
                                        case 'History':
                                            echo 'hue-rotate(364deg);'; // Soft magenta
                                            break;
                                        default:
                                            echo 'hue-rotate(0deg);'; // Default to Horror/Red
                                            break;
                                    }
                                    ?>">
                                        <?php echo htmlspecialchars($row['genre_2']); ?>
                                    </div>
                                </div>
                                <h2 class="title-card"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <div class="details">
                                    <span><?php echo htmlspecialchars($row['age_rating']); ?></span>•
                                    <div class="rating-container">
                                        <img src="/svg/stars/star.svg" alt="" class="star">
                                        <span><?php echo htmlspecialchars($row['movie_rating']); ?></span>
                                    </div>
                                    <span>•&nbsp;&nbsp;<?php $date = new DateTime($row['release_date']);
                                    $dateformat = $date->format('F j, Y');
                                    echo htmlspecialchars($dateformat); ?></span>
                                </div>
                                <?php if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                                    <button class="book-button" type="button" onclick="notJunior()">
                                        <img src="/svg/tickets/tickets.svg" alt="" class="ticket-icon">
                                        Book now
                                    </button>
                                <?php else: ?>
                                    <a
                                        href="booking.php?id=<?php echo urlencode($row['id']); ?>&title=<?php echo urlencode($row['title']); ?>">
                                        <button class="book-button" type="submit">
                                            <img src="/svg/tickets/tickets.svg" alt="" class="ticket-icon">
                                            Book now
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </section>
    <section class="content-trending">
        <div class="padding" style="padding-top: 0 !important;">
            <div class="h1-content">
                <div class="h1-background">
                    <dotlottie-player src="https://lottie.host/8af3dd86-8c49-4caf-ab2a-345499164622/QOlySXTkM5.lottie"
                        background="transparent" speed="1" style="width: 20px; height: 20px" loop
                        autoplay></dotlottie-player>
                    <h1 id="trendingtitle">Coming Soon</h1>
                </div>
            </div>
            <div class="swiper ComingSoon">
                <div class="swiper-wrapper">
                    <?php
                    $result = mysqli_query($dbhandle, "SELECT * FROM movies_soon ORDER BY release_date ASC");
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                        <div class="swiper-slide">
                            <img src="<?php echo htmlspecialchars($row['movie_banner']); ?>" alt="" class="movie-image">
                            <div class="content">
                                <h2 class="title-card"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <div class="details">
                                    <span><?php echo htmlspecialchars($row['age_rating']); ?></span>
                                    <span>•&nbsp;&nbsp;<span
                                            class="genre-1"><?php echo htmlspecialchars($row['genre_1']); ?></span> / <span
                                            class="genre-2"><?php echo htmlspecialchars($row['genre_2']); ?></span></span>
                                    <span>&nbsp;•&nbsp;<?php $date = new DateTime($row['release_date']);
                                    echo htmlspecialchars($date->format('F j, Y')); ?></span>
                                </div>
                                <button class="book-button">
                                    <img src="/svg/bell.svg" alt="" class="ticket-icon">
                                    Notify me
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </section>
    <section class="content-reasons">
        <div class="padding-reasons">
            <div class="container-reasons">
                <div class="swiper card-swiper">
                    <svg class="animate-spotlight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none"
                        preserveAspectRatio="none">
                    </svg>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide card">
                            <img src="https://ik.imagekit.io/carl/limelight/unlimited_shows.webp?updatedAt=1734002913222"
                                alt="Unlimited shows" class="hero__image" loading="lazy" />
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
                            <img src="https://ik.imagekit.io/carl/limelight/discounted_food.webp?updatedAt=1741116353856"
                                alt="Discounted food" class="hero__image" />
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
                            <img src="https://ik.imagekit.io/carl/limelight/any_venue.webp?updatedAt=1738168521679"
                                alt="Any venue" class="hero__image" />
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
                            <img src="https://ik.imagekit.io/carl/limelight/exclusive_access.webp?updatedAt=1738168494867"
                                alt="Exclusive access" class="hero__image" />
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
    <section class="content-footer">
        <div class="padding-reasons">
            <div class="faq-container">
                <div id="faq-emoji">
                    <h1 class="title-faq">Frequently Asked <br>Questions</h1>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Can junior members book tickets online?</button>
                    <div class="faq-answer">
                        <p>No, junior members cannot book tickets through our website. This is part of our safety
                            measures for younger viewers. Tickets for junior members need to be purchased by an adult
                            member or at the cinema box office.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">How do I register and book tickets?</button>
                    <div class="faq-answer">
                        <p>Click on the "Login / Register" button in the hamburger menu and complete the form, Once
                            registered, you can log in to book tickets for any screening. After booking, you'll be able
                            to download an e-ticket that can be printed or saved onto your device.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Where are the Limelight Cinemas located?</button>
                    <div class="faq-answer">
                        <p>Limelight Cinemas operates 5 venues across Midlothian: Balerno, Bonnyrigg, Corstorphine and
                            Leith. Visit our "Venues" page to find detailed information about each venue.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">How can I download my e-ticket?</button>
                    <div class="faq-answer">
                        <p>Once you've made a booking with us and navigated to "My Bookings", you'll see a "Print"
                            button to download your e-ticket.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br />
    <br />
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
                            <a href="/account" class="text-white transition"
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

    <script>
        function notJunior() {
            Swal.fire({
                icon: "error",
                title: "Access Denied",
                text: "Junior users are not allowed to book tickets.",
            });
        }
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"
        async></script>
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
$(document).ready(function() {
    $('#a-select').niceSelect();
    $('#select-venue').niceSelect();
});
</script>
    <script>
        const text = new SplitType(".title", { type: "chars" });
        gsap.from(text.chars, { opacity: 0, stagger: 0.05, y: 25, rotate: 5, duration: 1 });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        gsap.registerPlugin(ScrollTrigger);

        gsap.fromTo(".animate-spotlight",
            {
                width: "0%",
            },
            {
                width: "100%",
                opacity: 1,
                filter: "blur(50px) grayscale(0)",
                duration: 5,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".content-reasons",
                    start: "top 80%",
                    end: "bottom 20%",
                    toggleActions: "play none none reverse",
                    markers: false,
                },
            }
        );

        gsap.to(".card-swiper", {
            opacity: 1,
            duration: 2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".content-reasons",
                start: "top 70%",
                toggleActions: "play none none none",
            },
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function () {
            $('.search-contain input').on("keyup", function () {
                var val = $(this).val();
                var result = $(this).siblings(".result");
                if (val.length) {
                    $.get("", { search_term: val }).done(function (data) {
                        if (data.trim()) {
                            var firstResult = $(data).first();
                            if (firstResult.length > 0) {
                                result.html(firstResult).show();
                            } else {
                                result.hide();
                            }
                        } else {
                            result.hide();
                        }
                    });
                } else {
                    result.empty().hide();
                }
            });
            $('.result').on("click", "p", function () {
                var title = $(this).text();
                var id = $(this).data('id');
                window.location.href = "booking.php?id=" + id + "&title=" + encodeURIComponent(title);
            });
        });
    </script>

</body>

</html>