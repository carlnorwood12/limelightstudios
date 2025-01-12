<?php

$username = "root";
$password = "test123";
$hostname = "127.0.0.1";
$database = "limelight_cinemas";

$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");
$selected = mysqli_select_db($dbhandle, $database) or die("Could not select database");

?>