<?php
session_start(); // Start the session
include "../db_conn.php"; // Ensure this file sets up the $conn variable


// Function to redirect with error message that'll redirect to the contact page with error and data and show the specific error message
function redirectWithError($error, $data) {
    $data = urlencode($data);
    header("Location: ../contact.php?error=$error&$data");
    exit;
}

// Check if the required fields are set in the POST request
if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // prepare the data to be sent back in case of error
    $data = "name=$name&email=$email&message=$message";

    try {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirectWithError("Please enter a valid email address.", $data);
        }
        // Insert into messages table 
        $sql = "INSERT INTO messages(name, email, message) VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $email, $message]);
        // Redirect to contact page on success
        header("Location: ../contact.php?success=Your message has been sent successfully!");
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