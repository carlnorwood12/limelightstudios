<?php
// connection to the database
session_start();
include './connection.php';
global $dbhandle;

// Determine the SQL query based on the sorting criterion
$sql = "";
if ($sort === "highest_rated") {
    $sql = "SELECT * FROM movies ORDER BY movie_rating DESC";
} else if ($sort === "movie_rating") {
    $sql = "
        SELECT * FROM movies 
        ORDER BY 
            CASE age_rating
                WHEN 'PG' THEN 1
                WHEN '12' THEN 2
                WHEN '12A' THEN 3
                WHEN '15' THEN 4
                WHEN '18' THEN 5
            END ASC
    ";
} else if ($sort === "release_date") {
    $sql = "SELECT * FROM movies ORDER BY release_date DESC";
}

// Execute the query
$result = mysqli_query($dbhandle, $sql);

if ($result) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
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
                <a href="booking.php?id=<?php echo urlencode($row['id']); ?>&title=<?php echo urlencode($row['title']); ?>">
                    <button class="book-button" type="submit">
                        <img src="/svg/tickets/tickets.svg" alt="" class="ticket-icon">
                        Book now
                    </button>
                </a>
            </div>
        </div>
        <?php
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($dbhandle);
}
?>