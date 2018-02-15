<?php
session_start();
if(!isset($_SESSION["user_email"])) {
	header('Location: login.php');
}

//Login to the database 
include 'dblogin.php';

//Create and execute the SQL statement using paramterised statement with oci_bind_by_name (stops SQL injection)
$querystring = "DELETE FROM accountsdb WHERE email=:email_input"; 
$stmt = oci_parse($connect, $querystring);
oci_bind_by_name($stmt, ':email_input', $_SESSION["user_email"]); 
oci_execute($stmt);

header('Location: login.php?status=deleted');
exit();
?>