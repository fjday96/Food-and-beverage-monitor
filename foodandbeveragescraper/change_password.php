<?php
session_start();
if(!isset($_SESSION["user_email"])) {
	header('Location: login.php');
}
	
$email_input = $current_password = $new_password = $repeat_new_password = "";

//If this page is loaded with POST variables to be validated the following functions runs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$current_password = $_POST["current_password"];
	$new_password = $_POST["new_password"];
	$repeat_new_password = $_POST["repeat_new_password"];

	//Assume true, becomes false as soon as one field is invalid
	$valid = true;

	//Login to the database 
	include 'dblogin.php';

	//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
	$querystring = "SELECT passhash, salt FROM accountsdb WHERE email=:email_input"; 
	$stmt = oci_parse($connect, $querystring);
	oci_bind_by_name($stmt, ':email_input', $_SESSION["user_email"]); 
	oci_execute($stmt);

	while(oci_fetch_array($stmt)) {
		$current_passhash = oci_result($stmt,"PASSHASH");
		$current_salt = oci_result($stmt,"SALT");
	}

	oci_free_statement($stmt);

	//Validation
	if(hash(sha256, $current_salt.$current_password) != $current_passhash) {
		$valid = false;
	} else if($new_password == "" || strlen($new_password) > 25 || strlen($new_password) < 8) {
		$valid = false;
	} else if($repeat_new_password != $new_password) {
		$valid = false;
	}

	if($valid) {
		$salt_hash = hash(sha256, uniqid(mt_rand()));
		$passhash = hash(sha256, $salt_hash.$new_password);
		
		$querystring = "UPDATE accountsdb SET passhash=:passhash_bv, salt=:salt_bv WHERE email=:email"; 
		$stmt = oci_parse($connect, $querystring);
		oci_bind_by_name($stmt, ':passhash_bv', $passhash);
		oci_bind_by_name($stmt, ':salt_bv', $salt_hash);
		oci_bind_by_name($stmt, ':email', $_SESSION["user_email"]);
		oci_execute($stmt);
		
		session_unset();
		session_destroy(); 
		
		header('Location: login.php?status=changed');
		exit();
	}

	//Close connection
	oci_close($connect);
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	a .accounts_button {
		text-decoration: none;
	}
	.accounts_button {
		padding: 10px;
		background-color: #5C94CF;
		display: inline-block;
		color: #111;
	}
	.accounts_button:hover {
		background-color: #A4CDE1;
	}
	.light_grey h2 {
		margin-top: 40px;
	}
	.login_text {
		width: 100%;
		border: solid thin #444;
		outline: 0;
		font-size: 18px;
		font-family: 'OpenSans';
		padding-left: 2px;
	}
	form {
		width: 500px;
	}
	#submit_button {
		background-color: #5C94CF;
		border: 0;
		outline: 0;
		padding: 10px;
		font-family: 'OpenSans', sans-serif;
		font-size: 16px;
		margin-top: 10px;
		cursor: pointer;
	}
	#submit_button:hover {
		background-color: #A4CDE1;	
	}
</style>

</head>

<body>

<div id="top_bar">
	<div id="container">
		<img id="small_logo" src='Media/Images/logo_small.png'>
		<a href="index.php"><div class="nav_button">Home</div></a>
		<a href="spreadsheets.php"><div class="nav_button">Spreadsheets</div></a>
		<a href="search.php"><div class="nav_button">Search</div></a>
		<a href="reports.php"><div class="nav_button">Reports</div></a>
		<a href="about.php"><div class="nav_button">About</div></a>
		<div onclick="menu()" class="menu_icon"></div>
		<a href="logout.php"><div class="button_login">Logout</div></a>
		<a href="account_settings.php"><div class="button_login">Account Settings</div></a>
	</div>
</div>

<div id="mobile_nav">
	<a href="index.php"><div class="mobile_nav_button"><div id="container">HOME</div></div></a>
	<a href="spreadsheets.php"><div class="mobile_nav_button"><div id="container">SPREADSHEETS</div></div></a>
	<a href="search.php"><div class="mobile_nav_button"><div id="container">SEARCH</div></div></a>
	<a href="reports.php"><div class="mobile_nav_button"><div id="container">REPORTS</div></div></a>
	<a href="about.php"><div class="mobile_nav_button"><div id="container">ABOUT</div></div></a>
</div>

<div class="content_section light_grey">
	<div id="container">
		<h1>Change password</h1>
		<form method="post" action="change_password.php">
			Current password
			<input class="login_text" type="password" name="current_password" autocomplete="off" />
			New password
			<input class="login_text" type="password" name="new_password" autocomplete="off" />
			Repeat new password
			<input class="login_text" type="password" name="repeat_new_password" autocomplete="off" />
			<input type="submit" id="submit_button" value="Submit" />
		</form>
		<?php
		if(isset($valid)) {
			if(!$valid) {
				echo "<p style=\"color: #DB383B;\">Unable to change password. Ensure your new password is between 8 and 25 characters long.</p>";
			}
		}
		?>
	</div>
</div>

<div id="footer_top">
	<div id="container">
		<table id="table_footer">
			<tr>
				<td valign="top">
				<h2>Quick Links</h2>
					<a href="index.php"><div class="footer_button">Home</div></a>
					<a href="spreadsheets.php"><div class="footer_button">Spreadsheets</div></a>
					<a href="search.php"><div class="footer_button">Search</div></a>
					<a href="reports.php"><div class="footer_button">Reports</div></a>
					<a href="about.php"><div class="footer_button">About</div></a>
				</td>
				<td valign="top" class="td_padding_left">
				<div style="width: 160px; margin: 0 auto;">
				<h2>Additional Links</h2>
					<a href="http://www.globalobesity.com.au/" target="_blank"><div class="footer_button">GLOBE</div></a>
					<a href="http://www.deakin.edu.au/cphr" target="_blank"><div class="footer_button">CPHR</div></a>
					<a href="http://www.deakin.edu.au/" target="_blank"><div class="footer_button">Deakin University</div></a>
				</div>
				</td>
				<td valign="top" class="td_padding_left">
				<div style="float: right;">
				<h2>Contact</h2>
					<a href="mailto:#" style="font-size: 14px">email@deakin.edu.au</a> <br>
					<a href="tel:#" style="font-size: 14px">00 0000 0000</a>
				</div>	
				</td>
			</tr>
			<tr>
				<td valign="top" class="mobile_footer_td">
				<h2>Additional Links</h2>
					<a href="http://www.globalobesity.com.au/" target="_blank"><div class="footer_button">GLOBE</div></a>
					<a href="http://www.deakin.edu.au/cphr" target="_blank"><div class="footer_button">CPHR</div></a>
					<a href="http://www.deakin.edu.au/" target="_blank"><div class="footer_button">DEAKIN UNIVERSITY</div></a>
				</td>
			</tr>
			<tr>
				<td valign="top" class="mobile_footer_td">
				<h2>Contact</h2>
					<a href="mailto:#" style="font-size: 14px">email@deakin.edu.au</a> <br>
					<a href="tel:#" style="font-size: 14px">00 0000 0000</a>
				</td>
			</tr>
		</table>
	</div>
</div>

<div id="footer_bottom">
	<div id="container">
		Copyright &copy; <?php echo date("Y"); ?> 
	</div>
	
</div>

</body>
</html>