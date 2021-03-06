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
<title>Search</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	#table_main_search {
		width: 100%;
		border-collapse: collapse;
		border: none;
		margin: 0 auto;
	}
	#button_main_search {
		background-color: #474747;
		border: none;
		height: 50px;
		color: #EEE;
		font-family: 'OpenSans', sans-serif;
		font-weight: 700;
		outline: 0;
		width: 135px;
		text-align: center;
		font-size: 20px;
	}
	#button_main_search:hover {
		cursor: pointer;
		background-color: #333;
		color: #5C94CF;
	}
	#input_main_search_td {
		width: 100%;
	}
	#input_main_search {
		height: 50px;
		margin-top: 0px;
		border: none;
		padding-left: 10px;
		width: 100%;
		font-size: 20px;
		outline: 0;
	}
	#table_search_options {
		margin-top: 20px;
		display: none;
		width: 100%;
	}
	#table_search_options h2{
		font-size: 20px;
	}
	#table_search_options td {
		width: 270px;
		float: left;
		padding-top: 10px;
		padding-bottom: 10px;
	}
	select {
		float: right; 
		width: 150px;  
		margin-right: 10px;
	}
	#search_options_toggle {
		margin-top: 20px;
		display: inline-block;
	}
	#search_options_toggle:hover {
		text-decoration: underline;
		cursor: pointer;
	}
	#table_main_search input {
		-webkit-appearance: none;
		-webkit-border-radius:0; 
	}
</style>

<script>
	function toggleSearchOptions() {
		if(document.getElementById("table_search_options").style.display == 'block') {
			document.getElementById("table_search_options").style.display = 'none';
			document.getElementById("search_options_toggle").innerHTML = 'Show Search Options...';
		}
		else {
			document.getElementById("table_search_options").style.display = 'block';
			document.getElementById("search_options_toggle").innerHTML = 'Hide Search Options...';
		}
		
	}
</script>

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

<div class="content_section dark_grey">
	<div id="container">
		<form id="quick_search_form" action="search_results.php" method="get">
			<table id="table_main_search">
				<tr>
					<td id="input_main_search_td">
						<input type="search" id="input_main_search" name="input_main_search" placeholder="Keyword..." maxlength="35" autofocus>
					</td>
					<td>
						<input type="submit" id="button_main_search" name="button_main_search" value="Search">
					</td>
				</tr>
			</table>
			
			<table id="table_search_options">
				<tr>
					<td valign="top">
						<h2>Shops</h2>
						<input type="checkbox" name="shops_woolworths" value="woolworths"> Woolworths <br>
						<input type="checkbox" name="shops_coles" value="coles"> Coles 
					</td>
					<td valign="top">
						<h2>Specials</h2>
						<input type="radio" name="products" value="all" checked> All Products <br>
						<input type="radio" name="products" value="special"> Products on special <br>
						<input type="radio" name="products" value="multibuy"> Products with a multibuy special <br>
						<input type="radio" name="products" value="regular"> Products not on special 
					</td>
					<td valign="top">
						<h2>Price range</h2>
						From: <select name="min_price">
							  <option value="-1">-MIN-</option>
							  <option value="0">$0.00</option>
							  <option value="2.5">$2.50</option>
							  <option value="5">$5.00</option>
							  <option value="10">$10.00</option>
							  <option value="15">$15.00</option>
							  <option value="20">$20.00</option>
							</select>
							 <br>
						<div style="margin-top: 10px" >To: <select name="max_price">
							  <option value="1000">-MAX-</option>
							  <option value="2.5">$2.50</option>
							  <option value="5">$5.00</option>
							  <option value="10">$10.00</option>
							  <option value="15">$15.00</option>
							  <option value="20">$20.00</option>
							  <option value="50">$50.00</option>
							</select> </div>
					</td>
				</tr>
			</table>
		</form>
		<div id="search_options_toggle" onclick="toggleSearchOptions()">Show Search Options...</div>
	</div>
</div>

<div class="content_section light_grey">
	<div id="container">
		<h1>Why use the search?</h1>
		<p>The search allows you to query our database of food and beverage prices in Australia's largest supermarkets. The supermarkets include Woolworths and Coles.</p>
		<p>Use the the search bar at the top right to quickly search by keywork from any page on the site or use the search form above to narrow your search results.</p>
		<p>The purpose of the search is to allow you to find the cheapest healthy options at your local supermarkets.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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