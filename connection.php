<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "your_new_password";
$database = "limelightcinema";

$dbhandle = mysqli_connect($hostname, $username, $password, $database) or die("Could not connect to database");
$mysql = $dbhandle;

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>