<?php
// Start the session allowing us to access session variables for user information
session_start();

// Include the database connection file
include 'connection.php';
global $dbhandle; // Make sure $dbhandle is accessible globally
// Check if the user is logged in with cookies
if (isset($_COOKIE['logged_in'])) {
   // Ensures the username is safe to use in a SQL query
   $username = mysqli_real_escape_string($dbhandle, $_COOKIE['logged_in']);
   // Query selecting everything from the users table where the name matches the cookie
   $query = "SELECT * FROM users WHERE name='{$_COOKIE['logged_in']}'";
   // Execute the query and get the results
   $result = mysqli_query($dbhandle, $query);
   // Convert the result into an associative array
   $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
   // If the profile picture is not empty, set the file path
   if (!empty($user['profile_picture'])) {
      // set $filePath to the profile picture path, ensuring it's safe for HTML output
      $filePath = htmlspecialchars($user['profile_picture']);
   }
}

// Score tracking
$score = 0;
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $submitted = true;
   // Check answers for "Who's more popular" section
   if (isset($_POST['popular1']) && $_POST['popular1'] === 'a')
      $score++; // Correct is Leonardo DiCaprio
   if (isset($_POST['popular2']) && $_POST['popular2'] === 'c')
      $score++; // Correct is Scarlett Johansson
   if (isset($_POST['popular3']) && $_POST['popular3'] === 'c')
      $score++; // Correct is Robert Downey Jr.

   // Check answers for "Guess the pixelated movie" section
   if (isset($_POST['pixelated1']) && $_POST['pixelated1'] === 'a')
      $score++; // Correct is Get Out
   if (isset($_POST['pixelated2']) && $_POST['pixelated2'] === 'b')
      $score++; // Correct is Moana
   if (isset($_POST['pixelated3']) && $_POST['pixelated3'] === 'b')
      $score++; // Correct is Harry Potter

   // Check answers for "Guess the movie from emoji" section
   if (isset($_POST['emoji1']) && $_POST['emoji1'] === 'c')
      $score++; // Correct is Up
   if (isset($_POST['emoji2']) && $_POST['emoji2'] === 'b')
      $score++; // Correct is Frozen
   if (isset($_POST['emoji3']) && $_POST['emoji3'] === 'a')
      $score++; // Correct is The Lion King
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Movie Quiz</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/games.css">
   <link rel="stylesheet" href="./css/menu.css">
   <link rel="stylesheet" href="./css/footer.css">
</head>

<body>


   <!-- Header -->
   <header>
      <a class="hamburger-icon">
         <span></span>
         <span></span>
         <span></span>
      </a>
      <img src="/svg/logo/limelight.svg" id="limelight-logo" />
   </header>
   <!-- Header -->
   <!-- Menu Overlay -->
   <div class="menu-overlay">
      <div class="menu-cols">
         <div class="col-2">
            <div class="first-menu-item">
               <div class="profile-section">
                  <div class="profile-image-container">
                     <img class="profile-image"
                        src="upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>"
                        alt="Profile Picture">
                  </div>
                  <div class="profile-info">
                     <h3 class="profile-name"><?= $_SESSION['name'] ?? "Please login" ?></h3>
                     <p class="profile-role"><?= $_SESSION['user_status'] ?? "To view account details" ?></p>
                     <div class="row-buttons">
                        <?php
                        // If the user_status is set, show different buttons based on the user type
                        if (isset($_SESSION['user_status']) && ($_SESSION['user_status'] === 'Admin' || $_SESSION['user_status'] === 'Adult')):
                           ?>
                           <?php if ($_SESSION['user_status'] === 'Admin'): ?>
                              <a href="adminpanel/dashboard.php">
                                 <button class="nav-buttons dashboard">
                                    <img src="/svg/adminpanel/dashboard.svg" alt="dashboard" class="menu-icon">
                                    Dashboard
                                 </button>
                              </a>
                           <?php elseif ($_SESSION['user_status'] === 'Adult'): ?>
                              <a href="./adultpanel/bookings.php">
                                 <button class="nav-buttons dashboard">
                                    <img src="/svg/adminpanel/bookings.svg" alt="bookings" class="menu-icon">
                                    Bookings
                                 </button>
                              </a>
                           <?php endif; ?>
                           <!-- Both Admin and Adult users see Profile -->
                           <a
                              href="<?= $_SESSION['user_status'] === 'Admin' ? './adminpanel/profile-admin.php' : './adultpanel/profile.php' ?>">
                              <button class="nav-buttons settings">
                                 <img src="/svg/adminpanel/profile.svg" alt="settings" class="menu-icon">
                                 Profile
                              </button>
                           </a>
                        <?php elseif (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'): ?>
                           <!-- Junior users only can see the Profile -->
                           <a href="./adultpanel/profile.php">
                              <button class="nav-buttons settings">
                                 <img src="/svg/adminpanel/profile.svg" alt="settings" class="menu-icon">
                                 Profile
                              </button>
                           </a>
                        <?php else: ?>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="second-menu-item">
               <!-- Search functionality -->
               <div class="search-contain">
                  <img src="/svg/menu/search.svg" id="log-in" alt="log-in">
                  <input id="search-nav" type="text" placeholder="Search anything..." spellcheck="false">
                  <div class="result">
                     <p></p>
                  </div>
                  <img src="https://ik.imagekit.io/carl/limelight/go-right.svg?updatedAt=1748539460270" id="go-right"
                     alt="enter movie">
               </div>
               <!-- Menu links -->
               <div class="menu-link"><a href="index.html">Home</a></div>
               <div class="menu-link"><a href="venues.php">Venues</a></div>
               <div class="menu-link"><a href="contact.php">Contact</a></div>
               <div class="menu-link"><a href="about.php">About</a></div>
               <?php
               // If user_status is set to 'Junior', show the Games link
               if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'Junior'):
                  ?>
                  <div class="menu-link"><a href="games.php">Games</a></div>
               <?php endif; ?>
            </div>
            <!-- Login / Logout Buttons -->
            <div class="third-menu-item">
               <a href="logout.php">
                  <button class="arrow-btn exit-btn">
                     <span class="arrow-icon">
                        <img src="/svg/menu/logout.svg" alt="exit">
                        Logout
                     </span>
                  </button>
               </a>
               <a href="register.php">
                  <button class="arrow-btn login-btn">
                     <span class="arrow-icon">
                        Login / Register
                        <img src="/svg/menu/login.svg" alt="login">
                     </span>
                  </button>
               </a>
            </div>
         </div>
      </div>
   </div>
   <div class="container">
      <img src="https://ik.imagekit.io/carl/limelight/quiztime.png?updatedAt=1747322108554" alt="Logo"
         class="quiz-image">
      <form method="post">
         <div class="quiz-card">
            <div class="question">
               <div class="question-content">
                  <h3>1. Who's more popular?</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="popular1-a">
                           <input id="popular1-a" type="radio" name="popular1" value="a">
                           <span class="rdo"></span>
                           Leonardo DiCaprio
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular1-b">
                           <input id="popular1-b" type="radio" name="popular1" value="b">
                           <span class="rdo"></span>
                           Tom Cruise
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular1-c">
                           <input id="popular1-c" type="radio" name="popular1" value="c">
                           <span class="rdo"></span>
                           Brad Pitt
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="question-content">
                  <h3>2. Who's more popular?</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="popular2-a">
                           <input id="popular2-a" type="radio" name="popular2" value="a">
                           <span class="rdo"></span>
                           Jennifer Lawrence
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular2-b">
                           <input id="popular2-b" type="radio" name="popular2" value="b">
                           <span class="rdo"></span>
                           Emma Stone
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular2-c">
                           <input id="popular2-c" type="radio" name="popular2" value="c">
                           <span class="rdo"></span>
                           Scarlett Johansson
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="question-content">
                  <h3>3. Who's more popular?</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="popular3-a">
                           <input id="popular3-a" type="radio" name="popular3" value="a">
                           <span class="rdo"></span>
                           Chris Hemsworth
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular3-b">
                           <input id="popular3-b" type="radio" name="popular3" value="b">
                           <span class="rdo"></span>
                           Chris Evans
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="popular3-c">
                           <input id="popular3-c" type="radio" name="popular3" value="c">
                           <span class="rdo"></span>
                           Robert Downey Jr.
                        </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Guess the pixelated movie section -->
         <div class="quiz-card">
            <div class="question">
               <div class="question-image">
                  <img src="https://ik.imagekit.io/carl/limelight/getout.webp?updatedAt=1747323243483"
                     alt="Pixelated Movie 1" class="pixelated-movie">
               </div>
               <div class="question-content">
                  <h3>4. Guess the pixelated movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="pixelated1-a">
                           <input id="pixelated1-a" type="radio" name="pixelated1" value="a">
                           <span class="rdo"></span>
                           Get Out
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated1-b">
                           <input id="pixelated1-b" type="radio" name="pixelated1" value="b">
                           <span class="rdo"></span>
                           Passing
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated1-c">
                           <input id="pixelated1-c" type="radio" name="pixelated1" value="c">
                           <span class="rdo"></span>
                           The Lighthouse
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="question-image">
                  <img src="https://ik.imagekit.io/carl/limelight/moana2.png?updatedAt=1747324306539"
                     alt="Pixelated Movie 2" class="pixelated-movie">
               </div>
               <div class="question-content">
                  <h3>5. Guess the pixelated movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="pixelated2-a">
                           <input id="pixelated2-a" type="radio" name="pixelated2" value="a">
                           <span class="rdo"></span>
                           Finding Nemo
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated2-b">
                           <input id="pixelated2-b" type="radio" name="pixelated2" value="b">
                           <span class="rdo"></span>
                           Moana
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated2-c">
                           <input id="pixelated2-c" type="radio" name="pixelated2" value="c">
                           <span class="rdo"></span>
                           Atlantis
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="question-image">
                  <img src="https://ik.imagekit.io/carl/limelight/harrypotter.webp?updatedAt=1747324489441"
                     alt="Pixelated Movie 3" class="pixelated-movie">
               </div>
               <div class="question-content">
                  <h3>6. Guess the pixelated movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="pixelated3-a">
                           <input id="pixelated3-a" type="radio" name="pixelated3" value="a">
                           <span class="rdo"></span>
                           Star Wars
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated3-b">
                           <input id="pixelated3-b" type="radio" name="pixelated3" value="b">
                           <span class="rdo"></span>
                           Harry Potter
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="pixelated3-c">
                           <input id="pixelated3-c" type="radio" name="pixelated3" value="c">
                           <span class="rdo"></span>
                           The Matrix
                        </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Guess the movie from emoji section -->
         <div class="quiz-card">
            <div class="question">
               <div class="emoji-container">
                  <span class="emoji">🎈🏠👴</span>
               </div>
               <div class="question-content">
                  <h3>7. Guess the movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="emoji1-a">
                           <input id="emoji1-a" type="radio" name="emoji1" value="a">
                           <span class="rdo"></span>
                           Inside Out
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji1-b">
                           <input id="emoji1-b" type="radio" name="emoji1" value="b">
                           <span class="rdo"></span>
                           Home Alone
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji1-c">
                           <input id="emoji1-c" type="radio" name="emoji1" value="c">
                           <span class="rdo"></span>
                           Up
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="emoji-container">
                  <span class="emoji">❄️👸🏼☃️</span>
               </div>
               <div class="question-content">
                  <h3>8. Guess the movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="emoji2-a">
                           <input id="emoji2-a" type="radio" name="emoji2" value="a">
                           <span class="rdo"></span>
                           Ice Age
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji2-b">
                           <input id="emoji2-b" type="radio" name="emoji2" value="b">
                           <span class="rdo"></span>
                           Frozen
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji2-c">
                           <input id="emoji2-c" type="radio" name="emoji2" value="c">
                           <span class="rdo"></span>
                           The Polar Express
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="question">
               <div class="emoji-container">
                  <span class="emoji">🦁👑🌅</span>
               </div>
               <div class="question-content">
                  <h3>9. Guess the movie:</h3>
                  <div class="question-options">
                     <div class="radio-wrapper-13">
                        <label for="emoji3-a">
                           <input id="emoji3-a" type="radio" name="emoji3" value="a">
                           <span class="rdo"></span>
                           The Lion King
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji3-b">
                           <input id="emoji3-b" type="radio" name="emoji3" value="b">
                           <span class="rdo"></span>
                           Madagascar
                        </label>
                     </div>
                     <div class="radio-wrapper-13">
                        <label for="emoji3-c">
                           <input id="emoji3-c" type="radio" name="emoji3" value="c">
                           <span class="rdo"></span>
                           Jungle Book
                        </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="button-container">
            <button type="submit">Check Results</button>
         </div>
      </form>
      <?php if ($submitted): ?>
         <h2 class="results">
            <?php
            if ($score < 5) {
               echo "<span style='color: #ff5353;'>Tough luck! $score / 9</span>";
            } elseif ($score >= 5 && $score <= 8) {
               echo "<span style='color: #dcff53;'>Not bad! $score / 9</span>";
            } else {
               echo "<span style='color: #75ff53;'>Well done! $score / 9</span>";
            }
            ?>
         </h2>
      <?php endif; ?>
   </div>
   <footer>
      <div class="mx-auto max-w-screen-xl space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 lg:px-8">
         <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div>
               <p class="font-bold" style="color: #9ca1ed;">Links</p>
               <ul class="mt-6 space-y-4 text-sm">
                  <li><a href="/" class="text-white transition" style="opacity: 0.5; transition: opacity 0.3s ease;"
                        onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">Home</a></li>
                  <li><a href="/venues.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">Venues</a></li>
                  <li><a href="/contact.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">Contact</a></li>
                  <li><a href="/about.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">About</a></li>
               </ul>
            </div>
            <div>
               <p class="font-bold" style="color: #9ca1ed;">Account</p>
               <ul class="mt-6 space-y-4 text-sm">
                  <li><a href="/adultpanel/profile.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">My Account</a></li>
                  <li><a href="/adultpanel/bookings.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">My Bookings</a></li>
                  <li><a href="/adultpanel/saved.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">My Saved</a></li>
               </ul>
            </div>
            <div>
               <p class="font-bold" style="color: #9ca1ed;">Entertainment</p>
               <ul class="mt-6 space-y-4 text-sm">
                  <li><a href="/games.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">Games</a></li>
               </ul>
            </div>
            <div>
               <p class="font-bold" style="color: #9ca1ed;">Legal</p>
               <ul class="mt-6 space-y-4 text-sm">
                  <li><a href="/terms.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">Terms and Conditions</a></li>
                  <li><a href="/privacy.php" class="text-white transition"
                        style="opacity: 0.5; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0.5'">Privacy Policy</a></li>
               </ul>
            </div>
         </div>
         <p class="text-xs text-gray-500 dark:text-gray-400">
            &copy; 2025 Limelight Cinemas. All rights reserved.
         </p>
      </div>
   </footer>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="/js/script.js" defer></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
   <script src="/js/gsap.js" defer></script>
</body>

</html>