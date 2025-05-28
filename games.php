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
      <style>
         body {
         font-family: Arial, sans-serif;
         background: url("./svg/quiz_gradient.svg") center center / cover no-repeat;
         background-color: #170107;
         margin: 0;
         padding: 20px;
         }
         .container {
         max-width: 800px;
         margin: 0 auto;
         padding: 20px;
         }
         .header {
         display: flex;
         justify-content: space-between;
         padding-bottom: 10px;
         margin-bottom: 20px;
         color: white;
         }
         .quiz-card {
         border-radius: 8px;
         padding: 20px;
         margin-bottom: 20px;
         color: white;
         }
         .question {
         display: flex;
         margin-bottom: 20px;
         padding-bottom: 15px;
         border-bottom: 1px dashed #FFFFFF26;
         }
         .question:last-child {
         border-bottom: none;
         }
         .question-image {
         flex: 0 0 200px;
         margin-right: 20px;
         display: flex;
         align-items: flex-start;
         justify-content: flex-start;
         }
         .emoji-container {
         flex: 0 0 200px;
         margin-right: 20px;
         display: flex;
         align-items: center;
         justify-content: center;
         }
         .question-content {
         flex: 1;
         }
         .question-options {
         display: flex;
         flex-direction: column;
         }
         .button-container {
         display: flex;
         justify-content: center;
         margin-top: 20px;
         }
         button {
         background-color: #f0ff9e !important;
         user-select: none;
         display: inline-flex;
         justify-content: center;
         align-items: center;
         gap: 5px;
         border: none;
         font-family: inherit;
         font-size: 15px;
         font-weight: 700;
         white-space: nowrap;
         text-decoration: none;
         background-image: radial-gradient(66% 66% at 26% 20%, rgba(255, 255, 255, 0.55) 0%, rgba(255, 255, 255, 0) 69.79%, rgba(255, 255, 255, 0) 100%);
         border-radius: 50px;
         cursor: pointer;
         transition: transform 0.25s ease, filter 0.3s ease;
         z-index: 99;
         height: 45px;
         min-height: 45px;
         width: 100%;
         max-width: 200px;
         color: #000000;
         }
         button:hover {
         filter: brightness(1.15);
         }
         .emoji {
         font-size: 70px;
         display: block;
         text-align: center;
         }
         .pixelated-movie {
         width: 100%;
         max-width: 200px;
         border-radius: 10px;
         margin: 0;
         }
         .results {
         color: white;
         margin-top: 20px;
         font-size: 20px; 
         text-align: center;
         padding: 14px;
         }
         img {
         width: 100%;
         max-width: 400px;
         height: auto;
         display: block;
         margin: 0 auto 50px;
         }
         /* Radio button styling */
         .radio-wrapper-13 {
         margin-bottom: 10px;
         }
         .radio-wrapper-13 .rdo {
         position: relative;
         display: inline-block;
         width: 18px;
         height: 18px;
         border-radius: 10px;
         background-color: rgba(255, 255, 255, 0.05);
         transition: all 0.15s ease;
         margin-right: 10px;
         vertical-align: middle;
         }
         .radio-wrapper-13 .rdo:after {
         content: "";
         position: absolute;
         display: block;
         top: calc(50% - 3.5px);
         left: calc(50% - 3.5px);
         width: 7px;
         height: 7px;
         border-radius: 50%;
         background: #fff;
         opacity: 0;
         transform: scale(0);
         }
         .radio-wrapper-13 label {
         display: flex;
         align-items: center;
         cursor: pointer;
         margin-bottom: 8px;
         color: #FFFFFF80;
         }
         .radio-wrapper-13 input[type="radio"] {
         position: absolute;
         opacity: 0;
         }
         .radio-wrapper-13 input[type="radio"]:checked + .rdo {
         background-image: linear-gradient(#9ca1ed, #5962e1);
         }
         .radio-wrapper-13 input[type="radio"]:checked + .rdo:after {
         opacity: 1;
         transform: scale(1);
         transition: all 0.15s ease;
         }
         /* For mobile responsiveness */
         @media (max-width: 600px) {
         .question {
         flex-direction: column;
         }
         .question-image, .emoji-container {
         flex: 0 0 auto;
         width: auto;
         margin-bottom: 15px;
         margin-right: 0;
         justify-content: flex-start;
         }
         .pixelated-movie {
         max-width: 150px;
         height: auto;
         }
         .emoji {
         font-size: 50px;
         text-align: left;
         }
         }
      </style>
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