<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Admin panel for Limelight Cinema management"/>
    <title>Screenings | Admin Panel</title>
   <link rel="stylesheet" href="adult.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
<div class="radial-gradient"></div>
<?php
session_start();
include '../connection.php';
global $dbhandle;

// Check if user is admin otherwise redirect to home page
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle deletion if the delete button is pressed
    if (isset($_POST['delete'])) {
        $hidden = $_POST['hidden'] ?? '';
        $delete = "DELETE FROM screening WHERE screening_id=?";
        $stmt = mysqli_prepare($dbhandle, $delete);
        mysqli_stmt_bind_param($stmt, "i", $hidden);
        if(!mysqli_stmt_execute($stmt)){
            die('Cannot delete from database!');
        }
        mysqli_stmt_close($stmt);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    // Handle updating screening details
    if (isset($_POST['update'])) {
        $screening_date = $_POST['screening_date'] ?? '';
        $start_time = $_POST['start_time'] ?? '';
        $end_time = $_POST['end_time'] ?? '';
        $available_seats = $_POST['available_seats'] ?? '';
        $hidden = $_POST['hidden'] ?? '';
        $available_seats = intval($available_seats);
        $update = "UPDATE screening SET screening_date=?, start_time=?, end_time=?, available_seats=? WHERE screening_id=?";
        $stmt = mysqli_prepare($dbhandle, $update);
        mysqli_stmt_bind_param($stmt, "sssii", $screening_date, $start_time, $end_time, $available_seats, $hidden);
        if(!mysqli_stmt_execute($stmt)){
            die('Cannot update database!');
        }
        mysqli_stmt_close($stmt);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
if (isset($_POST['add'])) {
    $movie_id = $_POST['movie_id'] ?? '';
    $screening_date = $_POST['screening_date'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $available_seats = intval($_POST['available_seats'] ?? 0);
    // Check if movie_id exists in the movies table
    $movie_result = mysqli_query($dbhandle, "SELECT id FROM movies WHERE id = $movie_id");
    // Check if number of rows returned is greater than 0
    if (mysqli_num_rows($movie_result) > 0)
     {
        // Movie exists, so we can add the screening
        $insert_query = "INSERT INTO screening (movie_id, screening_date, start_time, end_time, available_seats) 
                         VALUES ('$movie_id', '$screening_date', '$start_time', '$end_time', $available_seats)";
        if (mysqli_query($dbhandle, $insert_query)) 
        {
            // Redirect to the same page to avoid resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            die('Cannot insert into database!');
        }
    } else {
        // say it doesnt exist
        echo "<script>alert('Movie ID does not exist. Please enter a valid Movie ID.');</script>";
    }
}
}
// Fetch all screenings from the database and join with movies to get the title
$result = mysqli_query($dbhandle, "SELECT s.*, m.title FROM screening s JOIN movies m ON s.movie_id = m.id ORDER BY s.screening_date DESC, s.start_time ASC") or die('Error querying database');
?>
<div class="page">
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-brand py-3">
                <div class="d-flex align-items-center">
                    <div class="profile-image-container">
                        <img class="profile-image" src="../upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>" alt="Profile Picture">
                    </div>
                    <div class="profile-info">
                        <h3 class="profile-name"><?=$_SESSION['name'] ?? "Please login" ?></h3>
                        <p class="profile-role">
                            <?= $_SESSION['user_status'] ?? "To view account details" ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="navbar-nav flex-row d-lg-none">
                </div>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                        <a class="nav-link" href="profile-admin.php" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                        </span>
                        <span class="nav-link-title">
                        Profile
                        </span>
                        </a>
                     </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/dashboard.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/users.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Users
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/staff.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Staff
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="movies.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/movies.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Movies
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="screenings.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/projector.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Screenings
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings-admin.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/tickets.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Bookings
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="mt-auto py-3">
                <a href="../" class="btn" style="color: gray !important">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="grey" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M5 12l6 6"></path><path d="M5 12l6 -6"></path></svg>
                    Back Home
                </a>
            </div>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Screenings</h2>
                        <p class="text-muted mt-1">View and manage all screenings.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                    <tr>
                                        <th>Screening ID</th>
                                        <th>Movie</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Available Seats</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                                        <tr>
                                            <form action="screenings.php" method="post">
                                                <td data-label="Screening ID">
                                                    <strong>#<?php echo htmlspecialchars($row['screening_id'] ?? ''); ?></strong>
                                                </td>
                                                <td data-label="Movie">
                                                    <?php echo htmlspecialchars($row['title'] ?? ''); ?>
                                                </td>
                                                <td data-label="Date">
                                                    <input type="date" name="screening_date" value="<?php echo htmlspecialchars($row['screening_date'] ?? ''); ?>" class="text-name"/>
                                                </td>
                                                <td data-label="Start Time">
                                                    <input type="time" name="start_time" value="<?php echo htmlspecialchars($row['start_time'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="End Time">
                                                    <input type="time" name="end_time" value="<?php echo htmlspecialchars($row['end_time'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="Available Seats">
                                                    <input type="number" min="0" name="available_seats" value="<?php echo htmlspecialchars($row['available_seats'] ?? ''); ?>"/>
                                                </td>
                                                <input type="hidden" name="hidden" value="<?php echo $row['screening_id']; ?>"/>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <input type="submit" name="update" value="Update" class="btn"/>
                                                        <input type="submit" name="delete" value="Delete" class="btn" onclick="return confirm('Are you sure you want to delete this screening?')"/>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <form action="screenings.php" method="post" class="d-inline">
                                    <input type="text" name="movie_id" placeholder="Movie ID" required/>
                                    <input type="date" name="screening_date" placeholder="Screening Date" required/>
                                    <input type="time" name="start_time" placeholder="Start Time" required/>
                                    <input type="time" name="end_time" placeholder="End Time" required/>
                                    <input type="number" name="available_seats" placeholder="Available Seats" min="0" required/>
                                    <input type="submit" name="add" value="Add Screening" class="btn"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
</script>
<script src="./dist/js/tabler.min.js?1692870487" defer></script>
<script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>

<?php
// Close the connection
mysqli_close($dbhandle);
?>