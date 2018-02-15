<?php
	$dbuser = "jpedler"; 
	$dbpass = "";
	$db = "SSID"; 
	$connect = oci_connect($dbuser, $dbpass, $db);
	//$datatable = "scraper_products"; 

	// Check connection
	if ($connect->connect_error) {
		die("Connection failed: " . $connect->connect_error);
	} 
?>