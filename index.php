<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>

<style>
	#banner {
		width: 100%;
		padding: 200px 0px;
		background-image: url(Media/Images/fresh_food_banner.jpg);
		background-size: cover;
		position: absolute;
		z-index: -1;
	}
	.banner_blurred {
		width: 100%;
		padding: 200px 0px;
		background-image: url(Media/Images/fresh_food_banner_blur.jpg);
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
		<table id="top_bar_table">
			<tr>
				<td valign="middle" id="top_bar_contact">
					email@deakin.edu.au <br> 00 0000 0000
				</td>
				<form id="quick_search_form" action="search_results.php" method="post">
					<td align="right" valign="middle">
						<input type="search" id="input_quick_search" name="input_main_search" placeholder="Keyword..." maxlength="35" >			
					</td>
					<td valign="middle" style="width: 100px;">
						<input type="submit" id="button_quick_search" name="button_main_search" value="SEARCH">
					</td>
				</form>
			</tr>
		</table>
	</div>
</div>

<div class="nav_bar">
	<div id="container">
		<a href="index.php"><div id="logo"></div></a>
		<div id="button_section">
			<a href="index.php"><div class="nav_button">HOME</div></a>
			<a href="search.php"><div class="nav_button">SEARCH</div></a>
			<a href="reports.php"><div class="nav_button">REPORTS</div></a>
			<a href="about.php"><div class="nav_button">ABOUT</div></a>
			<a href="contact.php"><div class="nav_button">CONTACT</div></a>
		</div>
	</div>
</div>
<div class="nav_bar_space"></div>

<div id="banner">
	<div id="container">
		<h1 style="margin: 0 auto; text-align: center; color: #EEE; font-size: 100px;">AUSTRALIAN</h1>
		<h1 style="margin: 0 auto; text-align: center; color: #DDD; font-size: 30px;">SUPERMARKET PRICE MONITORING SYSTEM</h1>
	</div>
</div>
<div class="banner_blurred">
	<h1 style="margin: 0 auto; text-align: center; color: #EEE; font-size: 100px;">AUSTRALIAN</h1>
	<h1 style="margin: 0 auto; text-align: center; color: #DDD; font-size: 30px;">SUPERMARKET PRICE MONITORING SYSTEM</h1>
</div>	

<div class="dark_grey">
	<div id="container">
		<table id="home_table">
			<tr>
				<td class="home_table_content_td">
					<h1>WHAT IS FOOD &amp; DRINK SCRAPER?</h1>
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
					<h1><a href="search.php">SEARCH</a></h1>
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
					<h1><a href="reports.php">REPORTS</a></h1>
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
					<h1><a href="about.php">ABOUT</a></h1>
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
					<h1><a href="contact.php">CONTACT</a></h1>
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
				<td>
					<h2>Quick Links</h2>
				</td>
				<td class="td_padding_left">
					<h2>Additional Links</h2>
				</td>
				<td class="td_padding_left">
					<h2>Contact</h2>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<a href="index.php"><div class="footer_button">HOME</div></a>
					<a href="search.php"><div class="footer_button">SEARCH</div></a>
					<a href="reports.php"><div class="footer_button">REPORTS</div></a>
					<a href="about.php"><div class="footer_button">ABOUT</div></a>
					<a href="contact.php"><div class="footer_button">CONTACT</div></a>
				</td>
				<td valign="top" class="td_padding_left">
					<a href="http://www.globalobesity.com.au/" target="_blank"><div class="footer_button">GLOBE</div></a>
					<a href="http://www.deakin.edu.au/cphr" target="_blank"><div class="footer_button">CPHR</div></a>
					<a href="http://www.deakin.edu.au/" target="_blank"><div class="footer_button">DEAKIN UNIVERSITY</div></a>
				</td>
				<td valign="top" class="td_padding_left">
					<a href="mailto:#">email@deakin.edu.au</a> <br>
					<a href="tel:#">00 0000 0000</a>
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