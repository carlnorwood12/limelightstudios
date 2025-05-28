<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="tailwind_override.css"/>
</head>
<body>
<div class="radial-gradient"></div>
<?php
session_start();
include 'connection.php';
global $dbhandle;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
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

        $update = "UPDATE users SET username='$user', password='$pass', dob='$dob', account='$account', name='$name', age=$age_value WHERE id='$hidden'";
        mysqli_query($dbhandle, $update) or die('Cannot update database!');
    }
    if (isset($_POST['add'])) {
        // Insert a new row with default values (no values specified)
        $insert = "INSERT INTO users () VALUES ()";
        mysqli_query($dbhandle, $insert) or die('Cannot insert into database!');
    }
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
            <h1 class="navbar-brand navbar-brand-autodark">
                <a href=".">
                    <img src="limelight-01.svg" width="20" alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>
            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item d-none d-lg-flex me-3">
                    <div class="btn-list">
                        <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" /></svg>
                            Source code
                        </a>
                        <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                            <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                            Sponsor
                        </a>
                    </div>
                </div>
                <div class="d-none d-lg-flex">
                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
                       data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
                       data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                    </a>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                            <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Last updates</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 1</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Change deprecated html tags to text decoration classes (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 2</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    justify-content:between ⇒ justify-content:space-between (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions show">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 3</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Update change-version.js (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 4</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Regenerate package-lock.json (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <div class="d-none d-xl-block ps-2">
                            <div>Paweł Kuna</div>
                            <div class="mt-1 small text-secondary">UI Designer</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Status</a>
                        <a href="./profile.html" class="dropdown-item">Profile</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="./settings.html" class="dropdown-item">Settings</a>
                        <a href="./sign-in.html" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                    <!-- Changed from dropdown to regular nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/dashboard.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminpanel.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/users.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Users
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminpanel.php" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/users.svg" class="icon" width="20px" />
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
                        <a class="nav-link" href="./" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/projector.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Screenings
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/tickets.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Bookings
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <img src="/svg/adminpanel/rss.svg" class="icon" width="20px" />
                            </span>
                            <span class="nav-link-title">
                                Newsletters
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <h1 class="h1-title" style="padding: 0 10px; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                                    User Management
                                </h1>
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
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
                                            <form action="adminpanel.php" method="post">
                                                <td data-label="Name">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                <input class="text-name" type="text" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>"/>
                                                            </div>
                                                            <div class="text-secondary">
                                                                <input class="text-reset" type="text" name="username" value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
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