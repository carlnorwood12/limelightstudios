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
session_start();

include 'connection.php';
global $dbhandle;

if (isset($_POST['user'], $_POST['email'], $_POST['pass'], $_POST['name'], $_POST['dob'])) {
    $username = mysqli_real_escape_string($dbhandle, $_POST['user']);
    $email = mysqli_real_escape_string($dbhandle, $_POST['email']);
    $password = mysqli_real_escape_string($dbhandle, $_POST['pass']);
    $name = mysqli_real_escape_string($dbhandle, $_POST['name']);
    $dob_input = $_POST['dob'];

    $dob = date('y-m-d', strtotime($dob_input)); // format the date for MySQL
    $birthday = strtotime($dob);
    $difference = time() - $birthday;
    $age = max(0, floor($difference / 31556926));
    // Check if username or email already exists
    $query = mysqli_query($dbhandle, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($query) > 0) {
        $error_message = "Username or email already exists!";
    } else {
        if ($age < 18) {
            $_SESSION['user_status'] = 'junior';
        } else {
            $_SESSION['user_status'] = 'adult';
        }
        $current_time = date('Y-m-d H:i:s');
        mysqli_query($dbhandle, "INSERT INTO users (name, username, email, password, dob, age, account, created) VALUES ('$name', '$username', '$email', '$password', '$dob', '$age', '{$_SESSION['user_status']}', '$current_time')");        // Redirect to index
        header("location:signin.php");
        exit();
    }
}

mysqli_close($dbhandle);
?>
<div class="contact-container">
    <div class="left">
        <div data-us-project="rFgcX5msDzIcpadZMmYC" style="width:100%; height: 100%; border-radius: 15px; clip-path: inset(0% 0% 0% 0% round 20px);"></div><script type="text/javascript">!function(){if(!window.UnicornStudio){window.UnicornStudio={isInitialized:!1};var i=document.createElement("script");i.src="https://cdn.unicorn.studio/v1.3.2/unicornStudio.umd.js",i.onload=function(){window.UnicornStudio.isInitialized||(UnicornStudio.init(),window.UnicornStudio.isInitialized=!0)},document.getElementsByTagName("head")[0].appendChild(i)}}();</script>
        <div class="marquee-container">
            <div class="content-wrapper">
                <p class="p-marquee">Exclusive offers</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Member Benefits</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Cinema Discounts</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Tailored Feed</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
            </div>
            <div class="content-wrapper">
                <p class="p-marquee">Exclusive offers</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Member Benefits</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Cinema Discounts</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Tailored Feed</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
            </div>
            <div class="content-wrapper">
                <p class="p-marquee">Exclusive offers</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Member Benefits</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Cinema Discounts</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
                <p class="p-marquee">Tailored Feed</p>
                <object class="twinkle" type="image/svg+xml" data="twinkle_purple.svg" aria-label="Icon"></object>
            </div>
        </div>
    </div>
    <div class="right">
        <form class="form" action="new_user.php" method="POST">
            <h1 class="h1">Create account</h1>
            <p class="p">Let's get you signed up and ready to explore!</p>
            <div class="input-wrapper">
                <img class="icon shown" src="user.svg" width="20px" aria-label="Icon"/>
                <input type="text" id="username-input" class="input" name="name" placeholder=" " pattern="^[a-zA-Z ]+$" spellcheck="false" required />
                <label for="username-input" class="label">Enter name</label>
                <span></span>
            </div>
            <div class="input-wrapper">
                <img class="icon shown" src="user.svg" width="20px" aria-label="Icon"/>
                <input type="text" id="username-input" class="input" name="user" placeholder=" " pattern="^[a-zA-Z0-9]+$" spellcheck="false" required />
                <label for="username-input" class="label">Enter username</label>
                <span></span>
            </div>
            <div class="input-wrapper">
                <img class="icon shown" src="at-sign.svg" width="20px" aria-label="Icon"/>
                <input type="email" id="email-input" class="input" name="email" placeholder=" " spellcheck="false" required />
                <label for="email-input" class="label">Enter email</label>
                <span></span>
            </div>
            <div class="input-wrapper">
                <img class="icon password" src="eye_on.svg" width="20px" aria-label="Icon" />
                <input type="password" id="password-input" class="input" name="pass" placeholder=" " spellcheck="false" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,32}$" required />
                <label for="password-input" class="label">Enter password</label>
                <span></span>
            </div>
            <div class="input-wrapper">
                <img class="icon shown" src="calendar.svg" width="20px" aria-label="Icon"/>
                <input type="text" id="dob-input" class="input" datepicker datepicker-autohide autocomplete="off" datepicker-orientation="center center" name="dob" placeholder=" " required />
                <label for="dob-input" class="label">Enter birthday</label>
                <span></span>
            </div>
            <div class="already-have-2">
                <p class="p-already-2">
                    <a href="signin.php"><span class="span">Forgot password?</span></a>
                </p>
            </div>
            <button class="button-submit" type="submit">
                Continue
                <img src="right.svg" width="20px" aria-label="Icon"></img>
            </button>
            <div class="already-have">
                <p class="p-already">
                    Already have an account? <a href="signin.php"><span class="span">Sign in</span></a>
                </p>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).mousemove(function (event) {
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        var scrollX = $(window).scrollLeft();
        var scrollY = $(window).scrollTop();
        var mouseXpercentage = Math.round(((event.pageX - scrollX) / windowWidth) * 100);
        var mouseYpercentage = Math.round(((event.pageY - scrollY) / windowHeight) * 100);
        $(".radial-gradient").css("background", "radial-gradient(circle at " + mouseXpercentage + "% " + mouseYpercentage + "%, #14142B 0%, #14142B 2%, #14142A 4%, #13132A 6%, #131329 8%, #131328 9%, #121228 11%, #121227 13%, #121226 14%, #111125 16%, #111123 18%, #101022 20%, #0F0F21 22%, #0F0F20 24%, #0E0E1E 27%, #0E0E1D 30%, #0D0D1C 33%, #0D0D1B 36%, #0C0C19 40%, #0B0B18 44%, #0B0B17 48%, #0B0B16 53%, #0A0A16 59%, #0A0A15 64%, #0A0A15 71%)");
    });
    document.querySelector('.icon.password').addEventListener('click', function ()
    {
        const password = document.getElementById('password-input');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.src = type === 'password' ? 'eye_on.svg' : 'eye_off.svg';
    });
</script>
<script>
</script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    tippy('.input-wrapper', {
        content: 'My tooltip!',
        theme: 'dark',
        animation: 'fade',
        trigger: 'focus',
        interactive: true,
    });
</script>
</body>
</html>