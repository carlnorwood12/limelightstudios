<?php
   // Start session at the very beginning before any output
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
   
   // Fetch current logged-in user information only
   $current_user = null;
   if (isset($_SESSION['name'])) {
       $username = mysqli_real_escape_string($dbhandle, $_SESSION['name']);
       $user_query = "
           SELECT 
               u.id as user_id,
               u.name,
               u.email,
               u.account as status,
               u.profile_picture,
               u.created
           FROM 
               users u
           WHERE u.name = '$username'
           LIMIT 1
       ";
       
       $user_result = mysqli_query($dbhandle, $user_query) or die('Error querying user: ' . mysqli_error($dbhandle));
       if ($user_result && mysqli_num_rows($user_result) > 0) {
           $current_user = mysqli_fetch_assoc($user_result);
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
      <link rel="stylesheet" href="tailwind_override.css"/>
      <link rel="stylesheet" href="./adminstyles.css"/>
   </head>
   <body>
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
                                <img src="/svg/dashboard.svg" class="icon" width="20px" />
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
                        <h2 class="page-title">Movies</h2>
                        <p class="text-muted mt-1">View all movies and manage them easily.</p>
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
                                       <th class="member-info-cell">Information</th>
                                       <th class="contact-cell">Contact</th>
                                       <th class="status-cell">Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($current_user): ?>
                                    <tr>
                                       <td class="member-info-cell" data-label="Information">
                                          <div class="member-details">
                                             <div class="detail-item">
                                                <span class="detail-label">Name:</span>
                                                <span class="detail-value"><?php echo htmlspecialchars($current_user['name']); ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Member ID:</span>
                                                <span class="detail-value">#<?php echo $current_user['user_id']; ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Joined:</span>
                                                <span class="detail-value"><?php echo date('M j, Y', strtotime($current_user['created'])); ?></span>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="contact-cell" data-label="Contact">
                                          <div class="contact-info">
                                             <div class="detail-item">
                                                <span class="detail-label">Email:</span>
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
      <script>
         // Force cell widths on load
         $(document).ready(function() {
             $('.profile-cell').css('width', '120px');
             $('.profile-cell').css('min-width', '120px');
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