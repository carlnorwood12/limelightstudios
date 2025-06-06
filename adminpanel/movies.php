<?php
session_start();
include '../connection.php';
global $dbhandle;

// Check if user is admin
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $age_rating = $_POST['age_rating'] ?? '';
    $poster_url = $_POST['poster_url'] ?? '';
    $hidden = $_POST['hidden'] ?? '';

    // Handle deletion
    if (isset($_POST['delete'])) {
        $stmt = mysqli_prepare($dbhandle, "DELETE FROM movies WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $hidden);
            if (mysqli_stmt_execute($stmt)) {
                $message = "Movie deleted successfully!";
            } else {
                $error = "Error deleting movie: " . mysqli_error($dbhandle);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Error preparing delete statement: " . mysqli_error($dbhandle);
        }
    }
    
    // Handle updating
    if (isset($_POST['update'])) {
        $stmt = mysqli_prepare($dbhandle, "UPDATE movies SET title = ?, duration = ?, age_rating = ?, movie_banner = ? WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $title, $duration, $age_rating, $poster_url, $hidden);
            if (mysqli_stmt_execute($stmt)) {
                $message = "Movie updated successfully!";
            } else {
                $error = "Error updating movie: " . mysqli_error($dbhandle);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Error preparing update statement: " . mysqli_error($dbhandle);
        }
    }
    
    // Handle adding new movie
    if (isset($_POST['add'])) {
        $stmt = mysqli_prepare($dbhandle, "INSERT INTO movies (title, duration, age_rating, movie_banner) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $title, $duration, $age_rating, $poster_url);
            if (mysqli_stmt_execute($stmt)) {
                $message = "Movie added successfully!";
            } else {
                $error = "Error adding movie: " . mysqli_error($dbhandle);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Error preparing insert statement: " . mysqli_error($dbhandle);
        }
    }
    
    // Redirect to prevent form resubmission
    if (isset($message) || isset($error)) {
        $_SESSION['message'] = $message ?? '';
        $_SESSION['error'] = $error ?? '';
        header("Location: movies.php");
        exit;
    }
}

// Display messages
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}

$result = mysqli_query($dbhandle, "SELECT * FROM movies ORDER BY title ASC");
if (!$result) {
    die('Error querying database: ' . mysqli_error($dbhandle));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Admin panel for Limelight Cinema management"/>
    <title>Movies | Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/tailwind_override.css"/>
    <link rel="stylesheet" href="./adminstyles.css"/>
</head>
<body>
<div class="radial-gradient"></div>

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
                        <a class="nav-link active" href="movies.php" >
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
                        <h2 class="page-title">Movies</h2>
                        <p class="text-muted mt-1">View and manage all movies.</p>
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
                                                    <input type="text" name="poster_url" value="<?php echo htmlspecialchars($row['movie_banner'] ?? ''); ?>"/>
                                                </td>
                                                <input type="hidden" name="hidden" value="<?php echo htmlspecialchars($row['id']); ?>"/>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <input type="submit" name="update" value="Update" class="btn"/>
                                                        <input type="submit" name="delete" value="Delete" class="btn" onclick="return confirm('Are you sure you want to delete this movie?')"/>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <form action="movies.php" method="post" class="d-inline">
                                    <input type="text" name="title" placeholder="Movie Title" required/>
                                    <input type="text" name="duration" placeholder="Duration" required/>
                                    <input type="text" name="age_rating" placeholder="Age Rating" required/>
                                    <input type="text" name="poster_url" placeholder="Poster URL"/>
                                    <input type="submit" name="add" value="Add Movie" class="btn"/>
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
<script src="./dist/js/tabler.min.js?1692870487" defer></script>
<script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>

<?php
// Close the connection
mysqli_close($dbhandle);
?>