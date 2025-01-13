<?php

$username = "phpmyadmin";  // Your MySQL user
$password = "Str0ngPassword!2025";  // Your MySQL password
$hostname = "192.168.1.100";  // Replace with your MySQL server's IP address
$database = "phpmyadmin";  // The database you want to connect to

// Create a connection to the MySQL server
$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

// Select the database
$selected = mysqli_select_db($dbhandle, $database) or die("Could not select database");

?>
