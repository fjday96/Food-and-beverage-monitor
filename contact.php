<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>

<style>
	#contact_table {
		border: none;
		width: 100%;
		margin: 0 auto;
	}
	.contact_td_label {
		width: 100px;
	}
	.contact_label {
		width: 100px;
	}
	.contact_td_input {
		width: 100%;
	}
	.contact_input {
		width: 100%;
	}
	#contact_table input {
		outline: none;
		height: 25px;
		width: 100%;
		font-size: 14px;
		font-family: OpenSans-Regular, sans-serif;
	}
	textarea {
		padding: 0;
		height: 200px;
		font-family: OpenSans-Regular, sans-serif;
		font-size: 14px;
		outline: none;
	}
	#contact_table #button_contact_submit {
		background-color: #474747;
		border: none;
		height: 50px;
		color: #EEE;
		font-family: OpenSans-Bold, sans-serif;
		outline: 0;
		width: 135px;
		text-align: center;
		font-size: 20px;
		width: 150px;
	}
	#contact_table #button_contact_submit:hover {
		cursor: pointer;
		background-color: #333;
		color: #5C94CF;
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
			<a href="spreadsheets.php"><div class="nav_button">SPREADSHEETS</div></a>
			<a href="search.php"><div class="nav_button">SEARCH</div></a>
			<a href="reports.php"><div class="nav_button">REPORTS</div></a>
			<a href="about.php"><div class="nav_button">ABOUT</div></a>
			<div onclick="menu()" class="menu_icon"></div>
		</div>
	</div>
</div>
<div class="nav_bar_space"></div>

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
		<h1>Contact</h1>
		<p>Comments? Questions? Send us a message.</p>
		<form>
			<table id="contact_table">
				<tr>
					<td class="contact_td_label">
						<div class="contact_label">First Name</div>
					</td>
					<td class="contact_td_input">
						<input class="contact_input" id="input_first_name" name="input_first_name" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						<div class="contact_label">Last name</div>
					</td>
					<td class="contact_td_input">
						<input class="contact_input" id="input_last_name" name="input_last_name" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						<div class="contact_label">Email</div>
					</td>
					<td class="contact_td_input">
						<input class="contact_input" id="input_email" name="input_email" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						<div class="contact_label">Phone No.</div>
					</td>
					<td class="contact_td_input">
						<input class="contact_input" id="input_phone" name="input_phone" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						<div class="contact_label">Message</div>
					</td>
					<td class="contact_td_input">
						<textarea class="contact_input" id="input_message" name="input_message" style="width: 100%; resize: none; padding-right: 2px;" maxlength="1000"></textarea>
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						
					</td>
					<td class="contact_td_input">
						<input type="submit" id="button_contact_submit" name="button_contact_submit" value="SUBMIT">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<div id="footer_top">
	<div id="container">
		<table id="table_footer">
			<tr>
				<td valign="top" class="">
				<h2>Quick Links</h2>
					<a href="index.php"><div class="footer_button">HOME</div></a>
					<a href="spreadsheets.php"><div class="footer_button">SPREADSHEETS</div></a>
					<a href="search.php"><div class="footer_button">SEARCH</div></a>
					<a href="reports.php"><div class="footer_button">REPORTS</div></a>
					<a href="about.php"><div class="footer_button">ABOUT</div></a>
				</td>
				<td valign="top" class="td_padding_left">
				<h2>Additional Links</h2>
					<a href="http://www.globalobesity.com.au/" target="_blank"><div class="footer_button">GLOBE</div></a>
					<a href="http://www.deakin.edu.au/cphr" target="_blank"><div class="footer_button">CPHR</div></a>
					<a href="http://www.deakin.edu.au/" target="_blank"><div class="footer_button">DEAKIN UNIVERSITY</div></a>
				</td>
				<td valign="top" class="td_padding_left">
				<h2>Contact</h2>
					<a href="mailto:#" style="font-size: 14px">email@deakin.edu.au</a> <br>
					<a href="tel:#" style="font-size: 14px">00 0000 0000</a>
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