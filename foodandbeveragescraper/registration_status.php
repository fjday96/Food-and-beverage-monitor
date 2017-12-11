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
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="icon" type="image/png" href="Media/Images/favicon.png">
<title>Register Status</title>
<style>
	body {
		background-color: #EEE;
		padding: 0;
		margin: 0;
		color: #222;
		
	}
	h1 {
		display: inline-block;
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
	#info_button {
		display: inline-block;
		background-color: #EEE;
		outline: 0;
		border: 0;
		padding: 0;
		font-size: 30px;
		font-family: Arial;
		color: #777;
		margin-left: 20px;
	}
	.input_error_message {
		height: 20px;
		color: #DB383B;
		margin-top: 1px;
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
			<?php
				if(isset($_GET['status'])) {
					if($_GET['status'] == "success") {
						echo "<h1>Verify your email.</h1>";
						echo "<p>Your account has been created, but before you can start using it you need to active it by clicking the activation link sent to the email you provided.</p>";
					} else {
						echo "<h1>Error loading status</h1>";
						echo "<p>An error occured while loading your activation status.</p>";
					} 
				} else {
					echo "<h1>Error loading status</h1>";
					echo "<p>An error occured while loading your activation status.</p>";
				}
			?>
			<a href="login.php"><div id="return_button">Return to Login</div></a>
		</div>
	</div>
</div>
</body>
</html>