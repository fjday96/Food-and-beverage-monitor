<?php
		$dbuser = "jpedler"; 
		$dbpass = "databasePassword";
		$db = "SSID"; 
		$connect = oci_connect($dbuser, $dbpass, $db);
		$datatable = "productdb"; 

		// Check connection
		if ($connect->connect_error) {
			die("Connection failed: " . $connect->connect_error);
		} 

error_reporting(0);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="jquery.js" type="text/javascript"></script>

<style>
	#sidebar {
		width: 250px;
		float: right;
		padding-top: 20px;
	}
	#search_results_section {
		width: 540px;
		float: left;
	}
	#container {
		overflow: auto;
	}
	#input_main_search {
		height: 30px;
		border: solid thin #AAA;
		width: 180px;
		font-size: 15px;
		outline: 0;
		background-color: #FCFCFC;
		padding-left: 10px;
	}
	#center_sidebar {
		width: 180px;
		margin: 0 auto;
	}
	select {
		float: right; 
		width: 120px;  
		margin-right: 10px;
	}
	h2 {
		padding-top: 0px;
		color: #5C94CF;
	}
	h3 {
		padding-top: 30px;
	}
	table {
		border-collapse: collapse;
	}
	
	#results_table td {
		width: 180px;
		padding: 10px 5px;
	}
	#results_table th {
		background-color: #CDCDCD;
		color: #5C94CF;
		border: none;
	}
	#results_table th h1 {
		font-size: 20px;
		padding-top: 10px;
		color: #121212;
	}
	#results_table tr:nth-child(even) {
    	background-color: #DDD;
	}
	#results_table tr:nth-child(odd) {
    	background-color: #E7E7E7;
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
		margin-top: 40px;
	}
	#button_main_search:hover {
		cursor: pointer;
		background-color: #333;
		color: #5C94CF;
	}
	.price_column {
		text-align: center;
	}
</style>

<script>
	function hideTable() {
		document.getElementById("results_table").style.display = "none";
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

<div class="content_section light_grey">
	<div id="container">
		<div id="search_results_section">
			<?php
				if(isset($_POST['button_main_search'])) {
					
					//POST variables
					$search_text = $_POST['input_main_search'];
					$shops_checkbox_woolworths = $_POST['shops_woolworths'];
					$shops_checkbox_coles = $_POST['shops_coles'];
					$shops_checkbox_aldi = $_POST['shops_aldi'];
					$product_type_radio = $_POST['product_type'];
					$min_price_select = $_POST['min_price'];
					$max_price_select = $_POST['max_price'];
					
					echo "<h1>SEARCH RESULTS</h1>";
					
					if($search_text != "") {
						
						echo "<p>Showing search results for \"".htmlentities($search_text)."\".</p>";
					} else {
						echo "<p>Use the keyword textbox to search for an item.</p>";
					}
				}
			?>

			<?php
				if(isset($_POST['input_main_search'])) {
					$sqlwherename = " LOWER(NAME) LIKE '%".strtolower($search_text)."%'";
					
					if($shops_checkbox_woolworths != "" || $shops_checkbox_coles != "" || $shops_checkbox_aldi != "") {
						$sqlwhereshops = " AND (";
						$x = 0;
						
						if($shops_checkbox_woolworths != "") {
							$sqlwhereshops = $sqlwhereshops." store='Woolworths'";
							$x++;
						}
						
						if($shops_checkbox_coles != "") {
							if($x != 0) {
								$sqlwhereshops = $sqlwhereshops." OR";
							}
							$sqlwhereshops = $sqlwhereshops." store='Coles'";
							$x++;
						}
						
						if($shops_checkbox_aldi != "") {
							if($x != 0) {
								$sqlwhereshops = $sqlwhereshops." OR";
							}
							$sqlwhereshops = $sqlwhereshops." store='Aldi'";
						}
						
						$sqlwhereshops = $sqlwhereshops.")";
						
					} else {
						$sqlwhereshops = "";
					}
					
					if(isset($_POST['product_type'])) {
						if($product_type_radio != "fb") {
							$sqlwheretype = " AND type='".$product_type_radio."'";
						} else {
							$sqlwheretype = "";
						}
					} else {
						$sqlwheretype = "";
					}
					
					$sql = "SELECT * FROM ".$datatable." WHERE".$sqlwherename.$sqlwhereshops.$sqlwheretype;
				
					//SELECT column FROM table LIMIT 10 OFFSET 10
					$stmt = oci_parse($connect, $sql);
					oci_execute($stmt);
					
					
				} else {
					$sqlwherename = "";
				}
				
			if(isset($_POST['input_main_search']) && $search_text != "") {	

				echo "<table id=\"results_table\">";
					echo "<tr>";
						echo "<th><h1>NAME</h1></th>";
						echo "<th><h1>PRICE</h1></th>";
						echo "<th><h1>STORE</h1></th>";
					echo "</tr>";
				
				$z = 0;

				 while(oci_fetch_array($stmt)) {
					 if(isset($_POST['min_price'])) {
					 	if($min_price_select < oci_result($stmt,"PRICE") && $max_price_select > oci_result($stmt,"PRICE")) {
								echo '<tr>';
								echo '<td>'.oci_result($stmt,"NAME").'</td>';
								echo '<td style="text-align: center;"> $'.oci_result($stmt,"PRICE").'</td>';
								echo '<td style="text-align: center;">'.oci_result($stmt,"STORE").'</td>';
								echo '</tr>';
							} else {
								$z++;
							}
					 } else {
						echo '<tr>';
						echo '<td>'.oci_result($stmt,"NAME").'</td>';
						echo '<td style="text-align: center;"> $'.oci_result($stmt,"PRICE").'</td>';
						echo '<td style="text-align: center;">'.oci_result($stmt,"STORE").'</td>';
						echo '</tr>';
					 }
					
				}; 
				echo "</table>";
				
				if(oci_num_rows($stmt) == 0) {
					echo "No results matched your search.";
					echo "<script>hideTable();</script>";	
				} else if($z == oci_num_rows($stmt)) {
					echo "No results matched your search.";
					echo "<script>hideTable();</script>";
				}
				
			}
				
			oci_close($connect); 	
			?> 
			</table>
		</div>
		<div id="sidebar">
			<form action="search_results.php" method="post">
				<div id="center_sidebar">
					
						<h3 style="padding-top: 0px; margin-top: 0px;">KEYWORD</h3>
						<input type="search" id="input_main_search" name="input_main_search" placeholder="Keyword..." maxlength="35" autocomplete="off"
						<?php 
							if(isset($_POST['input_main_search'])) {
								if ($search_text != "") {
									echo "value=\"".$search_text."\"";
								}
							}
						?>
						>

						<h3>SHOPS</h3>
						<input type="checkbox" name="shops_woolworths" value="woolworths" <?php if($shops_checkbox_woolworths != "") { echo "checked"; } ?> > Woolworths <br>
						<input type="checkbox" name="shops_coles" value="coles" <?php if($shops_checkbox_coles != "") { echo "checked"; } ?>> Coles <br>
						<input type="checkbox" name="shops_aldi" value="aldi" <?php if($shops_checkbox_aldi != "") { echo "checked"; } ?>> Aldi
							
						<h3>PRODUCT TYPE</h3>
						<input type="radio" name="product_type" value="fb" <?php if(isset($_POST['product_type'])) {if($product_type_radio == "fb") {echo "checked";}} else {echo "checked";} ?> > Food and beverage <br>
						<input type="radio" name="product_type" value="f" <?php if($product_type_radio == "f") {echo "checked";}?> >  Food <br>
						<input type="radio" name="product_type" value="b" <?php if($product_type_radio == "b") {echo "checked";}?> > Beverage 
						
						<h3>PRICE RANGE</h3>
						From: <select name="min_price">
							  <option value="-1">-MIN-</option>
							  <option value="0" <?php if(isset($_POST['min_price'])) {if($min_price_select == "0") {echo "selected";}} ?>>$0.00</option>
							  <option value="2.5" <?php if(isset($_POST['min_price'])) {if($min_price_select == "2.5") {echo "selected";}} ?>>$2.50</option>
							  <option value="5" <?php if(isset($_POST['min_price'])) {if($min_price_select == "5") {echo "selected";}} ?>>$5.00</option>
							  <option value="10" <?php if(isset($_POST['min_price'])) {if($min_price_select == "10") {echo "selected";}} ?>>$10.00</option>
							  <option value="15" <?php if(isset($_POST['min_price'])) {if($min_price_select == "15") {echo "selected";}} ?>>$15.00</option>
							  <option value="20" <?php if(isset($_POST['min_price'])) {if($min_price_select == "20") {echo "selected";}} ?>>$20.00</option>
							</select> <br>
						<div style="margin-top: 10px" >To: <select name="max_price">
							  <option value="1000">-MAX-</option>
							  <option value="2.5" <?php if(isset($_POST['max_price'])) {if($max_price_select == "2.5") {echo "selected";}} ?>>$2.50</option>
							  <option value="5" <?php if(isset($_POST['max_price'])) {if($max_price_select == "5") {echo "selected";}} ?>>$5.00</option>
							  <option value="10" <?php if(isset($_POST['max_price'])) {if($max_price_select == "10") {echo "selected";}} ?>>$10.00</option>
							  <option value="15" <?php if(isset($_POST['max_price'])) {if($max_price_select == "15") {echo "selected";}} ?>>$15.00</option>
							  <option value="20" <?php if(isset($_POST['max_price'])) {if($max_price_select == "20") {echo "selected";}} ?>>$20.00</option>
							  <option value="50" <?php if(isset($_POST['max_price'])) {if($max_price_select == "50") {echo "selected";}} ?>>$50.00</option>
							</select> </div>
							
							<input type="submit" id="button_main_search" name="button_main_search" value="SEARCH">
							
				</div>
			</form>
		</div>
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