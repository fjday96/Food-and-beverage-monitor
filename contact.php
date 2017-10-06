<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contact</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>

<style>
	#contact_table {
		border: none;
	}
	.contact_td_label {
		width: 200px;
	}
	.contact_td_input {
		width: 640px;
	}
	#contact_table input {
		outline: none;
		height: 25px;
		width: 640px;
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
		<h1>CONTACT</h1>
		<p>Comments? Questions? Send us a message.</p>
		<form>
			<table id="contact_table">
				<tr>
					<td class="contact_td_label">
						First name
					</td>
					<td class="contact_td_input">
						<input id="input_first_name" name="input_first_name" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						Last name
					</td>
					<td class="contact_td_input">
						<input id="input_last_name" name="input_last_name" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						Email
					</td>
					<td class="contact_td_input">
						<input id="input_email" name="input_email" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						Phone No.
					</td>
					<td class="contact_td_input">
						<input id="input_phone" name="input_phone" maxlength="20">
					</td>
				</tr>
				<tr>
					<td class="contact_td_label">
						Message
					</td>
					<td class="contact_td_input">
						<textarea id="input_message" name="input_message" style="width: 100%; resize: none;" maxlength="1000"></textarea>
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