<?php
session_start();

// Check if the email and password are set in the POST request
if (isset($_POST['email']) && isset($_POST['pass'])) 
{
    include "../connection.php";
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $data = "email=" . $email;
    // if the email or password is empty, redirect to login page with error message
    if (empty($email)) {
        $em = "Email is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else if (empty($pass)) {
        $em = "Password is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } 
    // if its not empty 
    else 
    {
        // select everything from users where email matches the input email
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        // if the row count is 1, it means the email exists in the database
        if ($stmt->rowCount() == 1) 
        {
            // fetch the user data
            $user = $stmt->fetch();
            $email = $user['email'];
            $password = $user['password'];
            $name = $user['name'];
            $id = $user['id'];
            $profile_picture = $user['profile_picture'];
            // check if the password matches the hashed password in the database
            if (password_verify($pass, $password)) 
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['user_status'] = $user['account'];
                $_SESSION['profile_picture'] = $user['profile_picture'];
                header("Location: ../index.php"); // Redirect to home page on successful login
                exit;
            }
            // if the password does not match, redirect to login page with error message
            else
            {
                $em = "Please enter the correct password.";
                header("Location: ../login.php?error=$em&$data");
                exit;
            }
        } 
        // if the email does not exist in the database, redirect to login page with error message
        else 
        {
            $em = "This email doesn't match any account <span><a href='signup.php' class='a_red'>Sign up</a></span>";
            header("Location: ../login.php?error=$em&$data");
            exit;
        }
    }
} else {
    header("Location: ../login.php?error=error");
    exit;
}
?>
