<?php
session_start();
if(!isset($_SESSION["user_email"])) {
	header('Location: login.php');
}

error_reporting(0);

include 'dblogin.php';

//Get most recent date retrieved, allows for this page to update automatically
$sql = "SELECT * FROM scraper_products WHERE ID = ( select max(ID) from scraper_products )";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	$lastid = oci_result($stmt,"ID");
	$dateretrieved = oci_result($stmt,"DATERETRIEVED");
}

//2nd most recently scraped data date
$sql = "SELECT dateretrieved FROM scraper_products WHERE ID = ".($lastid - 40000);
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	$dateretrievedold = oci_result($stmt,"DATERETRIEVED");
}

$sql = "SELECT * FROM scraper_products WHERE dateretrieved = '".$dateretrieved."'";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

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
$dietdrinkcoles = 0;
$dietdrinkwoolworths = 0;

//Total and specials data
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
}

//Diet beverages data
$sql = "SELECT * FROM scraper_products WHERE (dateretrieved='".$dateretrieved."') AND (catalogue='drinks' OR catalogue='Drinks')";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") { 
		$drinkcoles++;
	} else {
		$drinkwoolworths++;
	}
}

$sql = "SELECT * FROM scraper_products WHERE (LOWER(NAME) LIKE '%diet%' OR LOWER(NAME) LIKE '%sugar free%') AND (dateretrieved='".$dateretrieved."') AND (catalogue='drinks' OR catalogue='Drinks')";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") { 
		$dietdrinkcoles++;
	} else {
		$dietdrinkwoolworths++;
	}
}

//Brand data
$brandnamewoolworths = array();
$brandcountwoolworths = array();
$x = 0;

$sql = "SELECT brand, COUNT(*) FROM scraper_products WHERE (catalogue='drinks' OR catalogue='Drinks') AND (store='Woolworths') GROUP BY brand ORDER BY COUNT(*) DESC FETCH NEXT 10 ROWS ONLY";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	$brandnamewoolworths[$x] = oci_result($stmt,"BRAND");
	$brandcountwoolworths[$x] = oci_result($stmt,"COUNT(*)");
	$x++;
}

$brandnamecoles = array();
$brandcountcoles = array();
$x = 0;

$sql = "SELECT brand, COUNT(*) FROM scraper_products WHERE (catalogue='drinks' OR catalogue='Drinks') AND (store='Coles') GROUP BY brand ORDER BY COUNT(*) DESC FETCH NEXT 10 ROWS ONLY";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	$brandnamecoles[$x] = oci_result($stmt,"BRAND");
	$brandcountcoles[$x] = oci_result($stmt,"COUNT(*)");
	$x++;
}

//Overall price difference
$pricecoles = $pricewoolworths = $pricecolesnum = $pricewoolworthsnum = 0;

$sql = "SELECT store, price FROM scraper_products WHERE dateretrieved='".$dateretrieved."'";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") {
		$pricecoles += oci_result($stmt,"PRICE"); 
		$pricecolesnum++;
	} else {
		$pricewoolworths += oci_result($stmt,"PRICE"); 
		$pricewoolworthsnum++;
	}
}

$priceavgcoles = $pricecoles / $pricecolesnum;
$priceavgwoolworths = $pricewoolworths / $pricewoolworthsnum;



$pricecolesold = $pricewoolworthsold = $pricecolesnumold = $pricewoolworthsnumold = 0;

$sql = "SELECT store, price FROM scraper_products WHERE dateretrieved='".$dateretrievedold."'";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") {
		$pricecolesold += oci_result($stmt,"PRICE"); 
		$pricecolesnumold++;
	} else {
		$pricewoolworthsold += oci_result($stmt,"PRICE"); 
		$pricewoolworthsnumold++;
	}
}

$priceavgcolesold = $pricecolesold / $pricecolesnumold;
$priceavgwoolworthsold = $pricewoolworthsold / $pricewoolworthsnumold;



//Average price by category
$sql = "SELECT price, store, catalogue FROM scraper_products WHERE (dateretrieved='".$dateretrieved."')";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

$cat1totalcoles = 0;
$cat2totalcoles = 0;
$cat3totalcoles = 0;
$cat4totalcoles = 0;
$cat5totalcoles = 0;
$cat6totalcoles = 0;
$cat7totalcoles = 0;
$cat8totalcoles = 0;
$cat9totalcoles = 0;
$cat10totalcoles = 0;
$cat11totalcoles = 0;

$cat1countcoles = 0;
$cat2countcoles = 0;
$cat3countcoles = 0;
$cat4countcoles = 0;
$cat5countcoles = 0;
$cat6countcoles = 0;
$cat7countcoles = 0;
$cat8countcoles = 0;
$cat9countcoles = 0;
$cat10countcoles = 0;
$cat11countcoles = 0;

$cat1totalwoolworths = 0;
$cat2totalwoolworths = 0;
$cat3totalwoolworths = 0;
$cat4totalwoolworths = 0;
$cat5totalwoolworths = 0;
$cat6totalwoolworths = 0;
$cat7totalwoolworths = 0;
$cat8totalwoolworths = 0;
$cat9totalwoolworths = 0;

$cat1countwoolworths = 0;
$cat2countwoolworths = 0;
$cat3countwoolworths = 0;
$cat4countwoolworths = 0;
$cat5countwoolworths = 0;
$cat6countwoolworths = 0;
$cat7countwoolworths = 0;
$cat8countwoolworths = 0;
$cat9countwoolworths = 0;

while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") { 
		if(oci_result($stmt,"CATALOGUE") == "bread & bakery") { 
			$cat1totalcoles += oci_result($stmt,"PRICE");
			$cat1countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "fruit & vegetables") { 
			$cat2totalcoles += oci_result($stmt,"PRICE");
			$cat2countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "meat & seafood & deli") { 
			$cat3totalcoles += oci_result($stmt,"PRICE");
			$cat3countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "dairy & eggs & meals") { 
			$cat4totalcoles += oci_result($stmt,"PRICE");
			$cat4countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "pantry") { 
			$cat5totalcoles += oci_result($stmt,"PRICE");
			$cat5countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "frozen") { 
			$cat6totalcoles += oci_result($stmt,"PRICE");
			$cat6countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "drinks") { 
			$cat7totalcoles += oci_result($stmt,"PRICE");
			$cat7countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "liquor") { 
			$cat8totalcoles += oci_result($stmt,"PRICE");
			$cat8countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "international & foods") { 
			$cat9totalcoles += oci_result($stmt,"PRICE");
			$cat9countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "healthy & living") { 
			$cat10totalcoles += oci_result($stmt,"PRICE");
			$cat10countcoles++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "baby") { 
			$cat11totalcoles += oci_result($stmt,"PRICE");
			$cat11countcoles++;
		}
	} else {
		if(oci_result($stmt,"CATALOGUE") == "Bakery") { 
			$cat1totalwoolworths += oci_result($stmt,"PRICE");
			$cat1countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Fruit & Veg") { 
			$cat2totalwoolworths += oci_result($stmt,"PRICE");
			$cat2countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Meat, Seafood & Deli") { 
			$cat3totalwoolworths += oci_result($stmt,"PRICE");
			$cat3countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Dairy, Eggs & Fridge") { 
			$cat4totalwoolworths += oci_result($stmt,"PRICE");
			$cat4countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Pantry") { 
			$cat5totalwoolworths += oci_result($stmt,"PRICE");
			$cat5countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Freezer") { 
			$cat6totalwoolworths += oci_result($stmt,"PRICE");
			$cat6countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Drinks") { 
			$cat7totalwoolworths += oci_result($stmt,"PRICE");
			$cat7countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Liquor") { 
			$cat8totalwoolworths += oci_result($stmt,"PRICE");
			$cat8countwoolworths++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Baby") { 
			$cat9totalwoolworths += oci_result($stmt,"PRICE");
			$cat9countwoolworths++;
		}
	}
}
	
$cat1avgcoles = round(($cat1totalcoles / $cat1countcoles), 2);
$cat2avgcoles = round(($cat2totalcoles / $cat2countcoles), 2);
$cat3avgcoles = round(($cat3totalcoles / $cat3countcoles), 2);
$cat4avgcoles = round(($cat4totalcoles / $cat4countcoles), 2);
$cat5avgcoles = round(($cat5totalcoles / $cat5countcoles), 2);
$cat6avgcoles = round(($cat6totalcoles / $cat6countcoles), 2);
$cat7avgcoles = round(($cat7totalcoles / $cat7countcoles), 2);
$cat8avgcoles = round(($cat8totalcoles / $cat8countcoles), 2);
$cat9avgcoles = round(($cat9totalcoles / $cat9countcoles), 2);
$cat10avgcoles = round(($cat10totalcoles / $cat10countcoles), 2);
$cat11avgcoles = round(($cat11totalcoles / $cat11countcoles), 2);

$cat1avgwoolworths = round(($cat1totalwoolworths / $cat1countwoolworths), 2);
$cat2avgwoolworths = round(($cat2totalwoolworths / $cat2countwoolworths), 2);
$cat3avgwoolworths = round(($cat3totalwoolworths / $cat3countwoolworths), 2);
$cat4avgwoolworths = round(($cat4totalwoolworths / $cat4countwoolworths), 2);
$cat5avgwoolworths = round(($cat5totalwoolworths / $cat5countwoolworths), 2);
$cat6avgwoolworths = round(($cat6totalwoolworths / $cat6countwoolworths), 2);
$cat7avgwoolworths = round(($cat7totalwoolworths / $cat7countwoolworths), 2);
$cat8avgwoolworths = round(($cat8totalwoolworths / $cat8countwoolworths), 2);
$cat9avgwoolworths = round(($cat9totalwoolworths / $cat9countwoolworths), 2);


$sql = "SELECT price, store, catalogue FROM scraper_products WHERE (dateretrieved='".$dateretrievedold."')";
$stmt = oci_parse($connect, $sql);
oci_execute($stmt);

$cat1totalcolesold = 0;
$cat2totalcolesold = 0;
$cat3totalcolesold = 0;
$cat4totalcolesold = 0;
$cat5totalcolesold = 0;
$cat6totalcolesold = 0;
$cat7totalcolesold = 0;
$cat8totalcolesold = 0;
$cat9totalcolesold = 0;
$cat10totalcolesold = 0;
$cat11totalcolesold = 0;

$cat1countcolesold = 0;
$cat2countcolesold = 0;
$cat3countcolesold = 0;
$cat4countcolesold = 0;
$cat5countcolesold = 0;
$cat6countcolesold = 0;
$cat7countcolesold = 0;
$cat8countcolesold = 0;
$cat9countcolesold = 0;
$cat10countcolesold = 0;
$cat11countcolesold = 0;

$cat1totalwoolworthsold = 0;
$cat2totalwoolworthsold = 0;
$cat3totalwoolworthsold = 0;
$cat4totalwoolworthsold = 0;
$cat5totalwoolworthsold = 0;
$cat6totalwoolworthsold = 0;
$cat7totalwoolworthsold = 0;
$cat8totalwoolworthsold = 0;
$cat9totalwoolworthsold = 0;


$cat1countwoolworthsold = 0;
$cat2countwoolworthsold = 0;
$cat3countwoolworthsold = 0;
$cat4countwoolworthsold = 0;
$cat5countwoolworthsold = 0;
$cat6countwoolworthsold = 0;
$cat7countwoolworthsold = 0;
$cat8countwoolworthsold = 0;
$cat9countwoolworthsold = 0;


while(oci_fetch_array($stmt)) {
	if(oci_result($stmt,"STORE") == "Coles") { 
		if(oci_result($stmt,"CATALOGUE") == "bread & bakery") { 
			$cat1totalcolesold += oci_result($stmt,"PRICE");
			$cat1countcoleold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "fruit & vegetables") { 
			$cat2totalcolesold += oci_result($stmt,"PRICE");
			$cat2countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "meat & seafood & deli") { 
			$cat3totalcolesold += oci_result($stmt,"PRICE");
			$cat3countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "dairy & eggs & meals") { 
			$cat4totalcolesold += oci_result($stmt,"PRICE");
			$cat4countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "pantry") { 
			$cat5totalcolesold += oci_result($stmt,"PRICE");
			$cat5countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "frozen") { 
			$cat6totalcolesold += oci_result($stmt,"PRICE");
			$cat6countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "drinks") { 
			$cat7totalcolesold += oci_result($stmt,"PRICE");
			$cat7countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "liquor") { 
			$cat8totalcolesold += oci_result($stmt,"PRICE");
			$cat8countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "international & foods") { 
			$cat9totalcolesold += oci_result($stmt,"PRICE");
			$cat9countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "healthy & living") { 
			$cat10totalcolesold += oci_result($stmt,"PRICE");
			$cat10countcolesold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "baby") { 
			$cat11totalcolesold += oci_result($stmt,"PRICE");
			$cat11countcolesold++;
		}
	} else {
		if(oci_result($stmt,"CATALOGUE") == "Bakery") { 
			$cat1totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat1countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Fruit & Veg") { 
			$cat2totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat2countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Meat, Seafood & Deli") { 
			$cat3totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat3countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Dairy, Eggs & Fridge") { 
			$cat4totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat4countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Pantry") { 
			$cat5totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat5countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Freezer") { 
			$cat6totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat6countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Drinks") { 
			$cat7totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat7countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Liquor") { 
			$cat8totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat8countwoolworthsold++;
		}
		else if(oci_result($stmt,"CATALOGUE") == "Baby") { 
			$cat9totalwoolworthsold += oci_result($stmt,"PRICE");
			$cat9countwoolworthsold++;
		}
	}
}
	
$cat1avgcolesold = round(($cat1totalcolesold / $cat1countcolesold), 2);
$cat2avgcolesold = round(($cat2totalcolesold / $cat2countcolesold), 2);
$cat3avgcolesold = round(($cat3totalcolesold / $cat3countcolesold), 2);
$cat4avgcolesold = round(($cat4totalcolesold / $cat4countcolesold), 2);
$cat5avgcolesold = round(($cat5totalcolesold / $cat5countcolesold), 2);
$cat6avgcolesold = round(($cat6totalcolesold / $cat6countcolesold), 2);
$cat7avgcolesold = round(($cat7totalcolesold / $cat7countcolesold), 2);
$cat8avgcolesold = round(($cat8totalcolesold / $cat8countcolesold), 2);
$cat9avgcolesold = round(($cat9totalcolesold / $cat9countcolesold), 2);
$cat10avgcolesold = round(($cat10totalcolesold / $cat10countcolesold), 2);
$cat11avgcolesold = round(($cat11totalcolesold / $cat11countcolesold), 2);

$cat1avgwoolworthsold = round(($cat1totalwoolworthsold / $cat1countwoolworthsold), 2);
$cat2avgwoolworthsold = round(($cat2totalwoolworthsold / $cat2countwoolworthsold), 2);
$cat3avgwoolworthsold = round(($cat3totalwoolworthsold / $cat3countwoolworthsold), 2);
$cat4avgwoolworthsold = round(($cat4totalwoolworthsold / $cat4countwoolworthsold), 2);
$cat5avgwoolworthsold = round(($cat5totalwoolworthsold / $cat5countwoolworthsold), 2);
$cat6avgwoolworthsold = round(($cat6totalwoolworthsold / $cat6countwoolworthsold), 2);
$cat7avgwoolworthsold = round(($cat7totalwoolworthsold / $cat7countwoolworthsold), 2);
$cat8avgwoolworthsold = round(($cat8totalwoolworthsold / $cat8countwoolworthsold), 2);
$cat9avgwoolworthsold = round(($cat9totalwoolworthsold / $cat9countwoolworthsold), 2);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<script src="javascript.js" type="text/javascript"></script>
<link rel="icon" type="image/png" href="Media/Images/favicon.png">

<style>
	.reports_table_content_td {
			width: 100%;
			float: left;
		}
		.reports_table_visualisation_td {
			width: 100%;
			float: left;
		}

		h3 {
			font-size: 30px;
			margin-bottom: -10px;
		}
		
		#columnchart_material {
			padding-left: 100px;	
		}

	/*Changes to CSS when screen width is 870px or more*/
	@media only screen and (max-width: 880px) {
		.reports_table_content_td {
			width: 100%;
			float: left;
		}
		.reports_table_visualisation_td {
			width: 100%;
			float: left;
		}
		#columnchart_material {
			padding-left: 0;	
		}
	}
</style>

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

    var colors = [
	   { color: '#444' },  //high
	   { color: '#e8e486' }
   ];

	// Set chart options
	var options = {'title':'',
				   'width':550,
				   'height':550,
				   legend: { position: 'top'},
				   'chartArea': {'width': '100%', 'height': '80%'},
				   vAxis: {minValue: 0,
					},
				   'backgroundColor': 'none',
				   isStacked: true,
				   series: colors,
				   'fontSize': 12};	

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
  }

  function drawChart2() {

  	var data = google.visualization.arrayToDataTable([
        ['Store', 'Non-diet drinks', 'Diet drinks'],
        ['Woolworths', <?php echo $drinkwoolworths - $dietdrinkwoolworths ?>, <?php echo $dietdrinkwoolworths ?>],
        ['Coles', <?php echo $drinkcoles - $dietdrinkcoles ?>, <?php echo $dietdrinkcoles ?>]
      ]);

    var colors = [
	   { color: '#0c4db5' },  //high
	   { color: '#68a2ff' }
   ];

	// Set chart options
	var options = {'title':'',
				   'width':550,
				   'height':550,
				   legend: { position: 'top'},
				   'chartArea': {'width': '100%', 'height': '80%'},
				   vAxis: {minValue: 0,
					},
				   'backgroundColor': 'none',
				   isStacked: true,
				   series: colors,
				   'fontSize': 12};	

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
	chart.draw(data, options);
  }

  function drawChart3() {

  	var data = google.visualization.arrayToDataTable([
          ['Brand', 'No. of products']
          <?php
          	for($i = 0; $i < count($brandnamewoolworths); ++$i) {
          		echo ",['".$brandnamewoolworths[$i]."', ".$brandcountwoolworths[$i]."]";
          	}
          ?>
        ]);

    var colors = [
	   { color: '#0c4db5' },  //high
	   { color: '#68a2ff' }
   ];

	// Set chart options
	var options = {'title':'',
				   'width':550,
				   'height':550,
				   legend: { position: 'top'},
				   'chartArea': {'width': '100%', 'height': '80%'},
				   vAxis: {minValue: 0,
					},
				   'backgroundColor': 'none',
				   'fontSize': 12};	

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
	chart.draw(data, options);
  }
  
  
  
    function drawChart4() {

  	var data = google.visualization.arrayToDataTable([
          ['Brand', 'No. of products']
          <?php
          	for($i = 0; $i < count($brandnamecoles); ++$i) {
          		echo ",['".$brandnamecoles[$i]."', ".$brandcountcoles[$i]."]";
          	}
          ?>
        ]);

    var colors = [
	   { color: '#0c4db5' },  //high
	   { color: '#68a2ff' }
   ];

	// Set chart options
	var options = {'title':'',
				   'width':550,
				   'height':550,
				   legend: { position: 'top'},
				   'chartArea': {'width': '100%', 'height': '80%'},
				   vAxis: {minValue: 0,
					},
				   'backgroundColor': 'none',
				   'fontSize': 12};	

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
	chart.draw(data, options);
  }

</script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Store', '<?php echo $dateretrievedold ?>', '<?php echo $dateretrieved ?>'],
		['Coles', <?php echo round($priceavgcolesold, 2) ?>, <?php echo round($priceavgcoles, 2) ?>],
		['Woolworths', <?php echo round($priceavgwoolworthsold, 2) ?>, <?php echo round($priceavgwoolworths, 2) ?>]
	  
	]);

	var options = {
				'title':'',
			   'width':550,
			   'height':550,
			   legend: { position: 'top'},
			   'backgroundColor': 'none',
	  chart: {
		title: '',
		subtitle: '',
		legend: { position: 'top'}
	  }
	};

	var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

	chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Category", "<?php echo $dateretrievedold; ?>", "<?php echo $dateretrieved; ?>", { role: "style" } ],
        ["Bread & Bakery", <?php echo $cat1avgcoles; ?>, <?php echo $cat1avgcolesold; ?>, 'color: #76A7FA'],
        ["Fruit & Vegetables", <?php echo $cat2avgcoles; ?>, <?php echo $cat2avgcolesold; ?>, 'color: #76A7FA'],
        ["Meat, Seafood & Deli", <?php echo $cat3avgcoles; ?>, <?php echo $cat3avgcolesold; ?>, 'color: #76A7FA'],
        ["Dairy, Eggs & Meals", <?php echo $cat4avgcoles; ?>, <?php echo $cat4avgcolesold; ?>, 'color: #76A7FA'],
		["Pantry", <?php echo $cat5avgcoles; ?>, <?php echo $cat5avgcolesold; ?>, 'color: #76A7FA'],
		["Frozen", <?php echo $cat6avgcoles; ?>, <?php echo $cat6avgcolesold; ?>, 'color: #76A7FA'],
		["Drinks", <?php echo $cat7avgcoles; ?>, <?php echo $cat7avgcolesold; ?>, 'color: #76A7FA'],
		["Liquor", <?php echo $cat8avgcoles; ?>, <?php echo $cat8avgcolesold; ?>, 'color: #76A7FA'],
		["International & Foods", <?php echo $cat9avgcoles; ?>, <?php echo $cat9avgcolesold; ?>, 'color: #76A7FA'],
		["Healthy & Living", <?php echo $cat10avgcoles; ?>, <?php echo $cat10avgcolesold; ?>, 'color: #76A7FA'],
		["Baby", <?php echo $cat11avgcoles; ?>, <?php echo $cat11avgcolesold; ?>, 'color: #76A7FA']
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        title: "",
        width: 600,
        height: 800,
        bar: {groupWidth: "95%"},
		backgroundColor: 'none',
        legend: { position: "none" },
		chartArea: {
		  height: 750,
		  width: 300
		},
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
  
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Category", "<?php echo $dateretrievedold; ?>", "<?php echo $dateretrieved; ?>", { role: "style" } ],
        ["Bread & Bakery", <?php echo $cat1avgwoolworths; ?>, <?php echo $cat1avgwoolworthsold; ?>, 'color: #76A7FA'],
        ["Fruit & Vegetables", <?php echo $cat2avgwoolworths; ?>, <?php echo $cat2avgwoolworthsold; ?>, 'color: #76A7FA'],
        ["Meat, Seafood & Deli", <?php echo $cat3avgwoolworths; ?>, <?php echo $cat3avgwoolworthsold; ?>, 'color: #76A7FA'],
        ["Dairy, Eggs & Meals", <?php echo $cat4avgwoolworths; ?>, <?php echo $cat4avgwoolworthsold; ?>, 'color: #76A7FA'],
		["Pantry", <?php echo $cat5avgwoolworths; ?>, <?php echo $cat5avgwoolworthsold; ?>, 'color: #76A7FA'],
		["Frozen", <?php echo $cat6avgwoolworths; ?>, <?php echo $cat6avgwoolworthsold; ?>, 'color: #76A7FA'],
		["Drinks", <?php echo $cat7avgwoolworths; ?>, <?php echo $cat7avgwoolworthsold; ?>, 'color: #76A7FA'],
		["Liquor", <?php echo $cat8avgwoolworths; ?>, <?php echo $cat8avgwoolworthsold; ?>, 'color: #76A7FA'],
		["Baby", <?php echo $cat9avgwoolworths; ?>, <?php echo $cat9avgwoolworthsold; ?>, 'color: #76A7FA']
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        title: "",
        width: 600,
        height: 800,
        bar: {groupWidth: "95%"},
		backgroundColor: 'none',
        legend: { position: "none" },
		chartArea: {
		  height: 750,
		  width: 300
		},
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values2"));
      chart.draw(view, options);
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
	<a href="index.php"><div class="mobile_nav_button"><div id="container">Home</div></div></a>
	<a href="spreadsheets.php"><div class="mobile_nav_button"><div id="container">Spreadsheets</div></div></a>
	<a href="search.php"><div class="mobile_nav_button"><div id="container">Search</div></div></a>
	<a href="reports.php"><div class="mobile_nav_button"><div id="container">Reports</div></div></a>
	<a href="about.php"><div class="mobile_nav_button"><div id="container">About</div></div></a>
	<a href="account_settings.php"><div class="mobile_nav_button"><div id="container">Account Settings</div></div></a>
	<a href="logout.php"><div class="mobile_nav_button"><div id="container">Logout</div></div></a>
</div>

<div class="content_section dark_grey">
	<div id="container">	
		<table id="reports_table">
			<tr>
				<td class="reports_table_content_td">
                    <p style="color: #888; margin-bottom: 50px;">
                    <?php
						echo "This report is generated based on the data retrieved on ".$dateretrieved.".";
					?>
                    </p>
					<h3>Total products</h3>
					<p>
						<?php 
						if($totalwoolworths > $totalcoles) {
							echo "<p>Woolworths has more products at ".$totalwoolworths.". Coles has ".$totalcoles." products.</p>";
						} else {
							echo "<p>Coles has more products at ".$totalcoles.". Woolworths has ".$totalwoolworths." products.</p>";
						} 

						if($specialwoolworths > $specialcoles) {
							echo "<p>Woolworths has ".$specialwoolworths." products on special, while Coles has ".$specialcoles." products on special. ";
						} else {
							echo "<p>Coles has ".$specialcoles." products on special, while Woolworths has ".$specialwoolworths." products on special. ";
						}

						if(($specialwoolworths / $totalwoolworths) > ($specialcoles / $totalcoles)) {
							echo "Woolworths has a greater percentage of its products on sale at ".(round(($specialwoolworths / $totalwoolworths), 4) * 100)."%. Coles has ".(round(($specialcoles / $totalcoles), 4) * 100)."% of its products on sale.</p>";
						} else {
							echo "Coles has a greater percentage of its products on sale at ".(round(($specialcoles / $totalcoles), 4) * 100)."%. Woolworths has ".(round(($specialwoolworths / $totalwoolworths), 4) * 100)."% of its products on sale.</p>";
						}
						?> 
					</p>
					<p></p>
				</td>
				<td class="reports_table_visualisation_td" align="center">
					<div id="chart_div"></div>	
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="content_section light_grey">
	<div id="container">	
		<table id="reports_table">
			<tr>
				<td class="reports_table_content_td">
					<h3>Diet Drinks</h3>
					<p>Drinks are categorised as a diet drink if they include "diet" or "sugar free" in the title so results may not be completely accurate, but pretty close.</p>

					<p>Woolworths contains <?php echo $totalwoolworths; ?> beverages, <?php echo $dietdrinkwoolworths; ?> of which were identified as diet. Coles contains <?php echo $totalcoles; ?> beverages, <?php echo $dietdrinkcoles; ?> of which were identified as diet.</p>

				</td>

				<td class="reports_table_visualisation_td" align="center">
					<div id="chart_div2"></div>	
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="content_section dark_grey">
	<div id="container">	
		<table id="reports_table">
			<tr>
				<td class="reports_table_content_td">
					<h3>Beverage Brands</h3>
					<p>The pie chart below shows the top ten brands with the highest number of products for Woolworths.</p>
				</td>

				<td class="reports_table_visualisation_td" align="center">
					<div id="chart_div3"></div>	
				</td>
                
                <td class="reports_table_content_td">
					<p>The pie chart below shows the top ten brands with the highest number of products for Coles.</p>
				</td>

				<td class="reports_table_visualisation_td" align="center">
					<div id="chart_div4"></div>	
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="content_section light_grey">
	<div id="container">	
		<table id="reports_table">
			<tr>
				<td class="reports_table_content_td">
					<h3>Price Trends</h3>
                    <p>This graph shows the changes in average price for all products in store over the most recent 2 weeks of data collected.</p>
					<p>The average price for each product in Coles on <?php echo $dateretrievedold ?> was $<?php echo round($priceavgcolesold, 2);?>. As of <?php echo $dateretrieved ?> it was $<?php echo round($priceavgcoles, 2);?>.<br>
                    For Woolworths, the average price for each product on <?php echo $dateretrievedold ?> was $<?php echo round($priceavgwoolworthsold, 2);?>. As of <?php echo $dateretrieved ?> it was $<?php echo round($priceavgwoolworths, 2);?>.</p>
				</td>

                <td class="reports_table_visualisation_td" align="center">
					<div id="columnchart_material"></div>	
				</td>
                <td class="reports_table_content_td">
                    <p>The graph below shows changes in price for the categories in Coles between <?php echo $dateretrievedold; ?> and <?php echo $dateretrieved; ?>. </p>
				</td>
                <td class="reports_table_visualisation_td" align="center">
					<div id="barchart_values"></div>	
				</td>
                <td class="reports_table_content_td">
                    <p>The graph below shows changes in price for the categories in Woolworths between <?php echo $dateretrievedold; ?> and <?php echo $dateretrieved; ?>. </p>
				</td>
                <td class="reports_table_visualisation_td" align="center">
					<div id="barchart_values2"></div>	
				</td>
			</tr>
		</table>
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