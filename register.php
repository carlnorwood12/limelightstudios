<!DOCTYPE html>
<html class="dark">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/forms.css">
</head>
<body>
<div class="radial-gradient"></div>
    <div class="form-container">
		<div class="left">
			<video class="video-form" playsinline autoplay muted>
				<source src="https://limelightcinema.b-cdn.net/donthear_video.webm" type="video/mp4">
			</video>
			<div class="bottom">
			<div class="marquee-container">
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
            <div class="content-wrapper-scrolling">
				<p class="p-marquee">〝Simply Stunning〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Best Cinema in Edinburgh〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
				<p class="p-marquee">〝Breathtaking Atmosphere〞</p>
				<img class="twinkle" src="/svg/darktwinkle.svg" alt="" aria-label="">
            </div>
        </div>
			</div>
		</iframe>
		</div>
		<div class="right">
    	<form
    	      action="php/signup.php" 
    	      method="post"
    	      enctype="multipart/form-data">
    		<h1 id="account-h1">Create Account</h1>
			<p id="account-p">Let's get you signed up and ready to explore!</p>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/user.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="name" value="<?php echo (isset($_GET['name']))? $_GET['name']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Enter name</label>
			</div>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/email.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="email" value="<?php echo (isset($_GET['email']))? $_GET['email']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Enter email</label>
				<div class="error-message"><?php echo (isset($_GET['email_error']))? $_GET['email_error']:"" ?></div>
			</div>
			<div class="input-wrapper">
				<img class="icon password" src="/svg/form/eye_on.svg" width="20px" aria-label="Icon" />
				<input type="password" id="password-input" class="input" name="pass" placeholder="" spellcheck="false" required />
				<label for="password-input" class="label">Enter password</label>
				<span class="password-tooltip" id="password-toggle" aria-label="Icon"></span>
			</div>
			<div class="birthday-profile">
				<div class="input-wrapper" style="width: 65%; height: 50px;">
					<img class="icon shown" src="/svg/form/calendar.svg" width="20px" aria-label="Icon"/>
					<input type="text" id="dob-input" class="input" name="dob" datepicker datepicker-autohide autocomplete="off" datepicker-orientation="center center" placeholder=" " required />
					<label for="dob-input" class="label">Enter birthday</label>
				</div>
				<div class="input-wrapper-file" style="width: 45%; min-width: 135px; height: 50px;">
					<input type="file" id="small_size" class="w-1/3 h-full hidden" name="profile_picture" />
					<label for="small_size" class="w-full h-full flex items-center justify-center cursor-pointer" style="border-radius: 13px; color: #ffffffbf; background-color: #7c82b11f; font-size: 12px;">Upload picture &nbsp; 📤</label>
				</div>
			</div>
			<button class="button-submit" type="submit">
				Let's do this
				<img src="/svg/right.svg" width="20px" aria-label="Icon"></img>
			</button>
			<div class="already-have">
                <p class="p-already">
                    Already have an account? <a href="login.php"><span class="span">Sign in</span></a>
                </p>
            </div>
    		<?php if(isset($_GET['error'])){ ?>
				<div class="alert-danger" role="alert">
					<img src="/svg/warning.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['error']; ?>
				</div>
		    <?php } ?>
		</form>
		</div>
    </div>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous" defer></script>
	<script src="/js/password.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
	<script src="/js/gsap.js" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
	<script>
		const passwordInput = document.getElementById('password-input');
		const tooltip = tippy(passwordInput, 
		{
			content: 'Password must contain at least 8 characters, an uppercase letter, a number and a special character',
			trigger: 'manual',
			offset: [0, 20],
		});
		passwordInput.addEventListener('focus', () => 
		{
			tooltip.show();
		});
		passwordInput.addEventListener('mouseenter', () => 
		{
			tooltip.show();
		});
		passwordInput.addEventListener('blur', () => 
		{
			tooltip.hide();
		});
	</script>
</body>
</html>
