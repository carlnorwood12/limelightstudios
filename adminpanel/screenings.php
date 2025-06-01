<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Panel | Screenings</title>
   <link rel="stylesheet" href="adult.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
<div class="radial-gradient"></div>
<?php
session_start();
include '../connection.php';
global $dbhandle;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $screening_date = $_POST['screening_date'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $available_seats = $_POST['available_seats'] ?? '';
    $hidden = $_POST['hidden'] ?? '';

    // Handle deletion if the delete button is pressed
    if (isset($_POST['delete'])) {
        $delete = "DELETE FROM screening WHERE id='$hidden'";
        mysqli_query($dbhandle, $delete) or die('Cannot delete from database!');
    }
    // Handle updating screening details
    if (isset($_POST['update'])) {
        $available_seats = intval($available_seats);
        $update = "UPDATE screening SET screening_date='$screening_date', start_time='$start_time', end_time='$end_time', available_seats=$available_seats WHERE id='$hidden'";
        mysqli_query($dbhandle, $update) or die('Cannot update database!');
    }
    if (isset($_POST['add'])) {
        // Insert a new screening with default values
        $insert = "INSERT INTO screening (screening_date, start_time, end_time, available_seats) VALUES (CURDATE(), '00:00:00', '00:00:00', 0)";
        mysqli_query($dbhandle, $insert) or die('Cannot insert into database!');
    }
}

// Fetch all screenings from the database
$result = mysqli_query($dbhandle, "SELECT * FROM screening ORDER BY screening_date DESC, start_time ASC") or die('Error querying database');
?>

<div class="page">
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Updated profile section - from bookings.php -->
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
                <!-- Mobile menu controls -->
            </div>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
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
                                                    <strong>#<?php echo htmlspecialchars($row['id'] ?? ''); ?></strong>
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
                                                <input type="hidden" name="hidden" value="<?php echo $row['id']; ?>"/>
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