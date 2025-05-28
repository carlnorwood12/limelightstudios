<?php
session_start(); // Start the session
include "../db_conn.php"; // Ensure this file sets up the $conn variable

// Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted)
$current_date = "2025-05-15 18:14:35";
$current_user = "carlnorwood12";

function redirectWithError($error, $data) {
    $data = urlencode($data);
    header("Location: ../contact.php?error=$error&$data");
    exit;
}

if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $data = "name=$name&email=$email&message=$message";

    try {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirectWithError("Please enter a valid email address.", $data);
        }

        // Insert into messages table
        $sql = "INSERT INTO messages(name, email, message) VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);

        // Debugging: Log the query and values
        error_log("SQL Query: $sql");
        error_log("Values: " . json_encode([$name, $email, $message]));

        $stmt->execute([$name, $email, $message]);

        // Redirect to contact page on success
        header("Location: ../contact.php?success=Your message has been sent successfully! We'll get back to you soon.");
        exit;
    } catch (PDOException $e) {
        redirectWithError("Error: " . $e->getMessage(), $data); // Use the actual exception message
    }
} else {
    // Redirect if required fields are not set
    header("Location: ../contact.php?error=Please fill all required fields");
    exit;
}
?>