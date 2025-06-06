<?php
// Start session at the very beginning before any output
session_start();
include '../connection.php';
global $dbhandle;

// Check if the user is an adult
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Adult') {
   header("Location: ../");
   exit;
}
// Handle booking deletion if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {
   $booking_id = intval($_POST['booking_id'] ?? 0);
   if ($booking_id > 0) {
      $delete_query = "DELETE FROM bookings WHERE id = $booking_id";
      if (mysqli_query($dbhandle, $delete_query)) {
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
            </div>
            <div class="collapse navbar-collapse" id="sidebar-menu">
               <ul class="navbar-nav pt-lg-3">
                  <li class="nav-item">
                     <a class="nav-link" href="profile.php" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                        </span>
                        <span class="nav-link-title">Profile</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="bookings.php" >
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
                     <div class="card">
                        <div class="table-responsive">
                           <table class="table table-vcenter card-table" style="min-width: 1300px;">
                              <thead>
                                 <tr>
                                    <th class="poster-cell">Movie Poster</th>
                                    <th class="booking-details-cell">Booking Details</th>
                                    <th class="tickets-cell">Tickets & Extras</th>
                                    <th class="seats-cell">Seats</th>
                                    <th class="actions-cell">Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                                    <tr>
                                       <td class="poster-cell">
                                          <img src="<?php echo htmlspecialchars($booking['poster_url']); ?>"
                                             alt="<?php echo htmlspecialchars($booking['movie_title']); ?>"
                                             class="poster-thumbnail">
                                       </td>
                                       <td class="booking-details-cell">
                                          <div class="booking-details">
                                             <div class="movie-title">
                                                <?php echo htmlspecialchars($booking['movie_title']); ?>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Booking ID:</span>
                                                <span class="detail-value">#<?php echo $booking['booking_id']; ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Booked on:</span>
                                                <span class="detail-value"><?php echo date('M j, Y g:i A', strtotime($booking['booking_time'])); ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Screening:</span>
                                                <span class="detail-value"><?php echo date('M j, Y', strtotime($booking['screening_date'])); ?></span>
                                             </div>
                                             <div class="detail-item">
                                                <span class="detail-label">Time:</span>
                                                <span class="detail-value"><?php echo date('g:i A', strtotime($booking['start_time'])); ?>
                                                   - <?php echo date('g:i A', strtotime($booking['end_time'])); ?></span>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="tickets-cell">
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
                                       <td class="seats-cell">
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
                                                <img src="/svg/adminpanel/print.svg" class="icon" width="20px" />
                                                Print
                                             </button>
                                             <button type="button" class="delete-btn"
                                                onclick="confirmDelete(<?php echo $booking['booking_id']; ?>, '<?php echo htmlspecialchars($booking['movie_title'], ENT_QUOTES); ?>')">
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
                                                <img src="/svg/logo/limelight_dark.svg" alt="Limelight Cinema"
                                                   class="e-ticket-logo">
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
                                                <p>Please present this e-ticket at the cinema entrance. Enjoy your movie!</p>
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
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script>
      function confirmDelete(bookingId, movieTitle) {
    console.log(`Booking ID: ${bookingId}, Movie Title: ${movieTitle}`); // Debugging log
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
            const form = document.getElementById(`delete-form-${bookingId}`);
            if (form) {
                form.submit();
            } else {
                console.error(`Form for booking ID ${bookingId} not found.`);
            }
        }
    });
}

      // Function to print a ticket
      function printTicket(bookingId) {
         const ticketElement = document.getElementById(`printable-ticket-${bookingId}`);
         if (ticketElement) {
            // Create style to hide everything except ticket
            const styleSheet = document.createElement('style');
            styleSheet.textContent = `
               body * { visibility: hidden; }
               #printable-ticket-${bookingId}, #printable-ticket-${bookingId} * { 
                  visibility: visible; 
               }
               #printable-ticket-${bookingId} {
                  position: absolute;
                  left: 0;
                  top: 0;
                  width: 100%;
                  display: block !important;
               }
               @media print {
                  body * { visibility: hidden; }
                  #printable-ticket-${bookingId}, #printable-ticket-${bookingId} * { 
                     visibility: visible; 
                  }
                  #printable-ticket-${bookingId} {
                     position: absolute;
                     left: 0;
                     top: 0;
                     width: 100%;
                     display: block !important;
                  }
               }
            `;
            
            // Store original display and add styles
            const originalDisplay = ticketElement.style.display;
            document.head.appendChild(styleSheet);
            ticketElement.style.display = 'block';
            
            // Print
            window.print();
            
            // Restore original state
            setTimeout(() => {
               document.head.removeChild(styleSheet);
               ticketElement.style.display = originalDisplay;
            }, 100);
            
         } else {
            Swal.fire({
               title: 'Error',
               text: 'Unable to find the ticket to print. Please try again.',
               icon: 'error',
               confirmButtonColor: '#7928ca'
            });
         }
      }

      // Force cell widths on load
      $(document).ready(function () {
         $('.poster-cell').css('width', '200px');
         $('.poster-cell').css('min-width', '200px');
      });
   </script>
</body>

</html>
<?php
mysqli_close($dbhandle);
?>