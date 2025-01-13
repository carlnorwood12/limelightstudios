<?php
$username = "phpmyadmin";  // Your MySQL user
$password = "Str0ngPassword!2025";  // Your MySQL password
$hostname = "127.0.0.1";  // Use localhost
$database = "phpmyadmin";  // The database you want to connect to

// Specify the socket path
$socket = '/var/run/mysqld/mysqld.sock';  // Adjust this path if needed

// Create a connection to the MySQL server
$dbhandle = mysqli_connect($hostname, $username, $password, $database, null, $socket)
or die("Could not connect to database");

// Select the database
$selected = mysqli_select_db($dbhandle, $database) or die("Could not select database");
?>
