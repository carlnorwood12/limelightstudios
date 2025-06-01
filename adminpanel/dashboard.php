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
$isAdmin = (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Admin');

// Redirect if not admin
if (!$isAdmin) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $age_rating = $_POST['age_rating'] ?? '';
    $poster_url = $_POST['poster_url'] ?? '';
    $hidden = $_POST['hidden'] ?? '';

    if (isset($_POST['delete'])) {
        $delete = "DELETE FROM movies WHERE id='$hidden'";
        mysqli_query($dbhandle, $delete) or die('Cannot delete from database!');
    }

    if (isset($_POST['update'])) {
        $update = "UPDATE movies SET title='$title', duration='$duration', age_rating='$age_rating', poster_url='$poster_url' WHERE id='$hidden'";
        mysqli_query($dbhandle, $update) or die('Cannot update database!');
    }
    
    if (isset($_POST['add'])) {
        $add = "INSERT INTO movies (title, duration, age_rating, movie_banner) VALUES ('$title', '$duration', '$age_rating', '$poster_url')";
        if (mysqli_query($dbhandle, $add)) {
            $title = $duration = $age_rating = $poster_url = '';
            echo 'Data added successfully!';
        } else {
            die('Cannot add to database!');
        }
    }
}

$result = mysqli_query($dbhandle, "SELECT * FROM movies") or die('Error querying database');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Panel | Movies</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="adult.css"/>
    <link rel="stylesheet" href="../tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
                        <h2 class="page-title">Dashboard</h2>
                        <p class="text-muted mt-1">View website analytics and more.</p>
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
                                        <th>Title</th>
                                        <th>Duration</th>
                                        <th>Age Rating</th>
                                        <th>Poster URL</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
                                        <tr>
                                            <form action="movies.php" method="post">
                                                <td data-label="Title">
                                                    <input class="text-title" type="text" name="title" value="<?php echo htmlspecialchars($row['title'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="Duration">
                                                    <input type="text" name="duration" value="<?php echo htmlspecialchars($row['duration'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="Age Rating">
                                                    <input type="text" name="age_rating" value="<?php echo htmlspecialchars($row['age_rating'] ?? ''); ?>"/>
                                                </td>
                                                <td data-label="Poster URL">
                                                    <input type="text" name="poster_url" value="<?php echo htmlspecialchars($row['poster_url'] ?? ''); ?>"/>
                                                </td>
                                                <input type="hidden" name="hidden" value="<?php echo $row['id']; ?>"/>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <input type="submit" name="add" value="Add" class="btn"/>
                                                        <input type="submit" name="update" value="Update" class="btn"/>
                                                        <input type="submit" name="delete" value="Delete" class="btn"/>
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