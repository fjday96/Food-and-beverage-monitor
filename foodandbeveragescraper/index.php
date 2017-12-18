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
<title>Home</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	
	/*Changes to CSS when screen width is 870px or less*/
	@media only screen and (max-width: 880px) {
		#banner {
			display: none;
		}
		.banner_blurred {
			display: none;
		}
		.home_table_image_td {
			width: 0;
			display: none;
		}
		.home_table_content_td {
			width: 100%;
		}
		#home_table {
			width: 100%;
		}
	}
	
	#banner {
		width: 100%;
		padding: 150px 0px;
		background-image: url(Media/Images/fresh_food_banner.jpg);
		background-size: cover;
		position: absolute;
		z-index: -1;
		opacity: 0.75;
	}
	.banner_blurred {
		width: 100%;
		padding: 150px 0px;
		background-size: cover;
		position: relative;
		z-index: -2;
	}
	.home_table_content_td {
		width: 500px;
		padding: 0;
		margin: 0;
	}
	.home_table_image_td {
		width: 340px;
		padding: 0;
		margin: 0;
	}
	.home_button {
		text-align: center;
		height: 70px;
		line-height: 70px;
		border: thin solid #5C94CF;
		font-family: OpenSans-ExtraBold, sans-serif;
		font-size: 25px;
		width: 200px;
		margin: 0 auto;
	}
	.home_button:hover {
		background-color: #5C94CF;
		cursor: pointer;
	}
	.image_section {
		margin: 0px;
		background-color: #EEE;
		
	}
	#explanation_image {
		background-image: url(Media/Images/strawberry_jar.png);
		background-repeat: no-repeat;
		background-position: center;
		height: 500px;
		background-size: cover;
		padding: 0;
		margin: 0;
	}
	#search_image {
		background-image: url(Media/Images/drink.png);
		background-repeat: no-repeat;
		background-position: center;
		height: 500px;
		background-size: cover;
		padding: 0;
		margin: 0;
	}
	#reports_image {
		background-image: url(Media/Images/green_apple.png);
		background-repeat: no-repeat;
		background-position: center;
		height: 500px;
		background-size: cover;
		padding: 0;
		margin: 0;
	}
	#about_image {
		background-image: url(Media/Images/strawberry_drink.png);
		background-repeat: no-repeat;
		background-position: center;
		height: 500px;
		background-size: cover;
		padding: 0;
		margin: 0;
	}
	#contact_image {
		background-image: url(Media/Images/capsicum.png);
		background-repeat: no-repeat;
		background-position: center;
		height: 500px;
		background-size: cover;
		padding: 0;
		margin: 0;
	}
	#home_table {
		margin: 0;
		padding: 0;
		border-collapse: collapse;
		border: none;
	}
	h1 a {
		color: #5C94CF;
	}
	h1 a:hover {
		color: #1C3C73;
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

<div id="banner">
	<div id="container">
		<h1 style="margin: 0 auto; text-align: center; color: #EEE; font-size: 100px; font-family: 'OpenSans', sans-serif; font-weight: 900">AUSTRALIAN</h1>
		<h1 style="margin: 0 auto; text-align: center; color: #DDD; font-size: 32px;">SUPERMARKET PRICE MONITORING SYSTEM</h1>
	</div>
</div>
<div class="banner_blurred">
		<h1 style="margin: 0 auto; text-align: center; color: #EEE; font-size: 100px; font-family: 'OpenSans', sans-serif; font-weight: 900">AUSTRALIAN</h1>
		<h1 style="margin: 0 auto; text-align: center; color: #DDD; font-size: 32px;">SUPERMARKET PRICE MONITORING SYSTEM</h1>
</div>	

<div class="dark_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_content_td">
					<h1>What is Food &amp; Beverage Scraper?</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
				</td>
				<td class="home_table_image_td" id="explanation_image">
					
				</td>
			</tr>
		</table>
		
	</div>
</div>

<div class="light_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_image_td" id="search_image">
					
				</td>
				<td class="home_table_content_td">
					<h1><a href="search.php">Search</a></h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
				</td>
			</tr>
		</table>
		
	</div>
</div>

<div class="dark_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_content_td">
					<h1><a href="reports.php">Reports</a></h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
				</td>
				<td class="home_table_image_td" id="reports_image">
					
				</td>
			</tr>
		</table>
		
	</div>
</div>

<div class="light_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_image_td" id="about_image">
					
				</td>
				<td class="home_table_content_td">
					<h1><a href="about.php">About</a></h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
				</td>
			</tr>
		</table>
		
	</div>
</div>

<div class="dark_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_content_td">
					<h1><a href="contact.php">Contact</a></h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<p> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
				</td>
				<td class="home_table_image_td" id="contact_image">
					
				</td>
			</tr>
		</table>
		
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