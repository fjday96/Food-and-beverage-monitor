<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="icon" type="image/png" href="Media/Images/favicon.png">
<title>Verify Email</title>
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
	#return_button {
		background-color: #5C94CF;
		border: 0;
		outline: 0;
		padding: 10px;
		font-family: OpenSans, sans-serif;
		font-size: 16px;
		margin-top: 10px;
		cursor: pointer;
		width: 120px;
	}
	#return_button:hover {
		background-color: #A4CDE1;	
	}
	a {
		color: #222;
		text-decoration: none;
	}
</style>
</head>

<body>
<div class="outer">
	<div class="middle">
		<div class="inner">
			<h1>Email Verification</h1>
			<?php
				if(isset($_GET['status'])) {
					if($_GET['status'] == "success") {
						echo "<h3>Verification successful.</h3> Login to start using your account.";
					} else if($_GET['status'] == "fail") {
						echo "<h3>Verification failed.</h3> If you have verified this email previously or did not verify via the link sent to your email the verification won't work.";
					} else if($_GET['status'] == "removed") {
						echo "<h3>Account removed.</h3> Your account has been successfully removed.";
					} else {
						echo "<h3>Failed to load status.</h3>";
					}
				}
			?>
			<a href="login.php"><div id="return_button">Return to Login</div></a>
		</div>
	</div>
</div>
</body>
</html>