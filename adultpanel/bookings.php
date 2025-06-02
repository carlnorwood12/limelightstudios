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

// Check if the user is an adult - FIXED: Changed 'adult' to 'Adult' to match session data
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Adult') {
   header("Location: ../");
   exit;
}

// Handle booking deletion if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {
   $booking_id = $_POST['booking_id'] ?? 0;
   if ($booking_id > 0) {
      $delete_query = "DELETE FROM bookings WHERE id = '$booking_id'";
      if (mysqli_query($dbhandle, $delete_query)) {
         // Redirect to prevent form resubmission
         header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
         exit;
      }
   }
}

// Fetch all bookings with related movie and screening information
$booking_query = "
       SELECT 
           b.id as booking_id,
           b.user_id,
           b.screening_id,
           b.adult_tickets,
           b.child_tickets,
           b.senior_tickets,
           b.popcorn,
           b.drinks,
           b.booking_time,
           b.seats,
           m.title as movie_title,
           m.poster_url,
           s.screening_date,
           s.start_time,
           s.end_time,
           u.name as user_name
       FROM 
           bookings b
       JOIN 
           screening s ON b.screening_id = s.id
       JOIN 
           movies m ON s.id = m.id
       JOIN 
           users u ON b.user_id = u.id
       GROUP BY b.id 
       ORDER BY 
           b.booking_time DESC
   ";
$bookings_result = mysqli_query($dbhandle, $booking_query) or die('Error querying bookings: ' . mysqli_error($dbhandle));
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Adult Bookings</title>
   <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
   <link rel="stylesheet" href="../css/adult.css"/>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Add Print.js CSS and JS -->
   <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
   <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
   <style>
      /* Remove navbar border */
      aside.navbar-vertical {
         border: none !important;
         border-right: none !important;
      }

      .navbar-vertical.navbar-expand-lg {
         border-right: none !important;
      }

      /* Set minimum widths to prevent squishing */
      .table-responsive {
         overflow-x: auto;
      }

      .table {
         min-width: 1300px !important;
         /* Ensure table has a minimum width */
         table-layout: fixed !important;
         /* Fixed table layout to respect column widths */
      }

      /* Increased poster cell width - with higher specificity */
      .table th.poster-cell,
      .table td.poster-cell,
      th.poster-cell,
      td.poster-cell {
         width: 200px !important;
         min-width: 200px !important;
         /* Forced minimum width */
         text-align: center;
         padding: 15px;
      }

      .booking-details-cell {
         width: 300px;
         min-width: 300px;
         /* Minimum width */
      }

      .tickets-cell {
         width: 200px;
         min-width: 200px;
         /* Minimum width */
      }

      .seats-cell {
         width: 200px;
         min-width: 200px;
      }

      .actions-cell {
         width: 180px;
         min-width: 180px;
         /* Minimum width */
      }

      .poster-thumbnail {
         width: 200px;
         /* Slightly increased thumbnail size */
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

      .booking-details {
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

      .ticket-info {
         display: flex;
         flex-direction: column;
         gap: 0.5rem;
      }

      .ticket-row {
         display: flex;
         align-items: center;
         gap: 12px;
      }

      .ticket-label {
         font-weight: 500;
         color: #718096;
         min-width: 60px;
      }

      .ticket-value {
         font-weight: 600;
      }

      .seat-badge {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         width: 32px;
         height: 32px;
         border: 1px solid #9ca1ed;
         color: #9ca1ed;
         font-weight: 600;
         font-size: 0.85rem;
         border-radius: 6px;
         margin: 3px;
      }

      /* Updated button styles */
      .btn {
         position: relative;
         background-color: rgb(4, 21, 19) !important;
         color: #2BCFC1 !important;
         transition: all 0.2s ease !important;
         overflow: hidden !important;
         border: none !important;
      }

      .print-btn {
         position: relative;
         background-color: #0c0414 !important;
         color: #7928ca !important;
         transition: all 0.2s ease !important;
         overflow: hidden !important;
         border: none !important;
         display: inline-flex;
         gap: 5px;
         align-items: center;
         justify-content: center;
         padding: 1rem 1.5rem;
         /* This might be too large */
         border-radius: 50px;
         cursor: pointer;
         font-weight: 500;
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
         flex-direction: row;
         /* Changed to row for side-by-side layout */
         gap: 8px;
         justify-content: flex-start;
      }

      .page-title {
         font-size: 1.5rem;
         font-weight: 700;
         color: #fff;
      }

      /* Profile image styles */
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

      /* E-Ticket Styling */
      .e-ticket {
         display: none;
         font-family: 'Arial', sans-serif;
         max-width: 800px;
         margin: 0 auto;
         background-color: #fff;
         border-radius: 8px;
         overflow: hidden;
         box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      }

      .e-ticket-header {
         background: linear-gradient(135deg, #7928CA 0%, #9c8af2 100%);
         color: white;
         padding: 20px;
         text-align: center;
      }

      .e-ticket-logo {
         max-width: 150px;
         margin-bottom: 10px;
      }

      .e-ticket-title {
         font-size: 24px;
         font-weight: bold;
         margin: 0;
      }

      .e-ticket-body {
         padding: 20px;
         display: flex;
      }

      .e-ticket-poster {
         flex: 0 0 200px;
         margin-right: 20px;
      }

      .e-ticket-poster img {
         width: 100%;
         border-radius: 4px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .e-ticket-details {
         flex: 1;
      }

      .e-ticket-movie-title {
         font-size: 24px;
         font-weight: bold;
         margin-bottom: 15px;
         color: #333;
      }

      .e-ticket-info {
         margin-bottom: 20px;
      }

      .e-ticket-info-row {
         display: flex;
         margin-bottom: 8px;
      }

      .e-ticket-info-label {
         flex: 0 0 120px;
         font-weight: bold;
         color: #666;
      }

      .e-ticket-info-value {
         flex: 1;
         color: #333;
      }

      .e-ticket-seats {
         margin-top: 20px;
      }

      .e-ticket-seat {
         display: inline-block;
         padding: 5px 10px;
         background-color: #f0f0f0;
         border-radius: 4px;
         margin-right: 5px;
         margin-bottom: 5px;
         font-weight: bold;
         color: #333;
      }

      .e-ticket-footer {
         background-color: #f8f9fa;
         padding: 15px 20px;
         text-align: center;
         font-size: 14px;
         color: #666;
         border-top: 1px dashed #ddd;
      }

      .e-ticket-barcode {
         margin-top: 15px;
         text-align: center;
      }

      .e-ticket-barcode img {
         max-width: 80%;
         height: 70px;
      }

      .col
         {
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
               <!-- Updated profile section -->
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
               </div>
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
                     <li class="nav-item">
                        <a class="nav-link" href="bookings.php" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <img src="/svg/adminpanel/bookings.svg" class="icon" width="20px" />
                        </span>
                        <span class="nav-link-title">
                        Bookings
                        </span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="saved.php" >
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
                     <h2 class="page-title">Bookings</h2>
                     <p class="text-muted mt-1">View your bookings and manage them easily.</p>
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
                           <div>Booking was successfully deleted.</div>
                           <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                     <?php endif; ?>
                     <div class="card">
                        <div class="table-responsive">
                           <table class="table table-vcenter card-table" style="min-width: 1300px;">
                              <thead>
                                 <tr>
                                    <th style="width: 200px !important; min-width: 200px !important;"
                                       class="poster-cell">Movie Poster</th>
                                    <th class="booking-details-cell">Booking Details</th>
                                    <th class="tickets-cell">Tickets & Extras</th>
                                    <th class="seats-cell">Seats</th>
                                    <th class="actions-cell">Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                                    <tr>
                                       <td style="width: 200px !important; min-width: 200px !important;"
                                          class="poster-cell">
                                          <img src="<?php echo htmlspecialchars($booking['poster_url']); ?>"
                                             alt="<?php echo htmlspecialchars($booking['movie_title']); ?>"
                                             class="poster-thumbnail">
                                       </td>
                                       <td class="booking-details-cell" data-label="Booking Details">
                                          <div class="booking-details">
                                             <!-- Movie title moved to booking details -->
                                             <div class="movie-title">
                                                <?php echo htmlspecialchars($booking['movie_title']); ?>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Booking ID:</span>
                                                <span class="detail-value">#<?php echo $booking['booking_id']; ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Booked on:</span>
                                                <span
                                                   class="detail-value"><?php echo date('M j, Y g:i A', strtotime($booking['booking_time'])); ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Screening:</span>
                                                <span
                                                   class="detail-value"><?php echo date('M j, Y', strtotime($booking['screening_date'])); ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Time:</span>
                                                <span
                                                   class="detail-value"><?php echo date('g:i A', strtotime($booking['start_time'])); ?>
                                                   - <?php echo date('g:i A', strtotime($booking['end_time'])); ?></span>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="tickets-cell" data-label="Tickets & Extras">
                                          <div class="ticket-info">
                                             <?php if ($booking['adult_tickets'] > 0): ?>
                                                <div class="ticket-row">
                                                   <span class="ticket-label">Adult:</span>
                                                   <span class="ticket-value"><?php echo $booking['adult_tickets']; ?></span>
                                                </div>
                                             <?php endif; ?>
                                             <?php if ($booking['child_tickets'] > 0): ?>
                                                <div class="ticket-row">
                                                   <span class="ticket-label">Child:</span>
                                                   <span class="ticket-value"><?php echo $booking['child_tickets']; ?></span>
                                                </div>
                                             <?php endif; ?>
                                             <?php if ($booking['senior_tickets'] > 0): ?>
                                                <div class="ticket-row">
                                                   <span class="ticket-label">Senior:</span>
                                                   <span class="ticket-value"><?php echo $booking['senior_tickets']; ?></span>
                                                </div>
                                             <?php endif; ?>
                                             <?php if ($booking['popcorn'] > 0): ?>
                                                <div class="ticket-row">
                                                   <span class="ticket-label">Popcorn:</span>
                                                   <span class="ticket-value"><?php echo $booking['popcorn']; ?></span>
                                                </div>
                                             <?php endif; ?>
                                             <?php if ($booking['drinks'] > 0): ?>
                                                <div class="ticket-row">
                                                   <span class="ticket-label">Drinks:</span>
                                                   <span class="ticket-value"><?php echo $booking['drinks']; ?></span>
                                                </div>
                                             <?php endif; ?>
                                          </div>
                                       </td>
                                       <td class="seats-cell" data-label="Seats">
                                          <div class="d-flex flex-wrap gap-1">
                                             <?php
                                             $seats = explode(',', $booking['seats']);
                                             foreach ($seats as $seat) {
                                                if (trim($seat) != '') {
                                                   echo '<span class="seat-badge">' . htmlspecialchars(trim($seat)) . '</span>';
                                                }
                                             }
                                             ?>
                                          </div>
                                       </td>
                                       <td class="actions-cell">
                                          <div class="action-buttons">
                                             <button type="button" class="print-btn"
                                                onclick="printTicket(<?php echo $booking['booking_id']; ?>)">
                                                <img src="./svg/printer.svg" class="icon" width="20px" />
                                                Print
                                             </button>
                                             <button type="button" class="delete-btn"
                                                onclick="confirmDelete(<?php echo $booking['booking_id']; ?>, '<?php echo htmlspecialchars($booking['movie_title']); ?>')">
                                                Delete
                                             </button>
                                          </div>
                                          <!-- Hidden form for deletion -->
                                          <form id="delete-form-<?php echo $booking['booking_id']; ?>"
                                             action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                                             style="display: none;">
                                             <input type="hidden" name="booking_id"
                                                value="<?php echo $booking['booking_id']; ?>">
                                             <input type="hidden" name="delete_booking" value="1">
                                          </form>


                                          <!-- Hidden printable ticket -->
                                          <div id="printable-ticket-<?php echo $booking['booking_id']; ?>"
                                             class="e-ticket">
                                             <div class="e-ticket-header">
                                                <img src="/svg/logo/limelight.svg" alt="Limelight Cinema"
                                                   class="e-ticket-logo">
                                                <h1 class="e-ticket-title">E-TICKET</h1>
                                             </div>
                                             <div class="e-ticket-body">
                                                <div class="e-ticket-poster">
                                                   <img src="<?php echo htmlspecialchars($booking['poster_url']); ?>"
                                                      alt="<?php echo htmlspecialchars($booking['movie_title']); ?>">
                                                </div>
                                                <div class="e-ticket-details">
                                                   <h2 class="e-ticket-movie-title">
                                                      <?php echo htmlspecialchars($booking['movie_title']); ?></h2>
                                                   <div class="e-ticket-info">
                                                      <div class="e-ticket-info-row">
                                                         <div class="e-ticket-info-label">Booking ID:</div>
                                                         <div class="e-ticket-info-value">
                                                            #<?php echo $booking['booking_id']; ?></div>
                                                      </div>
                                                      <div class="e-ticket-info-row">
                                                         <div class="e-ticket-info-label">Date:</div>
                                                         <div class="e-ticket-info-value">
                                                            <?php echo date('l, F j, Y', strtotime($booking['screening_date'])); ?>
                                                         </div>
                                                      </div>
                                                      <div class="e-ticket-info-row">
                                                         <div class="e-ticket-info-label">Time:</div>
                                                         <div class="e-ticket-info-value">
                                                            <?php echo date('g:i A', strtotime($booking['start_time'])); ?>
                                                            - <?php echo date('g:i A', strtotime($booking['end_time'])); ?>
                                                         </div>
                                                      </div>
                                                      <div class="e-ticket-info-row">
                                                         <div class="e-ticket-info-label">Customer:</div>
                                                         <div class="e-ticket-info-value">
                                                            <?php echo htmlspecialchars($booking['user_name']); ?></div>
                                                      </div>
                                                      <div class="e-ticket-info-row">
                                                         <div class="e-ticket-info-label">Tickets:</div>
                                                         <div class="e-ticket-info-value">
                                                            <?php if ($booking['adult_tickets'] > 0): ?>
                                                               <?php echo $booking['adult_tickets']; ?>
                                                               Adult<?php echo $booking['adult_tickets'] > 1 ? 's' : ''; ?><br>
                                                            <?php endif; ?>
                                                            <?php if ($booking['child_tickets'] > 0): ?>
                                                               <?php echo $booking['child_tickets']; ?>
                                                               Child<?php echo $booking['child_tickets'] > 1 ? 'ren' : ''; ?><br>
                                                            <?php endif; ?>
                                                            <?php if ($booking['senior_tickets'] > 0): ?>
                                                               <?php echo $booking['senior_tickets']; ?>
                                                               Senior<?php echo $booking['senior_tickets'] > 1 ? 's' : ''; ?><br>
                                                            <?php endif; ?>
                                                         </div>
                                                      </div>
                                                      <?php if ($booking['popcorn'] > 0 || $booking['drinks'] > 0): ?>
                                                         <div class="e-ticket-info-row">
                                                            <div class="e-ticket-info-label">Extras:</div>
                                                            <div class="e-ticket-info-value">
                                                               <?php if ($booking['popcorn'] > 0): ?>
                                                                  <?php echo $booking['popcorn']; ?> Popcorn<br>
                                                               <?php endif; ?>
                                                               <?php if ($booking['drinks'] > 0): ?>
                                                                  <?php echo $booking['drinks']; ?>
                                                                  Drink<?php echo $booking['drinks'] > 1 ? 's' : ''; ?>
                                                               <?php endif; ?>
                                                            </div>
                                                         </div>
                                                      <?php endif; ?>
                                                   </div>
                                                   <div class="e-ticket-seats">
                                                      <div class="e-ticket-info-label">Seats:</div>
                                                      <div class="mt-2">
                                                         <?php
                                                         $seats = explode(',', $booking['seats']);
                                                         foreach ($seats as $seat) {
                                                            if (trim($seat) != '') {
                                                               echo '<span class="e-ticket-seat">' . htmlspecialchars(trim($seat)) . '</span>';
                                                            }
                                                         }
                                                         ?>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="e-ticket-footer">
                                                <p>Please present this e-ticket at the cinema entrance. Enjoy your movie!
                                                </p>
                                                <div class="e-ticket-barcode">
                                                   <img
                                                      src="https://barcode.tec-it.com/barcode.ashx?data=LIMELIGHT<?php echo $booking['booking_id']; ?>&code=Code128&dpi=96"
                                                      alt="Barcode">
                                                </div>
                                                <p class="mt-2">Limelight Cinema - The Ultimate Cinema Experience</p>
                                             </div>
                                          </div>
                                       </td>
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
   <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"></script>
   <script>
      // Function to handle delete confirmation
      function confirmDelete(bookingId, movieTitle) {
         Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete the booking for "${movieTitle}". This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7928ca',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
         }).then((result) => {
            if (result.isConfirmed) {
               // Submit the delete form
               document.getElementById(`delete-form-${bookingId}`).submit();
            }
         });
      }

      // Function to print a ticket
      function printTicket(bookingId) {
         // Use Print.js to print the e-ticket
         printJS({
            printable: `printable-ticket-${bookingId}`,
            type: 'html',
            css: ['https://printjs-4de6.kxcdn.com/print.min.css'],
            header: 'Limelight Cinema E-Ticket'
         });
      }
      // Force cell widths on load
      $(document).ready(function () {
         $('.poster-cell').css('width', '200px');
         $('.poster-cell').css('min-width', '200px');
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