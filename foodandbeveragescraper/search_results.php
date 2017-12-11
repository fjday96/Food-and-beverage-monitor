<?php

session_start();
if(!isset($_SESSION["user_email"])) {
	header('Location: login.php');
}

include 'dblogin.php';

//error_reporting(0);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	#sidebar {
		width: 250px;
		float: right;
		padding-top: 100px;
	}
	#sidebar h3 {
		color: #111;
		font-size: 20px;
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
	h3 {
		padding-top: 30px;
		margin-bottom: 10px;
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
		background-color: #BBB;
		border: none;
		height: 40px;
		color: #111;
		font-family: 'OpenSans', sans-serif;
		font-weight: 200;
		outline: 0;
		width: 100px;
		text-align: center;
		font-size: 20px;
		margin-top: 20px;
	}
	#button_main_search:hover {
		cursor: pointer;
		background-color: #DDD;
	}
	.price_column {
		text-align: center;
	}
	.result_tile {
		background-color: #FFF;
		border: solid thin #BBB;
		padding: 20px;
		margin-bottom: 20px;
	}
	.result_tile h1 {
		font-size: 28px;
	}
	.result_table {
		width: 100%;
	}
	#search_report {
		padding: 20px;
		margin-bottom: 20px;
	}
	.blue {
		background-color: #5C94CF;
	}
	h2 {
		padding-top: 0px;
		color: #5C94CF;
		font-size: 30px;
		font-family: 'OpenSans', sans-serif;
		font-weight: 200;
	}
	.statistics_box {
		width: 500px;
		float: left;
	}
	.statistics_box h3{
		color: #222;
		font-size: 22px;
	}
	#report_table {
		border: none;
		width: 500px;
		table-layout: fixed;
	}
	#report_table td {
		border: solid thin #333;
		text-align: center;
		padding: 10px 0;
	}
	a .page_button {
		text-decoration: none;
	}
	.page_button {
		text-decoration: none;
		background-color: #5C94CF;
		border: 0;
		outline: 0;
		padding: 10px;
		font-family: OpenSans, sans-serif;
		font-size: 16px;
		cursor: pointer;
	}
	.page_button:hover {
		background-color: #A4CDE1;	
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
		<div id="search_results_section">
			<h1>Search results</h1>
			<?php

			if(isset($_GET['button_main_search'])) {

				//Change GET variables to regular variables
				if(isset($_GET['input_main_search'])) {
					$search_text = $_GET['input_main_search'];
				}

				if(isset($_GET['shops_woolworths'])) {
					$shops_checkbox_woolworths = $_GET['shops_woolworths'];
				} else {
					$shops_checkbox_woolworths = "";
				}

				if(isset($_GET['shops_coles'])) {
					$shops_checkbox_coles = $_GET['shops_coles'];
				} else {
					$shops_checkbox_coles = "";
				}

				if(isset($_GET['products'])) {
					$products = $_GET['products'];
				} else {
					$products = "";
				}
					
				//Constructing the SQL query based on the user's input
				$sqlwherename = $sqlwhereshops = $sqlwheretype = "";
					
					//Keyword 
					if($search_text != "") {
						$sqlwherename = " (LOWER(NAME) LIKE '%' || :search_text_bv || '%' OR LOWER(BRAND) LIKE '%' || :search_text_bv || '%')";
						$x = 0;
						
						//Supermarkets 
						if(($shops_checkbox_woolworths == "" && $shops_checkbox_coles == "") || ($shops_checkbox_woolworths != "" && $shops_checkbox_coles != "")) {
							$sqlwhereshops = "";
						} else {
							if($shops_checkbox_woolworths != "") {
								$sqlwhereshops = " AND (store='Woolworths')";
							} else {
								$sqlwhereshops = " AND (store='Coles')";
							}
						}
						
						//Specials
						if($products == "special") {
							$sqlwheretype = " AND (special='True')"; 
						} else if($products == "multibuy") {
							$sqlwheretype = " AND (multibuy is not null)";
						} else if($products == "regular") {
							$sqlwheretype = " AND (special='False')";
						} 
					} 

				$min_price_select = $_GET['min_price'];
				$max_price_select = $_GET['max_price'];

				//The completed SQL string
				if(isset($_GET['page'])) {
					$page = $_GET['page'];
				} else {
					$page = 1;
				}

				$offset = ($page - 1) * 10;

				$sql = "SELECT * FROM productdb WHERE".$sqlwherename.$sqlwhereshops.$sqlwheretype." ORDER BY name OFFSET :offset_bv ROWS FETCH NEXT 10 ROWS ONLY";

				//Parse statement to the database
				$stmt = oci_parse($connect, $sql);
				oci_bind_by_name($stmt, ':search_text_bv', strtolower($search_text));
				oci_bind_by_name($stmt, ':offset_bv', $offset);
				oci_execute($stmt);

				if($search_text != "") {		
						echo "<p>Showing search results for \"".htmlentities($search_text)."\".</p>";
					} else {
						echo "<p>Use the keyword textbox to search for an item.</p>";
				}
				
				if(isset($_GET['input_main_search']) && $search_text != "") {	

					$z = 0;
					
					//Variables used for report
					$totalcoles = 0;
					$totalwoolworths = 0;
					$specialcoles = 0;
					$specialwoolworths = 0;
					$regularpricecoles = 0;
					$regularpricewoolworths = 0;
					$currentpricecoles = 0;
					$currentpricewoolworths = 0;
					$discountcoles = 0;
					$discountwoolworths = 0;

					 while(oci_fetch_array($stmt)) {
						 if(isset($_GET['min_price'])) {
							if($min_price_select < oci_result($stmt,"PRICE") && $max_price_select > oci_result($stmt,"PRICE")) {
								echo "<div class='result_tile'><h1>".oci_result($stmt,"NAME")."</h1><table class='result_table'><tr><td><strong>Current price</strong> <br><strong>Regular price</strong> <br><strong>Special</strong> <br><strong>Discount percentage</strong> <br>";
									if(oci_result($stmt,"MULTIBUY") != "") {echo "<strong>Multibuy</strong> <br>";}
									echo "<strong>Store</strong><br><strong>Brand</strong></td><td>$".number_format((float)oci_result($stmt,"PRICE"), 2, '.', '')."<br>$".number_format((float)oci_result($stmt,"ORIGINALPRICE"), 2, '.', '')."<br>".oci_result($stmt,"SPECIAL")."<br>".oci_result($stmt,"DISCOUNTPERCENTAGE")."%<br>"; 
									if(oci_result($stmt,"MULTIBUY") != "") {echo oci_result($stmt,"MULTIBUY")."<br>";}
									echo oci_result($stmt,"STORE")."<br>".oci_result($stmt,"BRAND")."</td><td align=\"right\"><img height='150' width='150' class='results_img' src='".oci_result($stmt,"IMAGEURL")."'/></td></tr></table></div>";
							} else {
								$z++;
							}
						 } 
					}; 


					$sql = "SELECT * FROM productdb WHERE".$sqlwherename.$sqlwhereshops.$sqlwheretype;

					//Parse statement to the database
					$stmt = oci_parse($connect, $sql);
					oci_bind_by_name($stmt, ':search_text_bv', strtolower($search_text));
					oci_execute($stmt);

					$num_rows = 0;

					while(oci_fetch_array($stmt)) {
						$num_rows++;
						if(oci_result($stmt,"STORE") == "Coles") { 
							$totalcoles++; 
							$regularpricecoles += oci_result($stmt,"ORIGINALPRICE");
							$currentpricecoles += oci_result($stmt,"PRICE");
							$discountcoles += oci_result($stmt,"DISCOUNTPERCENTAGE");
						} else if(oci_result($stmt,"STORE") == "Woolworths") { 
							$totalwoolworths++; 
							$regularpricewoolworths += oci_result($stmt,"ORIGINALPRICE");
							$currentpricewoolworths += oci_result($stmt,"PRICE");
							$discountwoolworths += oci_result($stmt,"DISCOUNTPERCENTAGE");
						}

						if(oci_result($stmt,"STORE") == "Coles" && oci_result($stmt,"SPECIAL") == "True") { 
							$specialcoles++; 
						} else if(oci_result($stmt,"STORE") == "Woolworths" && oci_result($stmt,"SPECIAL") == "True") { 
							$specialwoolworths++; 
						}

					};
					
					if($num_rows == 0) {
						echo "No results matched your search.";
					} else if($z == $num_rows) {
						echo "No results matched your search.";
					} 
				}
			}
				
		oci_close($connect);	
		?> 
		<?php 
			if($page > 1) {
				$pageprev = $page - 1;
				echo "<a href=\"?input_main_search=".$search_text."&button_main_search=Search&products=".$products."&min_price=".$min_price."&max_price=".$max_price."&page=".$pageprev."\"><div class='page_button' style='float: left;'>PREV</div></a>";
			}

			if($offset + 10 < $num_rows) {
				$pagenext = $page + 1;
				echo "<a href=\"?input_main_search=".$search_text."&button_main_search=Search&products=".$products."&min_price=".$min_price."&max_price=".$max_price."&page=".$pagenext."\"><div class='page_button' style='float: right;'>NEXT</div></a>";
			}
		?>
		</div>
		<div id="sidebar">
			<form action="search_results.php" method="get">
				<div id="center_sidebar">
					
						<h3 style="padding-top: 0px; margin-top: 0px;">Keyword</h3>
						<input type="search" id="input_main_search" name="input_main_search" placeholder="Keyword..." maxlength="35" autocomplete="off"
						<?php 
							if(isset($_GET['input_main_search'])) {
								if ($search_text != "") {
									echo "value=\"".$search_text."\"";
								}
							}
						?>
						>

						<h3>Shops</h3>
						<input type="checkbox" name="shops_woolworths" value="woolworths" <?php if($shops_checkbox_woolworths != "") { echo "checked"; } ?> > Woolworths <br>
						<input type="checkbox" name="shops_coles" value="coles" <?php if($shops_checkbox_coles != "") { echo "checked"; } ?>> Coles
							
						<h3>Specials</h3>
						<input type="radio" name="products" value="all" <?php if($products == "all") { echo "checked"; } ?>> All Products <br>
						<input type="radio" name="products" value="special" <?php if($products == "special") { echo "checked"; } ?>> Products on special <br>
						<input type="radio" name="products" value="multibuy" <?php if($products == "multibuy") { echo "checked"; } ?>> Products with a multibuy special <br>
						<input type="radio" name="products" value="regular" <?php if($products == "regular") { echo "checked"; } ?>> Products not on special 
						
						<h3>Price range</h3>
						From: <select name="min_price">
							  <option value="-1">-MIN-</option>
							  <option value="0" <?php if(isset($_GET['min_price'])) {if($min_price_select == "0") {echo "selected";}} ?>>$0.00</option>
							  <option value="2.5" <?php if(isset($_GET['min_price'])) {if($min_price_select == "2.5") {echo "selected";}} ?>>$2.50</option>
							  <option value="5" <?php if(isset($_GET['min_price'])) {if($min_price_select == "5") {echo "selected";}} ?>>$5.00</option>
							  <option value="10" <?php if(isset($_GET['min_price'])) {if($min_price_select == "10") {echo "selected";}} ?>>$10.00</option>
							  <option value="15" <?php if(isset($_GET['min_price'])) {if($min_price_select == "15") {echo "selected";}} ?>>$15.00</option>
							  <option value="20" <?php if(isset($_GET['min_price'])) {if($min_price_select == "20") {echo "selected";}} ?>>$20.00</option>
							</select> <br>
						<div style="margin-top: 10px" >To: <select name="max_price">
							  <option value="1000">-MAX-</option>
							  <option value="2.5" <?php if(isset($_GET['max_price'])) {if($max_price_select == "2.5") {echo "selected";}} ?>>$2.50</option>
							  <option value="5" <?php if(isset($_GET['max_price'])) {if($max_price_select == "5") {echo "selected";}} ?>>$5.00</option>
							  <option value="10" <?php if(isset($_GET['max_price'])) {if($max_price_select == "10") {echo "selected";}} ?>>$10.00</option>
							  <option value="15" <?php if(isset($_GET['max_price'])) {if($max_price_select == "15") {echo "selected";}} ?>>$15.00</option>
							  <option value="20" <?php if(isset($_GET['max_price'])) {if($max_price_select == "20") {echo "selected";}} ?>>$20.00</option>
							  <option value="50" <?php if(isset($_GET['max_price'])) {if($max_price_select == "50") {echo "selected";}} ?>>$50.00</option>
							</select> </div>
							
							<input type="submit" id="button_main_search" name="button_main_search" value="Search">
							
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

  // Load the Visualization API and the corechart package.
  google.charts.load('current', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawChart);
  google.charts.setOnLoadCallback(drawChart2);
  google.charts.setOnLoadCallback(drawChart3);
  google.charts.setOnLoadCallback(drawChart4);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

  	var data = google.visualization.arrayToDataTable([
        ['Store', 'Regular price products', 'Products on special'],
        ['Woolworths', <?php echo $totalwoolworths - $specialwoolworths ?>, <?php echo $specialwoolworths ?>],
        ['Coles', <?php echo $totalcoles - $specialcoles ?>, <?php echo $specialcoles ?>]
      ]);

	// Create the data table.
	//var data = google.visualization.arrayToDataTable([
    //    ['Regular price products', 'Products on special', { role: 'annotation' } ],
    //    ['Woolworths', <?php echo $totalwoolworths - $specialwoolworths; ?>, <?php echo $specialwoolworths; ?>, ''],
    //    ['Coles', <?php echo $totalcoles - $specialcoles; ?>, <?php echo $specialcoles; ?>, '']
    //  ]);

    var colors = [
	   { color: '#444' },  //high
	   { color: '#e8e486' }
   ];

	// Set chart options
	var options = {'title':'',
				   'width':500,
				   'height':400,
				   legend: { position: 'top'},
				   vAxis: {minValue: 0,
					},
				   chartArea: {  width: "80%", height: "80%" },
				   'backgroundColor': 'none',
				   isStacked: true,
				   series: colors,
				   'fontSize': 12};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
  }

  function drawChart2() {

	// Create the data table.
	var data = google.visualization.arrayToDataTable([
         ['Element', 'Density', { role: 'style' }],
         ['Woolworths', 8.94, '#46db4d'],        
         ['Coles', 10.49, '#c6171a'],           
      ]);

	// Set chart options
	var options = {'title':'',
				   'width':350,
				   'height':150,
				   legend:{position:'none'},
				   chartArea: {  width: "50%", height: "70%" },
				   series:{1:{targetAxisIndex:1}}, hAxes:{1:{direction:-1}},
				   'backgroundColor': 'none',
				   'fontSize': 14};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
	chart.draw(data, options);
  }

  function drawChart3() {

	// Create the data table.
	var data = google.visualization.arrayToDataTable([
         ['Element', 'Density', { role: 'style' }],
         ['Woolworths', 8.94, '#46db4d'],        
         ['Coles', 10.49, '#c6171a'],           
      ]);

	// Set chart options
	var options = {'title':'',
				   'width':350,
				   'height':150,
				   legend:{position:'none'},
				   chartArea: {  width: "50%", height: "70%" },
				   series:{1:{targetAxisIndex:1}}, hAxes:{1:{direction:-1}},
				   'backgroundColor': 'none',
				   'fontSize': 14};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.BarChart(document.getElementById('chart_div3'));
	chart.draw(data, options);
  }

  function drawChart4() {

	// Create the data table.
	var data = google.visualization.arrayToDataTable([
         ['Element', 'Density', { role: 'style' }],
         ['Woolworths', 8.94, '#46db4d'],        
         ['Coles', 10.49, '#c6171a'],           
      ]);

	// Set chart options
	var options = {'title':'',
				   'width':350,
				   'height':150,
				   legend:{position:'none'},
				   chartArea: {  width: "50%", height: "70%" },
				   series:{1:{targetAxisIndex:1}}, hAxes:{1:{direction:-1}},
				   'backgroundColor': 'none',
				   'fontSize': 14};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.BarChart(document.getElementById('chart_div4'));
	chart.draw(data, options);
  }
</script>

<?php
	
	$total = $totalwoolworths + $totalcoles;
	if($totalcoles > 0) {
		$avgregcoles = "$".number_format((float)($regularpricecoles / $totalcoles), 2, '.', '');
		$avgcurcoles = "$".number_format((float)($currentpricecoles / $totalcoles), 2, '.', '');
		$avgdiscountcoles = number_format((float)($discountcoles / $totalcoles), 2, '.', '')."%";
		$percentageonspeccoles = number_format((float)($specialcoles / $totalcoles) * 100, 2, '.', '')."%";
	} else {
		$avgregcoles = $avgcurcoles = $avgdiscountcoles = $percentageonspeccoles = "-";
	}

	if($totalwoolworths > 0) {
		$avgregwoolworths = "$".number_format((float)($regularpricewoolworths / $totalwoolworths), 2, '.', '');
		$avgcurwoolworths = "$".number_format((float)($currentpricewoolworths / $totalwoolworths), 2, '.', '');
		$avgdiscountwoolworths = number_format((float)($discountwoolworths / $totalwoolworths), 2, '.', '')."%";
		$percentageonspecwoolworths = number_format((float)($specialwoolworths / $totalwoolworths) * 100, 2, '.', '')."%";
	} else {
		$avgregwoolworths = $avgcurwoolworths = $avgdiscountwoolworths = $percentageonspecwoolworths = "-";
	}
	
	if($totalwoolworths > 0 && $totalcoles > 0) {
		$avgregtotal = "$".number_format((float)((($regularpricecoles / $totalcoles) + ($regularpricewoolworths / $totalwoolworths)) / 2), 2, '.', '');
		$avgcurtotal = "$".number_format((float)((($currentpricecoles / $totalcoles) + ($currentpricewoolworths / $totalwoolworths)) / 2), 2, '.', '');
		$avgdiscounttotal = number_format((float)((($discountcoles / $totalcoles) + ($discountwoolworths / $totalwoolworths)) / 2), 2, '.', '')."%";
		$percentageonspectotal = number_format((float)(((($specialcoles / $totalcoles) * 100) + (($specialwoolworths / $totalwoolworths) * 100)) / 2), 2, '.', '')."%";
	} else {
		$avgregtotal = $avgcurtotal = $avgdiscounttotal = $percentageonspectotal = "-";
	}



	echo "<div class=\"content_section dark_grey\">";
	echo "<div id=\"container\">";
	echo "<h2>Report based on your search</h2>";
	$totalproducts = $totalcoles + $totalwoolworths;
	echo "<p>Your search for \"".htmlentities($search_text)."\" yeilded ".$totalproducts." results.</p>";
	echo "<div class='statistics_box'><h3>Supermarket product distribution</h3><div id=\"chart_div\"></div><br>";
	echo "<table id='report_table'>";
	echo "<tr><td></td><td><strong>Coles</strong></td><td><strong>Woolworths</strong></td><td><strong>Total</strong></td></tr>";
	echo "<tr><td><strong>No. of products</strong></td><td>".$totalcoles."</td><td>".$totalwoolworths."</td><td>".$total."</td></tr>";
	echo "<tr><td><strong>Avg. regular price</strong></td><td>".$avgregcoles."</td><td>".$avgregwoolworths."</td><td>".$avgregtotal."</td></tr>";
	echo "<tr><td><strong>Avg. current price</strong></td><td>".$avgcurcoles."</td><td>".$avgcurwoolworths."</td><td>".$avgcurtotal."</td></tr>";
	echo "<tr><td><strong>Avg. discount %</strong></td><td>".$avgdiscountcoles."</td><td>".$avgdiscountwoolworths."</td><td>".$avgdiscounttotal."</td></tr>";
	echo "<tr><td><strong>% of products on special</strong></td><td>".$percentageonspeccoles."</td><td>".$percentageonspecwoolworths."</td><td>".$percentageonspectotal."</td></tr>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
?>
					

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