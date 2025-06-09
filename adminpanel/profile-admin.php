<?php
// Initialize session and database connection
session_start();
include '../connection.php';
global $dbhandle;

// Restrict access to admin users only
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}
// Fetch current user's profile information from database
$current_user = null;
if (isset($_SESSION['name'])) {
    // Use prepared statement to prevent SQL injection and only fetch 1 user since thats the one logged in
    $stmt = mysqli_prepare($dbhandle, "SELECT name, email, account as status FROM users WHERE name = ? LIMIT 1");
    // was the prepared statement created successfully?
    if ($stmt) 
    {
         // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['name']);
        mysqli_stmt_execute($stmt);
        $user_result = mysqli_stmt_get_result($stmt);
        //  Check if user data was retrieved successfully   
        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $current_user = mysqli_fetch_assoc($user_result);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Admin panel for Limelight Cinema management"/>
    <title>Profile | Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
    <div class="radial-gradient"></div>
    
    <div class="page">
        <!-- Admin Navigation Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <!-- Mobile menu toggle button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- User profile display section -->
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
                
                <!-- Mobile navigation controls (collapsed by default) -->
                <div class="navbar-nav flex-row d-lg-none">
                    <!-- Mobile menu controls -->
                </div>

                <!-- Main navigation menu -->
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <!-- Profile page (current page) -->
                        <li class="nav-item">
                            <a class="nav-link active" href="profile-admin.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                            Profile
                            </span>
                            </a>
                        </li>
                        <!-- Dashboard link -->
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/dashboard.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                        <!-- Users management link -->
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/users.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Users</span>
                            </a>
                        </li>
                        <!-- Staff management link -->
                        <li class="nav-item">
                            <a class="nav-link" href="staff.php">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/staff.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Staff</span>
                            </a>
                        </li>
                        <!-- Movies management link -->
                        <li class="nav-item">
                            <a class="nav-link" href="movies.php">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/movies.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Movies</span>
                            </a>
                        </li>
                        <!-- Screenings management link -->
                        <li class="nav-item">
                            <a class="nav-link" href="screenings.php">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/projector.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Screenings</span>
                            </a>
                        </li>
                        <!-- Bookings management link -->
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
                <div class="mt-auto py-3">
                <a href="../" class="btn" style="color: gray !important">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="grey" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M5 12l6 6"></path><path d="M5 12l6 -6"></path></svg>
                    Back Home
                </a>
            </div>
            </div>
        </aside>
        
        <!-- Main content area -->
        <div class="page-wrapper">
            <!-- Page header with title and description -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">Profile</h2>
                            <p class="text-muted mt-1">View your account information</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        <div class="col-12">
                            <!-- Profile information card -->
                            <div class="card">
                                <div class="table-responsive">
                                    <!-- User details table -->
                                    <table class="table table-vcenter card-table" style="min-width: 800px;">
                                        <thead>
                                            <tr>
                                                <th class="member-info-cell">Name</th>
                                                <th class="contact-cell">Email</th>
                                                <th class="status-cell">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($current_user): ?>
                                            <!-- Display user information if logged in -->
                                            <tr>
                                                <td class="member-info-cell" data-label="Information">
                                                    <div class="member-details">
                                                        <div class="detail-item">
                                                            <span class="detail-value"><?php echo htmlspecialchars($current_user['name']); ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="contact-cell" data-label="Contact">
                                                    <div class="contact-info">
                                                        <div class="detail-item">
                                                            <span class="detail-value"><?php echo htmlspecialchars($current_user['email']); ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="status-cell" data-label="Status">
                                                    <span class="status-badge status-<?php echo strtolower($current_user['status']); ?>">
                                                        <?php echo htmlspecialchars($current_user['status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <!-- Show message if user data couldn't be loaded -->
                                            <tr>
                                                <td colspan="3" class="text-center py-4">
                                                    <p class="text-muted">Please log in to view your account information.</p>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>
<?php
// Clean up database connection
mysqli_close($dbhandle);
?>