<?php
// Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted)
$current_date = "2025-05-15 18:14:35";
$current_user = "carlnorwood12";
?>

<!DOCTYPE html>
<html class="dark">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us</title>
	<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
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
		</div>
		<div class="right">
    	<form class="w-450 p-3" 
    	      action="php/contact.php" 
    	      method="post">
    		<h1 id="account-h1">Contact Us</h1>
			<p id="account-p">We'd love to hear from you. Send us a message!</p>
            
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/user.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="name" value="<?php echo (isset($_GET['name']))? $_GET['name']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Your name</label>
			</div>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/email.svg" width="20px" aria-label="Icon"/>
				<input type="email" id="email-input" class="input" name="email" value="<?php echo (isset($_GET['email']))? $_GET['email']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="email-input" class="label">Your email</label>
				<div class="error-message"><?php echo (isset($_GET['email_error']))? $_GET['email_error']:"" ?></div>
			</div>
            <div class="input-wrapper" style="height: 120px;">
				<textarea id="message-input" class="input" name="message" placeholder=" " spellcheck="false" required style="height: 100%; padding-top: 15px; resize: none;"><?php echo (isset($_GET['message']))? $_GET['message']:"" ?></textarea>
				<label for="message-input" class="label" style="top: 15px;">Your message</label>
			</div>
            
			<button class="button-submit" type="submit">
				Send Message
				<img src="/svg/right.svg" width="20px" aria-label="Icon"></img>
			</button>
            
    		<?php if(isset($_GET['error'])){ ?>
				<div class="alert-danger" role="alert">
					<img src="/svg/warning.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['error']; ?>
				</div>
		    <?php } ?>
            
            <?php if(isset($_GET['success'])){ ?>
				<div class="alert-success" role="alert">
					<img src="/svg/success.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['success']; ?>
				</div>
		    <?php } ?>
		</form>
		</div>
    </div>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
	<script src="/js/gsap.js" defer></script>
</body>
</html>