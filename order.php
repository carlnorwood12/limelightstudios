<?php
// Database connection
$username = "root";
$password = "test123";
$hostname = "127.0.0.1";
$database = "limelight_cinemas";

$dbhandle = mysqli_connect($hostname, $username, $password, $database);
if (!$dbhandle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the sorting criterion from the POST data
$sort = isset($_POST['sort']) ? $_POST['sort'] : '';

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
        <div class="swiper-slide" style="background-image: url('<?php echo htmlspecialchars($row['poster_url']); ?>'); background-size: cover; background-position: center center">
            <a href="https://www.google.com">
                <button class="btn">
                    <img src="ticket.svg" alt="Ticket" />
                    Book Now
                </button>
            </a>
            <?php if (!empty($row['rating_icon'])): ?>
                <div class="rating">
                    <img src="<?php echo htmlspecialchars($row['rating_icon']); ?>" alt="Rating" />
                </div>
            <?php endif; ?>
            <?php if (!empty($row['star_icon'])): ?>
                <div class="star">
                    <div class="rating-card">
                        <span class="rating-number"><?php echo htmlspecialchars($row['movie_rating']); ?></span>
                        <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($dbhandle);
}
?>
