<?php
session_start();
include '../connection.php';
global $dbhandle;

// Check if user is logged in via cookies
if (isset($_COOKIE['logged_in'])) {
    $username = mysqli_real_escape_string($dbhandle, $_COOKIE['logged_in']);
    $query = "SELECT * FROM users WHERE name='{$_COOKIE['logged_in']}'";
    $result = mysqli_query($dbhandle, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        // Set session variables if they're not already set
        if (!isset($_SESSION['name'])) {
            $_SESSION['name'] = $user['name'];
        }
        
        if (!isset($_SESSION['profile_picture']) && !empty($user['profile_picture'])) {
            $_SESSION['profile_picture'] = $user['profile_picture'];
        }
        
        if (!isset($_SESSION['user_status']) && isset($user['account'])) {
            $_SESSION['user_status'] = $user['account'];
        }
    }
}

// Check if user is admin
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}
// Fetch dashboard statistics
// Total users
$user_result = mysqli_query($dbhandle, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($user_result)['total'];

// Total bookings
$booking_result = mysqli_query($dbhandle, "SELECT COUNT(*) as total FROM bookings");
$total_bookings = mysqli_fetch_assoc($booking_result)['total'];

// Total venues (static count as you have 5 venues)
$total_venues = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Admin panel for Limelight Cinema management"/>
    <title>Dashboard | Admin Panel</title>

<link rel="icon" type="image/png" href="../favicon_limelightcinema/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/svg+xml" href="../favicon_limelightcinema/favicon.svg">
<link rel="shortcut icon" href="../favicon_limelightcinema/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="../favicon_limelightcinema/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
<link rel="stylesheet" href="../css/tailwind_override.css"/>
<link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
<div class="radial-gradient"></div>

<div class="page">
    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Profile section -->
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
                        <a class="nav-link active" href="dashboard.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/dashboard.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/users.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/staff.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Staff</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="movies.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/movies.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Movies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="screenings.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/projector.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Screenings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookings-admin.php">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/tickets.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">Bookings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    
    <!-- Page wrapper -->
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Dashboard</h2>
                        <p class="text-muted mt-1">View website analytics and overview.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    
                    <!-- Total Users -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                        <div class="card-body" style="background-color: #000911; border-radius: 20px; border: 0.5px solid #066FD1;">
                        <div class="row align-items-center">
                                    <div class="col-auto">
                                    <span class="text-white avatar" style="background-color: #066FD1;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="total-text">
                                            Total Users
                                        </div>
                                        <div class="total-users-number">
                                            <?php echo number_format($total_users); ?>
                                        </div>
                                        <div class="text-muted">
                                            Registered members
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Bookings -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body" style="background-color: #040e06; border-radius: 20px; border: 0.5px solid #31B245;">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                    <span class="text-white avatar" style="background-color: #31B245;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                                <path d="M15 5v2"/>
                                                <path d="M15 11v2"/>
                                                <path d="M15 17v2"/>
                                                <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="total-text">
                                            Total Bookings
                                        </div>
                                        <div class="total-bookings-number">
                                            <?php echo number_format($total_bookings); ?>
                                        </div>
                                        <div class="text-muted">
                                            Since Launch
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Venues -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                        <div class="card-body" style="background-color: #040e06; border-radius: 20px; border: 0.5px solid #b2ac31;">
                        <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="text-white avatar" style="background-color: #b2ac31;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                                <path d="M3 21l18 0"/>
                                                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"/>
                                                <path d="M9 9l0 .01"/>
                                                <path d="M15 9l0 .01"/>
                                                <path d="M10 12l4 0"/>
                                                <path d="M10 15l4 0"/>
                                                <path d="M10 18l4 0"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                    <div class="total-text">
                                    Total Venues
                                        </div>
                                        <div class="total-venues-number">
                                            <?php echo number_format($total_venues); ?>
                                        </div>
                                        <div class="text-muted">
                                            Cinema locations
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js" defer></script>
</body>
</html>

<?php
// Close the connection
mysqli_close($dbhandle);
?>