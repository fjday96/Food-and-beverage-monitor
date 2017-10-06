<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>

<style>
	#table_main_search {
		width: 100%;
		border-collapse: collapse;
		border: none;
	}
	#button_main_search {
		background-color: #474747;
		border: none;
		height: 50px;
		color: #EEE;
		font-family: OpenSans-Bold, sans-serif;
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
	#input_main_search {
		height: 50px;
		margin-top: 0px;
		border: none;
		padding-left: 10px;
		width: 700px;
		font-size: 20px;
		outline: 0;
	}
	#table_search_options {
		margin-top: 20px;
		display: none;
	}
	#table_search_options td {
		width: 210px;
		padding: 20px 0px;
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

<div class="content_section dark_grey">
	<div id="container">
		<form id="quick_search_form" action="search_results.php" method="post">
			<table id="table_main_search">
				<tr>
					<td>
						<input type="search" id="input_main_search" name="input_main_search" placeholder="Keyword..." maxlength="35" autofocus>
					</td>
					<td>
						<input type="submit" id="button_main_search" name="button_main_search" value="SEARCH">
					</td>
				</tr>
			</table>
			<table id="table_search_options">
				<tr>
					<td valign="top">
						<h2>SHOPS</h2>
						<input type="checkbox" name="shops_woolworths" value="woolworths"> Woolworths <br>
						<input type="checkbox" name="shops_coles" value="coles"> Coles <br>
						<input type="checkbox" name="shops_aldi" value="aldi"> Aldi
					</td>
					<td valign="top">
						<h2>PRODUCT TYPE</h2>
						<input type="radio" name="product_type" value="fb" checked="checked"> Food and Beverage <br>
						<input type="radio" name="product_type" value="f"> Food <br>
						<input type="radio" name="product_type" value="b"> Beverage 
					</td>
					<td valign="top">
						<h2>PRICE RANGE</h2>
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
		<h1>WHY USE THE SEARCH?</h1>
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