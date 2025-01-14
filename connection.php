<?php
$username = "root";  // Your MySQL user
$password = "your_new_password";  // Your MySQL password
$hostname = "127.0.0.1";  // Use localhost
$database = "limelightcinema";  // The database you want to connect to

// Specify the socket path

// Create a connection to the MySQL server
$dbhandle = mysqli_connect($hostname, $username, $password, $database)
or die("Could not connect to database");

// Select the database
$selected = mysqli_select_db($dbhandle, $database) or die("Could not select database");
?>
