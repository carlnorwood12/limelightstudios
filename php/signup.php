<?php
session_start(); // Start the session
include "../db_conn.php"; // Ensure this file sets up the $conn variable

function redirectWithError($error, $data) {
    $data = urlencode($data);
    header("Location: ../register.php?error=$error&$data");
    exit;
}

if (isset($_POST['name'], $_POST['email'], $_POST['pass'], $_POST['dob'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); // Hash the password
    $dob = date("Y-m-d", strtotime($_POST['dob']));
    $birthday = strtotime($dob);
    $difference = time() - $birthday;
    $age = max(0, floor($difference / 31556926)); // Calculate age
    $created = date("Y-m-d H:i:s"); // Current timestamp
    $data = "name=$name&email=$email&dob=$dob";
    $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"; 

    try {
        // Validate password format
        if (!preg_match($password_regex, $pass)) {
            redirectWithError("Please match the requested format for the password.", $data);
        }

        // Determine account type based on age
        $account = ($age < 18) ? 'Junior' : 'Adult';

        // Handle file upload
        if (!empty($_FILES['profile_picture']['name'])) {
            $img_name = $_FILES['profile_picture']['name'];
            $tmp_name = $_FILES['profile_picture']['tmp_name'];
            $error = $_FILES['profile_picture']['error'];

            if ($error === 0) {
                $img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                $allowed_exs = ['jpg', 'jpeg', 'png', 'gif'];
                $max_file_size = 2 * 1024 * 1024; // 2MB max

                if (in_array($img_ex, $allowed_exs) && $_FILES['profile_picture']['size'] <= $max_file_size) {
                    $new_img_name = uniqid($email, true) . '.' . $img_ex;
                    $upload_path = "../upload/" . $new_img_name;

                    // Ensure the upload directory exists
                    if (!is_dir("../upload")) {
                        mkdir("../upload", 0755, true);
                    }

                    move_uploaded_file($tmp_name, $upload_path);

                    // Insert into database with profile picture
                    $sql = "INSERT INTO users(name, email, password, dob, age, profile_picture, account, created) VALUES(?,?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$name, $email, $hashed_pass, $dob, $age, $new_img_name, $account, $created]);
                } else {
                    $error_message = $_FILES['profile_picture']['size'] > $max_file_size 
                        ? "File size exceeds the maximum limit of 2MB" 
                        : "You can't upload files of this type";
                    redirectWithError($error_message, $data);
                }
            } else {
                redirectWithError("Unknown error occurred during file upload!", $data);
            }
        } else {
            // Insert into database without profile picture
            $sql = "INSERT INTO users(name, email, password, dob, age, account, created) VALUES(?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);

            // Debugging: Log the query and values
            error_log("SQL Query: $sql");
            error_log("Values: " . json_encode([$name, $email, $hashed_pass, $dob, $age, $account, $created]));

            $stmt->execute([$name, $email, $hashed_pass, $dob, $age, $account, $created]);
        }

        // Set session variables
        $_SESSION['name'] = $name;
        $_SESSION['user_status'] = $account;

        // Redirect to login page on success
        header("Location: ../login.php?success=Your account has been created successfully!");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            redirectWithError("This email is already being used.", $data);
        } else {
            redirectWithError("Error: " . $e->getMessage(), $data); // Use the actual exception message
        }
    }
} else {
    // Redirect if required fields are not set
    header("Location: ../register.php?error=Please fill all required fields");
    exit;
}