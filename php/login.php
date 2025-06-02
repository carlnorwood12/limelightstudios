<?php
session_start();

if (isset($_POST['email']) && isset($_POST['pass'])) {
    include "../connection.php";
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $data = "email=" . $email;

    if (empty($email)) {
        $em = "Email is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else if (empty($pass)) {
        $em = "Password is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount() == 1) 
        {
            $user = $stmt->fetch();
            $email = $user['email'];
            $password = $user['password'];
            $name = $user['name'];
            $id = $user['id'];
            $profile_picture = $user['profile_picture'];
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
            else
            {
                $em = "Please enter the correct password.";
                header("Location: ../login.php?error=$em&$data");
                exit;
            }
        } 
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
