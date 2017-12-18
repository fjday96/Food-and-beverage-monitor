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
<title>View Spreadsheet</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	#table_spreadsheets {
		width: 800px;
	}
	#table_spreadsheets, #table_spreadsheets th, #table_spreadsheets td{
		border: 1px solid #222;
    	border-collapse: collapse;
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
	#table_spreadsheets tr:nth-child(even) {
    	background-color: #F4F4F4;
	}
	#table_spreadsheets {
		table-layout: fixed;
	}
	#table_spreadsheets th {
		font-size: 28px;
		background-color: #222;
		font-style: normal;
	}
	#table_spreadsheets td {
		border-left: solid thin #999;
		border-right: solid thin #999;
	}
	#table_spreadsheets th h3 {
		color: #EEE;
		margin: 0;
		font-family: 'Roboto', sans-serif;
		font-weight: 400;
		font-size: 20px;
	}
	#table_spreadsheets_head {
    	border-collapse: collapse;
		width: 800px;
		font-size: 16px;
		font-weight: 200;
		color: #FFF;
		background-color: #222;
		table-layout: fixed;
	}
	#table_spreadsheets_head td {
		padding: 10px 0 10px 10px;
	}
	.table_button {
		background-color: #5C94CF;
		width: 120px;
		float: left;
		margin: 4px;
		text-align: center;
		padding: 5px 0px;
	}
	a .table_button {
		text-decoration: none;
		color: #000;
	}
	#spreadsheet_div {
		max-height: 700px;
		overflow-y: scroll;
		overflow-x: hidden;
		display: inline-block;
		padding-right: 1px;
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
		<h1>Viewing spreadsheet</h1>
		<?php
			if(isset($_GET['spreadsheet'])) {
				$spreadsheet = $_GET['spreadsheet'];
				$dir = "Media/spreadsheets";
				$filenames = scandir($dir);
				$valid = false;
				
				if(file_exists($dir."/".$spreadsheet) == true) {
					$valid = true;
				}
				
				if($valid == true) {
					echo "<p>Displayed below is the data from the file \"", $spreadsheet, "\".</p>";
					$f = fopen("Media/spreadsheets/".$spreadsheet, "r");
					$x = 0;

					while (($line = fgetcsv($f)) !== false) {
						if($x == 0) {
							echo "<table id=\"table_spreadsheets_head\">";
							echo "<tr>";
								foreach ($line as $cell) {
									echo "<td>" . htmlspecialchars($cell) . "</td>";
								}
							echo "</tr>";
							echo "</table>";
							echo "<div id='spreadsheet_div'>";
							echo "<table id=\"table_spreadsheets\">";
							$x++;
						} else {
							echo "<tr>";
								foreach ($line as $cell) {
									echo "<td>" . htmlspecialchars($cell) . "</td>";
								}
							echo "</tr>";
						}
					}



					fclose($f);
					echo "</table>";
					echo "</div>";
				} else {
					echo "<p>Spreadsheet selected does not exist.</p>";
				}
			} else {
				echo "<p>Unable to display spreadsheet. Make sure you have selected a spreadsheet from the spreadsheets page.</p>";
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