<?php
// Start session at the very beginning before any output
session_start();
include '../connection.php';
global $dbhandle;

// Check if user is Adult or Junior (restrict access)
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] !== 'Adult' && $_SESSION['user_status'] !== 'Junior')) {
    header("Location: ../");
    exit;
}

// Fetch current logged-in user information
$current_user = null;
if (isset($_SESSION['name'])) {
    // Use prepared statement for security
    $stmt = mysqli_prepare($dbhandle, "SELECT name, email, account as status FROM users WHERE name = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['name']);
        mysqli_stmt_execute($stmt);
        $user_result = mysqli_stmt_get_result($stmt);
        
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
    <title>Adult Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/adult.css"/>
    <style>
        /* Remove navbar border */
        aside.navbar-vertical {
            border: none !important;
            border-right: none !important;
        }
        .member-profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #9ca1ed;
        }
        .member-info-cell {
            width: 250px;
        }
        .member-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .detail-item {
            display: flex;
            gap: 12px;
        }
        .detail-label {
            font-weight: 600;
            color: #718096;
            min-width: 80px;
        }
        .table td {
            vertical-align: middle;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }
        .profile-image-container {
            margin-right: 10px;
        }
        .profile-image {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-name {
            font-weight: 600;
            font-size: 15px;
            margin: 0;
            color: #fff;
        }
        .profile-role {
            font-size: 12px;
            color: #777;
            margin: 0;
        }
        .navbar-brand {
            justify-content: flex-start !important;
            align-items: flex-start !important;
            margin-left: 20px;
        }
        .col {
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="radial-gradient"></div>
    <div class="page">
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
                            <p class="profile-role"><?= $_SESSION['user_status'] ?? "To view account details" ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="navbar-nav flex-row d-lg-none">
                    <!-- Mobile menu controls -->
                </div>
                
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="profile.php" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Profile</span>
                            </a>
                        </li>
                        <?php if ($_SESSION['user_status'] !== 'Junior'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="bookings.php">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <img src="/svg/adminpanel/bookings.svg" class="icon" width="20px" />
                                    </span>
                                    <span class="nav-link-title">Bookings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="saved.php" >
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <img src="/svg/adminpanel/saveforlater.svg" class="icon" width="20px" />
                                    </span>
                                    <span class="nav-link-title">Saved</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
        
        <div class="page-wrapper">
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
            
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        <div class="col-12">
                            <div class="card">
                                <div class="table-responsive">
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
// Close the connection
mysqli_close($dbhandle);
?>