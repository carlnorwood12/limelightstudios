<?php
$hostname = "127.0.0.1";  // Use localhost
$username = "root";
$password = "your_new_password";
$database = "limelightcinema";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>