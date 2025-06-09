<?php
   session_start();
   include '../connection.php';
   global $dbhandle;
   
   // If user isn't logged in, redirect to the register page
   if (!isset($_SESSION['user_id'])) {
       header("Location: ../register.php");
       exit;
   }
   // Get the user ID from the session
   $user_id = $_SESSION['user_id'];
   
   // Function to show an error page with SweetAlert
   function showErrorPage($title, $message) {
       ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Booking</title>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
      <style>
         body {
         font-family: 'Montserrat', sans-serif;
         background-color: #000;
         opacity: 0.2;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         }
         .swal2-container {
         z-index: 9999999999999999999 !important;
         }
      </style>
   </head>
   <body>
      <script>
         // Error message 
         Swal.fire({
             icon: 'error',
             title: '<?php echo $title; ?>',
             text: '<?php echo $message; ?>'
         }).then(function() {
             window.history.back();
         });
      </script>
   </body>
</html>
<?php
   exit;
   }
   
   // Process the booking
   function processBooking($dbhandle, $user_id, $screening_id, $movie_id, $adult_tickets, $child_tickets, 
                       $senior_tickets, $popcorn, $drinks, $seats, $total_tickets, $movie_row) 
   {
    // convert date to format Y-m-d H:i:s
   $booking_time = date('Y-m-d H:i:s');
   
   try {
       // Start transaction, 
       mysqli_begin_transaction($dbhandle);
       // Reduce stock so were setting the stock as stock - total tickets where id = movie_id
       $update_stock_stmt = mysqli_prepare($dbhandle, "UPDATE movies SET stock = stock - ? WHERE id = ?");
       // bind parameters basically ii is from the parameters from the query we have ? and another ? and this telling what ? is
       mysqli_stmt_bind_param($update_stock_stmt, "ii", $total_tickets, $movie_id);
       // execute the statement ad close
       mysqli_stmt_execute($update_stock_stmt);
       mysqli_stmt_close($update_stock_stmt);
   
       // Update available seats if applicable
       if (isset($movie_row['available_seats'])) 
       {
        // Decrease available seats by total tickets same concept as above where the first ? is the $total_tickets and second is $screening_id thats why its ii and not i because theres two integers
           $update_seats_stmt = mysqli_prepare($dbhandle, 
               "UPDATE screening SET available_seats = available_seats - ? WHERE movie_id = ?");
           mysqli_stmt_bind_param($update_seats_stmt, "ii", $total_tickets, $screening_id);
           mysqli_stmt_execute($update_seats_stmt);
           mysqli_stmt_close($update_seats_stmt);
       }
       // Insert booking the user_id, etc as a prepared statement 
       $stmt = mysqli_prepare(
           $dbhandle,
           "INSERT INTO bookings 
               (user_id, screening_id, adult_tickets, child_tickets, senior_tickets, popcorn, drinks, booking_time, seats) 
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
       );
       // bind the parameters to the prepared statement
       mysqli_stmt_bind_param(
           $stmt, 
           "iiiiiiiss",
           $user_id, 
           $screening_id, 
           $adult_tickets,
           $child_tickets,
           $senior_tickets,
           $popcorn,
           $drinks,
           $booking_time, 
           $seats
       );
       // if not executed then throw an exception with the error message
       if (!mysqli_stmt_execute($stmt)) {
           throw new Exception(mysqli_error($dbhandle));
       }
       // then we close the statement and commit the transaction
       mysqli_stmt_close($stmt);
       mysqli_commit($dbhandle);
       return true;
       
   } 
   // basically just discard the changes if there is an error is what the rollback does an undo making sure it doesn't affect the database 
   catch (Exception $e) {
       mysqli_rollback($dbhandle);
       throw $e;
   }
   }
   
   // If the request method is a post and the screening_id is set, we will process the booking
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['screening_id'])) 
   {
        // Get the screening ID from the POST request and convert it to an integer
        $screening_id = intval($_POST['screening_id']);
   
        // Get ticket quantities or default to 0 if not set
        $adult_tickets = isset($_POST['adult_tickets']) ? intval($_POST['adult_tickets']) : 0;
        $child_tickets = isset($_POST['child_tickets']) ? intval($_POST['child_tickets']) : 0;
        $senior_tickets = isset($_POST['senior_tickets']) ? intval($_POST['senior_tickets']) : 0;
        
        // Calculate total tickets and ensure at least one ticket is selected
        $total_tickets = $adult_tickets + $child_tickets + $senior_tickets;
        if ($total_tickets < 1) {
            showErrorPage('No Tickets Selected', 'You must select at least one ticket.');
        }
        // If seats exists then join the seats into a string, otherwise set it to an empty string
        $seats = isset($_POST['seats']) ? implode(',', $_POST['seats']) : '';
        // Get popcorn and drinks quantities or default to 0 if not set
        $popcorn = isset($_POST['popcorn']) ? intval($_POST['popcorn']) : 0;
        $drinks = isset($_POST['drink']) ? intval($_POST['drink']) : 0;
        
        // Check and update movie stock
        // same concept as above where we prepare the statement and bind the parameters
        $get_movie_stmt = mysqli_prepare($dbhandle, "SELECT * FROM screening WHERE screening_id = ? OR movie_id = ?");
        mysqli_stmt_bind_param($get_movie_stmt, "ii", $screening_id, $screening_id);
        mysqli_stmt_execute($get_movie_stmt);
        $movie_result = mysqli_stmt_get_result($get_movie_stmt);
        $movie_row = mysqli_fetch_assoc($movie_result);
        mysqli_stmt_close($get_movie_stmt);
   
    // Check if the movie row exists
   if (!$movie_row) {
       showErrorPage('Screening Not Found', "The selected screening (ID: $screening_id) could not be found. Please contact support.");
   }
   // Get the movie ID from the movie row, if it exists, otherwise set it to 0
   $movie_id = $movie_row['id'] ?? 0;
   
   // Check current stock same concept as above where we prepare the statement and bind the parameters
   $stock_stmt = mysqli_prepare($dbhandle, "SELECT stock FROM movies WHERE id = ?");
   mysqli_stmt_bind_param($stock_stmt, "i", $movie_id);
   mysqli_stmt_execute($stock_stmt);
   $stock_result = mysqli_stmt_get_result($stock_stmt);
   $stock_row = mysqli_fetch_assoc($stock_result);
   mysqli_stmt_close($stock_stmt);
   
   if (!$stock_row) {
       showErrorPage('Movie Not Found', "The selected movie (ID: $movie_id) could not be found.");
   }
   
   $current_stock = $stock_row['stock'];
   
   // Check if enough stock is available
   if ($current_stock < $total_tickets) {
       showErrorPage('Not Enough Tickets', "Please adjust your selection.");
   }
   
   // Show the processing message and handle booking
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Processing Booking</title>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
      <style>
         body {
         font-family: 'Montserrat', sans-serif;
         background-color: #000;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         }
         .swal2-container {
         z-index: 9999999999999999999 !important;
         }
      </style>
   </head>
   <body>
      <script>
         // Show processing message
         Swal.fire({
             title: 'Processing Your Booking',
             text: 'Please wait...',
             allowOutsideClick: false,
             showConfirmButton: false,
             willOpen: () => {
                 Swal.showLoading();
             }
         });
         
         // Process the booking in the background
         setTimeout(function() {
             <?php
            $success = false;
            $error_message = '';
            
            // Call the processBooking function and catch any exceptions
            try {
                $success = processBooking(
                    $dbhandle, $user_id, $screening_id, $movie_id, 
                    $adult_tickets, $child_tickets, $senior_tickets, 
                    $popcorn, $drinks, $seats, $total_tickets, $movie_row
                );
            } catch (Exception $e) {
                $error_message = $e->getMessage();
            }
            ?>
            // if success was true then we will show the success message and redirect to the admin panel
             if (<?php echo $success ? 'true' : 'false'; ?>) {
                 // Show success message and redirect to adminpanel
                 Swal.fire({
                     icon: 'success',
                     title: 'Booking Successful!',
                     text: 'Your tickets have been booked successfully.',
                     timer: 2000,
                     showConfirmButton: false
                 }).then(function() {
                     if (<?php echo isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Adult' ? 'true' : 'false'; ?>) 
                     {
                         window.location.href = '../adultpanel/bookings.php';
                     } 
                     else 
                     {
                         window.location.href = '../adminpanel/bookings-admin.php';
                     }
                 });
             } else {
                 // Show error message
                 Swal.fire({
                     icon: 'error',
                     title: 'Booking Failed',
                     text: 'There was an error processing your booking: <?php echo addslashes($error_message ?: "Unknown error"); ?>'
                 }).then(function() {
                     window.history.back();
                 });
             }
         }, 1500); // Show processing for at least 1.5 seconds
      </script>
   </body>
</html>
<?php
   exit;
   }
   ?>