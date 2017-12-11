<?php
	session_start();
	if(isset($_SESSION["user_email"])) {
		header('Location: index.php');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="icon" type="image/png" href="Media/Images/favicon.png">
<title>Login</title>
<style>
	body {
		background-color: #EEE;
		padding: 0;
		margin: 0;
		color: #222;
		
	}
	h1, h3{
	}
	h3 {
		font-size: 20px;
		margin-top: -25px;
		color: #2A2A2A;
	}
	#login_box {
		width: 300px;
		margin: 0 auto;
		height: 100%;
	}
	.outer {
		display: table;
		position: absolute;
		height: 100%;
		width: 100%;
	}

	.middle {
		display: table-cell;
		vertical-align: middle;
	}

	.inner {
		margin-left: auto;
		margin-right: auto;
		width: 400px;
	}
	.login_text {
		width: 100%;
		border: solid thin #444;
		outline: 0;
		font-size: 18px;
		font-family: OpenSans;
		padding-left: 2px;
	}
	#submit_button {
		background-color: #5C94CF;
		border: 0;
		outline: 0;
		padding: 10px;
		font-family: OpenSans, sans-serif;
		font-size: 16px;
		margin-top: 10px;
		cursor: pointer;
	}
	#submit_button:hover {
		background-color: #A4CDE1;	
	}
	form a {
		color: #222;
		text-decoration: none;
	}
	form a:hover {
		color: #222;
		text-decoration: underline;
	}
	#login_error {
		height: 20px;
		color: #9A1517;
	}
	
</style>
</head>

<body>
<div class="outer">
	<div class="middle">
		<div class="inner">
			<h1>Login</h1>
			<h3>Deakin's Food &amp; Beverage Scraper</h3>
			<form action="verify_login.php" method="post">
				Email
				<input class="login_text" type="text" name="email_login" />
				Password
				<input class="login_text" type="password" name="password_login"/>
				<a href="register.php">Don't have an account? Register here.</a> <br> 
				<input id="submit_button" type="submit" value="Login"/>
				<div id="login_error">
					<?php
						if(isset($_GET['status'])) {
							if($_GET['status'] == "fail") {
								echo "<p>Login failed. Make sure your username and password combination is correct and you have verified your email.</p>";
							} else if($_GET['status'] == "changed") {
								echo "<p style=\"color: #248026;\">Password change successful. Login with your new password to continue using your account.</p>";
							} else if($_GET['status'] == "deleted") {
								echo "<p style=\"color: #248026;\">Your account has been successfully removed.</p>";
							}
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>