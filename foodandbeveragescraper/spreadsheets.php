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
<title>Spreadsheets</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	#table_spreadsheets, #table_spreadsheets th, #table_spreadsheets td{
		border: 1px solid #222;
    	border-collapse: collapse;
		width: 100%;
	}
	#table_spreadsheets th, #table_spreadsheets td{
		padding: 5px;
		text-align: left;
		border-left: none;
		border-right: none;
	}
	#table_spreadsheets tr:nth-child(odd) {
    	background-color: #E3E3E3;
	}
	#table_spreadsheets {
		table-layout: fixed;
		margin: 40px 0px;
	}
	#table_spreadsheets th {
		font-size: 18px;
		background-color: #222;
		font-style: normal;
	}
	#table_spreadsheets th h3 {
		color: #EEE;
		margin: 0;
		font-family: 'Roboto', sans-serif;
		font-weight: 400;
		font-size: 20px;
	}
	.table_button {
		background-color: #5C94CF;
		width: 120px;
		float: left;
		margin: 4px;
		text-align: center;
		padding: 5px 0px;
		border: 0;
		font-size: 14px;
	}
	.table_button:hover {
		background-color: #8FAACF;
	}
	a .table_button {
		text-decoration: none;
		color: #000;
	}
	.correct_submit {
		border: 0;
	}
	button {
		font-family: 'OpenSans', sans-serif;
    	font-weight: 400;
		cursor: pointer;
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
		<h1>Spreadsheets</h1>
		<p>Download complete datasets for either Coles or Woolworths in a CSV format (which can be opened with Microsoft Excel). Dates given represent the date that the data was
		collected (scraped) from the supermarket's website.</p>

		<table id="table_spreadsheets">
		  <tr>
			<th><h3>Date Collected</h3></th>
			<th><h3>Store</h3></th>
			<th><h3>View</h3></th>
		  </tr>
		  <form action="view_spreadsheet.php" method="get">
		  <?php
			$dir = "Media/spreadsheets";
			$spreadsheets_array = scandir($dir);
			for($x = 2; $x <= sizeof($spreadsheets_array) - 1; $x++) {
				$filename_explode = explode("_",$spreadsheets_array[$x]);
				echo "<tr>";
				echo "<td>", $filename_explode[0], "</td>";
				echo "<td>", substr($filename_explode[1], 0, -4), "</td>";
				echo "<td>";
				echo "<button class=\"table_button\" type=\"submit\" value=\"", $spreadsheets_array[$x],"\" name=\"spreadsheet\">Web View</button>";
				echo "<a href=\"Media/spreadsheets/", $spreadsheets_array[$x], "\" download><div class=\"table_button\">Download CSV</div></a>";
				echo "</td>";
				echo "</tr>";
			}
			
			echo ""
			?>
			</table>
			</form>
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