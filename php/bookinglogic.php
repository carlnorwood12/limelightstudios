<?php
session_start();
include '../connection.php';
global $dbhandle;

// If user isn't logged in, redirect to the register page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../register.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Helper function to display errors
function showErrorPage($title, $message) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Error</title>
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

// Helper function to process booking
function processBooking($dbhandle, $user_id, $screening_id, $movie_id, $adult_tickets, $child_tickets, 
                        $senior_tickets, $popcorn, $drinks, $seats, $total_tickets, $movie_row) {
    $booking_time = date('Y-m-d H:i:s');
    
    try {
        // Start transaction
        mysqli_begin_transaction($dbhandle);
        
        // Reduce stock
        $update_stock_stmt = mysqli_prepare($dbhandle, "UPDATE movies SET stock = stock - ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stock_stmt, "ii", $total_tickets, $movie_id);
        mysqli_stmt_execute($update_stock_stmt);
        mysqli_stmt_close($update_stock_stmt);

        // Update available seats if applicable
        if (isset($movie_row['available_seats'])) {
            $update_seats_stmt = mysqli_prepare($dbhandle, 
                "UPDATE screening SET available_seats = available_seats - ? WHERE id = ?");
            mysqli_stmt_bind_param($update_seats_stmt, "ii", $total_tickets, $screening_id);
            mysqli_stmt_execute($update_seats_stmt);
            mysqli_stmt_close($update_seats_stmt);
        }

        // Insert booking
        $stmt = mysqli_prepare(
            $dbhandle,
            "INSERT INTO bookings 
                (user_id, screening_id, adult_tickets, child_tickets, senior_tickets, popcorn, drinks, booking_time, seats) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
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

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($dbhandle));
        }

        mysqli_stmt_close($stmt);
        mysqli_commit($dbhandle);
        return true;
        
    } catch (Exception $e) {
        mysqli_rollback($dbhandle);
        throw $e;
    }
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['screening_id'])) {
    $screening_id = intval($_POST['screening_id']);

    // Get ticket quantities
    $adult_tickets = isset($_POST['adult_tickets']) ? intval($_POST['adult_tickets']) : 0;
    $child_tickets = isset($_POST['child_tickets']) ? intval($_POST['child_tickets']) : 0;
    $senior_tickets = isset($_POST['senior_tickets']) ? intval($_POST['senior_tickets']) : 0;

    // Validate ticket quantities
    $total_tickets = $adult_tickets + $child_tickets + $senior_tickets;
    if ($total_tickets < 1) {
        showErrorPage('No Tickets Selected', 'You must select at least one ticket.');
    }

    // Get other form data
    $seats = isset($_POST['seats']) ? implode(',', $_POST['seats']) : '';
    $popcorn = isset($_POST['popcorn']) ? intval($_POST['popcorn']) : 0;
    $drinks = isset($_POST['drink']) ? intval($_POST['drink']) : 0;

    // Check and update movie stock
    $get_movie_stmt = mysqli_prepare($dbhandle, "SELECT * FROM screening WHERE screening_id = ? OR id = ?");
    mysqli_stmt_bind_param($get_movie_stmt, "ii", $screening_id, $screening_id);
    mysqli_stmt_execute($get_movie_stmt);
    $movie_result = mysqli_stmt_get_result($get_movie_stmt);
    $movie_row = mysqli_fetch_assoc($movie_result);
    mysqli_stmt_close($get_movie_stmt);

    if (!$movie_row) {
        showErrorPage('Screening Not Found', "The selected screening (ID: $screening_id) could not be found. Please contact support.");
    }

    $movie_id = $movie_row['id'] ?? 0;

    // Check current stock
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
        showErrorPage('Not Enough Tickets', "Only $current_stock tickets are available. Please adjust your selection.");
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

                if (<?php echo $success ? 'true' : 'false'; ?>) {
                    // Show success message and redirect to adminpanel
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Successful!',
                        text: 'Your tickets have been booked successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = '/dashboard.php';
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