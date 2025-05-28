<?php
$hostname = "127.0.0.1";  // Use localhost
$username = "root";
$password = "your_new_password";
$database = "limelightcinema";
$dbhandle = mysqli_connect($hostname, $username, $password, $database) or die("Could not connect to database");
?>