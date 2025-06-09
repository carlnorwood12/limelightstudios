<?php
session_start();
// Include the database connection
include './connection.php';
global $dbhandle;

// Get the movie ID from the URL or default to 0
$id = $_GET['id'] ?? 0;

// check if user is logged in / registered
if (!isset($_SESSION['user_id'])) {
   header('Location: register.php');
   exit();
}

// Query to fetch movie details - run once and store result
$sql = "SELECT * FROM movies WHERE id = ?";
// Prepare and execute the statement to prevent SQL injection
$stmt = mysqli_prepare($dbhandle, $sql);
// Check if the statement was prepared successfully
mysqli_stmt_bind_param($stmt, "i", $id);
// Execute the statement and fetch the result
mysqli_stmt_execute($stmt);
// Check if the execution was successful
$result = mysqli_stmt_get_result($stmt);
// Fetch the single row of movie data as associative array
$row = mysqli_fetch_assoc($result);
// Close the statement
mysqli_stmt_close($stmt);

// Assign fetched data to variables
$title = $row['title'] ?? 'Default Title';

// Get poster URL, with fallback to the database value
// Check if poster URL is set in POST or GET, otherwise use the database value
if (isset($_POST['poster_url']) && !empty($_POST['poster_url'])) {
   $poster_url = htmlspecialchars($_POST['poster_url']);
} else if (isset($_GET['poster_url']) && !empty($_GET['poster_url'])) {
   $poster_url = htmlspecialchars($_GET['poster_url']);
} else {
   $poster_url = $row['poster_url'];
}

// This is a simple function with a switch statement to return a CSS filter value based on the genre
function getGenreColor($genre)
{
   switch (strtolower($genre)) {
      case 'horror':
         return 'hue-rotate(0deg)';
      case 'action':
         return 'hue-rotate(28deg)';
      case 'adventure':
         return 'hue-rotate(56deg)';
      case 'family':
         return 'hue-rotate(84deg)';
      case 'fantasy':
         return 'hue-rotate(112deg)';
      case 'comedy':
         return 'hue-rotate(140deg)';
      case 'sci-fi':
         return 'hue-rotate(168deg)';
      case 'mystery':
         return 'hue-rotate(196deg)';
      case 'thriller':
         return 'hue-rotate(224deg)';
      case 'crime':
         return 'hue-rotate(252deg)';
      case 'musical':
         return 'hue-rotate(280deg)';
      case 'drama':
         return 'hue-rotate(308deg)';
      case 'romance':
         return 'hue-rotate(336deg)';
      case 'history':
         return 'hue-rotate(364deg)';
      default:
         return 'hue-rotate(0deg)';
   }
}

// Here were creating a function to format the date string into a more readable format in the format 'F j, Y'
// which could be something like 'January 1, 2023'
function formatDate($dateString, $format = 'F j, Y')
{
   $date = new DateTime($dateString);
   return $date->format($format);
}

// initialize an empty array to hold screenings
$screenings = [];
// Query to fetch screenings for the movie
$screeningResult = mysqli_query($dbhandle, "SELECT * FROM screening WHERE movie_id = $id");
// While loop to fetch all screenings and store them in the screenings array
while ($screeningRow = mysqli_fetch_array($screeningResult, MYSQLI_ASSOC)) {
   $screenings[] = $screeningRow;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <title>LimelightCinema | Home</title>
   <link rel="icon" type="image/png" href="favicon_limelightcinema/favicon-96x96.png" sizes="96x96" />
   <link rel="icon" type="image/svg+xml" href="favicon_limelightcinema/favicon.svg" />
   <link rel="shortcut icon" href="favicon_limelightcinema/favicon.ico" />
   <link rel="apple-touch-icon" sizes="180x180" href="favicon_limelightcinema/apple-touch-icon.png" />
   <meta name="apple-mobile-web-app-title" content="MyWebSite" />
   <link rel="manifest" href="/site.webmanifest" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="theme-color" content="#000">
   <meta name="description"
      content="Limelight Cinema is a movie streaming platform that offers a wide range of movies and TV shows.">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Lora:wght@400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet">
   <link rel="stylesheet" href="./css/dropdown.css">
   <link rel="stylesheet" href="./css/styles.css" />
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
   <!-- this is to ensure that the poster image is blurred in the background -->
   <style>
      body
      {
         background-color: rgba(0, 0, 0, 0.05) !important;
      }
      html::before {
         content: '';
         position: fixed;
         inset: 0;
         background: url('<?php echo !empty($poster_url) ? htmlspecialchars($poster_url, ENT_QUOTES, 'UTF-8') : htmlspecialchars($row['poster_url'], ENT_QUOTES, 'UTF-8'); ?>') center center / cover no-repeat;
         filter: blur(150px) saturate(4);
         pointer-events: none;
         z-index: -1;
      }

      .swal2-container {
         z-index: 9999999999999999999 !important;
      }

      html.swal2-shown,
      body.swal2-shown {
         overflow-y: hidden !important;
      }
   </style>
</head>

<body>
   <div class="radial-gradient"></div>
   <section class="content-section hero2">
      <div class="container-them">
         <div class="contain-the-image">
            <!-- This div is used to set the background image of the hero section -->
            <div class="contain-image"
               style="background: url('<?php echo $poster_url ?: $row['poster_url']; ?>') center center/cover no-repeat;">
            </div>
         </div>
         <div class="left-text">
            <h1 class="title"><?php echo $title; ?></h1>
            <div class="genre-container-index">
               <div class="genre-badge" style="filter: <?php echo getGenreColor($row['genre_1']); ?>">
                  <?php echo htmlspecialchars($row['genre_1']); ?>
               </div>
               <div class="genre-badge" style="filter: <?php echo getGenreColor($row['genre_2']); ?>">
                  <?php echo htmlspecialchars($row['genre_2']); ?>
               </div>
            </div>
            <div class="metadata-group">
               <span><?php echo htmlspecialchars($row['age_rating']); ?></span>•
               <div class="rating-container">
                  <img src="/svg/stars/star.svg" alt="" class="star">
                  <span><?php echo htmlspecialchars($row['movie_rating']); ?></span>
               </div>
               <span>•&nbsp;&nbsp;<?php echo htmlspecialchars(formatDate($row['release_date'])); ?></span>
            </div>
            <p class="paragraph-left"><?php echo $row['description']; ?></p>
         </div>
      </div>
   </section>
   <section class="booking-stage">
      <div class="booking-flow">
         <div class="booking-step">
            <div class="swiper booking-swiper">
               <div class="swiper-wrapper">
                  <div class="swiper-slide booking-slide">
                     <div class="booking-step-content">
                        <img src="./svg/booking/date.svg" alt="Pin Icon" class="pin-icon" />
                        <span class="booking-step-text">Select Date</span>
                     </div>
                  </div>
                  <div class="swiper-slide booking-slide">
                     <div class="booking-step-content">
                        <img src="./svg/booking/chair.svg" alt="Pin Icon" class="pin-icon" />
                        <span class="booking-step-text">Choose Seats</span>
                     </div>
                  </div>
                  <div class="swiper-slide booking-slide">
                     <div class="booking-step-content">
                        <img src="/svg/booking/ticket_type.svg" alt="Pin Icon" class="pin-icon" />
                        <span class="booking-step-text">Ticket Type</span>
                     </div>
                  </div>
                  <div class="swiper-slide booking-slide">
                     <div class="booking-step-content">
                        <img src="/svg/booking/extras.svg" alt="Pin Icon" class="pin-icon" />
                        <span class="booking-step-text">Add Extras</span>
                     </div>
                  </div>
                  <div class="swiper-slide booking-slide">
                     <div class="booking-step-content">
                        <img src="/svg/booking/confirm_booking.svg" alt="Pin Icon" class="pin-icon" />
                        <span class="booking-step-text">Confirm Booking</span>
                     </div>
                  </div>
               </div>
               <div class="swiper-pagination"></div>
            </div>
         </div>
         <div class="booking-process">
            <div class="left">
               <img id="prevSlide" src="svg/booking/left_booking.svg" alt=" "
                  class="booking-nav-button booking-nav-button-left" />
            </div>
            <div class="content-area">
               <form method="post" action="php/bookinglogic.php" id="bookingForm">
                  <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                  <!-- Here we are using the screening divs which is the first step of the booking process -->
                  <!-- By default we'll show it (display: grid;) -->
                  <div class="venue-list" style="display: grid;">
                     <!-- For each screenings we will create a radio button with the screening date and time -->
                     <?php foreach ($screenings as $screeningRow): ?>
                        <label class="venue-option">
                           <div class="radio-wrapper-13">
                              <label for="example-13-<?php echo $screeningRow['movie_id']; ?>">
                                 <input id="example-13-<?php echo $screeningRow['movie_id']; ?>" type="radio" name="screening_id"
                                    value="<?php echo $screeningRow['movie_id']; ?>">
                                 <span class="rdo"></span>
                              </label>
                           </div>
                           <div class="venue-details">
                              <span
                                 class="venue-name"><?php echo htmlspecialchars(formatDate($screeningRow['screening_date'])); ?></span>
                              <span class="venue-availability">
                                 <?php
                                 echo htmlspecialchars(formatDate($screeningRow['start_time'], 'H:i'));
                                 echo ' - ';
                                 echo htmlspecialchars(formatDate($screeningRow['end_time'], 'H:i'));
                                 ?>
                              </span>
                           </div>
                        </label>
                     <?php endforeach; ?>
                  </div>
                  <!-- This is the second step of the booking process, where we select seats -->
                  <div class="venue-list2" style="display: none">
                     <div class="left-seats">
                        <table>
                           <tr>
                              <td></td>
                              <td>
                                 <p>1</p>
                              </td>
                              <td>
                                 <p>2</p>
                              </td>
                              <td>
                                 <p>3</p>
                              </td>
                              <td>
                                 <p>4</p>
                              </td>
                              <td>
                                 <p>5</p>
                              </td>
                           </tr>
                           <!-- Basically what this is doing is creating a table with 6 rows (A to F) and 5 columns (1 to 5) -->
                           <?php
                           // Loop through the rows A to F and create a checkbox for each seat
                           foreach (range('A', 'F') as $row_letter) {
                              echo '<tr><td><p>' . $row_letter . '</p></td>';
                              // Loop through the seat numbers 1 to 5
                              for ($i = 1; $i <= 5; $i++) {
                                 // Create a unique seat ID by combining the row letter and seat number
                                 $seat_id = $row_letter . $i;
                                 echo '<td>
                                       <div class="checkbox-wrapper">
                                           <input id="checkbox-' . $seat_id . '" type="checkbox" name="seats[]" value="' . $seat_id . '">
                                           <label for="checkbox-' . $seat_id . '">
                                               <div class="box"></div>
                                           </label>
                                       </div>
                                   </td>';
                              }
                              echo '</tr>';
                           }
                           ?>
                        </table>
                     </div>
                  </div>
                  <!-- This is the third step of the booking process, where we select the ticket type -->
                  <div class="venue-list4" style="display: none;">
                     <!-- Adult Tickets -->
                     <div class="venue-option">
                        <div class="venue-details">
                           <span class="venue-name">Adult Tickets</span>
                           <span class="venue-availability">Age 18+</span>
                           <div class="quantity">
                              <button type="button" class="minus" aria-label="Decrease">&minus;</button>
                              <input type="number" class="input-box" name="adult_tickets" value="0" min="0" max="10">
                              <button type="button" class="plus" aria-label="Increase">&plus;</button>
                           </div>
                        </div>
                     </div>
                     <!-- Child Tickets -->
                     <div class="venue-option">
                        <div class="venue-details">
                           <span class="venue-name">Child Tickets</span>
                           <span class="venue-availability">Under 12 years</span>
                           <div class="quantity">
                              <button type="button" class="minus" aria-label="Decrease">&minus;</button>
                              <input type="number" class="input-box" name="child_tickets" value="0" min="0" max="10">
                              <button type="button" class="plus" aria-label="Increase">&plus;</button>
                           </div>
                        </div>
                     </div>
                     <!-- Senior Tickets -->
                     <div class="venue-option">
                        <div class="venue-details">
                           <span class="venue-name">Senior Tickets</span>
                           <span class="venue-availability">65+ years</span>
                           <div class="quantity">
                              <button type="button" class="minus" aria-label="Decrease">&minus;</button>
                              <input type="number" class="input-box" name="senior_tickets" value="0" min="0" max="10">
                              <button type="button" class="plus" aria-label="Increase">&plus;</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- This is the fourth step of the booking process, where we add extras like popcorn and drinks -->
                  <div class="venue-list5" style="display:none;">
                     <div class="venue-option">
                        <div class="venue-details">
                           <div class="movie-details-row">
                              <img src="./svg/booking/popcorn.svg" alt="Popcorn" class="movie-snacks">
                              <div class="movie-details-column">
                                 <span class="venue-name">Popcorn</span>
                                 <span class="options-subtitle">Small</span>
                              </div>
                           </div>
                           <div class="quantity">
                              <button type="button" class="minus" aria-label="Decrease">&minus;</button>
                              <input type="number" class="input-box" name="popcorn" value="0" min="0" max="10">
                              <button type="button" class="plus" aria-label="Increase">&plus;</button>
                           </div>
                        </div>
                     </div>
                     <div class="venue-option">
                        <div class="venue-details">
                           <div class="movie-details-row">
                              <img src="./svg/booking/drink.svg" alt="Drink" class="movie-snacks">
                              <div class="movie-details-column">
                                 <span class="venue-name">Drink</span>
                                 <span class="options-subtitle">Small</span>
                              </div>
                           </div>
                           <div class="quantity">
                              <button type="button" class="minus" aria-label="Decrease">&minus;</button>
                              <input type="number" class="input-box" name="drink" value="0" min="0" max="10">
                              <button type="button" class="plus" aria-label="Increase">&plus;</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- This is the final step of the booking process, where we confirm the booking -->
                  <div class="venue-list6" style="display:none;">
                     <div class="venue-option booking-summary">
                        <div class="venue-details">
                           <span class="venue-name">Date</span>
                           <span class="options-subtitle"></span>
                        </div>
                     </div>
                     <div class="venue-option booking-summary">
                        <div class="venue-details">
                           <span class="venue-name">Seats</span>
                           <span class="options-subtitle"></span>
                        </div>
                     </div>
                     <div class="venue-option booking-summary">
                        <div class="venue-details">
                           <span class="venue-name">Ticket Type</span>
                           <span class="options-subtitle"></span>
                        </div>
                     </div>
                     <div class="venue-option booking-summary">
                        <div class="venue-details">
                           <span class="venue-name">Popcorn</span>
                           <span class="options-subtitle"></span>
                        </div>
                     </div>
                     <div class="venue-option booking-summary">
                        <div class="venue-details">
                           <span class="venue-name">Drinks</span>
                           <span class="options-subtitle"></span>
                        </div>
                     </div>
                     <button id="confirmBookingBtn" type="submit" form="bookingForm">Confirm Booking</button>
                  </div>
            </div>
            <div class="right">
               <img id="nextSlide" src="svg/booking/right_booking.svg" alt=" "
                  class="booking-nav-button booking-nav-button-right" />
            </div>
         </div>
      </div>
   </section>
   <br />
   <br />
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
      // Single DOMContentLoaded handler with all initialization
      document.addEventListener('DOMContentLoaded', function () {
         // Basically this is checking if it can find booking_success in the URL parameters
         // getting everything after the ? in the URL
         const urlParams = new URLSearchParams(window.location.search);
         if (urlParams.get('booking_success') === '1') {
            Swal.fire({
               icon: 'success',
               title: 'Booking Successful!',
               text: 'Your tickets have been booked successfully.',
               timer: 3000,
               showConfirmButton: false
            });
         }

         // Initialize Swiper
         var swiper = new Swiper(".booking-swiper", {
            allowTouchMove: false,
            slidesPerView: 1,
            pagination: {
               el: ".swiper-pagination",
               type: "progressbar",
            },
         });
         // Setup navigation buttons
         const nextButton = document.getElementById('nextSlide');
         const prevButton = document.getElementById('prevSlide');

         // function to update visibility of venue lists based on active slide
         function updateVenueListVisibility() {
            const activeIndex = swiper.activeIndex;
            // toggle them all off
            document.querySelectorAll('[class^="venue-list"]').forEach(el => {
               el.style.display = 'none';
            });
            // So if the active index is 0, we show the first venue list and etc 
            if (activeIndex === 0) {
               document.querySelector('.venue-list').style.display = 'grid';
            }
            else if (activeIndex === 1) {
               document.querySelector('.venue-list2').style.display = 'grid';
            } else if (activeIndex === 2) {
               document.querySelector('.venue-list4').style.display = 'grid';
            } else if (activeIndex === 3) {
               document.querySelector('.venue-list5').style.display = 'grid';
            } else if (activeIndex === 4) {
               document.querySelector('.venue-list6').style.display = 'grid';

               // Here we are checking if screening radio is checked where input has name screening_id and is checked 
               const screeningRadio = document.querySelector('input[name="screening_id"]:checked');
               // Here we find the closest ancestor element with class venue-option and then find the venue name inside it
               const screeningDate = screeningRadio ? screeningRadio.closest('.venue-option').querySelector('.venue-name').textContent :'Not selected';
               // Here we are getting all the checked seats and joining them with a comma
               const seats = Array.from(document.querySelectorAll('input[name="seats[]"]:checked'))
                  .map(checkbox => checkbox.value).join(', ') || 'None';
               // Here we are getting the values of the ticket types and parsing them to integers, otherwise defaulting to zero
               const adult = parseInt(document.querySelector('[name="adult_tickets"]').value) || 0;
               const child = parseInt(document.querySelector('[name="child_tickets"]').value) || 0;
               const senior = parseInt(document.querySelector('[name="senior_tickets"]').value) || 0;
               const popcorn = parseInt(document.querySelector('[name="popcorn"]').value) || 0;
               const drinks = parseInt(document.querySelector('[name="drink"]').value) || 0;

               // Update summary values
               document.querySelectorAll('.venue-option.booking-summary').forEach(option => {
                  // removing white space 
                  const name = option.querySelector('.venue-name').textContent.trim();
                  const subtitle = option.querySelector('.options-subtitle');
                  // simple switch that checks the name of the venue and then updates the 
                  switch (name) {
                     case 'Date':
                        subtitle.textContent = screeningDate;
                        break;
                     case 'Seats':
                        subtitle.textContent = seats;
                        break;
                     case 'Ticket Type':
                        subtitle.textContent = `${adult} Adult, ${child} Child, ${senior} Senior`;
                        break;
                     case 'Popcorn':
                        subtitle.textContent = popcorn;
                        break;
                     case 'Drinks':
                        subtitle.textContent = drinks;
                        break;
                  }
               });
               // Hide next button on final step
               nextButton.style.display = 'none';
            } else {
               nextButton.style.display = 'block';
            }
         }
         // Validation for next button
         nextButton.addEventListener('click', () => {
            // Validate current step and check if screening id is checked then fire swal
            if (swiper.activeIndex === 0 && !document.querySelector('input[name="screening_id"]:checked')) {
               Swal.fire({
                  icon: 'warning',
                  title: 'Selection Required',
                  text: 'Please select a screening time!'
               });
               return;
            }
            // Validate next step and check if seats are checked
            if (swiper.activeIndex === 1 && !document.querySelector('input[name="seats[]"]:checked')) {
               Swal.fire({
                  icon: 'warning',
                  title: 'Selection Required',
                  text: 'Please select at least one seat!'
               });
               return;
            }
            // Validate next step and check if at least one ticket is selected
            if (swiper.activeIndex === 2) {
               // for example select where name= "adult_tickets" and parse the value to an integer otherwise default to zero
               const adult = parseInt(document.querySelector('[name="adult_tickets"]').value) || 0;
               const child = parseInt(document.querySelector('[name="child_tickets"]').value) || 0;
               const senior = parseInt(document.querySelector('[name="senior_tickets"]').value) || 0;
               // check if all tickets are zero if true then show error 
               if (adult + child + senior < 1) {
                  Swal.fire({
                     icon: 'warning',
                     title: 'Selection Required',
                     text: 'Please select at least one ticket!'
                  });
                  return;
               }
            }
            // Validate next step and check if popcorn or drinks are selected
            swiper.slideNext();
         });
         prevButton.addEventListener('click', () => {
            swiper.slidePrev();
         });
         swiper.on('slideChange', updateVenueListVisibility);
         // Initialize first view
         updateVenueListVisibility();
         // Setup quantity controls
         document.querySelectorAll('.quantity').forEach(quantity => {
            const minus = quantity.querySelector('.minus');
            const plus = quantity.querySelector('.plus');
            const input = quantity.querySelector('input');

            function update() {
               const value = parseInt(input.value) || 0;
               minus.disabled = value <= 0;
               plus.disabled = value >= 10;
            }

            minus.addEventListener('click', () => {
               input.value = Math.max(parseInt(input.value || 0) - 1, 0);
               update();
            });

            plus.addEventListener('click', () => {
               input.value = Math.min(parseInt(input.value || 0) + 1, 10);
               update();
            });

            input.addEventListener('input', () => {
               input.value = Math.min(Math.max(parseInt(input.value || 0), 0), 10);
               update();
            });
            update();
         });
         // Once we click the confirm booking button, we will show a processing message
         document.getElementById('confirmBookingBtn').addEventListener('click', function (e) {
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
            return true;
         });
      });
   </script>
</body>

</html>