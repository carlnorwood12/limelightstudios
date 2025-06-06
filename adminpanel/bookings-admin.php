<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Admin panel for Limelight Cinema management"/>
    <title>Bookings | Admin Panel</title>
   <link rel="stylesheet" href="adult.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
<div class="radial-gradient"></div>
<?php
// start the session and include the database connection and global variable
session_start();
include '../connection.php';
global $dbhandle;

// Check if user isn't logged in or is not an admin
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // retrieve form data or set default values if null to empty strings
    $user_id = $_POST['user_id'] ?? ''; 
    $screening_id = $_POST['screening_id'] ?? '';
    $seats = $_POST['seats'] ?? '';
    $adult_tickets = $_POST['adult_tickets'] ?? '';
    $child_tickets = $_POST['child_tickets'] ?? '';
    $senior_tickets = $_POST['senior_tickets'] ?? '';
    $popcorn = $_POST['popcorn'] ?? '';
    $drinks = $_POST['drinks'] ?? '';
    $booking_time = $_POST['booking_time'] ?? '';
    $hidden = $_POST['hidden'] ?? '';
    
    // Handle deletion if the delete button is pressed
    if (isset($_POST['delete'])) 
    {
        $delete = "DELETE FROM bookings WHERE id='$hidden'";
        mysqli_query($dbhandle, $delete) or die('Cannot delete from database!');
    }
    // Handle add booking if the add button is pressed
    if (isset($_POST['add'])) {
        $insert = "INSERT INTO bookings (user_id, screening_id, seats, adult_tickets, child_tickets, senior_tickets, popcorn, drinks, booking_time) VALUES ('', '', '', 0, 0, 0, 0, 0, NOW())";
        mysqli_query($dbhandle, $insert) or die('Cannot insert into database!');
    }
}
// Fetch all bookings from the database 
// SELECT b.* = get all the column in bookings with alias as 'b', get name and rename to 'user_name' to avoid conflicts
// get email address from users table (alias 'u'), etc
// from bookings with alias b
// join the tables together using left join where user_id in bookings matches id in users, same with screening alias s
// then well order by booking_time in descending order
$query = "SELECT b.id, b.user_id, b.screening_id, b.seats, b.adult_tickets, b.child_tickets, 
          b.senior_tickets, b.popcorn, b.drinks, b.booking_time,
          u.name as user_name, u.email, 
          s.screening_date, s.start_time, s.end_time, s.available_seats
          FROM bookings b 
          LEFT JOIN users u ON b.user_id = u.id 
          LEFT JOIN screening s ON b.screening_id = s.id 
          GROUP BY b.id
          ORDER BY b.booking_time DESC";
// execute the query or die with an error message
$result = mysqli_query($dbhandle, $query) or die('Error querying database');
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
                        <a class="nav-link" href="screenings.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/projector.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Screenings
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="bookings-admin.php" >
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
                        <h2 class="page-title">Bookings</h2>
                        <p class="text-muted mt-1">View and manage all bookings.</p>
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
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Screening</th>
                                        <th>Seats</th>
                                        <th>Ticket Types</th>
                                        <th>Snacks</th>
                                        <th>Booking Time</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Loop through the results and display each booking -->
                                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                                        <tr>
                                            <form action="bookings-admin.php" method="post">
                                                <td data-label="Booking ID">
                                                    <strong>#<?php echo htmlspecialchars($row['id'] ?? ''); ?></strong>
                                                </td>
                                                <td data-label="Customer">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                <?php echo htmlspecialchars($row['user_name'] ?? 'Unknown User'); ?>
                                                            </div>
                                                            <div class="text-secondary">
                                                                <?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?>
                                                            </div>
                                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id'] ?? ''); ?>"/>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Screening">
                                                    <div class="text-sm">
                                                        <!-- Display screening information with date and time -->
                                                        <?php 
                                                        $screening_info = '';
                                                        if ($row['screening_date']) {
                                                            $screening_info = date('M j, Y', strtotime($row['screening_date'])); // Format date to "Month Day, Year"
                                                        }
                                                        if ($row['start_time']) {
                                                            $screening_info .= '<br>' . date('g:i A', strtotime($row['start_time']));
                                                        }
                                                        if ($row['end_time']) {
                                                            $screening_info .= ' - ' . date('g:i A', strtotime($row['end_time']));
                                                        }
                                                        echo $screening_info ?: 'N/A'; 
                                                        ?>
                                                        <div class="text-muted small"><?php echo htmlspecialchars($row['available_seats'] ?? 'N/A'); ?> seats left</div>
                                                    </div>
                                                    <input type="hidden" name="screening_id" value="<?php echo htmlspecialchars($row['screening_id'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="Seats">
                                                    <?php echo htmlspecialchars($row['seats'] ?? ''); ?>
                                                </td>
                                                <td data-label="Ticket Types">
                                                    <div class="text-sm">
                                                        <?php
                                                        $tickets = []; // Initialize an array to hold ticket types
                                                        // if bigger than 0, initialize the array with the number of tickets and type, etc for each type
                                                        if ($row['adult_tickets'] > 0) {
                                                            $tickets[] = $row['adult_tickets'] . ' Adult';
                                                        }
                                                        if ($row['child_tickets'] > 0) {
                                                            $tickets[] = $row['child_tickets'] . ' Child';
                                                        }
                                                        if ($row['senior_tickets'] > 0) {
                                                            $tickets[] = $row['senior_tickets'] . ' Senior';
                                                        }
                                                        echo implode('<br>', $tickets) ?: 'No tickets';
                                                        ?>
                                                    </div>
                                                </td>
                                                <td data-label="Snacks">
                                                    <div class="text-sm">
                                                        <?php
                                                        $snacks = []; //same thing here if we don't do this it'll output snacks we haven't selected
                                                        if ($row['popcorn'] > 0) {
                                                            $snacks[] = $row['popcorn'] . ' Popcorn';
                                                        }
                                                        if ($row['drinks'] > 0) {
                                                            $snacks[] = $row['drinks'] . ' Drinks';
                                                        }
                                                        echo implode('<br>', $snacks) ?: 'No snacks';
                                                        ?>
                                                    </div>
                                                </td>
                                                <!-- Jun 2, 2025 12:35 AM for example for the format -->
                                                <td data-label="Booking Time">
                                                    <?php echo date('M j, Y g:i A', strtotime($row['booking_time'] ?? '')); ?>
                                                </td>
                                                <input type="hidden" name="hidden" value="<?php echo $row['id']; ?>"/>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <input type="submit" name="delete" value="Delete" class="btn" onclick="return confirm('Are you sure you want to delete this booking?')"/>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./dist/js/tabler.min.js?1692870487" defer></script>
<script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>

<?php
// Close the connection
mysqli_close($dbhandle);
?>