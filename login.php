<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="radial-gradient"></div>
    <div class="form-container">
    	<form class="shadow w-450 p-3" 
    	      action="php/login.php" 
    	      method="post">
			<h1 id="account-h1">Welcome back</h1>
			<p id="account-p">Let's get you logged back into your experience!</p>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/email.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="email" value="<?php echo (isset($_GET['email']))? $_GET['email']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Enter email</label>
				<div class="error-message"><?php echo (isset($_GET['email_error']))? $_GET['email_error']:"" ?></div>
			</div>
			<div class="input-wrapper">
				<img class="icon shown" src="/svg/form/eye_on.svg" width="20px" aria-label="Icon"/>
				<input type="text" id="name-input" class="input" name="pass" value="<?php echo (isset($_GET['pass']))? $_GET['pass']:"" ?>" placeholder=" " spellcheck="false" required />
				<label for="name-input" class="label">Enter password</label>
				<div class="error-message"><?php echo (isset($_GET['pass_error']))? $_GET['pass_error']:"" ?></div>
			</div>
			<button class="button-submit" type="submit">
				Login
				<img src="/svg/right.svg" width="20px" aria-label="Icon"></img>
			</button>
    		<?php if(isset($_GET['error'])){ ?>
				<div class="alert-danger" role="alert">
					<img src="/svg/warning.svg" width="20px" aria-label="Icon">
					<?php echo $_GET['error']; ?>
				</div>
		    <?php } ?>
		</form>
    </div>
</body>
</html>
