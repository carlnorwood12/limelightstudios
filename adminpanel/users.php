<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Users | Admin Panel</title>

<link rel="icon" type="image/png" href="../favicon_limelightcinema/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/svg+xml" href="../favicon_limelightcinema/favicon.svg">
<link rel="shortcut icon" href="../favicon_limelightcinema/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="../favicon_limelightcinema/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $user = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $age = $_POST['age'] ?? '';
    $hidden = $_POST['hidden'] ?? '';

    // Handle deletion if the delete button is pressed
    if (isset($_POST['delete'])) {
        $delete = "DELETE FROM users WHERE id='$hidden'";
        mysqli_query($dbhandle, $delete) or die('Cannot delete from database!');
    }
    // Handle updating user details
    if (isset($_POST['update'])) {
        $account = $_SESSION['user_status'] ?? '';

        if ($age === '' || !is_numeric($age)) {
            $age_value = "NULL";
        } else {
            $age_value = intval($age);
        }
        $update = "UPDATE users SET email='$user', password='$pass', email='$email', dob='$dob', account='$account', name='$name', age=$age_value WHERE id='$hidden'";
        mysqli_query($dbhandle, $update) or die('Cannot update database!');
    }
    if (isset($_POST['add'])) {
        // Insert a new row with default values (no values specified)
        $insert = "INSERT INTO users () VALUES ()";
        mysqli_query($dbhandle, $insert) or die('Cannot insert into database!');
    }
}
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Admin') {
    header("Location: ../");
    exit;
}

// Fetch all users from the database
$result = mysqli_query($dbhandle, "SELECT * FROM users") or die('Error querying database');
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
                        <h2 class="page-title">Users</h2>
                        <p class="text-muted mt-1">View and manage all users members.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card"><div class="table-responsive">
    <table class="table table-vcenter table-mobile-md card-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Account</th>
            <th>Age</th>
            <th>Birthday</th>
            <th class="w-1"></th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
            <tr>
                <form action="users.php" method="post">
                    <td data-label="Name">
                        <div class="d-flex py-1 align-items-center">
                            <div class="flex-fill">
                                <input class="text-name" type="text" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>"/>
                            </div>
                        </div>
                    </td>
                    <td data-label="Email">
                        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>"/>
                    </td>
                    <td data-label="Password">
                        <input type="text" name="password" value="<?php echo htmlspecialchars($row['password'] ?? ''); ?>"/>
                    </td>
                    <td data-label="Account">
                        <input type="text" name="account" value="<?php echo htmlspecialchars($row['account'] ?? ''); ?>"/>
                    </td>
                    <td data-label="Age">
                        <input type="text" name="age" value="<?php echo htmlspecialchars($row['age'] ?? ''); ?>"/>
                    </td>
                    <td data-label="Birthday">
                        <input type="text" name="dob" value="<?php echo htmlspecialchars($row['dob'] ?? ''); ?>"/>
                    </td>
                    <input type="hidden" name="hidden" value="<?php echo $row['id']; ?>"/>
                    <td>
                        <div class="btn-list flex-nowrap">
                            <input type="submit" name="update" value="Update" class="btn btn-primary"/>
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