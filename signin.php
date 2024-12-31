<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
<div class="radial-gradient"></div>

<?php
$username = "root";
$password = "test123";
$hostname = "127.0.0.1";

$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");
$selected = mysqli_select_db($dbhandle, "limelight_cinemas");

$myusername = '';
$mypassword = '';

// if the user and pass are set
if (isset($_POST['user']) && isset($_POST['pass']))
{
    $myusername = mysqli_real_escape_string($dbhandle, $_POST['user']);
    $mypassword = mysqli_real_escape_string($dbhandle, $_POST['pass']);

    $query = "SELECT * FROM users WHERE username='$myusername' AND password='$mypassword'";
    $result = mysqli_query($dbhandle, $query);
    $count = mysqli_num_rows($result);

    mysqli_close($dbhandle);
    if ($count == 1) {
        setcookie('logged_in', $myusername, time() + 3600, "/");
        header("location:users.php");
        exit();
    } else {
        $error_message = "Wrong Credentials!";
    }
}
?>

<form class="form-2" action="signin.php" method="POST">
    <h1 class="h1">Welcome back!</h1>
    <p class="p">
        Let's log in, so you can enjoy your benefits
    </p>
    <div class="input-wrapper">
        <input type="text" id="username-input" class="input" name="user" placeholder=" " required />
        <label for="username-input" class="label">Enter username</label>
    </div>
    <div class="input-wrapper">
        <input type="password" id="password-input" class="input" name="pass" placeholder=" " required />
        <label for="password-input" class="label">Enter password</label>
    </div>
    <div class="flex-row">
        <p class="p-already-2">
            <a href="signin.php"><span class="span">Forgot password?</span></a>
        </p>
    </div>
    <button class="button-submit" type="submit">
        Continue
        <img src="right.svg" width="20px" aria-label="Icon"></img>
    </button>
    <div class="already-have">
        <p class="p-already">Don't have an account? <a href="new_user.php"><span class="span">Sign up</span></a></p>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).mousemove(function (event) {
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        var scrollX = $(window).scrollLeft();
        var scrollY = $(window).scrollTop();
        var mouseXpercentage = Math.round(((event.pageX - scrollX) / windowWidth) * 100);
        var mouseYpercentage = Math.round(((event.pageY - scrollY) / windowHeight) * 100);
        $(".radial-gradient").css("background", "radial-gradient(circle at " + mouseXpercentage + "% " + mouseYpercentage + "%, #14142b 10%, #0a0a15 70%)");
    });
</script>
</body>
</html>
