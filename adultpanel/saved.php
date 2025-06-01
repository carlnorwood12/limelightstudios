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

   // Handle movie deletion
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_movie'])) {
      $movie_id = $_POST['movie_id'] ?? 0;
      if ($movie_id > 0) {
         $delete_query = "DELETE FROM saved_movies WHERE id = '$movie_id'";
         if (mysqli_query($dbhandle, $delete_query)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
            exit;
         }
      }
   }
   
   // Fetch saved movies
   $saved_movies_query = "
       SELECT 
           id,
           title,
           poster_url,
           saved_at
       FROM 
           saved_movies
       ORDER BY saved_at DESC
   ";
   
   $saved_movies_result = mysqli_query($dbhandle, $saved_movies_query) or die('Error querying saved movies: ' . mysqli_error($dbhandle));
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Saved Movies</title>
      <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
      <link rel="stylesheet" href="../adult.css"/>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <style>
         aside.navbar-vertical {
         border: none !important;
         border-right: none !important;
         }

         .navbar-vertical.navbar-expand-lg {
         border-right: none !important;
         }

         .table-responsive {
         overflow-x: auto;
         }

         .table {
         min-width: 1200px !important;
         table-layout: fixed !important;
         }

         .table th.poster-cell,
         .table td.poster-cell,
         th.poster-cell,
         td.poster-cell {
         width: 200px !important;
         min-width: 200px !important;
         text-align: center;
         padding: 15px;
         }

         .movie-details-cell {
         width: 400px;
         min-width: 400px;
         }

         .saved-info-cell {
         width: 250px;
         min-width: 250px;
         }

         .actions-cell {
         width: 180px;
         min-width: 180px;
         }

         .poster-thumbnail {
         width: 200px;
         border-radius: 8px;
         transition: transform 0.3s ease;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
         display: inline-block;
         }

         .movie-title {
         margin-bottom: 15px;
         font-weight: 700;
         font-size: 1.1rem;
         color: white;
         opacity: 0.75;
         }

         .movie-details {
         display: flex;
         flex-direction: column;
         gap: 0.5rem;
         }

         .detail-item {
         display: flex;
         gap: 12px;
         }

         .detail-label {
         font-weight: 500;
         color: #718096;
         min-width: 80px;
         }

         .detail-value {
         font-weight: 600;
         }

         .saved-info {
         display: flex;
         flex-direction: column;
         gap: 0.5rem;
         }

         .delete-btn {
         position: relative;
         background-color: #150406 !important;
         color: #cf2b39 !important;
         transition: all 0.2s ease !important;
         overflow: hidden !important;
         border: none !important;
         padding: 0.5rem 1rem;
         border-radius: 4px;
         cursor: pointer;
         font-weight: 500;
         max-width: 100px;
         min-width: 100px;
         }

         .table td {
         vertical-align: middle;
         }

         .action-buttons {
         display: flex;
         flex-direction: column;
         gap: 8px;
         justify-content: flex-start;
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

         .saved-date {
            color: #9ca1ed;
            font-size: 0.9rem;
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
                  <div class="navbar-nav flex-row d-lg-none"></div>
                  <div class="collapse navbar-collapse" id="sidebar-menu">
                     <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                           <a class="nav-link" href="profile.php" >
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                           </span>
                           <span class="nav-link-title">
                           Profile
                           </span>
                           </a>
                        </li>
                        <?php if ($_SESSION['user_status'] !== 'Junior'): ?>
                           <li class="nav-item">
                              <a class="nav-link" href="bookings.php">
                                 <span class="nav-link-icon d-md-none d-lg-inline-block">
                                       <img src="/svg/adminpanel/bookings.svg" class="icon" width="20px" />
                                 </span>
                                 <span class="nav-link-title">
                                       Bookings
                                 </span>
                              </a>
                           </li>
                        <?php endif; ?>
                        <li class="nav-item">
                           <a class="nav-link active" href="saved.php" >
                           <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <img src="/svg/adminpanel/saveforlater.svg" class="icon" width="20px" />
                           </span>
                           <span class="nav-link-title">
                           Saved
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
                        <h2 class="page-title">Saved Movies</h2>
                        <p class="text-muted mt-1">Your personal watchlist of saved movies.</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="page-body">
               <div class="container-xl">
                  <div class="row row-cards">
                     <div class="col-12">
                        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
                           <div class="alert alert-success alert-dismissible" role="alert">
                              <div>Movie was successfully removed from your watchlist.</div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                           </div>
                        <?php endif; ?>
                        <div class="card">
                           <div class="table-responsive">
                              <table class="table table-vcenter card-table" style="min-width: 1200px;">
                                 <thead>
                                    <tr>
                                       <th style="width: 200px !important; min-width: 200px !important;"
                                          class="poster-cell">Movie Poster</th>
                                       <th class="movie-details-cell">Movie Details</th>
                                       <th class="saved-info-cell">Saved Information</th>
                                       <th class="actions-cell">Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($saved_movies_result && mysqli_num_rows($saved_movies_result) > 0): ?>
                                       <?php while ($movie = mysqli_fetch_assoc($saved_movies_result)): ?>
                                       <tr>
                                          <td style="width: 200px !important; min-width: 200px !important;"
                                             class="poster-cell">
                                             <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>"
                                                alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                                class="poster-thumbnail">
                                          </td>
                                          <td class="movie-details-cell" data-label="Movie Details">
                                             <div class="movie-details">
                                                <div class="movie-title">
                                                   <?php echo htmlspecialchars($movie['title']); ?>
                                                </div>
                                                <div class="detail-item">
                                                   <span class="detail-label">Movie ID:</span>
                                                   <span class="detail-value">#<?php echo $movie['id']; ?></span>
                                                </div>
                                                <div class="detail-item">
                                                   <span class="detail-label">Status:</span>
                                                   <span class="detail-value">Coming Soon</span>
                                                </div>
                                             </div>
                                          </td>
                                          <td class="saved-info-cell" data-label="Saved Information">
                                             <div class="saved-info">
                                                <div class="detail-item">
                                                   <span class="detail-label">Saved on:</span>
                                                   <span class="detail-value saved-date">
                                                      <?php echo date('M j, Y', strtotime($movie['saved_at'])); ?>
                                                   </span>
                                                </div>
                                                <div class="detail-item">
                                                   <span class="detail-label">Time:</span>
                                                   <span class="detail-value saved-date">
                                                      <?php echo date('g:i A', strtotime($movie['saved_at'])); ?>
                                                   </span>
                                                </div>
                                             </div>
                                          </td>
                                          <td class="actions-cell">
                                             <div class="action-buttons">
                                                <button type="button" class="delete-btn"
                                                   onclick="confirmDelete(<?php echo $movie['id']; ?>, '<?php echo htmlspecialchars($movie['title']); ?>')">
                                                   Remove
                                                </button>
                                             </div>
                                             <form id="delete-form-<?php echo $movie['id']; ?>"
                                                action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                                                style="display: none;">
                                                <input type="hidden" name="movie_id"
                                                   value="<?php echo $movie['id']; ?>">
                                                <input type="hidden" name="delete_movie" value="1">
                                             </form>
                                          </td>
                                       </tr>
                                       <?php endwhile; ?>
                                    <?php else: ?>
                                    <tr>
                                       <td colspan="4" class="text-center py-4">
                                          <p class="text-muted">No saved movies found. Start building your watchlist!</p>
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
      <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
         crossorigin="anonymous"></script>
      <script>
         function confirmDelete(movieId, movieTitle) {
            Swal.fire({
               title: 'Are you sure?',
               text: `You are about to remove "${movieTitle}" from your watchlist. This action cannot be undone!`,
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#7928ca',
               cancelButtonColor: '#6c757d',
               confirmButtonText: 'Yes, remove it!',
               cancelButtonText: 'Cancel'
            }).then((result) => {
               if (result.isConfirmed) {
                  document.getElementById(`delete-form-${movieId}`).submit();
               }
            });
         }

         $(document).ready(function () {
            $('.poster-cell').css('width', '200px');
            $('.poster-cell').css('min-width', '200px');
         });

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
   mysqli_close($dbhandle);
   ?>