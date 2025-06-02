<?php
   // Score tracking
   $score = 0;
   $submitted = false;
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST')
   {
       $submitted = true;
       // Check answers for "Who's more popular" section
       if (isset($_POST['popular1']) && $_POST['popular1'] === 'a') $score++; // Correct is Leonardo DiCaprio
       if (isset($_POST['popular2']) && $_POST['popular2'] === 'c') $score++; // Correct is Scarlett Johansson
       if (isset($_POST['popular3']) && $_POST['popular3'] === 'c') $score++; // Correct is Robert Downey Jr.
       
       // Check answers for "Guess the pixelated movie" section
       if (isset($_POST['pixelated1']) && $_POST['pixelated1'] === 'a') $score++; // Correct is Get Out
       if (isset($_POST['pixelated2']) && $_POST['pixelated2'] === 'b') $score++; // Correct is Moana
       if (isset($_POST['pixelated3']) && $_POST['pixelated3'] === 'b') $score++; // Correct is Harry Potter
       
       // Check answers for "Guess the movie from emoji" section
       if (isset($_POST['emoji1']) && $_POST['emoji1'] === 'c') $score++; // Correct is Up
       if (isset($_POST['emoji2']) && $_POST['emoji2'] === 'b') $score++; // Correct is Frozen
       if (isset($_POST['emoji3']) && $_POST['emoji3'] === 'a') $score++; // Correct is The Lion King
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Movie Quiz</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./css/games.css">
   </head>
   <body>
      <div class="container">
         <img src="https://ik.imagekit.io/carl/limelight/quiztime.png?updatedAt=1747322108554" alt="Logo" class="quiz-image">
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
                     <img src="https://ik.imagekit.io/carl/limelight/getout.webp?updatedAt=1747323243483" alt="Pixelated Movie 1" class="pixelated-movie">
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
                     <img src="https://ik.imagekit.io/carl/limelight/moana2.png?updatedAt=1747324306539" alt="Pixelated Movie 2" class="pixelated-movie">
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
                     <img src="https://ik.imagekit.io/carl/limelight/harrypotter.webp?updatedAt=1747324489441" alt="Pixelated Movie 3" class="pixelated-movie">
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
      <script src="/js/gsap.js" defer></script>
   </body>
</html>