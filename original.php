<?php
// Start the session
session_start();

// Example DOB from the database (you should retrieve this from the DB in a real scenario)
$dob = '1985-06-06';

// Split the DOB into year, month, and day
list($year, $month, $day) = explode('-', $dob); // Correct usage of explode

// Convert the DOB into a Unix timestamp (the number of seconds since the Unix epoch)
$birthday = mktime(0, 0, 0, $month, $day, $year);

// Output some debug information
echo "This represents the total amount of seconds that have passed between the Unix epoch and DOB: " . $birthday . "<br />";
echo "This represents the total amount of seconds that have passed between the Unix epoch and now: " . time() . "<br />";

// Calculate the difference in seconds between the current time and the user's birthday
$difference = time() - $birthday;
echo "This represents the total amount of seconds the user has been on the planet: " . $difference . "<br />";

// Calculate the age by dividing the difference by the number of seconds in a year (approx. 31556926 seconds)
$age = floor($difference / 31556926); // floor to get the complete years
echo "This represents the user's age: " . $age . "<br />";

// Use the $age variable as part of the condition in the IF statement
// If the user is 18 or older, set an 'adult' session, otherwise set a 'junior' session
if ($age >= 18) {
    $_SESSION['user_status'] = 'adult';
    echo "User is 18 or older. Setting session to 'adult'.<br />";
} else {
    $_SESSION['user_status'] = 'junior';
    echo "User is under 18. Setting session to 'junior'.<br />";
}

?>
