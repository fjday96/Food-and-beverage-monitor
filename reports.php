<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reports</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>

<style>

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
		<h1>REPORTS</h1>
		<p>Reports page content.</p>
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