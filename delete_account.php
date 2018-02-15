<?php
session_start();
if(!isset($_SESSION["user_email"])) {
	header('Location: login.php');
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
	a #submit_button {
		text-decoration: none;
	}
	#delete_button {
		background-color: #5C94CF;
		color: #111;
		padding: 10px;
		display: inline-block;
		font-family: 'OpenSans', sans-serif;
		font-size: 16px;
		margin-top: 10px;
		cursor: pointer;
	}
	#delete_button:hover {
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
	<a href="index.php"><div class="mobile_nav_button"><div id="container">Home</div></div></a>
	<a href="spreadsheets.php"><div class="mobile_nav_button"><div id="container">Spreadsheets</div></div></a>
	<a href="search.php"><div class="mobile_nav_button"><div id="container">Search</div></div></a>
	<a href="reports.php"><div class="mobile_nav_button"><div id="container">Reports</div></div></a>
	<a href="about.php"><div class="mobile_nav_button"><div id="container">About</div></div></a>
	<a href="account_settings.php"><div class="mobile_nav_button"><div id="container">Account Settings</div></div></a>
	<a href="logout.php"><div class="mobile_nav_button"><div id="container">Logout</div></div></a>
</div>

<div class="content_section light_grey">
	<div id="container">
		<h1>Delete account</h1>
		<p>If you select delete, you will no longer be able to sign in with this account and your details will be wiped.</p>
		<a href="delete_user.php"><div id="delete_button">Delete</div></a>
		
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